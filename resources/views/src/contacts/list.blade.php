@extends("layouts.app")

@section("content")
    <div id="main-content">
        <div class="container">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Contacts</li>
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
                            <h2>{{$contactsCount}} Contacts in List</h2>
                            <ul class="header-dropdown">
                                <li><a href="{{url('/contact/add')}}" class="btn btn-info" >Add new contact</a></li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th style="width: 60%">Contact Information</th>
                                        <th>Type</th>
                                        <th>Open Task</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contacts as $contact)
                                        <tr>
                                            <td>
                                            @if($contact->status == 1)
                                                    <img src="{{ asset('/assets/images/green_dot.png') }}" style="width: 16px" />
                                            @elseif($contact->status == 2)
                                                    <img src="{{ asset('/assets/images/orange_dot.png') }}" style="width: 16px" />
                                            @else
                                                    <img src="{{ asset('/assets/images/red_dot.png') }}" style="width: 16px" />
                                            @endif
                                            </td>
                                            <td>
                                                <h6 class="mb-0">{!! $contact->firstname !!} {!! $contact->lastname !!}</h6>
                                                <div>{!! $contact->email !!}</div>
                                                <div><small>{!! $contact->location !!}</small></div>

                                                <div class="badge badge-secondary" style="margin: 20px 0 0;">{{$contact->mobile}}</div>
                                            </td>
{{--                                            <td><span class="badge badge-danger">{{$contact->mobile}}</span></td>--}}
{{--                                            <td>{!! $contact->location !!}</td>--}}
                                            <td>
                                                @if($contact->freelancer==1) <span class="badge badge-info">Freelancer</span>@endif
                                                @if($contact->permanent==1) <span class="badge badge-primary">Permanent</span>@endif
                                            </td>
                                            <td>
                                                <a href="#defaultModal_{{$contact->id}}" data-toggle="modal" data-target="#defaultModal_{{$contact->id}}" class="btn btn-outline-danger btn-sm">Task</a>
                                                <div class="modal fade" id="defaultModal_{{$contact->id}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="title" id="defaultModalLabel">{{$contact->firstname}} {{$contact->lastname}}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="{{ url('/task/create') }}">
                                                                    @csrf
                                                                    <input type="hidden" name="contact_id" value="{{$contact->id}}">
                                                                    <div class="form-group">
                                                                        <label>Company</label>
                                                                        <input type="text" class="form-control" name="company">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Description</label>
                                                                        <textarea class="form-control" name="description"></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Link</label>
                                                                        <input type="text" class="form-control" name="link" />
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                                                                        <button type="submit" name="submit" class="btn btn-primary" value="Submit">Submit</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="/contact/update/{{$contact->id}}" type="button" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="fa fa-edit"></i></a>
                                                <a href="/contact/activities/{{$contact->id}}" type="button" class="btn btn-sm btn-outline-success" title="Activities"><i class="fa fa-bars"></i></a>



{{--                                                <a href="#defaultModal_{{$contact->id}}" data-toggle="modal" data-target="#defaultModal_{{$contact->id}}" class="btn btn-outline-success btn-sm"><i class="fa fa-bars"></i></a>--}}
{{--                                                <div class="modal fade" id="defaultModal_{{$contact->id}}" tabindex="-1" role="dialog">--}}
{{--                                                    <div class="modal-dialog modal-lg" role="document">--}}
{{--                                                        <div class="modal-content">--}}
{{--                                                            <div class="modal-header">--}}
{{--                                                                <h4 class="title" id="defaultModalLabel">{{$contact->firstname}} {{$contact->lastname}}</h4>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="modal-body">--}}
{{--                                                                <table class="table table-responsive">--}}
{{--                                                                    @foreach($contact->activities as $activity)--}}
{{--                                                                    <tr>--}}
{{--                                                                        <td style="width: 30%"><p style="white-space: pre-wrap">{{$activity->description}}</p></td>--}}
{{--                                                                        @if($activity->note == null)--}}
{{--                                                                        <form action="{{ url('/activity/note/store') }}" method="post" >--}}
{{--                                                                            <input type="hidden" class="form-control" name="activity_id" value="{{$activity->id}}" />--}}
{{--                                                                            <td style="width: 50%">--}}
{{--                                                                                <label>Note</label>--}}
{{--                                                                                <input type="text" name="activity_note"  class="form-control"/>--}}
{{--                                                                            </td>--}}
{{--                                                                            <td style="width: 20%"><button type="submit" class="btn btn-primary">Save</button></td>--}}
{{--                                                                        </form>--}}
{{--                                                                        @else--}}
{{--                                                                            <td colspan="2">--}}
{{--                                                                                {{ $activity->note }}--}}
{{--                                                                            </td>--}}
{{--                                                                        @endif--}}

{{--                                                                    </tr>--}}
{{--                                                                        @endforeach--}}
{{--                                                                </table>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$contacts->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
