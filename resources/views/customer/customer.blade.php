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
                            <a href="#custom-modal" class="btn btn-default btn-md waves-effect waves-light m-b-30" data-animation="fadein" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a"><i class="md md-add"></i> Add Customer</a>
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
                                        <td id="customer-id">{{$customer->id}}</td>
                                        <td id ="customer-name">{{$customer->name}}</td>
                                        <td id ="customer-phone">{{$customer->phone}}</td>
                                        <td id ="customer-email">{{$customer->email}}</td>
                                        <td id ="customer-createAt">{{$customer->created_at->toDateString()}}</td>
                                        <td>200</td>
                                        <td>320,800</td>
                                        <td>
                                            <a href="#custom-modal" data-id = {{$customer->id}} data-overlayspeed="200" data-overlaycolor="#36404a" data-animation="fadein" data-plugin="custommodal" id="btn-edit" class="btn btn-default btn-sm waves-effect waves-light">
                                                <i class="fa fa-pencil"></i>
                                            </a>
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

    <!-- Modal -->
    <div id="custom-modal" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add</h4>
        <div class="custom-modal-text text-left">

            <form role="form" class="form_modal" id="myForm" method="post" action="/customers/add">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="form_id" value="">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="form-name" name="name" placeholder="Enter name">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="form-email" name="email" placeholder="Enter email">
                </div>

                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input type="tel" class="form-control" id="form-phone" name="phone" placeholder="Enter phone number">
                </div>

                <button type="submit" data-from="admin" id="btn-submit" class="btn btn-default waves-effect waves-light">Save</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.close();">Cancel</button>
                <span id="message"></span>
            </form>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->
@stop

@section('script')
    <script src="/js/customer.js"></script>
@endsection


