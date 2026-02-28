@extends('layouts.dashboard')

@section('title', 'Profile')

@section('page_header', 'Profile')

@section('content')
    <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl"
            style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        </div>
        <div class="card card-body mx-3 mx-md-4 mt-n7">
            <div class="row gx-4 mb-2">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ Avatar::create(Auth::user()->name)->setDimension(400, 400)->setFontSize(200)->toBase64() }}"
                            alt="profile_image" class="w-100 border-radius-lg ">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ Auth::user()->name }}
                        </h5>
                        <p class="mb-0 font-weight-normal text-sm">
                            {{ ucfirst(Auth::user()->getRoleNames()->first()) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                @role('teacher|student')
                    {{-- Platform Settings Section --}}
                    <div class="col-12 col-xl-4">
                        <div class="card card-plain h-100">
                            <div class="card-header p-3 pb-0">
                                <h6>Platform Settings</h6>
                                <h6 class="text-uppercase text-body text-xs font-weight-bolder">
                                    Enable & Disable Notifications according to your preference.
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                <ul class="list-group">
                                    @role('teacher')
                                        <li class="list-group-item border-0 px-0 d-flex align-items-center">
                                            <div class="form-check form-switch ps-0 me-3">
                                                <input class="form-check-input ms-auto notify-toggle" type="checkbox"
                                                    id="assignment_submissions" data-field="assignment_submissions"
                                                    {{ auth()->user()->notificationSettings?->assignment_submissions ? 'checked' : '' }}>
                                            </div>
                                            <label class="form-check-label text-body w-80 mb-0" for="assignment_submissions">
                                                Email me when students submit their assignment.
                                            </label>
                                        </li>

                                        <li class="list-group-item border-0 px-0 d-flex align-items-center">
                                            <div class="form-check form-switch ps-0 me-3">
                                                <input class="form-check-input ms-auto notify-toggle" type="checkbox"
                                                    id="subject_changes" data-field="subject_changes"
                                                    {{ auth()->user()->notificationSettings?->subject_changes ? 'checked' : '' }}>
                                            </div>
                                            <label class="form-check-label text-body w-80 mb-0" for="subject_changes">
                                                Email me when I’m assigned to a new subject.
                                            </label>
                                        </li>
                                    @endrole
                                    @role('student')
                                        <li class="list-group-item border-0 px-0 d-flex align-items-center">
                                            <div class="form-check form-switch ps-0 me-3">
                                                <input class="form-check-input ms-auto notify-toggle" type="checkbox"
                                                    id="new_assignments" data-field="new_assignments"
                                                    {{ auth()->user()->notificationSettings?->new_assignments ? 'checked' : '' }}>
                                            </div>
                                            <label class="form-check-label text-body w-80 mb-0" for="new_assignments">
                                                New Assignments
                                            </label>
                                        </li>
                                        <li class="list-group-item border-0 px-0 d-flex align-items-center">
                                            <div class="form-check form-switch ps-0 me-3">
                                                <input class="form-check-input ms-auto notify-toggle" type="checkbox"
                                                    id="new_study_materials" data-field="new_study_materials"
                                                    {{ auth()->user()->notificationSettings?->new_study_materials ? 'checked' : '' }}>
                                            </div>
                                            <label class="form-check-label text-body w-80 mb-0" for="new_study_materials">
                                                New Study Materials
                                            </label>
                                        </li>
                                        <li class="list-group-item border-0 px-0 d-flex align-items-center">
                                            <div class="form-check form-switch ps-0 me-3">
                                                <input class="form-check-input ms-auto notify-toggle" type="checkbox" id="deadlines"
                                                    data-field="deadlines"
                                                    {{ auth()->user()->notificationSettings?->deadlines ? 'checked' : '' }}>
                                            </div>
                                            <label class="form-check-label text-body w-80 mb-0" for="deadlines">
                                                Assignment Deadlines
                                            </label>
                                        </li>
                                        <li class="list-group-item border-0 px-0 d-flex align-items-center">
                                            <div class="form-check form-switch ps-0 me-3">
                                                <input class="form-check-input ms-auto notify-toggle" type="checkbox" id="grades"
                                                    data-field="grades"
                                                    {{ auth()->user()->notificationSettings?->grades ? 'checked' : '' }}>
                                            </div>
                                            <label class="form-check-label text-body w-80 mb-0" for="grades">
                                                Assignment Grades
                                            </label>
                                        </li>
                                    @endrole
                                </ul>
                            </div>
                        </div>
                    </div>
                @endrole

                {{-- Profile Information Section --}}
                <div class="col-12 col-xl-4">
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <h6>Personal Information</h6>
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder">
                                Update your account's profile information and email address here.
                            </h6>
                        </div>

                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <div class="card-body p-3">
                            <form role="form" class="text-start" method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('patch')

                                <div class="input-group input-group-outline mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" required
                                        value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <p class="text-sm text-danger fw-bold mb-0">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="input-group input-group-outline mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <p class="text-sm text-danger fw-bold mb-0">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="input-group input-group-outline mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" class="form-control"
                                        value="{{ old('phone', $user->phone) }}" required>
                                    @error('phone')
                                        <p class="text-sm text-danger fw-bold mb-0">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                    <div class="alert alert-warning mt-2 text-white text-center" role="alert">
                                        <p class="mb-2">
                                            Your email address is unverified.
                                        </p>
                                        <a href="#Hi"
                                            onclick="event.preventDefault(); document.getElementById('send-verification').submit();"
                                            class="alert-link text-white">
                                            Click here to re-send the verification email.
                                        </a>
                                    </div>
                                @endif

                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-primary w-100 mb-2">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Password Update Section --}}
                <div class="col-12 col-xl-4">
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <h6>Update Password</h6>
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder">
                                Ensure your account is using a long, random password to stay secure.
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <form role="form" class="text-start" method="POST"
                                action="{{ route('password.update') }}">
                                @csrf
                                @method('put')

                                <div class="input-group input-group-outline mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" id="current_password" name="current_password"
                                        class="form-control" required>
                                    @error('current_password', 'updatePassword')
                                        <div class="w-100">
                                            <p class="text-sm text-danger fw-bold mt-1 mb-0">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>

                                <div class="input-group input-group-outline mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                    @error('password', 'updatePassword')
                                        <p class="text-sm text-danger fw-bold mb-0">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="input-group input-group-outline mb-3">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" id="confirm_password" name="password_confirmation"
                                        class="form-control" required>
                                    @error('password_confirmation', 'updatePassword')
                                        <p class="text-sm text-danger fw-bold mb-0">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-primary w-100 mb-2">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.notify-toggle').forEach(checkbox => {
                checkbox.addEventListener('change', async function() {
                    const field = this.dataset.field;
                    const value = this.checked;

                    try {
                        const response = await fetch(
                            "{{ route('notification-settings.toggle') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    field,
                                    value
                                })
                            });

                        const data = await response.json();

                        if (data.success) {
                            window.dispatchEvent(new CustomEvent('success-toast', {
                                detail: {
                                    message: field.replace('_', ' ') +
                                        ' notifications updated successfully!'
                                }
                            }));
                        } else {
                            window.dispatchEvent(new CustomEvent('error-toast', {
                                detail: {
                                    message: 'Failed to update ' + field.replace(
                                        '_', ' ')
                                }
                            }));
                        }
                    } catch (error) {
                        window.dispatchEvent(new CustomEvent('error-toast', {
                            detail: {
                                message: 'Something went wrong! Please try again.'
                            }
                        }));
                    }
                });
            });
        });
    </script>

    {{-- Toast Container --}}
    <div class="position-fixed bottom-1 end-1 z-index-2" style="transition: opacity 0.5s ease-in-out;"
        id="toastContainer"></div>

    <script>
        function showToast(message, type = 'success') {
            const toastId = `toast-${Date.now()}`;
            const icon = type === 'success' ? 'check' : 'campaign';
            const color = type === 'success' ? 'text-success' : 'text-danger';

            const toast = document.createElement('div');
            toast.className = 'toast fade show p-2 mt-2 bg-white';
            toast.id = toastId;
            toast.role = 'alert';
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            toast.style.opacity = 0;

            toast.innerHTML = `
                <div class="toast-header border-0">
                    <i class="material-icons ${color} me-2">${icon}</i>
                    <span class="me-auto font-weight-bold">${type === 'success' ? 'Success' : 'Error'}</span>
                    <small class="text-body">Just now</small>
                    <i class="fas fa-times text-md ms-3 cursor-pointer" onclick="this.closest('.toast').remove()"></i>
                </div>
                <hr class="horizontal dark m-0">
                <div class="toast-body">
                    ${message}
                </div>
            `;

            document.getElementById('toastContainer').appendChild(toast);

            // Animate
            setTimeout(() => toast.style.opacity = 1, 100);
            setTimeout(() => {
                toast.style.opacity = 0;
                setTimeout(() => toast.remove(), 500);
            }, 7000);
        }

        // Listen for JS-triggered toasts
        window.addEventListener('success-toast', e => showToast(e.detail.message, 'success'));
        window.addEventListener('error-toast', e => showToast(e.detail.message, 'error'));

        // Trigger session flashes
        @if (session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif
        @if (session('error'))
            showToast("{{ session('error') }}", 'error');
        @endif
    </script>
@endsection
