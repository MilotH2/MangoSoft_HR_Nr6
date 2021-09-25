@extends("layouts.app")

@section("content")
    <div id="main-content">
        <div class="container">

            <div class="row clearfix">
                <div class="col-lg-3 col-md-6">
                    <div class="card top_counter">
                        <div class="body">
                            <h5 class="text-center">Stats</h5>
                            <hr />
                            <div class="icon"><i class="fa fa-user"></i> </div>
                            <div class="content">
                                <div class="text">Completed Contacts (CV)</div>
                                <h5 class="number">{{$contacts}}</h5>
                            </div>
                            <hr>
                            <div class="icon"><i class="fa fa-tasks"></i> </div>
                            <div class="content">
                                <div class="text">Tasks </div>
                                <h5 class="number"><span class="text-success">{{$activeTasks}}</span> / {{$tasks}}</h5>
                            </div>
                            <hr>
                            <div class="icon"><i class="fa fa-tags"></i> </div>
                            <div class="content">
                                <div class="text">Statuses</div>
                                <h5 class="number">{!! $statuses !!}</h5>
                            </div>
                            <hr>
                            <div class="icon"><i class="fa fa-check-square"></i> </div>
                            <div class="content">
                                <div class="text">Contracts</div>
                                <h5 class="number">{!! $contracts !!}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <h5>Statuses</h5>
                            <hr />
                            <div class="sparkline-pie m-t-20">{!! $opens !!},{!! $interviews !!},{!! $declines !!},{!! $contracts !!}</div>
                            <div class="stats-report m-b-30">
                                <div class="stat-item">
                                    <h5>Open</h5>
                                    <b class="col-black">{!! number_format($opens/($opens+$interviews+$declines+$contracts),2)*100 !!}%</b></div>
                                <div class="stat-item">
                                    <h5>Interview</h5>
                                    <b class="col-black">{!! number_format($interviews/($opens+$interviews+$declines+$contracts),2)*100 !!}%</b></div>
                                <div class="stat-item">
                                    <h5>Decline</h5>
                                    <b class="col-black">{!! number_format($declines/($opens+$interviews+$declines+$contracts),2)*100 !!}%</b></div>
                                <div class="stat-item">
                                    <h5>Contract</h5>
                                    <b class="col-black">{!! number_format($contracts/($opens+$interviews+$declines+$contracts),2)*100 !!}%</b></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="body">
                            <h5 class="text-center">Last 5 Contacts (CV)</h5>
                            <hr />
                            <div class="table-responsive">
                                <table class="table table-hover m-b-0">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Availability</th>
                                        <th>Salary</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lastContacts as $contact)
                                    <tr>
                                        <td>{!! $contact->firstname.' '.$contact->lastname !!}</td>
                                        <td><span>{!! $contact->positions[0]->position ?? '' !!}</span></td>
                                        <td>
                                            @if($contact->permanent==1)
                                                <span class="badge badge-success">Permanent</span>
                                            @elseif($contact->freelancer==1)
                                                <span class="badge badge-info">Freelancer</span>
                                            @else
                                                <span class="badge badge-danger">Not Available</span>
                                            @endif
                                        </td>
                                        <td class="text-right">{!! $contact->salary_from.'-'.$contact->salary_to !!} &euro;</td>
                                    </tr>
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
@endsection
@section('footer')
    <script src="/frontend_assets/bundles/chartist.bundle.js"></script>
    <script src="/frontend_assets/js/index.js"></script>
@endsection
