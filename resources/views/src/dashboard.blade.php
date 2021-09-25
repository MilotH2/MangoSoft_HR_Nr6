@extends("layouts.app")

@section("content")
    <div id="main-content">
        <div class="container">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Dashboard</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-3 col-md-6">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon"><i class="fa fa-user"></i> </div>
                            <div class="content">
                                <div class="text">New Employee</div>
                                <h5 class="number">22</h5>
                            </div>
                            <hr>
                            <div class="icon"><i class="fa fa-users"></i> </div>
                            <div class="content">
                                <div class="text">Total Employee</div>
                                <h5 class="number">425</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon"><i class="fa fa-university"></i> </div>
                            <div class="content">
                                <div class="text">Total Salary</div>
                                <h5 class="number">$2.8M</h5>
                            </div>
                            <hr>
                            <div class="icon"><i class="fa fa-university"></i> </div>
                            <div class="content">
                                <div class="text">Avg. Salary</div>
                                <h5 class="number">$1,250</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <h5>Income Analysis</h5>
                            <span>8% High then last month</span>
                            <div class="sparkline-pie m-t-20">6,4,8</div>
                            <div class="stats-report m-b-30">
                                <div class="stat-item">
                                    <h5>Design</h5>
                                    <b class="col-black">84.60%</b></div>
                                <div class="stat-item">
                                    <h5>Dev</h5>
                                    <b class="col-black">15.40%</b></div>
                                <div class="stat-item">
                                    <h5>SEO</h5>
                                    <b class="col-black">5.10%</b></div>
                            </div>
                            <span id="sparkline-compositeline">8,4,0,0,0,0,1,4,4,10,10,10,10,0,0,0,4,6,5,9,10</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Employee Performance</h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover m-b-0">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Avatar</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Performance</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><img src="/assets/images/xs/avatar1.jpg" class="rounded-circle width35" alt=""></td>
                                        <td>Marshall Nichols</td>
                                        <td><span>UI UX Designer</span></td>
                                        <td><span class="badge badge-success">Good</span></td>
                                        <td><span class="sparkbar">5,8,6,3,5,9,2</span></td>
                                    </tr>
                                    <tr>
                                        <td><img src="../assets/images/xs/avatar2.jpg" class="rounded-circle width35" alt=""></td>
                                        <td>Susie Willis</td>
                                        <td><span>Designer</span></td>
                                        <td><span class="badge badge-warning">Average</span></td>
                                        <td><span class="sparkbar">2,1,3,-3,5,9,2</span></td>
                                    </tr>
                                    <tr>
                                        <td><img src="../assets/images/xs/avatar3.jpg" class="rounded-circle width35" alt=""></td>
                                        <td>Francisco Vasquez</td>
                                        <td><span>Team Leader</span></td>
                                        <td><span class="badge badge-primary">Excellent</span></td>
                                        <td><span class="sparkbar">5,8,6,3,5,9,2</span></td>
                                    </tr>
                                    <tr>
                                        <td><img src="../assets/images/xs/avatar4.jpg" class="rounded-circle width35" alt=""></td>
                                        <td>Erin Gonzales</td>
                                        <td><span>Android Developer</span></td>
                                        <td><span class="badge badge-danger">Weak</span></td>
                                        <td><span class="sparkbar">2,-5,3,-6,-4,8,-1</span></td>
                                    </tr>
                                    <tr>
                                        <td><img src="../assets/images/xs/avatar5.jpg" class="rounded-circle width35" alt=""></td>
                                        <td>Ava Alexander</td>
                                        <td><span>UI UX Designer</span></td>
                                        <td><span class="badge badge-success">Good</span></td>
                                        <td><span class="sparkbar">5,8,6,3,5,9,-2</span></td>
                                    </tr>
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
