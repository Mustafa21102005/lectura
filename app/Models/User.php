<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed'
        ];
    }

    /**
     * Creates a new notification setting for the user based on their role.
     * If the user already has notification settings, this method will do nothing.
     */
    public function createNotificationSettingsByRole()
    {
        if ($this->notificationSettings()->exists()) {
            return;
        }

        if ($this->hasRole('teacher')) {

            $this->notificationSettings()->create([
                'assignment_submissions' => true,
                'subject_changes'        => true,
                'new_assignments'        => false,
                'new_study_materials'    => false,
                'deadlines'              => false,
                'grades'                 => false,
            ]);
        } elseif ($this->hasRole('student')) {

            $this->notificationSettings()->create([
                'assignment_submissions' => false,
                'subject_changes'        => false,
                'new_assignments'        => true,
                'new_study_materials'    => true,
                'deadlines'              => true,
                'grades'                 => true,
            ]);
        }
    }

    /**
     * Get the curricula that this student belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function curricula()
    {
        return $this->belongsToMany(
            Curriculum::class,
            'student_curriculum', // pivot table
            'student_id',         // foreign key on pivot table for this model
            'curriculum_id'       // foreign key on pivot table for related model
        )
            ->withPivot('grade_level_id', 'section_id')
            ->withTimestamps();
    }

    /**
     * Get all subjects that belong to the User through assigned curricula.
     *
     * @return \Illuminate\Support\Collection<\App\Models\Subject>
     */
    public function studentSubjects()
    {
        // get all subjects through assigned curricula
        return $this->curricula()->with('subjects')->get()->flatMap->subjects;
    }

    /**
     * Get the subjects that the teacher is assigned to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teacherSubjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'teacher_subject_grade_level',
            'teacher_id',
            'subject_id'
        )->withPivot('grade_level_id')->withTimestamps();
    }

    /**
     * Get all submissions that belong to the teacher.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function teacherSubmissions()
    {
        return Submission::whereHas('assignment', function ($q) {
            $q->where('teacher_id', $this->id);
        });
    }

    /**
     * Get all children of the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\User>
     */
    public function children()
    {
        return $this->belongsToMany(User::class, 'parent_student', 'parent_id', 'student_id');
    }

    /**
     * Get all parents of the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\User>
     */
    public function parents()
    {
        return $this->belongsToMany(User::class, 'parent_student', 'student_id', 'parent_id');
    }

    /**
     * Get all of the submissions for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Submission>
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'student_id');
    }

    /**
     * Get all assignments that belong to the teacher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Assignment>
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'teacher_id');
    }

    /**
     * Get the notification settings associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function notificationSettings()
    {
        return $this->hasOne(NotificationSetting::class);
    }

    /**
     * Get all assignment reminders that belong to the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\AssignmentReminder>
     */
    public function assignmentReminders()
    {
        return $this->hasMany(AssignmentReminder::class, 'student_id');
    }
}
