<?php

namespace App\Policies;

use App\Models\{Assignment, Submission, User};
use Illuminate\Auth\Access\Response;

class SubmissionPolicy
{
    /**
     * Determine whether the user can create a submission for the given assignment.
     * We'll register this policy for the Assignment model so Laravel will resolve it.
     */
    public function create(User $user, Assignment $assignment): Response
    {
        // Must be a student
        if (!$user->hasRole('student')) {
            return Response::deny('Only students can submit assignments.');
        }

        // Don’t allow if assignment is closed
        if ($assignment->status === 'closed') {
            return Response::deny('This assignment is closed. Submissions are no longer accepted.');
        }

        // Allow only when assignment is on-time or late
        if (! in_array($assignment->status, ['on-time', 'late'])) {
            return Response::deny('Submissions are not allowed for this assignment status.');
        }

        // Check if the student already submitted
        $alreadySubmitted = Submission::where('assignment_id', $assignment->id)
            ->where('student_id', $user->id)
            ->exists();

        if ($alreadySubmitted) {
            return Response::deny('You have already submitted this assignment.');
        }

        // ✅ All checks passed
        return Response::allow();
    }

    /**
     * Determine whether the user can update the given submission.
     */
    public function update(User $user, Submission $submission): Response
    {
        // must be owner
        if ($submission->student_id !== $user->id) {
            return Response::deny('You do not own this submission.');
        }

        // cannot update graded submissions
        if ($submission->status === 'graded') {
            return Response::deny('Graded submissions cannot be edited.');
        }

        // Prevent edits if assignment is late or closed (business rule you had)
        if (in_array($submission->assignment->status, ['late', 'closed'])) {
            return Response::deny('Cannot edit because the assignment is late or closed.');
        }

        return Response::allow();
    }
}
