<?php

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Submission;
use App\Models\User;
use App\Policies\AssignmentPolicy;
use App\Policies\SubmissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Assignment::class => AssignmentPolicy::class,
        Submission::class => SubmissionPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Custom gate for student submissions
        Gate::define('submit-assignment', function (User $user, Assignment $assignment) {
            return app(SubmissionPolicy::class)
                ->create($user, $assignment);
        });
    }
}
