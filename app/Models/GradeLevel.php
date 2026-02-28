<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GradeLevel extends Model
{
    /** @use HasFactory<\Database\Factories\GradeLevelFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Automatically generate a slug based on the grade level when creating or updating.
     *
     * When creating a new grade level, the slug will be generated using the grade level.
     * When updating an existing grade level, the slug will only be updated if the grade level changed.
     */
    protected static function booted()
    {
        // When creating a new grade level
        static::creating(function ($gradeLevel) {
            $gradeLevel->slug = Str::slug($gradeLevel->name);
        });

        // When updating an existing grade level
        static::updating(function ($gradeLevel) {
            // Only update slug if the grade level changed
            if ($gradeLevel->isDirty('name')) {
                $gradeLevel->slug = Str::slug($gradeLevel->name);
            }
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
     * Get the sections associated with the grade level.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    /**
     * Get the students associated with the grade level.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'student_curriculum', 'grade_level_id', 'student_id')
            ->withPivot('curriculum_id', 'section_id')
            ->withTimestamps();
    }

    /**
     * Get the teachers associated with the grade level.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignedTeachers()
    {
        return $this->belongsToMany(
            User::class,
            'teacher_subject_grade_level',     // Pivot table
            'grade_level_id',                  // This model's foreign key in pivot
            'teacher_id'                       // Related model's foreign key
        )->withPivot('subject_id')->withTimestamps();
    }

    /**
     * Get the subjects associated with the grade level.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'teacher_subject_grade_level',
            'grade_level_id',
            'subject_id'
        )->withPivot('teacher_id')->withTimestamps();
    }
}
