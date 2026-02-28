<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Curriculum extends Model
{
    /** @use HasFactory<\Database\Factories\CurriculumFactory> */
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
     * Automatically generate a slug based on the name of the curriculum when creating or updating.
     *
     * When creating a new curriculum, the slug will be generated using the name.
     * When updating an existing curriculum, the slug will only be updated if the name changed.
     */
    protected static function booted()
    {
        // When creating a new curriculum
        static::creating(function ($curriculum) {
            $curriculum->slug = Str::slug($curriculum->name);
        });

        // When updating an existing curriculum
        static::updating(function ($curriculum) {
            // Only update slug if the name changed
            if ($curriculum->isDirty('name')) {
                $curriculum->slug = Str::slug($curriculum->name);
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
     * Get the subjects that are part of the curriculum.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Subject>
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'curriculum_subject', 'curriculum_id', 'subject_id');
    }

    /**
     * Get the students that are part of the curriculum.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\User>
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'student_curriculum', 'curriculum_id', 'student_id')
            ->withPivot('grade_level_id', 'section_id')
            ->withTimestamps();
    }

    /**
     * Get the grade levels associated with the curriculum.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\GradeLevel>
     */
    public function gradeLevels()
    {
        return $this->belongsToMany(GradeLevel::class, 'student_curriculum', 'curriculum_id', 'grade_level_id')
            ->withPivot('student_id', 'section_id')
            ->withTimestamps();
    }

    /**
     * Get the sections associated with the curriculum.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Section>
     */
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'student_curriculum', 'curriculum_id', 'section_id')
            ->withPivot('student_id', 'grade_level_id')
            ->withTimestamps();
    }
}
