
<link rel="stylesheet" href="/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">

<div class="card">
    <div class="header">
        <h2 style="margin:0;">
            Result
            <a href="{{url('/contact/add')}}" class="btn btn-info btn-sm pull-right">Add new contact</a>
        </h2>
        <hr style="margin-bottom:0;" />
    </div>
    <div class="body" style="padding-top:0;">
        <div class="table-responsive">
            <table class="table table-hover myDataTable dataTable table-custom m-b-0">
                <thead>
                <tr>
                    <th></th>
                    <th>Name / Email</th>
                    <th>Position</th>
                    <th>Degree</th>
                    <th>Age</th>
                    <th>Salary Range</th>
                    <th>Fit</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @foreach($contacts as $contact)
                    @php
                        $contact = (object)$contact;
                    @endphp
                    @if(isset($contact->positions))
                        @php
                            $positions = $contact->positions;
                        @endphp
                    @else
                        @php
                            $positions = [];
                        @endphp
                    @endif
                    @if(isset($contact->degrees))
                        @php
                            $degrees = $contact->degrees;
                        @endphp
                    @else
                        @php
                            $degrees = [];
                        @endphp
                    @endif
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
                            <span>{!! $contact->email !!}</span>
                            <br />
                            <span class="badge badge-danger">{{$contact->mobile}}</span>
                        </td>
                        <td style=" word-wrap: break-word;max-width:150px;white-space: normal;">
                            @if(isset($positions[0]))
                                {!! $positions[0]['position'] !!}
                            @endif
                        </td>
                        <td style=" word-wrap: break-word;max-width:100px;white-space: normal;">
                            @if(isset($degrees[0]))
                                {!! $degrees[0]['degree'] !!}
                            @endif
                        </td>
                        <td>@if($contact->birthday!=null){!! \Carbon\Carbon::parse($contact->birthday)->age; !!}@endif</td>
                        <td>@if($contact->salary_from!=null) {!! (int)$contact->salary_from !!} - @endif @if($contact->salary_to!=null) {!! (int)$contact->salary_to !!}k @endif</td>
                        <td>@if($skills!=null){!! \App\Library\LibHelper::skillsFit($contact->skills, $skills) !!}@endif</td>
                        <td>
                            <a href="/contact/update/{{$contact->id}}" target="_blank" class="btn btn-outline-info btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="#defaultModal_{{$contact->id}}" data-toggle="modal" data-target="#defaultModal_{{$contact->id}}" class="btn btn-outline-success btn-sm"><i class="fa fa-bars"></i></a>
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
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br />
{{--            @if($contacts->links())--}}
{{--                {{$contacts->links()}}--}}
{{--            @endif--}}
        </div>
    </div>
</div>


@section('footer')
    <script src="/frontend_assets/js/pages/tables/jquery-datatable.js"></script>
@endsection
