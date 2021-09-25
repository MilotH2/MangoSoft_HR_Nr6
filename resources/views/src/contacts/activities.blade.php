@extends("layouts.app")

@section("content")
    <div id="main-content">
        <div class="container">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{url('/contact/list')}}">Contact List</a></li>
                            <li class="breadcrumb-item active">{{$contact->firstname}} {{$contact->lastname}}</li>
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
                        <div class="body">
                            <div class="table-responsive">
                                @if($contact->activities->isEmpty())
                                    <span class="badge badge-warning">There is no activity for this contact</span>
                                @else
                                    <table class="table table-responsive">

                                        @foreach($contact->activities as $activity)
                                            <tr>
                                                <td style="width: 30%"><p style="white-space: pre-wrap">{{$activity->description}}</p></td>
                                                <form action="{{ url('/activity/note/store') }}" method="post" >
                                                    <input type="hidden" class="form-control" name="activity_id" value="{{$activity->id}}" />
                                                    <td style="width: 50%">
                                                        <label>Note</label>
                                                        <input type="text" name="activity_note" @if($activity->note != null) value="{{$activity->note}}" @endif class="form-control"/>
                                                    </td>
                                                    <td style="width: 20%"><button type="submit" class="btn btn-primary" style="margin-top: 28px !important;">Save</button></td>
                                                </form>

                                            </tr>
                                        @endforeach
                                    </table>
                                @endif




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
