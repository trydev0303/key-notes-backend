<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{ asset('admin/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('admin/src/plugins/src/mousetrap/mousetrap.min.js') }}"></script>
<script src="{{ asset('admin/src/plugins/src/waves/waves.min.js') }}"></script>


<script src="{{ asset('admin/src/plugins/src/global/vendors.min.js') }}"></script>
<script src="{{ asset('admin/src/assets/js/custom.js') }}"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="{{ asset('admin/src/plugins/src/apex/apexcharts.min.js') }}"></script>
<script src="{{ asset('admin/src/plugins/src/apex/custom-apexcharts.js') }}"></script>

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}" type="text/javascript"></script>

<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>
<script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/custom/gmaps/gmaps.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
<script src="{{ asset('assets/js/pages/dashboard.js') }}" type="text/javascript"></script>

<!--end::Page Scripts -->

<script>
    $(document).ready(function() {
        toastr.options.timeOut = 10000;
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        };

        toastr.clear();
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif (Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
    });
</script>
