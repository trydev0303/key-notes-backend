@extends('admin.layouts.master')

@section('title')
    Key-Notes | User Chat
@endsection
{{-- @include('admin.layouts.secondary-nav') --}}
@section('content')
<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">User Support</h3>
        </div>
    </div>
</div>

<!-- end:: Subheader -->

<!--begin: chartsection -->
<div class="row layout-top-spacing support-table">
        <div class="col-xl-8 col-lg-8 col-sm-8 mx-auto  layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="chat-contin-box">
                    <div class="chat-box-title">
                        <h2>User Support</h2>
                    </div>

                    <div class="chat-box" id="chatContainerSC">
                        @foreach ($chat as $item)
                        @if ($item->sender_id === Auth::id())
                            <div class="right-side-chat">
                                    <div class="flex-part">
                                        <div class="msg-part">
                                            <p>{{ $item->message }}</p>
                                            <div class="time-show">{{ $item->created_at->format('h:i A') }}
                                            </div>
                                        </div>
                                        <img alt="avatar" src="{{ asset('admin/src/assets/img/placeholder-user.svg') }}" class="rounded-circle">
                                    </div>
                                </div>
                            @else
                                <div class="left-side-chat">
                                    <div class="flex-part">
                                        @if ($item->user_detail)
                                        <img src="{{ asset('uploads' . '/' . $item->user_detail->profile_image) }}" class="rounded-circle">
                                        @else
                                            <img alt="avatar" src="{{ asset('admin/src/assets/img/placeholder-user.svg') }}" class="rounded-circle">
                                        @endif
                                        <div class="msg-part">
                                            <p>{{ $item->message }}</p> 
                                            <div class="time-show">{{ $item->created_at->format('h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="chat-send-part">
                        <form id="chatForm">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Type here..."
                                    id="messageInput">
                                <input type="hidden" id="supportId" value="{{ $support_id }}">
                                <input type="hidden" name="user_id" value="{{ $user_id }}">
                                <button class="input-group-text send-btn-msg" id="send-message">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
<!--end: chatsection -->
    
    @section('script')
    <script>
       document.getElementById('chatContainerSC').scrollTop = 9999999999999999999999; 
            $(document).ready(function() {
                $("#send-message").click(function(e) {
                    e.preventDefault();

                    var supportId = $("#supportId").val();
                    var user_id = $("input[name='user_id']").val();
                    var message = $("#messageInput").val();

                    if (message) {
                        var baseUrl = '{{ route('send.message') }}';
                        $.ajax({
                            url: baseUrl,
                            type: 'post',
                            data: {
                                user_id: user_id,
                                message: message,
                                supportId: supportId
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(res) {
                                var msg = "Message sent successfully";
                                location.reload(true);
                            },
                            error: function(xhr, status, error) {
                                var msg = "Error sending message";
                                toastr.error(msg);
                            }
                        });
                    } else {
                        // Display a message if user_id or message is empty
                        var msg = "Message are required";
                        toastr.error(msg);
                    }
                });
            });
    </script>

    @endsection

@endsection
