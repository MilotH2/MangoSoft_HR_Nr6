@extends("layouts.app")

@section("content")
    <div id="main-content">
        <div class="container">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Statuses</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix" id="app">
                <main-app token="{{ auth()->user()->remember_token }}" />
            </div>
        </div>
    </div>
@endsection
@section("footer")
    <script src="/js/app.js"></script>
@endsection
