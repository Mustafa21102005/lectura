<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationSettingFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'assignment_submissions',
        'subject_changes',
        'new_assignments',
        'new_study_materials',
        'deadlines',
        'grades'
    ];

    /**
     * Get the user that owns the notification setting.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
