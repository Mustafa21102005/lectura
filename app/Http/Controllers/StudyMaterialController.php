<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HandlesMedia;
use App\Models\StudyMaterial;
use App\Http\Requests\{StoreStudyMaterialRequest, UpdateStudyMaterialRequest};
use App\Models\{MaterialType, User};
use App\Notifications\NewStudyMaterialNotification;
use Illuminate\Support\Facades\{Auth, URL, Storage};

class StudyMaterialController extends Controller
{
    use HandlesMedia;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get study materials for the logged-in teacher only
        $materials = StudyMaterial::where('teacher_id', auth()->id())->get();

        return view('study-materials.index', compact('materials'));
    }

    /**
     * Display a listing of the resources assigned to the student.
     */
    public function studentIndex()
    {
        $student = Auth::user();

        $subjectIds = $student->studentSubjects()->pluck('id');

        $materials = StudyMaterial::with(['subject', 'teacher', 'type'])
            ->whereIn('subject_id', $subjectIds)
            ->get();

        return view('study-materials.student.index', compact('materials'));
    }

    /**
     * Display a listing of the resources assigned to the child.
     */
    public function parentIndex()
    {
        // Get logged-in parent
        $parent = auth()->user();

        // Get the parent's children
        $children = $parent->children()->with('curricula.subjects')->get();

        // Collect all unique subject IDs across children
        $subjectIds = $children
            ->flatMap(function ($child) {
                return $child->studentSubjects()->pluck('id');
            })->unique();

        // Get all study materials related to those subjects
        $materials = StudyMaterial::with(['subject', 'teacher', 'type'])
            ->whereIn('subject_id', $subjectIds)
            ->latest()
            ->get();

        return view('study-materials.parent.index', compact('materials', 'children'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teacher = Auth::user();

        // Get all subjects the teacher teaches with their grade levels
        $subjects = $teacher->teacherSubjects()
            ->with(['gradeLevels' => function ($q) use ($teacher) {
                $q->wherePivot('teacher_id', $teacher->id);
            }])
            ->orderBy('name')
            ->get();

        $types = MaterialType::all();

        return view('study-materials.create', compact('types', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudyMaterialRequest $request)
    {
        $data = $request->validated();
        $data['teacher_id'] = auth()->id();

        $material = StudyMaterial::create($data);

        // Handle uploaded files
        if ($request->filled('uploaded_files')) {
            $uploadedFiles = json_decode($request->uploaded_files, true);

            foreach ($uploadedFiles as $fileData) {
                $tmpPath = 'uploads/tmp/' . $fileData['folder'] . '/' . $fileData['file'];

                if (Storage::disk('public')->exists($tmpPath)) {
                    $material->addMedia(Storage::disk('public')->path($tmpPath))
                        ->usingFileName($fileData['file'])
                        ->toMediaCollection('study-materials');

                    Storage::disk('public')->deleteDirectory('uploads/tmp/' . $fileData['folder']);
                }
            }
        }

        $gradeLevelIds = json_decode($request->grade_level_id, true) ?? [];

        $students = User::whereHas('roles', fn($q) => $q->where('name', 'student'))
            ->whereHas('curricula', fn($q) => $q->whereIn('grade_level_id', $gradeLevelIds))
            ->whereHas('notificationSettings', fn($q) => $q->where('new_study_materials', true))
            ->get(['id', 'email', 'name']);

        foreach ($students as $student) {
            $student->notify(new NewStudyMaterialNotification($material->id, $student->name));
        }

        return redirect()->route('study-materials.index')->with('success', 'Study material created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(StudyMaterial $studyMaterial)
    {
        $media = $studyMaterial->getMedia('study-materials')->map(function ($media) {
            return [
                'id' => $media->id,
                'name' => $media->file_name,
                'url' => URL::temporarySignedRoute(
                    'study-materials.media.temp',
                    now()->addMinutes(120),
                    ['media' => $media->id]
                ),
            ];
        });

        return view('study-materials.show', compact('studyMaterial', 'media'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudyMaterial $studyMaterial)
    {
        $teacher = Auth::user();

        // Get all subjects the teacher teaches with their grade levels
        $subjects = $teacher->teacherSubjects()
            ->with(['gradeLevels' => function ($q) use ($teacher) {
                $q->wherePivot('teacher_id', $teacher->id);
            }])
            ->orderBy('name')
            ->get();

        $materialTypes = MaterialType::all();

        $files = $studyMaterial->getMedia('study-materials')->map(function ($media) {
            return [
                'id' => $media->id,
                'name' => $media->file_name,
                'url' => $media->getFullUrl(),
                'size' => $media->size,
            ];
        });

        return view('study-materials.edit', compact('studyMaterial', 'subjects', 'materialTypes', 'files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudyMaterialRequest $request, StudyMaterial $studyMaterial)
    {
        $data = $request->validated();
        $studyMaterial->update($data);

        // Handle new uploads
        if ($request->filled('uploaded_files')) {
            $uploadedFiles = json_decode($request->uploaded_files, true);

            foreach ($uploadedFiles as $fileData) {
                $tmpPath = 'uploads/tmp/' . $fileData['folder'] . '/' . $fileData['file'];

                if (Storage::disk('public')->exists($tmpPath)) {
                    $studyMaterial
                        ->addMedia(Storage::disk('public')->path($tmpPath))
                        ->usingFileName($fileData['file'])
                        ->toMediaCollection('study-materials');

                    Storage::disk('public')->deleteDirectory('uploads/tmp/' . $fileData['folder']);
                }
            }
        }

        return redirect()->route('study-materials.index')->with('success', 'Study Material updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudyMaterial $studyMaterial)
    {
        $studyMaterial->clearMediaCollection('study-materials');

        $studyMaterial->delete();

        return redirect()->route('study-materials.index')
            ->with('success', 'Study Material and its files were deleted successfully.');
    }
}
