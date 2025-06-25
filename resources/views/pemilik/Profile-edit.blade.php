<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        @include('pemilik.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('pemilik.navbar')

                <div class="container mt-5">
                    <h1>Edit Profile</h1>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Form for editing the profile -->
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name Dropdown -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <select class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                                <option value="">-- Select User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" data-email="{{ $user->email }}" {{ old('name', auth()->user()->id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email field (readonly) -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" readonly>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                                        <i class="fas fa-eye-slash" id="eye-icon"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="form-text text-muted">Leave blank if you don't want to change your password.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="toggle-confirm-password">
                                        <i class="fas fa-eye-slash" id="eye-icon-confirm"></i>
                                    </button>
                                </div>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // When a name is selected, automatically fill the email input
            const nameSelect = document.getElementById('name');
            const emailInput = document.getElementById('email');

            nameSelect.addEventListener('change', function() {
                const selectedOption = nameSelect.options[nameSelect.selectedIndex];
                const email = selectedOption.getAttribute('data-email');
                emailInput.value = email;
            });

            // Toggle password visibility for New Password field
            const togglePasswordButton = document.getElementById('toggle-password');
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            togglePasswordButton.addEventListener('click', function() {
                const type = passwordField.type === 'password' ? 'text' : 'password';
                passwordField.type = type;

                if (type === 'password') {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            });

            // Toggle password visibility for Confirm Password field
            const toggleConfirmPasswordButton = document.getElementById('toggle-confirm-password');
            const confirmPasswordField = document.getElementById('password_confirmation');
            const eyeIconConfirm = document.getElementById('eye-icon-confirm');

            toggleConfirmPasswordButton.addEventListener('click', function() {
                const type = confirmPasswordField.type === 'password' ? 'text' : 'password';
                confirmPasswordField.type = type;

                if (type === 'password') {
                    eyeIconConfirm.classList.remove('fa-eye');
                    eyeIconConfirm.classList.add('fa-eye-slash');
                } else {
                    eyeIconConfirm.classList.remove('fa-eye-slash');
                    eyeIconConfirm.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>
