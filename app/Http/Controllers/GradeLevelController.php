<?php

namespace App\Http\Controllers;

use App\Models\GradeLevel;
use App\Http\Requests\StoreGradeLevelRequest;
use App\Http\Requests\UpdateGradeLevelRequest;

class GradeLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gradeLevels = GradeLevel::all();

        return view('grade-levels.index', compact('gradeLevels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('grade-levels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeLevelRequest $request)
    {
        $validated = $request->validated();

        // Create grade level
        $gradeLevel = GradeLevel::create([
            'name' => "Grade " . $validated['number'],
        ]);

        return redirect()->route('grade-levels.index')->with('success', "{$gradeLevel->name} created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(GradeLevel $gradeLevel)
    {
        $sections = $gradeLevel->sections()->get();
        $subjects = $gradeLevel->subjects()->get();
        $teachers = $gradeLevel->assignedTeachers()->get()->unique('id');
        $students = $gradeLevel->students()->get();

        return view('grade-levels.show', compact(
            'gradeLevel',
            'sections',
            'subjects',
            'teachers',
            'students'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GradeLevel $gradeLevel)
    {
        // Extract number from the "Grade"
        $gradeNumber = (int) filter_var($gradeLevel->name, FILTER_SANITIZE_NUMBER_INT);

        return view('grade-levels.edit', compact('gradeLevel', 'gradeNumber'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeLevelRequest $request, GradeLevel $gradeLevel)
    {
        $validated = $request->validated();

        $gradeLevel->update([
            'name' => "Grade " . $validated['number'],
        ]);

        return redirect()->route('grade-levels.index')->with('success', "{$gradeLevel->name} updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GradeLevel $gradeLevel)
    {
        // Check if the grade level has any students or sections
        if ($gradeLevel->subjects()->exists() || $gradeLevel->students()->exists()) {
            return redirect()->route('grade-levels.index')
                ->withErrors(['error' => 'Cannot delete this grade level because it is assigned to subjects or has enrolled students.']);
        }

        $gradeLevel->delete();

        return redirect()->route('grade-levels.index')->with('success', 'Grade level deleted successfully!');
    }
}
