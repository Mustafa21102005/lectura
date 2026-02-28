<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /** @use HasFactory<\Database\Factories\SectionFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'grade_level_id'
    ];

    /**
     * The grade level that this section belongs to
     *
     * @return BelongsTo<Section, GradeLevel>
     */
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    /**
     * Get the students associated with the section.
     *
     * @return BelongsToMany<Section, User>
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'student_curriculum', 'section_id', 'student_id')
            ->withPivot('curriculum_id', 'grade_level_id')
            ->withTimestamps();
    }
}
