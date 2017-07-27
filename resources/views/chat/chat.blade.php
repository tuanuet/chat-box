@extends('layouts.master')
@section('content')
    <link rel="stylesheet" href="/css/chatlog.css">

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div>Room Type: {{$room_type}}</div>
                {{--content chat--}}
                <ol class="chat">
                    @foreach($messages as $message)
                        @if($message['sender_id'] !== 0)
                            <li class="other">
                        @else
                            <li class="self">
                                @endif
                                <div class="msg">
                                    <p class="sender"><a href="customer/{{$message['sender_id']}}">{{$message['sender_name']}}</a></p>
                                    <p>{{$message['content']}}</p>
                                    <time>{{$message['sent_time']}}</time>
                                </div>
                            </li>
                            @endforeach
                </ol>

                {{--end content chat --}}
                <input class="textarea" type="text" placeholder="Type here!"/><div class="emojis"></div>
            </div>
        </div>


        <footer class="footer">
            © 2017. All rights reserved.
        </footer>

    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->

@stop
@push('inline_scripts')
    <script src="/js/socket.io.js"></script>
    <script src="/js/jquery-migrate-3.0.0.min.js"></script>
    <script src="/js/scrollyeah.js"></script>
    <script src="/js/chat.js"></script>
    @endpush