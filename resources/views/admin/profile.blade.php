@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">

            <div class="wraper container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group pull-right m-t-15">
                            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i class="fa fa-cog"></i></span></button>
                            <ul class="dropdown-menu drop-menu-right" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>

                        <h4 class="page-title">Profile</h4>
                        <ol class="breadcrumb">
                            <li><a href="#">Ubold</a></li>
                            <li><a href="#">Extras</a></li>
                            <li class="active">Profile</li>
                        </ol>
                    </div>
                </div>

                <div class="row" style="text-align: center" >
                    <div class="col-md-8 col-md-offset-2">
                        <div class="profile-detail card-box">
                            <div>
                                <img src="/images/avatar-default.png" width="" class="img-circle" alt="profile-image">

                                <hr>
                                <h4 class="text-uppercase font-600">About Me</h4>

                                <form class="form-horizontal" role="form" style="padding-left: 20%">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Text</label>
                                        <div class="col-md-6">
                                            <input type="text" disabled class="form-control" value="{{$admin->name}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-email">Email</label>
                                        <div class="col-md-6">
                                            <input type="email" disabled id="example-email" name="example-email" class="form-control" value="{{$admin->email}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Phone</label>
                                        <div class="col-md-6">
                                            <input type="text" disabled class="form-control" value="{{$admin->phone}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Password</label>
                                        <div class="col-md-6">
                                            <input type="password" disabled class="form-control" value="{{$admin->password}}">
                                        </div>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>

                </div>



            </div> <!-- container -->

        </div> <!-- content -->

        <footer class="footer">
            2016 © Ubold. Design by Coderthemes
        </footer>

    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->
@stop

@section('script')
    <script src="/js/admin.js"></script>
@endsection