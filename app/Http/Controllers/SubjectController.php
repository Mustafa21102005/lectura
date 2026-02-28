<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\{Curriculum, GradeLevel, User};
use App\Notifications\TeacherAssignedToSubjectNotification;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();

        return view('subjects.index', compact('subjects'));
    }

    /**
     * Display a listing of the resources assigned to the teacher.
     *
     * @return \Illuminate\View\View
     */
    public function teacherIndex()
    {
        $teacher = auth()->user();

        // Fetch all subjects assigned to this teacher with needed relationships
        $subjects = $teacher->teacherSubjects()
            ->with(['curricula', 'assignedTeachers'])
            ->get()
            ->groupBy('id')
            ->map(function ($group) use ($teacher) {
                $subject = $group->first();

                // Collect all grade levels assigned to this teacher for the subject
                $grades = $subject->assignedTeachers
                    ->where('id', $teacher->id)
                    ->pluck('pivot.grade_level_id')
                    ->unique()
                    ->map(fn($gradeId) => optional(GradeLevel::find($gradeId))->name)
                    ->filter()
                    ->values();

                return [
                    'subject' => $subject,
                    'grades' => $grades,
                ];
            })
            ->values();

        return view('subjects.teacher.index', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * Show the logged-in student's enrolled subjects.
     *
     * @return \Illuminate\View\View
     */
    public function studentIndex()
    {
        $student = auth()->user();

        $subjects = $student->studentSubjects();

        return view('subjects.student.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $curriculums = Curriculum::all();
        $gradeLevels = GradeLevel::all();
        $teachers = User::role('teacher')->get();

        return view('subjects.create', compact('curriculums', 'gradeLevels', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        $validated = $request->validated();

        // Create subject
        $subject = Subject::create($request->only('name'));

        // Attach curricula in bulk
        $subject->curricula()->sync($validated['curricula']);

        // Attach teacher for multiple grade levels efficiently
        $teacherId = $validated['teacher_id'];
        $gradeLevels = $validated['grade_levels'];

        $attachData = [];
        $now = now();

        foreach ($gradeLevels as $gradeLevelId) {
            $attachData[$teacherId][$gradeLevelId] = [
                'grade_level_id' => $gradeLevelId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Flatten the array for attach()
        $syncData = [];
        foreach ($gradeLevels as $gradeLevelId) {
            $syncData[] = [
                'teacher_id' => $teacherId,
                'grade_level_id' => $gradeLevelId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Use attach() directly
        foreach ($syncData as $data) {
            $subject->assignedTeachers()->attach($data['teacher_id'], [
                'grade_level_id' => $data['grade_level_id'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]);
        }

        $teacher = User::find($teacherId);

        // Send notification if teacher wants it
        if ($teacher?->notificationSettings?->subject_changes) {
            $teacher->notify(new TeacherAssignedToSubjectNotification($subject, $teacher->name));
        }

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        // Fetch all assignments and curriculums
        $assignments = $subject->assignments()->get();
        $curriculums = $subject->curricula()->get();

        // Get all teachers related to this subject
        $teachers = $subject->assignedTeachers()->get()->unique('id');

        // Use the existing relationship for all grade levels tied to this subject
        $grades = $subject->assignedTeacherGrades()->with('sections')->get();

        // Prepare grade + sections in consistent format
        $gradesWithSections = $grades->map(function ($grade) {
            return [
                'id' => $grade->id,
                'name' => $grade->name,
                'sections' => $grade->sections,
                'model' => $grade,
            ];
        });

        return view('subjects.show', compact(
            'subject',
            'assignments',
            'curriculums',
            'teachers',
            'gradesWithSections'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        $curriculums = Curriculum::all();
        $teachers = User::role('teacher')->get();
        $gradeLevels = GradeLevel::all();

        // Get the grade levels currently assigned to this subject for the selected teacher (if any)
        $assignedGradeLevels = $subject->assignedTeacherGrades->pluck('id')->toArray();
        $assignedTeacherId = optional($subject->assignedTeachers->first())->id;

        return view('subjects.edit', compact(
            'subject',
            'curriculums',
            'teachers',
            'gradeLevels',
            'assignedGradeLevels',
            'assignedTeacherId'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $validated = $request->validated();

        // Update subject name
        $subject->update($request->only('name'));

        // Sync curricula with timestamps
        $syncCurricula = collect($validated['curricula'])->mapWithKeys(fn($id) => [
            $id => ['created_at' => now(), 'updated_at' => now()]
        ])->toArray();
        $subject->curricula()->sync($syncCurricula);

        // Sync teacher-grade assignments efficiently
        $teacherId = $validated['teacher_id'];
        $syncTeacherGrades = collect($validated['grade_levels'])->mapWithKeys(fn($gradeLevelId) => [
            $teacherId . '_' . $gradeLevelId => [
                'teacher_id' => $teacherId,
                'grade_level_id' => $gradeLevelId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ])->values()->toArray();

        // Remove old assignments and insert new ones in bulk
        $subject->assignedTeachers()->detach(); // remove old pivot rows
        foreach ($syncTeacherGrades as $data) {
            $subject->assignedTeachers()->attach($data['teacher_id'], [
                'grade_level_id' => $data['grade_level_id'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]);
        }

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully');
    }
}
