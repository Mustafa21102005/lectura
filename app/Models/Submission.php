<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Submission extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\SubmissionFactory> */
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'assignment_id',
        'student_id',
        'remarks',
        'status'
    ];

    /**
     * The student that submitted this submission
     *
     * @return BelongsTo<User, Submission>
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * The assignment this submission belongs to
     *
     * @return BelongsTo<Assignment, Submission>
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * The grade for this submission
     *
     * @return HasOne<Submission, Grade>
     */
    public function grade()
    {
        return $this->hasOne(Grade::class);
    }
}
