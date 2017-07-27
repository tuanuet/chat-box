@extends('layouts.master')
@section('content')
    <link rel="stylesheet" href="/css/chatlog.css">

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div>Room Type: {{$room_type}}</div>
                {{--content chat--}}
                <div class="chat-content">
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
            </div>
                <div class="customer-info">
                    <div class="card-box">
                        <ul>
                            <h3>Customer info</h3>
                            <li>
                                <p>
                                    <b>Name: </b>
                                    {{$customer->name}}
                                </p>
                            </li>
                            <li>
                                <p>
                                    <b>Phone: </b>
                                    <a href="#">{{$customer->phone}}</a>
                                </p>
                            </li>
                            <li>
                                <p>
                                    <b>Email: </b>
                                    <a href="#">{{$customer->email}}</a>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>

                {{--end content chat --}}
                <div class="close-time" style="width: 50%;">
                    Room was closed at {{$room->closed_at}}
                </div>
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
