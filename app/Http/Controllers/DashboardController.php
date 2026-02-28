<?php

namespace App\Http\Controllers;

use App\Models\{Assignment, Curriculum, Grade, GradeLevel, Submission, User};
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the dashboard for the authenticated user.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // * ====== Admin Dashboard === ===
        $totalStudentsAdmin = User::role('student')->count();
        $totalTeachers = User::role('teacher')->count();
        $totalParents = User::role('parent')->count();
        $totalAssignmentsAdmin = Assignment::count();

        // Get grade levels with student count
        $grades = GradeLevel::withCount('students')->get();

        // Assignments submitted per day (last 7 days)
        $startDate = Carbon::today()->subDays(6);
        $endDate = Carbon::today()->endOfDay();

        $dailySubmissions = Submission::whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(fn($submission) => $submission->created_at->format('Y-m-d'));

        $dates = collect(range(0, 6))
            ->map(fn($i) => Carbon::today()->subDays(6 - $i)->format('Y-m-d'));

        $submissions = $dates->map(fn($date) => $dailySubmissions->get($date)?->count() ?? 0);

        // Graded vs Ungraded submissions
        $graded = Grade::count();
        $ungraded = Submission::doesntHave('grade')->count();

        // All ungraded submissions grouped by teacher - optimized
        $teachersWithUngraded = User::role('teacher')
            ->with(['assignments.submissions' => fn($query) => $query->doesntHave('grade')])
            ->get()
            ->map(function ($teacher) {
                $ungradedCount = $teacher->assignments->flatMap->submissions->count();
                return $ungradedCount > 0
                    ? ['teacher' => $teacher, 'ungraded_count' => $ungradedCount]
                    : null;
            })
            ->filter(); // removes nulls

        // Recent submissions (latest 6)
        $recentSubmissions = Submission::with(['student', 'assignment', 'grade'])
            ->latest()
            ->take(6)
            ->get();
        // * ====== Admin Dashboard === ===

        // * ====== Teacher Dashboard ======
        $teacher = Auth::user();

        // Get subject IDs the teacher teaches
        $subjectIds = $teacher->teacherSubjects->pluck('id');

        // Get grade levels the teacher teaches
        $gradeLevelIds = $teacher->teacherSubjects->pluck('pivot.grade_level_id')->unique();

        // Get curricula that include those subjects
        $curriculumIds = Curriculum::whereHas('subjects', function ($query) use ($subjectIds) {
            $query->whereIn('subjects.id', $subjectIds);
        })->pluck('id');

        // Total students this teacher is responsible for
        $totalStudents = User::whereHas('curricula', function ($query) use ($curriculumIds, $gradeLevelIds) {
            $query->whereIn('curriculum_id', $curriculumIds)
                ->whereIn('grade_level_id', $gradeLevelIds);
        })
            ->role('Student')
            ->count();

        // Total unique subjects the teacher teaches
        $totalSubjects = $teacher->teacherSubjects()->distinct('subjects.id')->count('subjects.id');

        // Total ungraded submissions for this teacher
        $totalUngraded = $teacher->teacherSubmissions()
            ->whereIn('status', ['submitted', 'late'])
            ->count();

        // Total assignments by this teacher
        $totalAssignmentsTeacher = $teacher->assignments()->count();

        // Get all submissions for this teacher
        $teacherSubmissions = $teacher->teacherSubmissions()->get();

        // Count by status
        $submissionStatusCounts = [
            'submitted' => $teacherSubmissions->where('status', 'submitted')->count(),
            'late' => $teacherSubmissions->where('status', 'late')->count(),
            'graded' => $teacherSubmissions->where('status', 'graded')->count(),
        ];

        // Get subject IDs the teacher teaches
        $subjectIds = $teacher->teacherSubjects->pluck('id');

        // Get top 3 students based on teacher's subjects
        $topStudentIds = Grade::join('submissions', 'grades.submission_id', '=', 'submissions.id')
            ->join('assignments', 'submissions.assignment_id', '=', 'assignments.id')
            ->whereIn('assignments.subject_id', $subjectIds) // subjects teacher teaches
            ->where('assignments.teacher_id', $teacher->id) // only assignments by THIS teacher
            ->whereHas('submission.student.curricula', function ($query) use ($curriculumIds, $gradeLevelIds) {
                $query->whereIn('curriculum_id', $curriculumIds)
                    ->whereIn('grade_level_id', $gradeLevelIds);
            })
            ->selectRaw('submissions.student_id, AVG(grades.score) as avg_score')
            ->groupBy('submissions.student_id')
            ->orderByDesc('avg_score')
            ->take(3)
            ->get();

        // Fetch student info
        $topStudents = $topStudentIds->map(function ($item) {
            $student = User::find($item->student_id);
            return [
                'student' => $student,
                'avg_score' => round($item->avg_score, 2),
            ];
        });

        // Students with most late submissions
        $lateStudents = Submission::join('assignments', 'submissions.assignment_id', '=', 'assignments.id')
            ->where('assignments.teacher_id', $teacher->id)
            ->where('submissions.status', 'late')
            ->selectRaw('submissions.student_id, COUNT(*) as late_count')
            ->groupBy('submissions.student_id')
            ->orderByDesc('late_count')
            ->take(3)
            ->get();

        // Fetch student info
        $lateStudentsList = $lateStudents->map(function ($item) {
            $student = User::find($item->student_id);
            return [
                'name' => $student?->name ?? 'Unknown',
                'late_count' => $item->late_count,
            ];
        });

        $studentsWithUngraded = User::role('student')
            ->whereHas('submissions', function ($query) use ($teacher) {
                $query->whereHas('assignment', function ($q) use ($teacher) {
                    $q->where('teacher_id', $teacher->id);
                })
                    ->where('status', 'submitted'); // only ungraded
            })
            ->with(['submissions' => function ($query) use ($teacher) {
                $query->whereHas('assignment', function ($a) use ($teacher) {
                    $a->where('teacher_id', $teacher->id);
                })
                    ->where('status', 'submitted')
                    ->orderBy('created_at');
            }])
            ->get()
            ->map(function ($student) {
                return [
                    'student' => $student,
                    'ungraded_count' => $student->submissions->count(),
                    'first_submission' => $student->submissions->first(),
                ];
            });

        $teacherAssignments = $teacher->assignments()
            ->withCount('submissions')
            ->get()
            ->map(function ($assignment) {
                $assignment->total_students = $assignment->students()->count();
                return $assignment;
            });
        // * ====== End Teacher Dashboard ======

        // * ====== Student Dashboard ======
        $student = Auth::user();

        // Get all subject IDs from curricula
        $subjectIds = $student->curricula()
            ->with('subjects')
            ->get()
            ->flatMap->subjects
            ->pluck('id')
            ->unique();

        // Get all assignments for those subjects
        $studentAssignments = Assignment::whereIn('subject_id', $subjectIds)
            ->with(['submissions' => function ($q) use ($student) {
                $q->where('student_id', $student->id);
            }])
            ->get();

        // Count pending assignments
        $pendingAssignments = $studentAssignments->filter(function ($assignment) {
            return $assignment->submissions->isEmpty();
        })->count();

        // Total subjects the student is taking
        $totalStudentSubjects = $student->studentSubjects()->unique('id')->count();

        // Get all graded submissions for the student
        $gradedSubmissions = $student->submissions()->whereHas('grade')->with('grade')->get();

        $averageGrade = $gradedSubmissions->count()
            ? round($gradedSubmissions->avg(fn($s) => $s->grade->score), 2)
            : 0;

        // Get all subjects the student is enrolled in
        $subjectIds = $student->studentSubjects()->pluck('id');

        // Get all assignments that belong to those subjects
        $totalStudentAssignments = Assignment::whereIn('subject_id', $subjectIds)->count();

        // Count how many submissions this student has made
        $submittedAssignments = Submission::where('student_id', $student->id)->count();

        // Calculate pending assignments
        $pendingStudentAssignments = max($totalStudentAssignments - $submittedAssignments, 0);

        // Determine if submissions are less than half
        $isLowSubmission = $totalStudentAssignments > 0 && $submittedAssignments < ($totalStudentAssignments / 2);

        // Count student's submissions by status
        $studentSubmissionStatusCounts = [
            'submitted' => $student->submissions()->where('status', 'submitted')->count(),
            'late' =>      $student->submissions()->where('status', 'late')->count(),
            'graded' =>    $student->submissions()->where('status', 'graded')->count(),
        ];

        // Top subjects for the student (by average grade)
        $topSubjects = Grade::join('submissions', 'grades.submission_id', '=', 'submissions.id')
            ->join('assignments', 'submissions.assignment_id', '=', 'assignments.id')
            ->join('subjects', 'assignments.subject_id', '=', 'subjects.id')
            ->where('submissions.student_id', $student->id)
            ->selectRaw('subjects.name as subject_name, AVG(grades.score) as avg_score')
            ->groupBy('subjects.name')
            ->orderByDesc('avg_score')
            ->take(3)
            ->get();

        $lateSubjects = Submission::join('assignments', 'submissions.assignment_id', '=', 'assignments.id')
            ->join('subjects', 'assignments.subject_id', '=', 'subjects.id')
            ->where('submissions.student_id', $student->id)
            ->where('submissions.status', 'late')
            ->selectRaw('subjects.name as subject_name, COUNT(*) as late_count')
            ->groupBy('subjects.name')
            ->orderByDesc('late_count')
            ->take(3)
            ->get();

        // Count ALL pending assignments (not just the first 6)
        $totalPendingAssignments = Assignment::whereDoesntHave('submissions', function ($query) use ($student) {
            $query->where('student_id', $student->id);
        })->count();

        // Fetch only the first 6 to display
        $studentPendingAssignments = Assignment::whereDoesntHave('submissions', function ($query) use ($student) {
            $query->where('student_id', $student->id);
        })
            ->orderBy('due_date', 'asc')
            ->take(6)
            ->get();

        $Studentassignments = Assignment::with(['submissions' => function ($query) use ($student) {
            $query->where('student_id', $student->id);
        }])->orderBy('due_date', 'asc')
            ->take(10)
            ->get();
        // * ====== End Student Dashboard ======

        // * ====== Parent Dashboard ======
        $parent = auth()->user();

        $childrenCount = $parent->children()->count();

        $assignmentchildIds = $parent->children()->pluck('users.id')->toArray();

        $pendingAssignmentsCount = Assignment::whereDoesntHave('submissions', function ($q) use ($assignmentchildIds) {
            $q->whereIn('student_id', $assignmentchildIds);
        })->count();

        $gradedAssignmentsCount = Submission::whereIn('student_id', $parent->children()->pluck('users.id'))
            ->whereHas('grade')
            ->count();

        $lateSubmissionsCount = Submission::whereIn('student_id', $parent->children()->pluck('users.id'))
            ->where('status', 'late')
            ->count();

        // Get all children IDs
        $childrenIds = $parent->children()->pluck('users.id');

        // Count submissions by status for all children
        $childrenSubmissionStatusCounts = [
            'submitted' => Submission::whereIn('student_id', $childrenIds)->where('status', 'submitted')->count(),
            'late' => Submission::whereIn('student_id', $childrenIds)->where('status', 'late')->count(),
            'graded' => Submission::whereIn('student_id', $childrenIds)->where('status', 'graded')->count(),
        ];

        // Subjects with most late submissions
        $ParentLateSubjects = Submission::join('assignments', 'submissions.assignment_id', '=', 'assignments.id')
            ->join('subjects', 'assignments.subject_id', '=', 'subjects.id')
            ->whereIn('submissions.student_id', $childrenIds)
            ->where('submissions.status', 'late')
            ->selectRaw('subjects.name as subject_name, COUNT(*) as late_count')
            ->groupBy('subjects.name')
            ->orderByDesc('late_count')
            ->take(3)
            ->get();

        $childrenAvgGrades = User::whereIn('id', $childrenIds)
            ->with(['submissions' => function ($q) {
                $q->whereHas('grade');
            }])
            ->get()
            ->map(function ($child) {
                $grades = $child->submissions->pluck('grade.score');
                $avgGrade = $grades->count() ? round($grades->avg(), 2) : 0;
                return [
                    'name' => $child->name,
                    'avg_grade' => $avgGrade,
                ];
            });

        $pendingAssignmentsForChildren = Assignment::whereHas('submissions', function ($q) use ($childrenIds) {
            $q->whereIn('student_id', $childrenIds);
        }, '<', 1)
            ->with(['submissions', 'subject'])
            ->get()
            ->groupBy(function ($assignment) use ($childrenIds) {
                // Determine which child hasn't submitted
                foreach ($childrenIds as $id) {
                    if (!$assignment->submissions->contains('student_id', $id)) {
                        return User::find($id)->name;
                    }
                }
                return 'Unknown';
            });

        $childrenProgressTimeline = [];

        $children = $parent->children()->get();

        foreach ($children as $child) {
            $totalAssignments = Assignment::whereIn('subject_id', $child->studentSubjects()->pluck('id'))
                ->count();

            $submitted = $child->submissions()->count();

            $percentage = $totalAssignments
                ? round(($submitted / $totalAssignments) * 100, 2)
                : 0;

            $childrenProgressTimeline[$child->name] = [
                'submitted' => $submitted,
                'total' => $totalAssignments,
                'percentage' => $percentage,
            ];
        }
        // * ====== End Parent Dashboard ======

        return view('dashboard', [
            'totalStudentsAdmin' => $totalStudentsAdmin,
            'totalTeachers' => $totalTeachers,
            'totalParents' => $totalParents,
            'grades' => $grades,
            'submissionDates' => $dates,
            'submissionCounts' => $submissions,
            'graded' => $graded,
            'ungraded' => $ungraded,
            'teachersWithUngraded' => $teachersWithUngraded,
            'recentSubmissions' => $recentSubmissions,
            'totalAssignmentsAdmin' => $totalAssignmentsAdmin,
            'totalStudents' => $totalStudents,
            'totalSubjects' => $totalSubjects,
            'totalUngraded' => $totalUngraded,
            'totalAssignmentsTeacher' => $totalAssignmentsTeacher,
            'submissionStatusCounts' => $submissionStatusCounts,
            'topStudents' => $topStudents,
            'lateStudentsList' => $lateStudentsList,
            'studentsWithUngraded' => $studentsWithUngraded,
            'teacherAssignments' => $teacherAssignments,
            'pendingAssignments' => $pendingAssignments,
            'totalStudentSubjects' => $totalStudentSubjects,
            'averageGrade' => $averageGrade,
            'pendingStudentAssignments' => $pendingStudentAssignments,
            'submittedAssignments' => $submittedAssignments,
            'totalStudentAssignments' => $totalStudentAssignments,
            'isLowSubmission' => $isLowSubmission,
            'studentSubmissionStatusCounts' => $studentSubmissionStatusCounts,
            'topSubjects' => $topSubjects,
            'lateSubjects' => $lateSubjects,
            'studentPendingAssignments' => $studentPendingAssignments,
            'Studentassignments' => $Studentassignments,
            'totalPendingAssignments' => $totalPendingAssignments,
            'childrenCount' => $childrenCount,
            'pendingAssignmentsCount' => $pendingAssignmentsCount,
            'gradedAssignmentsCount' => $gradedAssignmentsCount,
            'lateSubmissionsCount' => $lateSubmissionsCount,
            'childrenSubmissionStatusCounts' => $childrenSubmissionStatusCounts,
            'ParentLateSubjects' => $ParentLateSubjects,
            'childrenAvgGrades' => $childrenAvgGrades,
            'pendingAssignmentsForChildren' => $pendingAssignmentsForChildren,
            'childrenProgressTimeline' => $childrenProgressTimeline
        ]);
    }
}
