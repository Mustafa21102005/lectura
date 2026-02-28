<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Grade extends Model
{
    /** @use HasFactory<\Database\Factories\GradeFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'submission_id',
        'score',
        'remarks'
    ];

    /**
     * Get the submission that this grade belongs to
     *
     * @return BelongsTo<Grade, Submission>
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    /**
     * Get the student that this grade belongs to
     *
     * This will return the student that submitted the assignment which this grade belongs to.
     *
     * @return HasOneThrough<User, Submission>
     */
    public function student(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,        // Final model
            Submission::class,  // Intermediate model
            'id',               // Foreign key on submissions table
            'id',               // Foreign key on users table
            'submission_id',    // Local key on grades table
            'student_id'        // Local key on submissions table
        );
    }
}
