@extends('admin.layouts.master')

@section('title')
    Key-Notes | User Details & Edit
@endsection
{{-- @include('admin.layouts.secondary-nav') --}}
@section('content')
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">User Details & Edit</h3>
            </div>
        </div>
    </div>
    <!-- end:: Subheader -->

    <!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
<div class="account-settings-container layout-top-spacing">

<div class="account-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
            <form action="{{ url('admin/profile/update/') }}" method="post" enctype="multipart/form-data"
                class="section general-info">
                @csrf
                <input type="hidden" value="1" name="type">
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="info">
                    <h6 class="">General Information</h6>
                    <div class="row">
                        <div class="col-lg-11 mx-auto">
                            <div class="row">
                                <div class="col-xl-2 col-lg-12 col-md-4 text-center">
                                    <div class="upload-img-edit">
                                        @if ($user->profile_image)
                                            <img id="imagePreview"
                                                src="{{ asset('uploads' . '/' . $user->profile_image) }}">
                                        @else
                                            <img id="imagePreview" alt="avatar"
                                                src="{{ asset('admin/src/assets/img/placeholder-user.svg') }}"
                                                class="rounded-circle">
                                        @endif
                                        <input type="file" id="imageInput" name="profile_image"
                                            accept="image/*">
                                    </div>

                                    <a href="#" id="removeImage" style="display: none;">Remove
                                        Image</a>
                                </div>

                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                    <div class="form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fullName">First Name</label>
                                                    <input type="name" class="form-control mb-3"
                                                        id="fullName" name="first_name"
                                                        placeholder="Full Name"
                                                        value="{{ $user->first_name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control mb-3"
                                                        id="email" name="email"
                                                        placeholder="Write your email here"
                                                        value="{{ $user->email }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">Last Name</label>
                                                    <input type="text" class="form-control mb-3"
                                                        id="phone" name="last_name"
                                                        placeholder="Write your phone number here"
                                                        value="{{ $user->last_name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="country">Status</label>
                                                    <select class="form-select mb-3" name="status"
                                                        id="status">
                                                        <option {{ $user->status == 1 ? 'selected' : '' }}
                                                            value="1">Active</option>
                                                        <option {{ $user->status == 2 ? 'selected' : '' }}
                                                            value="2">Suspended</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-1">
                                                <div class="form-group text-end">
                                                    <button type="submit" class="btn btn-brand btn-elevate btn-icon-sm">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4 height-equal-row">
            <div class="summary height-equal">
                <div class="widget-content widget-content-area info">
                    <h3 class="">Other Information</h3>
                    <div class="order-summary">
                        <div class="row">
                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                                <div class="summary-list summary-income">
                                    <div class="summery-info">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-airplay">
                                                <path
                                                    d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1">
                                                </path>
                                                <polygon points="12 15 17 21 7 21 12 15"></polygon>
                                            </svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>Last Login <span
                                                        class="summary-count">{{ \Carbon\Carbon::parse($user->last_login)->format('d F Y') ?? 'N/A' }}
                                                    </span></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                                <div class="summary-list summary-profit">
                                    <div class="summery-info">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-sidebar">
                                                <rect x="3" y="3" width="18" height="18"
                                                    rx="2" ry="2"></rect>
                                                <line x1="9" y1="3" x2="9"
                                                    y2="21"></line>
                                            </svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>Login Type
                                                    <span class="summary-count">
                                                        @if ($user->login_type == 1)
                                                            Social
                                                        @else
                                                            General
                                                        @endif
                                                    </span>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                                <div class="summary-list summary-expenses">
                                    <div class="summery-info">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-calendar">
                                                <rect x="3" y="4" width="18" height="18"
                                                    rx="2" ry="2"></rect>
                                                <line x1="16" y1="2" x2="16"
                                                    y2="6"></line>
                                                <line x1="8" y1="2" x2="8"
                                                    y2="6"></line>
                                                <line x1="3" y1="10" x2="21"
                                                    y2="10"></line>
                                            </svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>Registered Date <span
                                                        class="summary-count">{{ \Carbon\Carbon::parse($user->created_at)->format('d F Y') ?? 'N/A' }}
                                                    </span></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                                <div class="summary-list summary-income">
                                    <div class="summery-info">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-smartphone">
                                                <rect x="5" y="2" width="14" height="20"
                                                    rx="2" ry="2"></rect>
                                                <line x1="12" y1="18" x2="12.01"
                                                    y2="18"></line>
                                            </svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>Device Type <span class="summary-count">
                                                        @if ($user->device_type == 0)
                                                            Android
                                                        @elseif ($user->device_type == 1)
                                                            IOS
                                                        @else
                                                            N/A
                                                        @endif
                                                    </span></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                                <div class="summary-list summary-profit">
                                    <div class="summery-info">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-info">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="16" x2="12"
                                                    y2="12"></line>
                                                <line x1="12" y1="8" x2="12.01"
                                                    y2="8"></line>
                                            </svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>Device Model <span
                                                        class="summary-count">{{ $user->device_model ?? 'N/A' }}</span>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                                <div class="summary-list summary-expenses">
                                    <div class="summery-info">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-map-pin">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>Country <span
                                                        class="summary-count">{{ $user->country ?? 'N/A' }}</span>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                                <div class="summary-list summary-expenses">
                                    <div class="summery-info">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-user">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>Gender <span
                                                        class="summary-count">{{ $user->gender ?? 'N/A' }}</span>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                                <div class="summary-list summary-expenses">
                                    <div class="summery-info">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-user">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>DOB <span
                                                        class="summary-count">{{ $user->date_of_birth ?? 'N/A' }}</span>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="row ">
        <div class="col-xl-4 col-lg-3 col-md-3 layout-spacing height-equal-row">
            <div class="section general-info mb-3 height-equal">
                <div class="info">
                    <h6 class="">Deactivate Account</h6>
                    <p>Once you deactivate the account, there is no way to log in again. Please be certain.</p>
                    <div class="form-group mt-4">
                        <div class="switch form-switch-custom switch-inline form-switch-success mt-1">
                            <input class="switch-input" type="checkbox" id="statusChange" role="switch"
                                data-id="{{ $user->id }}" {{ $user->status == 3 ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-3 col-md-3 layout-spacing height-equal-row">
            <div class="section general-info height-equal">
                <div class="info">
                    <h6 class="">Delete Account</h6>
                    <p>Once you delete the account, there is no going back. Please be certain.</p>
                    <div class="form-group mt-4">
                        <form id="deleteAccountForm" action="{{ url('admin/delete/user/') }}"
                            method="post">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            @csrf
                        </form>
                        <button id="deleteAccount" data-id="{{ $user->id }}"
                            class="btn btn-danger btn-elevate btn-icon-sm _effect--ripple waves-effect waves-light">Delete my account</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 layout-spacing height-equal-row">
            <form action="{{ url('admin/profile/update/') }}" method="post"
                enctype="multipart/form-data" class="section general-info">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <div class="general-info height-equal">
                    <div class="info">
                        <h6 class="">Reset Password</h6>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="newpassword">New Password</label>
                                    <input name="password" type="password" class="form-control mb-3"
                                        id="newpassword" placeholder="New Password" value="" required>
                                    @error('password')
                                        {{-- <script>
                                            toastr.options.timeOut = 10000;
                                            toastr.options = {
                                                "closeButton": true,
                                                "progressBar": true
                                            };
                                            toastr.error('{{ $message }}');
                                        </script> --}}
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="confirmpassword">Confirm Password</label>
                                    <input name="confirm_password" type="password"
                                        class="form-control mb-3" id="confirmpassword"
                                        placeholder="Confirm Password" value="" required>
                                    @error('confirm_password')
                                        {{-- <script>
                                            toastr.options.timeOut = 10000;
                                            toastr.options = {
                                                "closeButton": true,
                                                "progressBar": true
                                            };
                                            toastr.error('{{ $message }}');
                                        </script> --}}
                                        <span class="invalid-feedback" role="alert" style="display:block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 ">
                                <div class="form-group ">
                                    <button type="submit"
                                        class="btn btn-brand btn-elevate btn-icon-sm _effect--ripple waves-effect waves-light">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

</div>
</div>

<!-- end:: Content -->
@section('script')
    <script>
        $("#statusChange").click(function() {
            var user_id = $(this).data("id");
            var baseUrl = '{{ url('admin/status/change') }}';
            $.ajax({
                url: baseUrl,
                type: 'post',
                data: {
                    user_id: user_id
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(res) {
                    var msg = (res.status == 1) ? "Successfully Activated Account" :
                        "Successfully Deactivated Account";
                    toastr.success(msg);
                }
            });
        });

        $("#deleteAccount").click(function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    title: 'titleColor',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#deleteAccountForm").submit();
                }
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            // File input change event handler
            $('#imageInput').on('change', function() {
                var fileInput = this;
                var imagePreview = $('#imagePreview');
                var removeImageBtn = $('#removeImage');

                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.attr('src', e.target.result);
                        removeImageBtn.show();
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            });

            // Remove the image preview
            $('#removeImage').on('click', function() {
                $('#imagePreview').attr('src', 'placeholder.jpg');
                $('#imageInput').val('');
                $(this).hide();
            });
        });
    </script>
@endsection
@endsection
