<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Set the slug when creating or updating the subject
     *
     * @param static \Illuminate\Database\Eloquent\Builder $subject
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($subject) {
            $subject->slug = Str::slug($subject->name);
        });

        static::updating(function ($subject) {
            if ($subject->isDirty('name')) {
                $subject->slug = Str::slug($subject->name);
            }
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * The curricula that include this subject.
     *
     * @return BelongsToMany<Curriculum>
     */
    public function curricula()
    {
        return $this->belongsToMany(Curriculum::class, 'curriculum_subject', 'subject_id', 'curriculum_id');
    }

    /**
     * The teachers that are assigned to this subject.
     *
     * @return BelongsToMany<User>
     */
    public function assignedTeachers()
    {
        return $this->belongsToMany(
            User::class,
            'teacher_subject_grade_level',
            'subject_id',
            'teacher_id'
        )->withPivot('grade_level_id')->withTimestamps();
    }

    /**
     * Get the distinct grade levels that the teachers assigned to this subject teach.
     *
     * @return BelongsToMany<GradeLevel>
     */
    public function assignedTeacherGrades()
    {
        return $this->belongsToMany(
            GradeLevel::class,
            'teacher_subject_grade_level',
            'subject_id',
            'grade_level_id'
        )->distinct();
    }

    /**
     * Get all grade levels this subject is taught in by a specific teacher.
     */
    public function gradeLevels()
    {
        return $this->belongsToMany(
            GradeLevel::class,
            'teacher_subject_grade_level',
            'subject_id',
            'grade_level_id'
        )->withPivot('teacher_id')->distinct();
    }

    /**
     * The teacher that is assigned to this subject.
     *
     * @return BelongsTo<User>
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * The assignments that are part of this subject.
     *
     * @return HasMany<Assignment>
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
