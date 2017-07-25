@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

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

                        <h4 class="page-title">Datatable</h4>
                        <ol class="breadcrumb">
                            <li>
                                <a href="#">Ubold</a>
                            </li>
                            <li>
                                <a href="#">Tables</a>
                            </li>
                            <li class="active">
                                Datatable
                            </li>
                        </ol>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title"><b>Default Example</b></h4>
                            <p class="text-muted font-13 m-b-30">
                                DataTables has most features enabled by default, so all you need to do to use it with
                                your own tables is to call the construction function: <code>$().DataTable();</code>.
                            </p>

                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Started Date</th>
                                    <th>Attended rooms</th>
                                    <th>Sent messages</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody>
                                @foreach($customers as $customer)
                                <tr>
                                    <td>{{$customer->id}}</td>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$customer->phone}}</td>
                                    <td>{{$customer->email}}</td>
                                    <td>{{$customer->created_at->toDateString()}}</td>
                                    <td>200</td>
                                    <td>320,800</td>
                                    <td>
                                            <button type="button" class="btn btn-default btn-sm waves-effect waves-light">
                                                   <i class="fa fa-pencil"></i>

                                            </button>
                                    </td>
                                </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



                {{--End row--}}




            </div> <!-- container -->

        </div> <!-- content -->

        <footer class="footer">
            © 2017. All rights reserved.
        </footer>

    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->

@stop