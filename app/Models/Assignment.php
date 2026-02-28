<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Assignment extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\AssignmentFactory> */
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'subject_id',
        'grade_level_id',
        'teacher_id',
        'due_date',
        'max_score'
    ];

    private bool $syncFlag = false;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'datetime',
    ];

    /**
     * Set the slug when creating or updating the assignment
     *
     * When creating a new assignment, the slug will be generated using the title.
     * When updating an existing assignment, the slug will only be updated if the title changed.
     */
    protected static function booted()
    {
        static::creating(function ($assignment) {
            $assignment->slug = Str::slug($assignment->title);
        });

        static::updating(function ($assignment) {
            if ($assignment->isDirty('title')) {
                $assignment->slug = Str::slug($assignment->title);
            }
        });

        static::updated(function ($assignment) {

            // Only sync if subject or grade changed
            if ($assignment->wasChanged(['subject_id', 'grade_level_id'])) {

                $assignment->syncStudents();
            }
        });

        static::created(function ($assignment) {
            $assignment->syncStudents();
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get all of the submissions for the Assignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Get the teacher that owns the Assignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get all students who belong to curricula that include this assignment's subject.
     *
     * This method returns a collection of students who are enrolled in curricula
     * that include the subject of this assignment.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function students()
    {
        // Get all students who belong to curricula that include this assignment's subject
        return User::role('student')
            ->whereHas('curricula.subjects', function ($query) {
                $query->where('subjects.id', $this->subject_id);
            });
    }

    /**
     * Get the subject that owns the Assignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the grade level that owns the Assignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grade_level()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    /**
     * Get all reminder statuses for this assignment.
     *
     * @return HasMany<AssignmentReminder>
     */
    public function reminderStatuses()
    {
        return $this->hasMany(AssignmentReminder::class);
    }

    /**
     * Get all students who were reminded about this assignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function remindedStudents()
    {
        return $this->belongsToMany(User::class, 'assignment_reminders', 'assignment_id', 'student_id')
            ->withPivot(['sent', 'sent_at'])
            ->withTimestamps();
    }

    /**
     * Synchronize the reminder rows for this assignment.
     *
     * This method ensures that all students who should have a reminder
     * for this assignment have a corresponding and all students who should not
     * have a reminder row for this assignment do not have one.
     */
    public function syncStudents()
    {
        // Get current students
        $currentStudents = User::role('student')
            ->whereHas(
                'curricula',
                fn($q) =>
                $q->where('grade_level_id', $this->grade_level_id)
                    ->whereHas(
                        'subjects',
                        fn($q2) =>
                        $q2->where('subjects.id', $this->subject_id)
                    )
            )
            ->pluck('id')
            ->toArray();

        // Delete rows not in current students
        AssignmentReminder::where('assignment_id', $this->id)
            ->whereNotIn('student_id', $currentStudents)
            ->delete();

        // Insert missing rows
        $created = 0;
        foreach ($currentStudents as $studentId) {
            $row = AssignmentReminder::firstOrCreate([
                'assignment_id' => $this->id,
                'student_id'   => $studentId,
            ]);

            if ($row->wasRecentlyCreated) {
                $created++;
            }
        }
    }
}
