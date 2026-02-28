<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreChildRequest, StoreUserRequest, UpdateUserRequest};
use App\Models\{Curriculum, GradeLevel, User};
use Illuminate\Support\Facades\{Auth, Hash, DB};

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $curriculums = Curriculum::all();

        $gradeLevels = GradeLevel::with('sections')->get();

        $gradeSections = $gradeLevels->mapWithKeys(function ($grade) {
            return [
                $grade->id => $grade->sections->map(function ($section) {
                    return [
                        'id' => $section->id,
                        'name' => $section->name,
                    ];
                })
            ];
        });

        return view('users.create', compact(
            'curriculums',
            'gradeLevels',
            'gradeSections'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {

            $now = now();

            // Create main user
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'phone'    => $validated['phone'] ?? null,
                'password' => Hash::make('password'),
            ]);

            $user->assignRole($validated['role_id']);
            $user->createNotificationSettingsByRole();

            /*
            |--------------------------------------------------------------------------
            | Case 1: Student (Auto-create Parent)
            |--------------------------------------------------------------------------
            */
            if ($validated['role_id'] === 'student') {

                $parent = User::create([
                    'name'     => $validated['parent_name'],
                    'email'    => $validated['parent_email'],
                    'phone'    => $validated['parent_phone'] ?? null,
                    'password' => Hash::make('password'),
                ]);

                $parent->assignRole('parent');

                $user->parents()->attach($parent->id, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                $user->curricula()->attach($validated['curriculum_id'], [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Case 2: Parent (Create Multiple Children)
            |--------------------------------------------------------------------------
            */
            if ($validated['role_id'] === 'parent' && !empty($validated['children'])) {

                foreach ($validated['children'] as $childData) {

                    $child = User::create([
                        'name'     => $childData['name'],
                        'email'    => $childData['email'],
                        'password' => Hash::make('password'),
                    ]);

                    $child->assignRole('student');
                    $child->createNotificationSettingsByRole();

                    // Attach parent relation
                    $child->parents()->attach($user->id, [
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                    // Attach curriculum + grade + optional section
                    $pivotData = [
                        'grade_level_id' => $childData['grade_level_id'],
                        'created_at'     => $now,
                        'updated_at'     => $now,
                    ];

                    if (!empty($childData['section_id'])) {
                        $pivotData['section_id'] = $childData['section_id'];
                    }

                    $child->curricula()->attach(
                        $childData['curriculum_id'],
                        $pivotData
                    );
                }
            }
        });

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $curriculums = Curriculum::all();

        $user->load([
            'roles',
            'parents',
            'children',
            'curricula.gradeLevels',
            'curricula.sections',
            'teacherSubjects.gradeLevels',
        ]);

        // Only needed for teacher section table
        $teacherSubjects = $user->teacherSubjects;

        // For enroll child modal
        $gradeLevels = GradeLevel::with('sections')->get();

        $gradeSections = $gradeLevels->mapWithKeys(function ($grade) {
            return [
                $grade->id => $grade->sections->map(function ($section) {
                    return [
                        'id'   => $section->id,
                        'name' => $section->name,
                    ];
                })
            ];
        });

        return view('users.show', compact(
            'user',
            'curriculums',
            'teacherSubjects',
            'gradeLevels',
            'gradeSections'
        ));
    }

    /**
     * Store a newly created child user and associate them with a parent user.
     */
    public function storeChild(StoreChildRequest $request, User $parent)
    {
        $validated = $request->validated();

        // Create the child user
        $child = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt('password'), // default password
            'phone'    => $validated['phone'] ?? null,
        ]);

        // Assign student role and create notification settings
        $child->assignRole('student');
        $child->createNotificationSettingsByRole();

        // Attach parent-child relationship
        $child->parents()->attach($parent->id, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Attach curriculum, grade level, and section if provided
        if (!empty($validated['curriculum_id'])) {
            $attachData = [
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (!empty($validated['grade_level_id'])) {
                $attachData['grade_level_id'] = $validated['grade_level_id'];
            }

            if (!empty($validated['section_id'])) {
                $attachData['section_id'] = $validated['section_id'];
            }

            $child->curricula()->attach($validated['curriculum_id'], $attachData);
        }

        return back()->with('success', 'Child enrolled successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load(['curricula']);

        $curriculums = [];
        $gradeLevels = collect(); // default empty

        if ($user->hasRole('student')) {
            $curriculums = Curriculum::all();
            $gradeLevels = GradeLevel::with('sections')->get();
        }

        return view('users.edit', compact('user', 'curriculums', 'gradeLevels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        // Update basic info
        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;

        if ($user->hasRole('student') && isset($validated['curriculum_id'])) {
            // Sync curriculum with grade_level_id and section_id in the pivot table
            $user->curricula()->sync([
                $validated['curriculum_id'] => [
                    'grade_level_id' => $validated['grade_level_id'] ?? null,
                    'section_id'     => $validated['section_id'] ?? null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ],
            ]);
        }

        // Clear email verification if email is changed
        if ($user->email !== $validated['email']) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $authUser = auth()->user();

        // Prevent parents from being deleted directly
        if ($user->hasRole('parent')) {
            return redirect()->route('users.index')
                ->withErrors(['error' => 'Parents cannot be deleted directly.']);
        }

        // Prevent an admin from deleting themselves
        if ($authUser->id === $user->id && $user->hasRole('admin')) {
            return redirect()->route('users.index')
                ->withErrors(['error' => 'You cannot delete your own account.']);
        }

        // Prevent deleting a teacher if still assigned to subjects
        if ($user->hasRole('teacher') && $user->teacherSubjects()->exists()) {
            return redirect()->route('users.index')
                ->withErrors(['error' => 'This teacher is still assigned to subjects.']);
        }

        // If the user is a student, handle parent cleanup
        if ($user->hasRole('student')) {
            foreach ($user->parents as $parent) {
                $parent->children()->detach($user->id);

                $remainingChildren = $parent->children()->count();

                if ($remainingChildren === 0) {
                    $parent->delete();
                }
            }

            $user->curricula()->detach();
            $user->submissions()->delete();
        }

        // Finally delete the user
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Get all students that are in the same grade level and subject as the logged in teacher.
     *
     * @return \Illuminate\View\View
     */
    public function teacherIndex()
    {
        $teacher = Auth::user();

        // Get all subject IDs the teacher teaches
        $subjectIds = $teacher->teacherSubjects->pluck('id');

        // Get all grade levels where the teacher teaches those subjects
        $gradeLevelIds = $teacher->teacherSubjects->pluck('pivot.grade_level_id')->unique();

        // Get all curricula that include those subjects
        $curriculumIds = Curriculum::whereHas('subjects', function ($query) use ($subjectIds) {
            $query->whereIn('subjects.id', $subjectIds);
        })->pluck('id');

        // Now find students enrolled in those curricula and grade levels
        $students = User::whereHas('curricula', function ($query) use ($curriculumIds, $gradeLevelIds) {
            $query->whereIn('curriculum_id', $curriculumIds)
                ->whereIn('grade_level_id', $gradeLevelIds);
        })
            ->whereHas('roles', function ($q) {
                $q->where('name', 'Student');
            })
            ->get();

        return view('users.teacher.index', compact('students'));
    }

    /**
     * Display a list of the parent's children.
     */
    public function ParentIndex()
    {
        // Get the authenticated parent
        $parent = Auth::user();

        // Load children relationship
        $children = $parent->children()->with('curricula')->get();

        return view('users.parent.index', compact('children'));
    }

    /**
     * Show the logged-in student's info: enrolled curricula, grade levels, sections, and parents.
     */
    public function studentIndex()
    {
        $user = Auth::user();

        $user->load([
            'curricula.gradeLevels',
            'curricula.sections'
        ]);

        $enrollments = $user->curricula->map(function ($curriculum) {

            $gradeLevel = $curriculum->gradeLevels
                ->firstWhere('id', $curriculum->pivot->grade_level_id);

            $section = $curriculum->sections
                ->firstWhere('id', $curriculum->pivot->section_id);

            return [
                'curriculum' => $curriculum,
                'grade_level' => $gradeLevel,
                'section' => $section,
            ];
        });

        return view('users.student.index', compact('enrollments'));
    }
}
