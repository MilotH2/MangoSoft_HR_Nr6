@extends("layouts.app")

@section("content")
    <div id="main-content">
        <div class="container">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Administrators</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-12 text-right">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>List</h2>
                            <ul class="header-dropdown">
                                <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#add_user">Add User</a></li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th></th>
                                        <th></th>
                                        <th>Created Date</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="width45">
                                                <img src="../assets/images/xs/avatar1.jpg" class="rounded-circle width35" alt="">
                                            </td>
                                            <td>
                                                <h6 class="mb-0">{!! $user->firstname !!} {!! $user->lastname !!}</h6>
                                                <span>{!! $user->email !!}</span>
                                            </td>
                                            <td><span class="badge badge-danger">@if($user->role == 2) Admin @else Employee @endif</span></td>
                                            <td>{!! date("d-m-Y",strtotime($user->created_at)) !!}</td>
                                            <td>{!! $user->position !!}</td>
                                            <td>
                                                <button type="button" data-toggle="modal" data-target="#edit_user_{!! $user->id !!}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="fa fa-edit"></i></button>
                                                @if($user->status == 1)
                                                <a  href="{{ url("/user/deactivate/$user->id") }}" type="button" class="btn btn-sm btn-outline-danger js-sweetalert" title="Delete" data-type="confirm"><i class="fa fa-times-circle"></i></a>
                                                @else
                                                <a  href="{{ url("/user/activate/$user->id") }}" type="button" class="btn btn-sm btn-outline-success js-sweetalert" title="Delete" data-type="confirm"><i class="fa fa-check"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                        <div class="modal animated fadeIn" id="edit_user_{!! $user->id !!}" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="title" id="defaultModalLabel">Add User</h6>
                                                    </div>
                                                    <form action="{!! url("/user/add/$user->id") !!}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-12">
                                                                    <div class="form-group">
                                                                        <input name="firstname"  value="{!! $user->firstname !!}"   type="text" class="form-control" placeholder="First Name *">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-12">
                                                                    <div class="form-group">
                                                                        <input name="lastname" value="{!! $user->lastname !!}"  type="text" class="form-control" placeholder="Last Name *">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <input name="email" value="{!! $user->email !!}" type="email" class="form-control" placeholder="Email ID *">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-12">
                                                                    <div class="form-group">
                                                                        <input name="password" type="password" class="form-control" placeholder="Password *">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-12">
                                                                    <div class="form-group">
                                                                        <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password *">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <input name="address" value="{!! $user->address !!}" type="text" class="form-control" placeholder="Address">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-12">
                                                                    <div class="form-group">
                                                                        <input name="position" value="{!! $user->position !!}" type="text" class="form-control" placeholder="Position">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal animated fadeIn" id="add_user" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title" id="defaultModalLabel">Add User</h6>
                </div>
                <form action="{!! url("/user/add") !!}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                    <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <input name="firstname" @if(isset($user)) value="{!! $user->first_name !!}" @endif  type="text" class="form-control" placeholder="First Name *">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <input name="lastname"  type="text" class="form-control" placeholder="Last Name *">
                                </div>
                            </div>
                    </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <input name="email" type="email" class="form-control" placeholder="Email ID *">
                                    </div>
                                </div>
                            </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <input name="password" type="password" class="form-control" placeholder="Password *">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password *">
                                </div>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <input name="address" type="text" class="form-control" placeholder="Address">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input name="position" type="text" class="form-control" placeholder="Position">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
