<?php

namespace App\Http\Controllers;

use App\Models\{Curriculum, GradeLevel, User};

class HomeController extends Controller
{
    /**
     * Home page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /* -------------------------
         |  Teachers
         --------------------------*/
        $teachers = User::role('teacher')
            ->with([
                'teacherSubjects.assignedTeachers'
            ])
            ->take(4)
            ->get()
            ->map(function ($teacher) {

                $assignments = $teacher->teacherSubjects
                    ->map(function ($subject) use ($teacher) {

                        $pivot = $subject->assignedTeachers
                            ->firstWhere('id', $teacher->id)
                            ?->pivot;

                        $gradeName = GradeLevel::find($pivot?->grade_level_id)->name
                            ?? 'Unknown Grade';

                        preg_match('/(\d+)([A-Z]?)/i', $gradeName, $matches);

                        return [
                            'subject' => $subject->name,
                            'gradeNumber' => $matches[1] ?? $gradeName,
                            'section' => $matches[2] ?? '',
                        ];
                    })
                    ->groupBy(fn($item) => $item['subject'] . '-' . $item['gradeNumber'])
                    ->map(function ($items) {

                        $subjectName = $items[0]['subject'];
                        $gradeNum = $items[0]['gradeNumber'];

                        $sections = array_filter(
                            array_column($items->toArray(), 'section')
                        );

                        sort($sections);

                        if (count($sections) > 1) {
                            $gradeDisplay = "Grade {$gradeNum}" . implode(', ', $sections);
                        } elseif (count($sections) === 1) {
                            $gradeDisplay = "Grade {$gradeNum}{$sections[0]}";
                        } else {
                            $gradeDisplay = "Grade {$gradeNum}";
                        }

                        return $subjectName . ' (' . $gradeDisplay . ')';
                    })
                    ->unique()
                    ->values()
                    ->toArray();

                $teacher->firstSubjects = array_slice($assignments, 0, 2);
                $teacher->extraSubjects = array_slice($assignments, 2);

                return $teacher;
            });

        /* -------------------------
         |  Curriculums + Subjects
         --------------------------*/

        $curriculums = Curriculum::with([
            'subjects.assignedTeacherGrades',
            'subjects.curricula'
        ])->get();

        $subjects = $curriculums
            ->pluck('subjects')
            ->flatten()
            ->unique('id')
            ->map(function ($subject) {

                // Filter classes
                $subject->filter_classes = $subject->curricula
                    ->map(fn($c) => "curriculum-{$c->id}")
                    ->implode(' ');

                // Collect grade names
                $grades = $subject->assignedTeacherGrades
                    ->pluck('name')
                    ->unique()
                    ->sort()
                    ->values()
                    ->toArray();

                $subject->grade_display = $this->formatGradeRanges($grades);

                return $subject;
            });

        return view('home', compact('teachers', 'curriculums', 'subjects'));
    }

    /* -------------------------
     |  Helper Methods
     --------------------------*/

    /**
     * Extracts the grade number from a grade name string.
     *
     * Example: "Grade 10" will return 10.
     *
     * @param string $gradeName
     * @return int|null
     */
    private function extractGradeNumber($gradeName)
    {
        preg_match('/\d+/', $gradeName, $matches);
        return isset($matches[0]) ? (int) $matches[0] : null;
    }

    /**
     * Formats a list of grade ranges.
     *
     * Example: [10, 11, 12] will return "10 - 12".
     *
     * @param array $grades
     * @return string
     */
    private function formatGradeRanges($grades)
    {
        if (empty($grades)) {
            return '';
        }

        $numericGrades = array_map(
            fn($g) => $this->extractGradeNumber($g),
            $grades
        );

        $numericGrades = array_filter($numericGrades);
        sort($numericGrades);

        if (empty($numericGrades)) {
            return '';
        }

        $ranges = [];
        $start = $numericGrades[0];
        $end = $numericGrades[0];

        for ($i = 1; $i < count($numericGrades); $i++) {
            if ($numericGrades[$i] == $end + 1) {
                $end = $numericGrades[$i];
            } else {
                $ranges[] = $start == $end ? $start : "$start - $end";
                $start = $end = $numericGrades[$i];
            }
        }

        $ranges[] = $start == $end ? $start : "$start - $end";

        return implode(', ', $ranges);
    }
}
