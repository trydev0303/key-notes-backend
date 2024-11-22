@extends("admin.layouts.master")
@section('title')
Key-Notes | Change-Password
@endsection
@section("content")
<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Change Password</h3>
        </div>
    </div>
</div>

<!-- end:: Subheader -->

<div class="account-settings-container layout-top-spacing">

            <div class="account-content">
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-5 mt-4 mx-auto">
                        <form class="section general-info" action="{{ route('change.password') }}" method="post">
                            @csrf
                            <div class="info">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <h2>Change Password</h2>
                                    </div>
                                </div>
                                <div class="form">
                                    <div class="row">
                                    <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="newpassword">Old Password</label>
                                                <input type="password" name="old_password" class="form-control mb-3" id="oldpassword" placeholder="Old Password">
                                                @error('password')
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
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="newpassword">New Password</label>
                                                <input type="password" name="password" class="form-control mb-3" id="newpassword" placeholder="New Password">
                                                @error('password')
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
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="confirmpassword">Confirm Password</label>
                                                <input type="password"  name="confirm_password" class="form-control mb-3" id="confirmpassword" placeholder="Confirm Password">
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
                                        <div class="col-md-12 mt-1">
                                            <div class="form-group text-end">
                                                <button type="submit" class="btn thme-btn">Submit</button>
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
@endsection