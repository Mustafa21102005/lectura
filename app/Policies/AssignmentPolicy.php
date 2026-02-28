<?php

namespace App\Policies;

use App\Models\{Assignment, User};

class AssignmentPolicy
{
    /**
     * Teacher can update only if assignment status is "on-time".
     */
    public function update(User $user, Assignment $assignment): bool
    {
        // Only teachers can edit their own assignments when status = "on-time"
        return $user->hasRole('teacher')
            && $assignment->teacher_id === $user->id
            && strtolower($assignment->status) === 'on-time';
    }
}
