<?php

use App\Http\Controllers\{
    AssignmentController,
    CurriculumController,
    DashboardController,
    GradeController,
    GradeLevelController,
    HomeController,
    MaterialTypeController,
    NotificationSettingController,
    ProfileController,
    SectionController,
    StudyMaterialController,
    SubjectController,
    SubmissionController,
    UploadController,
    UserController
};
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authenitcated & Verified Middleware
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('workspace', [DashboardController::class, 'index'])->name('dashboard');

    // Teacher Routes
    Route::middleware(['role:teacher'])->group(function () {
        Route::get('teacher/subjects', [SubjectController::class, 'teacherIndex'])
            ->name('teacher.subjects.index');

        Route::get('teacher/students', [UserController::class, 'teacherIndex'])
            ->name('teacher.students.index');

        Route::resource('material-types', MaterialTypeController::class);

        Route::resource('study-materials', StudyMaterialController::class)->except('show');

        Route::delete('study-materials/media/{media}', [StudyMaterialController::class, 'destroyMedia'])
            ->name('study-materials.media.destroy');

        Route::delete('/assignments/media/{media}', [AssignmentController::class, 'destroyMedia']);

        Route::resource('assignments', AssignmentController::class)->except('show');

        Route::resource('grades', GradeController::class)->except('destroy', 'create', 'edit', 'show');

        Route::get('submissions', [SubmissionController::class, 'index'])
            ->name('submissions.index');
    });

    // Admin Routes
    Route::middleware(['role:admin'])->group(function () {

        Route::resource('curriculums', CurriculumController::class)->except('show');

        Route::resource('subjects', SubjectController::class)->except('show');

        Route::resource('users', UserController::class)->except('show');

        Route::post('/users/{parent}/children', [UserController::class, 'storeChild'])
            ->name('users.store-child');

        Route::resource('grade-levels', GradeLevelController::class)->except('show');

        Route::prefix('sections')->group(function () {
            Route::get('/', [SectionController::class, 'index'])->name('sections.index');

            Route::get('/{gradeLevel}/manage', [SectionController::class, 'show'])
                ->name('sections.show');

            Route::post('/{gradeLevel}/manage', [SectionController::class, 'manage'])
                ->name('sections.manage');
        });
    });

    // Student Routes
    Route::middleware(['role:student'])->group(function () {
        Route::get('student/assignments', [AssignmentController::class, 'studentIndex'])
            ->name('student.assignments.index');

        Route::get('submissions/{assignment:slug}/create', [SubmissionController::class, 'create'])
            ->name('submissions.create');

        Route::post('submissions', [SubmissionController::class, 'store'])
            ->name('submissions.store');

        Route::get('submissions/{submission}/edit', [SubmissionController::class, 'edit'])
            ->name('submissions.edit');

        Route::put('submissions/{submission}', [SubmissionController::class, 'update'])
            ->name('submissions.update');

        Route::get('my/info', [UserController::class, 'studentIndex'])->name('student.info');

        Route::get('student/submissions', [SubmissionController::class, 'studentIndex'])
            ->name('student.submissions.index');

        Route::get('student/study-materials', [StudyMaterialController::class, 'studentIndex'])
            ->name('student.study-materials.index');

        Route::get('student/grades', [GradeController::class, 'studentIndex'])
            ->name('student.grades.index');

        Route::get('student/subjects', [SubjectController::class, 'studentIndex'])
            ->name('student.subjects.index');
    });

    // All Users Routes
    Route::middleware(['role:admin|teacher|parent|student'])->group(function () {

        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

        Route::get('curriculums/{curriculum}', [CurriculumController::class, 'show'])
            ->name('curriculums.show');

        Route::get('subjects/{subject}', [SubjectController::class, 'show'])->name('subjects.show');

        Route::get('grade-levels/{gradeLevel}', [GradeLevelController::class, 'show'])
            ->name('grade-levels.show');

        Route::get('study-materials/{studyMaterial}', [StudyMaterialController::class, 'show'])
            ->name('study-materials.show');

        Route::get('submissions/{submission}', [SubmissionController::class, 'show'])
            ->name('submissions.show');
    });

    // Student and Teacher Routes
    Route::middleware(['role:student|teacher'])->group(function () {

        Route::middleware(['signed'])->group(function () {
            Route::get('/study-materials/media/{media}/temp', [StudyMaterialController::class, 'tempView'])
                ->name('study-materials.media.temp');

            Route::get('/assignments/media/{media}/temp', [AssignmentController::class, 'tempView'])
                ->name('assignments.media.temp');

            Route::get('/submissions/media/{media}/temp', [SubmissionController::class, 'tempView'])
                ->name('submissions.media.temp');
        });

        Route::delete('/submissions/media/{media}', [SubmissionController::class, 'destroyMedia']);

        Route::post('uploads', [UploadController::class, 'upload']);

        Route::delete('/uploads/revert/{folder}', [UploadController::class, 'revert']);
    });

    // Student, Parent, and Teacher Routes
    Route::middleware(['role:student|parent|teacher'])->group(function () {

        Route::get('assignments/{assignment}', [AssignmentController::class, 'show'])
            ->name('assignments.show');

        Route::get('grades/{grade}', [GradeController::class, 'show'])->name('grades.show');
    });

    // Parent Routes
    Route::middleware(['role:parent'])->group(function () {

        Route::get('my/children', [UserController::class, 'parentIndex'])->name('parent.users.index');

        Route::get('child/assignments', [AssignmentController::class, 'parentIndex'])
            ->name('parent.assignments.index');

        Route::get('child/grades', [GradeController::class, 'parentIndex'])
            ->name('parent.grades.index');

        Route::get('child/submissions', [SubmissionController::class, 'parentIndex'])
            ->name('parent.submissions.index');

        Route::get('child/study-materials', [StudyMaterialController::class, 'parentIndex'])
            ->name('parent.study-materials.index');
    });
});

// Authenticated Middleware
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/settings/notifications/toggle', [NotificationSettingController::class, 'toggle'])
        ->name('notification-settings.toggle');
});

require __DIR__ . '/auth.php';
