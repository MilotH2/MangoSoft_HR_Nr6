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
                @if(isset($searchResults))
                    <div class="col-12">
                        @include('src.search.search')
                    </div>
                @else
                    <div class="col-lg-3">
                        @include('src.search.filters')
                    </div>
                    <div class="col-lg-9">
                        @include('src.search.result')
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="/frontend_assets/js/pages/tables/jquery-datatable.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYU0AHeiV6cYQM3JSi-_rDjJX9LTmi4CY&libraries=places"></script>
    <script>
        function initAutocomplete() {
            var input = document.getElementById('my-input-searchbox');
            var searchBox = new google.maps.places.Autocomplete(input,{types:['(cities)'],
                componentRestrictions: {country: "ch"}});
        }
        document.addEventListener("DOMContentLoaded", function(event) {
            initAutocomplete();
        });
    </script>
@endsection
