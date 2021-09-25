
<div class="card">
    <div class="header">
        <h2 class="pull-left" style="margin:0;">
            Filter
        </h2>
            <a class="btn btn-outline-danger pull-right btn-sm" href="{{ url('/search/clear') }}">Clear Search</a>
        <div class="clearfix"></div>
        <hr style="margin-bottom:0;" />
    </div>
    <div class="body" style="padding-top:0;">
        <form action="/search" method="post">
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <label>Content</label>
                    <input type="text" name="content" placeholder="Search for content" @if($content!=null) value="{{$content}}" @endif  class="form-control"/>
                </div>
                <div class="col-sm-12">
                    <label>At Least</label>
                    <select class="form-control" name="degree">
                        <option value="*">Anything</option>
                        @foreach($degrees as $degree)
                            <option value="{{$degree}}" @if($searchDegree==$degree) selected @endif>{{$degree}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-8">
                            <label>Location</label>
                            <input type="text" @if($location!=null) value="{{$location}}" @endif name="location" id="my-input-searchbox" autocomplete="off" placeholder="Enter location" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label>Radius</label>
                            <select class="form-control" name="radius">
                                <option value="" @if($radius == '') selected @endif>None</option>
                                <option value="50km" @if($radius == '50km') selected @endif >Up to 50km</option>
                                <option value="100km" @if($radius == '100km') selected @endif>Up to 100km</option>
                                <option value="150km" @if($radius == '150km') selected @endif>Up to 150km</option>
                            </select>
                        </div>

                    </div>

{{--                    <select class="form-control" name="position">--}}
{{--                        <option value="*">Anything</option>--}}
{{--                        @foreach($positions as $pos)--}}
{{--                            <option value="{{$pos->position}}" @if($position==$pos->position) selected @endif>{{$pos->position}}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label>Skills</label>
                    <input type="text" name="skills" placeholder="Search for content" @if($skills!=null) value="{{$skills}}" @endif class="form-control"/>
                </div>
                <div class="col-sm-12" style="padding-top:10px;padding-left:0;">
                    <div class="col-6">
                        <div class="form-group">
                            <div class="fancy-checkbox">
                                <label>
                                    <input type="checkbox" name="permanent" value="1" @if($permanent!=null && $permanent!=0) checked @endif>
                                    <span>Permanent</span>
                                </label>
                            </div>
                            <div class="fancy-checkbox">
                                <label>
                                    <input type="checkbox" name="freelancer" value="1" @if($freelancer!=null && $freelancer!=0) checked @endif>
                                    <span>Freelancer</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-8">
                            <label>Language</label>
                            <select class="form-control" name="language">
                                <option value="*">All</option>
                                @foreach($languages as $lang)
                                    <option value="{{$lang->language}}" @if($language==$lang->language) selected @endif>{{$lang->language}} ({{$lang->nrs}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label>Level</label>
                            <select class="form-control" name="level">
                                <option value="*" @if($level=='*') selected @endif>All</option>
                                <option value="A1" @if($level=='A1') selected @endif>A1</option>
                                <option value="A2" @if($level=='A2') selected @endif>A2</option>
                                <option value="B1" @if($level=='B1') selected @endif>B1</option>
                                <option value="B2" @if($level=='B2') selected @endif>B2</option>
                                <option value="C1" @if($level=='C1') selected @endif>C1</option>
                                <option value="native" @if($level=='native') selected @endif>Native</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <hr />
            <button class="btn btn-info" style="width:100%;">Filter</button>
        </form>
    </div>
</div>
