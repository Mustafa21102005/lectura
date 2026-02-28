<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HandlesMedia;
use App\Models\Submission;
use App\Http\Requests\StoreSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use App\Models\Assignment;
use App\Notifications\StudentSubmittedAssignmentNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class SubmissionController extends Controller
{
    use HandlesMedia, AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = auth()->user()
            ->teacherSubmissions()
            ->with(['assignment', 'student', 'grade'])
            ->get();

        return view('submissions.index', compact('submissions'));
    }

    /**
     * Display submissions for the authenticated student
     */
    public function studentIndex()
    {
        $submissions = auth()->user()->submissions()->with('assignment')->get();

        return view('submissions.student.index', compact('submissions'));
    }

    /**
     * Display submissions for the authenticated parent's children
     *
     * @return \Illuminate\View\View
     */
    public function parentIndex()
    {
        $parent = auth()->user();

        // Get all children IDs
        $childIds = $parent->children()->pluck('users.id')->toArray();

        // Fetch all submissions for those children
        $submissions = Submission::with(['assignment', 'student'])
            ->whereIn('student_id', $childIds)
            ->get();

        return view('submissions.parent.index', compact('submissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Assignment $assignment)
    {
        $this->authorize('submit-assignment', $assignment);

        return view('submissions.create', compact('assignment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubmissionRequest $request)
    {
        $data = $request->validated();
        $data['student_id'] = auth()->id();

        // Get the assignment (we'll authorize using the assignment)
        $assignment = Assignment::findOrFail($data['assignment_id']);

        $this->authorize('submit-assignment', $assignment);

        // existing duplicate-submission check...
        $exists = Submission::where('assignment_id', $data['assignment_id'])
            ->where('student_id', $data['student_id'])
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors('You have already submitted this assignment!');
        }

        // Determine status
        $now = Carbon::now();

        if ($assignment->status === 'late' || $now->gt($assignment->due_date)) {
            $data['status'] = 'late';
        } else {
            $data['status'] = 'submitted';
        }

        $submission = Submission::create($data);

        // Handle uploaded files
        if ($request->filled('uploaded_files')) {
            $uploadedFiles = json_decode($request->uploaded_files, true);

            foreach ($uploadedFiles as $fileData) {
                $tmpPath = 'uploads/tmp/' . $fileData['folder'] . '/' . $fileData['file'];

                if (Storage::disk('public')->exists($tmpPath)) {
                    $submission->addMedia(Storage::disk('public')->path($tmpPath))
                        ->usingFileName($fileData['file'])
                        ->toMediaCollection('student-assignment');

                    Storage::disk('public')->deleteDirectory('uploads/tmp/' . $fileData['folder']);
                }
            }
        }

        $teacher = $assignment->teacher;

        if ($teacher && $teacher->notificationSettings?->assignment_submissions) {
            $teacher->notify(new StudentSubmittedAssignmentNotification($submission));
        }

        return redirect()->route('student.assignments.index')->with('success', 'Assignment submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        $media = $submission->getMedia('student-assignment')->map(function ($media) {
            return [
                'id' => $media->id,
                'name' => $media->file_name,
                'url' => URL::temporarySignedRoute(
                    'submissions.media.temp',
                    now()->addMinutes(120),
                    ['media' => $media->id]
                ),
            ];
        });

        return view('submissions.show', compact('submission', 'media'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        $this->authorize('update', $submission);

        $files = $submission->getMedia('student-assignment')->map(function ($media) {
            return [
                'id' => $media->id,
                'name' => $media->file_name,
                'url' => $media->getFullUrl(),
                'size' => $media->size,
            ];
        });

        return view('submissions.edit', compact('submission', 'files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubmissionRequest $request, Submission $submission)
    {
        $this->authorize('update', $submission);

        $submission->update($request->validated());

        // Handle new uploads (if any)
        if ($request->filled('uploaded_files')) {
            $uploadedFiles = json_decode($request->uploaded_files, true);

            foreach ($uploadedFiles as $fileData) {
                $tmpPath = 'uploads/tmp/' . $fileData['folder'] . '/' . $fileData['file'];

                if (Storage::disk('public')->exists($tmpPath)) {
                    $submission
                        ->addMedia(Storage::disk('public')->path($tmpPath))
                        ->usingFileName($fileData['file'])
                        ->toMediaCollection('student-assignment');

                    Storage::disk('public')->deleteDirectory('uploads/tmp/' . $fileData['folder']);
                }
            }
        }

        return redirect()->route('student.submissions.index')->with('success', 'Submission updated successfully.');
    }
}
