<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Http\Requests\StoreCurriculumRequest;
use App\Http\Requests\UpdateCurriculumRequest;
use Illuminate\Database\QueryException;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $curriculums = Curriculum::all();

        return view('curriculums.index', compact('curriculums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('curriculums.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCurriculumRequest $request)
    {
        Curriculum::create($request->validated());

        return redirect()->route('curriculums.index')->with('success', 'Curriculum created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curriculum $curriculum)
    {
        $subjects = $curriculum->subjects()->get();
        $students = $curriculum->students()->get();

        return view('curriculums.show', compact('curriculum', 'subjects', 'students'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curriculum $curriculum)
    {
        return view('curriculums.edit', compact('curriculum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurriculumRequest $request, Curriculum $curriculum)
    {
        $curriculum->update($request->validated());

        return redirect()->route('curriculums.index')->with('success', 'Curriculum updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curriculum $curriculum)
    {
        if ($curriculum->students()->exists() || $curriculum->subjects()->exists()) {
            return back()->withErrors([
                'error' => 'This curriculum cannot be deleted because it still has enrolled students or subjects assigned.',
            ]);
        }

        $curriculum->delete();

        return redirect()->route('curriculums.index')->with('success', 'Curriculum deleted successfully');
    }
}
