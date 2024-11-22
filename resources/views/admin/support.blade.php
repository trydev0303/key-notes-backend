@extends('admin.layouts.master')

@section('title')
    Key-Notes | Support
@endsection

@section('content')
<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Support</h3>
        </div>
    </div>
</div>

<!-- end:: Subheader -->

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                            <rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"/>
                            <rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"/>
                        </g>
                    </svg>
                </span>
                <h3 class="kt-portlet__head-title">Support</h3>
            </div>
        </div>
        <div class="kt-portlet__body">

            <!--begin: Datatable -->
            <div class="widget-content widget-content-area br-8">
                        <table id="style-1" class="table style-1 dt-table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    {{-- <th>Subject</th>  --}}
                                    {{-- <th>Message</th>  --}}
                                    {{-- <th>Status</th>   --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allSupport as $item)
                                    <tr>
                                        <td>1</td>
                                        <td><a href="{{ url('admin/chat/' . $item->id . '/' . $item->user_id) }}">
                                                {{ ucfirst($item->user_detail->first_name ?? 'N/A') }}</a>
                                        </td>
                                        <td>{{ ucfirst($item->user_detail->last_name ?? 'N/A') }}</td>
                                        <td>{{ $item->user_detail->email ?? 'N/A' }}</td>
                                        <td class="text-left">
                                            <select class="form-select mb-0 statusChange" data-id="{{ $item->id }}">
                                                <option id="status" value="2"
                                                    {{ $item->status == 2 ? 'selected' : '' }}>Resolved</option>
                                                <option id="status" value="1"
                                                    {{ $item->status == 1 ? 'selected' : '' }}>Unresolved</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

            <!--end: Datatable -->
        </div>
    </div>
</div>

<!-- end:: Content -->
@section('script')

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('admin/src/plugins/src/table/datatable/datatables.js') }}"></script>
    <script>
        // var e;
        c1 = $('#style-1').DataTable({
            headerCallback: function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML = ``
            },
            columnDefs: [{
                targets: 0,
                width: "30px",
                className: "",
                orderable: !1,
                render: function(e, a, t, n) {
                    return ``
                }
            }],
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 10
        });
        multiCheck(c1);
    </script>
    <script>
        $(".statusChange").on('change',function() {
            var support_id = $(this).data("id");
            var baseUrl = '{{ route('support.change.status') }}';
            $.ajax({
                url: baseUrl,
                type: 'post',
                data: {
                    support_id: support_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    if (res.status == 2) {
                        var msg = "Successfully Resolved";
                        $('#status').find("option[value='2']").prop("selected", true);
                    } else {
                        var msg = "Successfully Unresolved";
                        $('#status').find("option[value='1']").prop("selected", true);
                    }
                    toastr.success(msg);
                }
            });
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->

@endsection
@endsection
