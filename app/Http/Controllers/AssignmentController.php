<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HandlesMedia;
use App\Models\{Assignment, Subject, User};
use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Notifications\NewAssignmentNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\{Auth, DB, Storage, URL};

class AssignmentController extends Controller
{
    use HandlesMedia, AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = Auth::user();

        // Get only assignments that belong to the logged-in teacher
        $assignments = Assignment::where('teacher_id', $teacher->id)
            ->with('subject')
            ->orderByDesc('created_at')
            ->get();

        return view('assignments.index', compact('assignments'));
    }

    /**
     * Display all assignments for the authenticated student
     */
    public function studentIndex()
    {
        $student = auth()->user();

        $subjectIds = $student->studentSubjects()->pluck('id');

        $assignments = Assignment::whereIn('subject_id', $subjectIds)
            ->with(['submissions' => function ($query) use ($student) {
                $query->where('student_id', $student->id);
            }])
            ->orderBy('due_date')
            ->get();

        return view('assignments.student.index', [
            'assignments' => $assignments
        ]);
    }

    /**
     * Show all assignments belonging to the parent's children.
     */
    public function parentIndex()
    {
        $parent = auth()->user();
        $children = $parent->children;

        $childIds = $children->pluck('id');

        $assignments = Assignment::whereHas('subject.curricula', function ($query) use ($childIds) {
            $query->whereHas('students', function ($q) use ($childIds) {
                $q->whereIn('users.id', $childIds);
            });
        })
            ->with([
                'subject',
                'teacher',
                'submissions' => function ($query) use ($childIds) {
                    $query->whereIn('student_id', $childIds);
                }
            ])
            ->orderBy('due_date')
            ->get();

        return view('assignments.parent.index', compact('assignments', 'children'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teacher = Auth::user();

        $subjects = $teacher->teacherSubjects()->withPivot('grade_level_id')->get()->map(function ($s) {
            $s->grade_levels = DB::table('teacher_subject_grade_level')
                ->where('teacher_id', auth()->id())
                ->where('subject_id', $s->id)
                ->pluck('grade_level_id');
            return $s;
        });

        return view('assignments.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssignmentRequest $request)
    {
        $data = $request->validated();
        $data['teacher_id'] = auth()->id();

        $subjectGrade = $request->input('subject_grade');
        [$subjectId, $gradeLevelId] = explode('_', $subjectGrade);

        $data['subject_id'] = $subjectId;
        $data['grade_level_id'] = $gradeLevelId;

        // Create the assignment
        $assignment = Assignment::create($data);

        // Handle uploaded files
        if ($request->filled('uploaded_files')) {
            $uploadedFiles = json_decode($request->uploaded_files, true);

            foreach ($uploadedFiles as $fileData) {
                $tmpPath = 'uploads/tmp/' . $fileData['folder'] . '/' . $fileData['file'];

                if (Storage::disk('public')->exists($tmpPath)) {
                    $assignment->addMedia(Storage::disk('public')->path($tmpPath))
                        ->usingFileName($fileData['file'])
                        ->toMediaCollection('teacher-assignment');

                    Storage::disk('public')->deleteDirectory('uploads/tmp/' . $fileData['folder']);
                }
            }
        }

        // Notify students in the selected grade level
        $students = User::whereHas('roles', fn($q) => $q->where('name', 'student'))
            ->whereHas('curricula', fn($q) => $q->where('grade_level_id', $gradeLevelId))
            ->whereHas('notificationSettings', fn($q) => $q->where('new_assignments', true))
            ->get(['id', 'email', 'name']);

        foreach ($students as $student) {
            $student->notify(new NewAssignmentNotification($assignment));
        }

        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment)
    {
        $media = $assignment->getMedia('teacher-assignment')->map(function ($media) {
            return [
                'id' => $media->id,
                'name' => $media->file_name,
                'url' => URL::temporarySignedRoute(
                    'assignments.media.temp',
                    now()->addMinutes(120),
                    ['media' => $media->id]
                ),
            ];
        });

        return view('assignments.show', compact('assignment', 'media'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        $this->authorize('update', $assignment);

        $teacher = Auth::user();

        $subjects = $teacher->teacherSubjects()->withPivot('grade_level_id')->get()->map(function ($s) {
            $s->grade_levels = DB::table('teacher_subject_grade_level')
                ->where('teacher_id', auth()->id())
                ->where('subject_id', $s->id)
                ->pluck('grade_level_id');
            return $s;
        });

        $files = $assignment->getMedia('teacher-assignment')->map(function ($media) {
            return [
                'id' => $media->id,
                'name' => $media->file_name,
                'url' => $media->getFullUrl(),
                'size' => $media->size,
            ];
        });

        $selectedValue = $assignment->subject_id . '_' . $assignment->grade_level_id;

        return view('assignments.edit', compact('assignment', 'files', 'subjects', 'selectedValue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        $this->authorize('update', $assignment);

        $data = $request->validated();

        // Extract subject and grade from the combined input
        [$subjectId, $gradeLevelId] = explode('_', $request->subject_grade);
        $data['subject_id'] = $subjectId;
        $data['grade_level_id'] = $gradeLevelId;

        $assignment->update($data);

        // Handle new uploads
        if ($request->filled('uploaded_files')) {
            $uploadedFiles = json_decode($request->uploaded_files, true);

            foreach ($uploadedFiles as $fileData) {
                $tmpPath = 'uploads/tmp/' . $fileData['folder'] . '/' . $fileData['file'];

                if (Storage::disk('public')->exists($tmpPath)) {
                    $assignment
                        ->addMedia(Storage::disk('public')->path($tmpPath))
                        ->usingFileName($fileData['file'])
                        ->toMediaCollection('teacher-assignment');

                    Storage::disk('public')->deleteDirectory('uploads/tmp/' . $fileData['folder']);
                }
            }
        }

        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment)
    {
        $assignment->clearMediaCollection('teacher-assignment');

        $assignment->delete();

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment and its files were deleted successfully.');
    }
}
