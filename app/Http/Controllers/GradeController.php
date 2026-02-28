<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Models\Submission;
use App\Notifications\GradeNotification;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::all();

        return view('grades.index', compact('grades'));
    }

    /**
     * Display a listing of the resource assigned to the student.
     */
    public function studentIndex()
    {
        $student = auth()->user();

        $grades = Grade::with([
            'submission.assignment.subject', // eager-load related models
        ])
            ->whereHas('submission', function ($query) use ($student) {
                $query->where('student_id', $student->id);
            })
            ->latest()
            ->get();

        return view('grades.student.index', compact('grades'));
    }

    /**
     * Display a listing of all grades belonging to the parent's children.
     */
    public function parentIndex()
    {
        $parent = Auth::user();

        // Get all grades for assignments submitted by this parent's children
        $grades = Grade::with([
            'submission.assignment', // assignment info
            'student'                // student (child) info
        ])
            ->whereHas('student.parents', function ($query) use ($parent) {
                $query->where('parent_id', $parent->id);
            })
            ->latest()
            ->get();

        return view('grades.parent.index', compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
        $data = $request->validated();

        $submission = Submission::findOrFail($data['submission_id']);

        $grade = Grade::create([
            'submission_id' => $submission->id,
            'score' => $data['score'],
            'remarks' => $data['remarks'] ?? null,
        ]);

        $submission->status = 'graded';
        $submission->save();

        $student = $submission->student;

        if ($student->notificationSettings && $student->notificationSettings->grades) {
            $student->notify(new GradeNotification($grade, 'new'));
        }

        return redirect()->route('submissions.show', $submission)->with('success', 'Submission graded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        return view('grades.show', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $data = $request->validated();

        $grade->update([
            'score' => $data['score'],
            'remarks' => $data['remarks'] ?? null,
        ]);

        $student = $grade->submission->student;

        if ($student->notificationSettings && $student->notificationSettings->grades) {
            $student->notify(new GradeNotification($grade, 'updated'));
        }

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully!');
    }
}
