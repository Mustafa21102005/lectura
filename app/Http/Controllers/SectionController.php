<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\GradeLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = GradeLevel::with('sections')->get();

        return view('sections.index', compact('grades'));
    }

    /**
     * Show the sections for the given grade level.
     *
     * @param GradeLevel $gradeLevel
     * @return \Illuminate\Http\Response
     */
    public function show(GradeLevel $gradeLevel)
    {
        $possibleSections = ['A', 'B', 'C', 'D'];

        $existingSections = $gradeLevel->sections
            ->pluck('name')
            ->map(fn($n) => strtoupper(preg_replace('/.*([A-Z])$/i', '$1', $n)))
            ->toArray();

        return view('sections.show', compact(
            'gradeLevel',
            'possibleSections',
            'existingSections'
        ));
    }

    /**
     * Update the sections for the given grade level.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\GradeLevel $gradeLevel
     * @return \Illuminate\Http\Response
     */
    public function manage(Request $request, GradeLevel $gradeLevel)
    {
        $sections = collect($request->input('sections', []))
            ->map(fn($s) => strtoupper($s))
            ->toArray();

        DB::transaction(function () use ($gradeLevel, $sections) {

            // Fetch existing sections and normalize
            $existingSections = $gradeLevel->sections
                ->pluck('name')
                ->map(fn($n) => strtoupper(substr($n, -1)))
                ->toArray();

            // Determine which sections to add/delete
            $toAdd = array_diff($sections, $existingSections);
            $toDelete = array_diff($existingSections, $sections);

            $now = now();

            // Insert new sections
            foreach ($toAdd as $letter) {
                Section::create([
                    'name' => "Section {$letter}",
                    'grade_level_id' => $gradeLevel->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            // Delete removed sections
            if (!empty($toDelete)) {
                Section::where('grade_level_id', $gradeLevel->id)
                    ->whereIn(DB::raw("UPPER(RIGHT(name, 1))"), $toDelete)
                    ->delete();
            }
        });

        return redirect()->route('sections.index', $gradeLevel)->with('success', 'Sections updated successfully!');
    }
}
