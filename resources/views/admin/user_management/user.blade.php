@extends('admin.layouts.master')

@section('title')
    Key-Notes | User Management
@endsection

@section('content')
<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">User Management</h3>
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
                        <polygon points="0 0 24 0 24 24 0 24"/>
                        <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                        <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                    </g>
                </svg>
                </span>
                <h3 class="kt-portlet__head-title">User Management</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a id="exportBtn" href="{{ route('export') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-download">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>&nbsp; Download</a>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">

            <!--begin: Datatable -->
            <div class="widget-content widget-content-area br-8">
                <table id="style-1" class="table style-1 dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="checkbox-column dt-no-sorting"></th>
                            <th>S.No.</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Subscriber</th>
                            <th>Profile Picture</th>
                            <th>Action Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allUsers as $key => $item)
                            <tr>
                                <td></td>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <a href="{{ url('admin/user/detail/view/' . '1/' . $item->id) }}"
                                        class="anchor-link kt-link">
                                        {{ ucfirst($item->first_name) . ' ' . $item->last_name }}
                                    </a>
                                </td>
                                <td>{{ $item->email }}</td>
                                {{-- <td>Paid Subscriber</td> --}}
                                <td>Free Subscriber</td>
                                <td class="">
                                    <a class="profile-img"
                                        href="{{ url('admin/user/detail/view/' . '1/' . $item->id) }}">
                                        @if ($item->profile_image)
                                            <img alt="avatar"
                                                src="{{ asset('uploads' . '/' . $item->profile_image) }}"
                                                style="width:40px"
                                                >
                                        @else
                                            <img alt="avatar"
                                                src="{{ asset('admin/src/assets/img/placeholder-user.svg') }}"
                                                style="width:40px"
                                                >
                                        @endif
                                    </a>
                                </td>
                                @if ($item->status == 1)
                                <td class="text-left">
                                    <span class="shadow-none badge badge-primary">Active</span>
                                </td>
                            @elseif($item->status == 2)
                                <td class="text-left">
                                    <span class="shadow-none badge badge-danger">Suspended</span>
                                </td>
                            @elseif($item->status == 3)
                                <td class="text-left">
                                    <span class="shadow-none badge badge-danger">Deactivated</span>
                                </td>
                            @else
                                <td class="text-left">
                                    <span class="shadow-none badge badge-primary">In Active</span>
                                </td>
                            @endif
                            
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

    <script src="{{ asset('admin/src/plugins/src/table/datatable/datatables.js') }}"></script>

    <script>
        // ## export CSV Download
        $("#exportBtn").click(function() {
            var baseUrl = '{{ route('export') }}';
            $.ajax({
                url: baseUrl,
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    var msg = "Successfully XLSX Downloaded";
                    toastr.success(msg);
                }
            });
        });

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

@endsection
@endsection
