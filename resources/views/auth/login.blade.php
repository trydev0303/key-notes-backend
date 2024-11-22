<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>SignIn</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/src/assets/img/favicon.ico') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/src/favicon.png') }}" />
    <link href="{{ asset('admin/layouts/vertical-dark-menu/css/dark/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('admin/layouts/vertical-dark-menu/loader.js') }}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('admin/src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('admin/layouts/vertical-dark-menu/css/light/plugins.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('admin/src/assets/css/light/authentication/auth-boxed.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('admin/layouts/vertical-dark-menu/css/dark/plugins.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('admin/src/assets/css/dark/authentication/auth-boxed.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- Custom Css Start-->
    <!-- <link href="{{ asset('admin/src/assets/css/custom-css.css') }}" rel="stylesheet" type="text/css" /> -->
    <!-- Custom Css Start-->

</head>
<style>
    .invalid-feedback{
        display: inherit;
    }
</style>

<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">
            <div class="row">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h2>Sign In</h2>
                                        <p>Enter your Email and Password to Sign In</p>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            {{-- <input type="email" name="email" class="form-control"> --}}
                                            <input id="email" type="email"
                                                class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                              <div class="input-group flex-nowrap">
                                                 <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="current-password">

                                                <span class="input-group-text class-eye-icon" id="addon-wrapping"
                                                    onclick="togglePassword()">
                                                    <img src="{{ asset('admin/src/eye_hide_icon.svg') }}"
                                                        alt="icon" id="eyeIcon">
                                                </span>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <p class="mb-3"><a href="forgot-password.html" class="text-warning">Forgot Password?</a></p>
                                    </div>
                                         </div> --}}
                                    
                                    {{-- <div class="col-md-12 mt-1 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="customCheck1">
                                            <label class="form-check-label" for="customCheck1">Remember Me</label>
                                        </div>
                                    </div> --}}

                                    <div class="col-12">
                                        <div class="mb-4">
                                            {{-- <a class="btn btn-secondary w-100" href="#">SIGN IN</a> --}}
                                            {{-- <button type="submit"class="btn btn-secondary w-100">SIGN IN</button>  --}}
                                            <button type="submit"
                                                class="btn btn-secondary btn-icon-sm w-100">{{ __('SIGN IN') }}</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Forgot Password-->
    <div class="modal fade" id="forgot-pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg> ... </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-text">Mauris mi tellus, pharetra vel mattis sed, tempus ultrices eros. Phasellus
                        egestas sit amet velit sed luctus. Orci varius natoque penatibus et magnis dis parturient
                        montes, nascetur ridiculus mus. Suspendisse potenti. Vivamus ultrices sed urna ac pulvinar. Ut
                        sit amet ullamcorper mi. </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>
                        Discard</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('admin/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.src = "{{ asset('admin/src/eye_open_icon.svg') }}";
            } else {
                passwordInput.type = "password";
                eyeIcon.src = "{{ asset('admin/src/eye_hide_icon.svg') }}";
            }
        }
    </script>

</body>

</html>
