@extends("layouts.app")

@section("content")
    <div id="main-content">
        <div class="container">

            @if(!$isStart)
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Contacts</li>
                            <li class="breadcrumb-item active">{{$contact->firstname.' '.$contact->lastname}}</li>
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
            @endif
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <div class="modal-body">
                                @if(($contact->id != null || $contact->id != 0) && auth()->check())
                                <h4><button type="button" style="border: 0" class="btn btn-outline-info" onclick="javascript:window.history.back();"><i class="fa fa-angle-left"></i></button> Basic Information</h4>

                                    @if($contact->status == 1)
                                        <img src="{{ asset('/assets/images/green_dot.png') }}" style="width: 16px" />
                                    @elseif($contact->status == 2)
                                        <img src="{{ asset('/assets/images/orange_dot.png') }}" style="width: 16px" />
                                    @else
                                        <img src="{{ asset('/assets/images/red_dot.png') }}" style="width: 16px" />
                                    @endif
                                    <a style="float: right;margin: 0 10px" href="#changeStatus_{{$contact->id}}" data-toggle="modal" data-target="#changeStatus_{{$contact->id}}"
                                    @if($contact->status == 1)
                                    class="btn btn-success btn-sm"
                                    @elseif($contact->status == 2)
                                       class="btn btn-warning btn-sm"
                                    @else
                                       class="btn btn-danger btn-sm"
                                    @endif
                                    >
                                        Change Status</a>
                                    <div class="modal fade" id="changeStatus_{{$contact->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="title" id="defaultModalLabel">Change Status</h4>
                                                    <i class="fa fa-times" style="float: right;cursor: pointer" data-dismiss="modal"></i>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" id="statusForm" action="{{ url("/contact/$contact->id/changeStatus") }}">
                                                        <div class="form-group">
                                                            <select name="status" class="form-control" id="status">
                                                                <option @if($contact->status == 1) selected @endif value="1">Green</option>
                                                                <option @if($contact->status == 2) selected @endif value="2">Orange</option>
                                                                <option @if($contact->status == 3) selected @endif value="3">Red</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn btn-primary" name="submit" type="submit">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a style="float: right;margin: 0 10px" href="#createNote" data-toggle="modal" data-target="#createNote" class="btn btn-primary btn-sm">Create Note</a>
                                    <div class="modal fade" id="createNote" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="title" id="defaultModalLabel">Add note</h4>
                                                    <i class="fa fa-times" style="float: right;cursor: pointer" data-dismiss="modal"></i>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{ url("/contact/$contact->id/saveNote") }}">
                                                        <div class="form-group">
                                                            <label for="note">Note</label>
                                                            <textarea class="form-control" name="note" id="note"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </form>

                                                    <br />
                                                    <hr>
                                                    <br />
                                                    <div class="notes">
                                                        <table class="table table-responsive">
                                                            <tr>
                                                                <td>Note</td>
                                                                <td>Created Date</td>
                                                            </tr>

                                                            @foreach($contact->notes as $note )
                                                                <tr>
                                                                    <td>{{$note->note}}</td>
                                                                    <td>{{ date('d.m.Y H:i',strtotime($note->created_at)) }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a style="float: right;margin: 0 10px" href="#defaultModal_{{$contact->id}}" data-toggle="modal" data-target="#defaultModal_{{$contact->id}}" class="btn btn-info btn-sm">Task</a>
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

                                    <a style="float: right;margin: 0 10px" href="/contact/activities/{{$contact->id}}" type="button" class="btn btn-sm btn-outline-success" title="History"><i class="fa fa-bars"></i> History</a>
                                @endif

                                <br/>
                                <hr />
                                <form action="{!! url('/contact/save') !!}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{$contact->id}}" name="id" />
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>First name</label>
                                                <input name="firstname"  type="text" value="{{$contact->firstname}}" class="form-control" placeholder="First Name *">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Last name</label>
                                                <input name="lastname"  type="text" value="{{$contact->lastname}}" class="form-control" placeholder="Last Name *">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Email address</label>
                                                <input name="email" type="email" value="{{$contact->email}}" class="form-control" placeholder="Email ID *">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input name="mobile" type="tel" value="{{$contact->mobile}}" class="form-control" placeholder="Mobile Nr">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Tel</label>
                                                <input name="tel" type="tel" value="{{$contact->tel}}" class="form-control" placeholder="Tel Nr">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>Plz</label>
                                                <input name="plz" type="text" value="{{$contact->plz}}" class="form-control" placeholder="Plz">
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input name="location" type="text" value="{{$contact->location}}" class="form-control" placeholder="Location">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input name="country" type="text" value="{{$contact->country}}" class="form-control" placeholder="Country">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Birthday</label>
                                                <input name="birthday" type="text" autocomplete="off" class="datepicker form-control" value="{{$contact->birthday}}" placeholder="Birthday">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="form-group">
                                                <label>Link to PDF </label>
                                                <input name="link_to_pdf" type="url" value="{{$contact->link_to_pdf}}" class="form-control" placeholder="http://">
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Salary from </label>
                                                <input name="salary_from" type="number" min="0.00" step="100" value="{{$contact->salary_from}}" class="form-control" placeholder="4000">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Salary to </label>
                                                <input name="salary_to" type="number" min="0.00" step="100" value="{{$contact->salary_to}}" class="form-control" placeholder="8000">
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="fancy-checkbox">
                                                    <label>
                                                        <input type="checkbox" name="freelancer" value="1" @if($contact->freelancer==1) checked @endif >
                                                        <span>Freelancer</span>
                                                    </label>
                                                </div>
                                                <div class="fancy-checkbox">
                                                    <label>
                                                        <input type="checkbox" name="permanent" value="1" @if($contact->permanent==1) checked @endif >
                                                        <span>Permanent</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Note</label>
                                                <input type="text" class="form-control" value="{{$contact->note}}" name="note" />
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card" id="app">
                        <div class="body">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        @include('src.contacts.skill')
                                        <br />
                                    </div>
                                    <div class="col-lg-6">
                                        @include('src.contacts.education')
                                        <br />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5">
                                        @include('src.contacts.position')
                                        <br />
                                    </div>
                                    <div class="col-lg-3">
                                        @include('src.contacts.language')
                                        <br />
                                    </div>
                                    <div class="col-lg-4">
                                        @include('src.contacts.nationality')
                                        <br />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('footer')
    <script>
        $( document ).ready(function() {
            $('.datepicker').datepicker({
                format: 'dd.mm.yyyy',
            });

            @if(session('modalStatus'))
                    var e = document.getElementById("status");
                    var selectedStatus = e.options[e.selectedIndex].value;
                    if(selectedStatus == 1){
                        var message = 'Changed Status to available(green)'
                    }else if (selectedStatus == 2){
                        var message = 'Changed Status to in review(orange)'
                    }else if (selectedStatus == 3){
                        var message = 'Changed Status to busy(red)'
                    }
                    $("textarea#note").html(message);
                    console.log(message);
                    $('#createNote').modal('show');
                @endif
        });
            $("#statusForm").submit( function (event) {
                event.preventdefault();
                var url = $(this).attr('action');
                var data = $(this).serialize();
                var request_method = $(this).attr("method");
                $.ajax({
                    url : url,
                    type: request_method,
                    data : data
                }).done(function(response){
                });
            });
    </script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                contact_id:'{{$contact->id}}',
                showAddSkills:1,
                showAddPositions:1,
                showAddEdu:1,
                showAddLang:1,
                showAddNation:1,
                nation:{
                    id:null,
                    nationality:null,
                    permission_to_work:null,
                },
                nationalities:[],
                language:{
                    id:null,
                    language:null,
                    level:null,
                },
                languages:[],
                degree:{
                    id:null,
                    degree:null,
                    institution:null,
                    year:null,
                },
                degrees:[],
                position:{
                    id:null,
                    position:null,
                    description:null,
                    company:null,
                    from_year:null,
                    to_year:null,
                },
                positions:[],
                skills_list:[],
                skill:{
                    id:null,
                    skill:null,
                    level:null,
                },
                skill_error:0,
                level_error:0,
                skills:[],
                skillsArray:['Angular','VueJs','ReactJs','NodeJs','PHP','Laravel'],
                countries:[
                    {"name": "Afghanistan", "code": "AF"},
                    {"name": "Åland Islands", "code": "AX"},
                    {"name": "Albania", "code": "AL"},
                    {"name": "Algeria", "code": "DZ"},
                    {"name": "American Samoa", "code": "AS"},
                    {"name": "AndorrA", "code": "AD"},
                    {"name": "Angola", "code": "AO"},
                    {"name": "Anguilla", "code": "AI"},
                    {"name": "Antarctica", "code": "AQ"},
                    {"name": "Antigua and Barbuda", "code": "AG"},
                    {"name": "Argentina", "code": "AR"},
                    {"name": "Armenia", "code": "AM"},
                    {"name": "Aruba", "code": "AW"},
                    {"name": "Australia", "code": "AU"},
                    {"name": "Austria", "code": "AT"},
                    {"name": "Azerbaijan", "code": "AZ"},
                    {"name": "Bahamas", "code": "BS"},
                    {"name": "Bahrain", "code": "BH"},
                    {"name": "Bangladesh", "code": "BD"},
                    {"name": "Barbados", "code": "BB"},
                    {"name": "Belarus", "code": "BY"},
                    {"name": "Belgium", "code": "BE"},
                    {"name": "Belize", "code": "BZ"},
                    {"name": "Benin", "code": "BJ"},
                    {"name": "Bermuda", "code": "BM"},
                    {"name": "Bhutan", "code": "BT"},
                    {"name": "Bolivia", "code": "BO"},
                    {"name": "Bosnia and Herzegovina", "code": "BA"},
                    {"name": "Botswana", "code": "BW"},
                    {"name": "Bouvet Island", "code": "BV"},
                    {"name": "Brazil", "code": "BR"},
                    {"name": "British Indian Ocean Territory", "code": "IO"},
                    {"name": "Brunei Darussalam", "code": "BN"},
                    {"name": "Bulgaria", "code": "BG"},
                    {"name": "Burkina Faso", "code": "BF"},
                    {"name": "Burundi", "code": "BI"},
                    {"name": "Cambodia", "code": "KH"},
                    {"name": "Cameroon", "code": "CM"},
                    {"name": "Canada", "code": "CA"},
                    {"name": "Cape Verde", "code": "CV"},
                    {"name": "Cayman Islands", "code": "KY"},
                    {"name": "Central African Republic", "code": "CF"},
                    {"name": "Chad", "code": "TD"},
                    {"name": "Chile", "code": "CL"},
                    {"name": "China", "code": "CN"},
                    {"name": "Christmas Island", "code": "CX"},
                    {"name": "Cocos (Keeling) Islands", "code": "CC"},
                    {"name": "Colombia", "code": "CO"},
                    {"name": "Comoros", "code": "KM"},
                    {"name": "Congo", "code": "CG"},
                    {"name": "Congo, The Democratic Republic of the", "code": "CD"},
                    {"name": "Cook Islands", "code": "CK"},
                    {"name": "Costa Rica", "code": "CR"},
                    {"name": "Cote DIvoire", "code": "CI"},
                    {"name": "Croatia", "code": "HR"},
                    {"name": "Cuba", "code": "CU"},
                    {"name": "Cyprus", "code": "CY"},
                    {"name": "Czech Republic", "code": "CZ"},
                    {"name": "Denmark", "code": "DK"},
                    {"name": "Djibouti", "code": "DJ"},
                    {"name": "Dominica", "code": "DM"},
                    {"name": "Dominican Republic", "code": "DO"},
                    {"name": "Ecuador", "code": "EC"},
                    {"name": "Egypt", "code": "EG"},
                    {"name": "El Salvador", "code": "SV"},
                    {"name": "Equatorial Guinea", "code": "GQ"},
                    {"name": "Eritrea", "code": "ER"},
                    {"name": "Estonia", "code": "EE"},
                    {"name": "Ethiopia", "code": "ET"},
                    {"name": "Falkland Islands (Malvinas)", "code": "FK"},
                    {"name": "Faroe Islands", "code": "FO"},
                    {"name": "Fiji", "code": "FJ"},
                    {"name": "Finland", "code": "FI"},
                    {"name": "France", "code": "FR"},
                    {"name": "French Guiana", "code": "GF"},
                    {"name": "French Polynesia", "code": "PF"},
                    {"name": "French Southern Territories", "code": "TF"},
                    {"name": "Gabon", "code": "GA"},
                    {"name": "Gambia", "code": "GM"},
                    {"name": "Georgia", "code": "GE"},
                    {"name": "Germany", "code": "DE"},
                    {"name": "Ghana", "code": "GH"},
                    {"name": "Gibraltar", "code": "GI"},
                    {"name": "Greece", "code": "GR"},
                    {"name": "Greenland", "code": "GL"},
                    {"name": "Grenada", "code": "GD"},
                    {"name": "Guadeloupe", "code": "GP"},
                    {"name": "Guam", "code": "GU"},
                    {"name": "Guatemala", "code": "GT"},
                    {"name": "Guernsey", "code": "GG"},
                    {"name": "Guinea", "code": "GN"},
                    {"name": "Guinea-Bissau", "code": "GW"},
                    {"name": "Guyana", "code": "GY"},
                    {"name": "Haiti", "code": "HT"},
                    {"name": "Heard Island and Mcdonald Islands", "code": "HM"},
                    {"name": "Holy See (Vatican City State)", "code": "VA"},
                    {"name": "Honduras", "code": "HN"},
                    {"name": "Hong Kong", "code": "HK"},
                    {"name": "Hungary", "code": "HU"},
                    {"name": "Iceland", "code": "IS"},
                    {"name": "India", "code": "IN"},
                    {"name": "Indonesia", "code": "ID"},
                    {"name": "Iran, Islamic Republic Of", "code": "IR"},
                    {"name": "Iraq", "code": "IQ"},
                    {"name": "Ireland", "code": "IE"},
                    {"name": "Isle of Man", "code": "IM"},
                    {"name": "Israel", "code": "IL"},
                    {"name": "Italy", "code": "IT"},
                    {"name": "Jamaica", "code": "JM"},
                    {"name": "Japan", "code": "JP"},
                    {"name": "Jersey", "code": "JE"},
                    {"name": "Jordan", "code": "JO"},
                    {"name": "Kazakhstan", "code": "KZ"},
                    {"name": "Kenya", "code": "KE"},
                    {"name": "Kiribati", "code": "KI"},
                    {"name": "Korea", "code": "KP"},
                    {"name": "Korea, Republic of", "code": "KR"},
                    {"name": "Kuwait", "code": "KW"},
                    {"name": "Kyrgyzstan", "code": "KG"},
                    {"name": "Lao People", "code": "LA"},
                    {"name": "Latvia", "code": "LV"},
                    {"name": "Lebanon", "code": "LB"},
                    {"name": "Lesotho", "code": "LS"},
                    {"name": "Liberia", "code": "LR"},
                    {"name": "Libyan Arab Jamahiriya", "code": "LY"},
                    {"name": "Liechtenstein", "code": "LI"},
                    {"name": "Lithuania", "code": "LT"},
                    {"name": "Luxembourg", "code": "LU"},
                    {"name": "Macao", "code": "MO"},
                    {"name": "Macedonia, The Former Yugoslav Republic of", "code": "MK"},
                    {"name": "Madagascar", "code": "MG"},
                    {"name": "Malawi", "code": "MW"},
                    {"name": "Malaysia", "code": "MY"},
                    {"name": "Maldives", "code": "MV"},
                    {"name": "Mali", "code": "ML"},
                    {"name": "Malta", "code": "MT"},
                    {"name": "Marshall Islands", "code": "MH"},
                    {"name": "Martinique", "code": "MQ"},
                    {"name": "Mauritania", "code": "MR"},
                    {"name": "Mauritius", "code": "MU"},
                    {"name": "Mayotte", "code": "YT"},
                    {"name": "Mexico", "code": "MX"},
                    {"name": "Micronesia, Federated States of", "code": "FM"},
                    {"name": "Moldova, Republic of", "code": "MD"},
                    {"name": "Monaco", "code": "MC"},
                    {"name": "Mongolia", "code": "MN"},
                    {"name": "Montserrat", "code": "MS"},
                    {"name": "Morocco", "code": "MA"},
                    {"name": "Mozambique", "code": "MZ"},
                    {"name": "Myanmar", "code": "MM"},
                    {"name": "Namibia", "code": "NA"},
                    {"name": "Nauru", "code": "NR"},
                    {"name": "Nepal", "code": "NP"},
                    {"name": "Netherlands", "code": "NL"},
                    {"name": "Netherlands Antilles", "code": "AN"},
                    {"name": "New Caledonia", "code": "NC"},
                    {"name": "New Zealand", "code": "NZ"},
                    {"name": "Nicaragua", "code": "NI"},
                    {"name": "Niger", "code": "NE"},
                    {"name": "Nigeria", "code": "NG"},
                    {"name": "Niue", "code": "NU"},
                    {"name": "Norfolk Island", "code": "NF"},
                    {"name": "Northern Mariana Islands", "code": "MP"},
                    {"name": "Norway", "code": "NO"},
                    {"name": "Oman", "code": "OM"},
                    {"name": "Pakistan", "code": "PK"},
                    {"name": "Palau", "code": "PW"},
                    {"name": "Palestinian Territory, Occupied", "code": "PS"},
                    {"name": "Panama", "code": "PA"},
                    {"name": "Papua New Guinea", "code": "PG"},
                    {"name": "Paraguay", "code": "PY"},
                    {"name": "Peru", "code": "PE"},
                    {"name": "Philippines", "code": "PH"},
                    {"name": "Pitcairn", "code": "PN"},
                    {"name": "Poland", "code": "PL"},
                    {"name": "Portugal", "code": "PT"},
                    {"name": "Puerto Rico", "code": "PR"},
                    {"name": "Qatar", "code": "QA"},
                    {"name": "Reunion", "code": "RE"},
                    {"name": "Romania", "code": "RO"},
                    {"name": "Russian Federation", "code": "RU"},
                    {"name": "RWANDA", "code": "RW"},
                    {"name": "Saint Helena", "code": "SH"},
                    {"name": "Saint Kitts and Nevis", "code": "KN"},
                    {"name": "Saint Lucia", "code": "LC"},
                    {"name": "Saint Pierre and Miquelon", "code": "PM"},
                    {"name": "Saint Vincent and the Grenadines", "code": "VC"},
                    {"name": "Samoa", "code": "WS"},
                    {"name": "San Marino", "code": "SM"},
                    {"name": "Sao Tome and Principe", "code": "ST"},
                    {"name": "Saudi Arabia", "code": "SA"},
                    {"name": "Senegal", "code": "SN"},
                    {"name": "Serbia and Montenegro", "code": "CS"},
                    {"name": "Seychelles", "code": "SC"},
                    {"name": "Sierra Leone", "code": "SL"},
                    {"name": "Singapore", "code": "SG"},
                    {"name": "Slovakia", "code": "SK"},
                    {"name": "Slovenia", "code": "SI"},
                    {"name": "Solomon Islands", "code": "SB"},
                    {"name": "Somalia", "code": "SO"},
                    {"name": "South Africa", "code": "ZA"},
                    {"name": "South Georgia and the South Sandwich Islands", "code": "GS"},
                    {"name": "Spain", "code": "ES"},
                    {"name": "Sri Lanka", "code": "LK"},
                    {"name": "Sudan", "code": "SD"},
                    {"name": "Suriname", "code": "SR"},
                    {"name": "Svalbard and Jan Mayen", "code": "SJ"},
                    {"name": "Swaziland", "code": "SZ"},
                    {"name": "Sweden", "code": "SE"},
                    {"name": "Switzerland", "code": "CH"},
                    {"name": "Syrian Arab Republic", "code": "SY"},
                    {"name": "Taiwan, Province of China", "code": "TW"},
                    {"name": "Tajikistan", "code": "TJ"},
                    {"name": "Tanzania, United Republic of", "code": "TZ"},
                    {"name": "Thailand", "code": "TH"},
                    {"name": "Timor-Leste", "code": "TL"},
                    {"name": "Togo", "code": "TG"},
                    {"name": "Tokelau", "code": "TK"},
                    {"name": "Tonga", "code": "TO"},
                    {"name": "Trinidad and Tobago", "code": "TT"},
                    {"name": "Tunisia", "code": "TN"},
                    {"name": "Turkey", "code": "TR"},
                    {"name": "Turkmenistan", "code": "TM"},
                    {"name": "Turks and Caicos Islands", "code": "TC"},
                    {"name": "Tuvalu", "code": "TV"},
                    {"name": "Uganda", "code": "UG"},
                    {"name": "Ukraine", "code": "UA"},
                    {"name": "United Arab Emirates", "code": "AE"},
                    {"name": "United Kingdom", "code": "GB"},
                    {"name": "United States", "code": "US"},
                    {"name": "United States Minor Outlying Islands", "code": "UM"},
                    {"name": "Uruguay", "code": "UY"},
                    {"name": "Uzbekistan", "code": "UZ"},
                    {"name": "Vanuatu", "code": "VU"},
                    {"name": "Venezuela", "code": "VE"},
                    {"name": "Viet Nam", "code": "VN"},
                    {"name": "Virgin Islands, British", "code": "VG"},
                    {"name": "Virgin Islands, U.S.", "code": "VI"},
                    {"name": "Wallis and Futuna", "code": "WF"},
                    {"name": "Western Sahara", "code": "EH"},
                    {"name": "Yemen", "code": "YE"},
                    {"name": "Zambia", "code": "ZM"},
                    {"name": "Zimbabwe", "code": "ZW"}
                ],
                languages_list:[
                    {
                        "name":"Abkhaz",
                        "nativeName":"аҧсуа"
                    },
                    {
                        "name":"Afar",
                        "nativeName":"Afaraf"
                    },
                    {
                        "name":"Afrikaans",
                        "nativeName":"Afrikaans"
                    },
                    {
                        "name":"Akan",
                        "nativeName":"Akan"
                    },
                    {
                        "name":"Albanian",
                        "nativeName":"Shqip"
                    },
                    {
                        "name":"Amharic",
                        "nativeName":"አማርኛ"
                    },
                    {
                        "name":"Arabic",
                        "nativeName":"العربية"
                    },
                    {
                        "name":"Aragonese",
                        "nativeName":"Aragonés"
                    },
                    {
                        "name":"Armenian",
                        "nativeName":"Հայերեն"
                    },
                    {
                        "name":"Assamese",
                        "nativeName":"অসমীয়া"
                    },
                    {
                        "name":"Avaric",
                        "nativeName":"авар мацӀ, магӀарул мацӀ"
                    },
                    {
                        "name":"Avestan",
                        "nativeName":"avesta"
                    },
                    {
                        "name":"Aymara",
                        "nativeName":"aymar aru"
                    },
                    {
                        "name":"Azerbaijani",
                        "nativeName":"azərbaycan dili"
                    },
                    {
                        "name":"Bambara",
                        "nativeName":"bamanankan"
                    },
                    {
                        "name":"Bashkir",
                        "nativeName":"башҡорт теле"
                    },
                    {
                        "name":"Basque",
                        "nativeName":"euskara, euskera"
                    },
                    {
                        "name":"Belarusian",
                        "nativeName":"Беларуская"
                    },
                    {
                        "name":"Bengali",
                        "nativeName":"বাংলা"
                    },
                    {
                        "name":"Bihari",
                        "nativeName":"भोजपुरी"
                    },
                    {
                        "name":"Bislama",
                        "nativeName":"Bislama"
                    },
                    {
                        "name":"Bosnian",
                        "nativeName":"bosanski jezik"
                    },
                    {
                        "name":"Breton",
                        "nativeName":"brezhoneg"
                    },
                    {
                        "name":"Bulgarian",
                        "nativeName":"български език"
                    },
                    {
                        "name":"Burmese",
                        "nativeName":"ဗမာစာ"
                    },
                    {
                        "name":"Catalan; Valencian",
                        "nativeName":"Català"
                    },
                    {
                        "name":"Chamorro",
                        "nativeName":"Chamoru"
                    },
                    {
                        "name":"Chechen",
                        "nativeName":"нохчийн мотт"
                    },
                    {
                        "name":"Chichewa; Chewa; Nyanja",
                        "nativeName":"chiCheŵa, chinyanja"
                    },
                    {
                        "name":"Chinese",
                        "nativeName":"中文 (Zhōngwén), 汉语, 漢語"
                    },
                    {
                        "name":"Chuvash",
                        "nativeName":"чӑваш чӗлхи"
                    },
                    {
                        "name":"Cornish",
                        "nativeName":"Kernewek"
                    },
                    {
                        "name":"Corsican",
                        "nativeName":"corsu, lingua corsa"
                    },
                    {
                        "name":"Cree",
                        "nativeName":"ᓀᐦᐃᔭᐍᐏᐣ"
                    },
                    {
                        "name":"Croatian",
                        "nativeName":"hrvatski"
                    },
                    {
                        "name":"Czech",
                        "nativeName":"česky, čeština"
                    },
                    {
                        "name":"Danish",
                        "nativeName":"dansk"
                    },
                    {
                        "name":"Divehi; Dhivehi; Maldivian;",
                        "nativeName":"ދިވެހި"
                    },
                    {
                        "name":"Dutch",
                        "nativeName":"Nederlands, Vlaams"
                    },
                    {
                        "name":"English",
                        "nativeName":"English"
                    },
                    {
                        "name":"Esperanto",
                        "nativeName":"Esperanto"
                    },
                    {
                        "name":"Estonian",
                        "nativeName":"eesti, eesti keel"
                    },
                    {
                        "name":"Ewe",
                        "nativeName":"Eʋegbe"
                    },
                    {
                        "name":"Faroese",
                        "nativeName":"føroyskt"
                    },
                    {
                        "name":"Fijian",
                        "nativeName":"vosa Vakaviti"
                    },
                    {
                        "name":"Finnish",
                        "nativeName":"suomi, suomen kieli"
                    },
                    {
                        "name":"French",
                        "nativeName":"français, langue française"
                    },
                    {
                        "name":"Fula; Fulah; Pulaar; Pular",
                        "nativeName":"Fulfulde, Pulaar, Pular"
                    },
                    {
                        "name":"Galician",
                        "nativeName":"Galego"
                    },
                    {
                        "name":"Georgian",
                        "nativeName":"ქართული"
                    },
                    {
                        "name":"German",
                        "nativeName":"Deutsch"
                    },
                    {
                        "name":"Greek, Modern",
                        "nativeName":"Ελληνικά"
                    },
                    {
                        "name":"Guaraní",
                        "nativeName":"Avañeẽ"
                    },
                    {
                        "name":"Gujarati",
                        "nativeName":"ગુજરાતી"
                    },
                    {
                        "name":"Haitian; Haitian Creole",
                        "nativeName":"Kreyòl ayisyen"
                    },
                    {
                        "name":"Hausa",
                        "nativeName":"Hausa, هَوُسَ"
                    },
                    {
                        "name":"Hebrew",
                        "nativeName":"עברית"
                    },
                    {
                        "name":"Hebrew",
                        "nativeName":"עברית"
                    },
                    {
                        "name":"Herero",
                        "nativeName":"Otjiherero"
                    },
                    {
                        "name":"Hindi",
                        "nativeName":"हिन्दी, हिंदी"
                    },
                    {
                        "name":"Hiri Motu",
                        "nativeName":"Hiri Motu"
                    },
                    {
                        "name":"Hungarian",
                        "nativeName":"Magyar"
                    },
                    {
                        "name":"Interlingua",
                        "nativeName":"Interlingua"
                    },
                    {
                        "name":"Indonesian",
                        "nativeName":"Bahasa Indonesia"
                    },
                    {
                        "name":"Interlingue",
                        "nativeName":"Originally called Occidental; then Interlingue after WWII"
                    },
                    {
                        "name":"Irish",
                        "nativeName":"Gaeilge"
                    },
                    {
                        "name":"Igbo",
                        "nativeName":"Asụsụ Igbo"
                    },
                    {
                        "name":"Inupiaq",
                        "nativeName":"Iñupiaq, Iñupiatun"
                    },
                    {
                        "name":"Ido",
                        "nativeName":"Ido"
                    },
                    {
                        "name": "Icelandic",
                        "nativeName": "Íslenska"
                    },
                    {
                        "name":"Italian",
                        "nativeName":"Italiano"
                    },
                    {
                        "name":"Inuktitut",
                        "nativeName":"ᐃᓄᒃᑎᑐᑦ"
                    },
                    {
                        "name":"Japanese",
                        "nativeName":"日本語 (にほんご／にっぽんご)"
                    },
                    {
                        "name":"Javanese",
                        "nativeName":"basa Jawa"
                    },
                    {
                        "name":"Kalaallisut, Greenlandic",
                        "nativeName":"kalaallisut, kalaallit oqaasii"
                    },
                    {
                        "name":"Kannada",
                        "nativeName":"ಕನ್ನಡ"
                    },
                    {
                        "name":"Kanuri",
                        "nativeName":"Kanuri"
                    },
                    {
                        "name":"Kashmiri",
                        "nativeName":"कश्मीरी, كشميري‎"
                    },
                    {
                        "name":"Kazakh",
                        "nativeName":"Қазақ тілі"
                    },
                    {
                        "name":"Khmer",
                        "nativeName":"ភាសាខ្មែរ"
                    },
                    {
                        "name":"Kikuyu, Gikuyu",
                        "nativeName":"Gĩkũyũ"
                    },
                    {
                        "name":"Kinyarwanda",
                        "nativeName":"Ikinyarwanda"
                    },
                    {
                        "name":"Kirghiz, Kyrgyz",
                        "nativeName":"кыргыз тили"
                    },
                    {
                        "name":"Komi",
                        "nativeName":"коми кыв"
                    },
                    {
                        "name":"Kongo",
                        "nativeName":"KiKongo"
                    },
                    {
                        "name":"Korean",
                        "nativeName":"한국어 (韓國語), 조선말 (朝鮮語)"
                    },
                    {
                        "name":"Kurdish",
                        "nativeName":"Kurdî, كوردی‎"
                    },
                    {
                        "name":"Kwanyama, Kuanyama",
                        "nativeName":"Kuanyama"
                    },
                    {
                        "name":"Latin",
                        "nativeName":"latine, lingua latina"
                    },
                    {
                        "name":"Luxembourgish, Letzeburgesch",
                        "nativeName":"Lëtzebuergesch"
                    },
                    {
                        "name":"Luganda",
                        "nativeName":"Luganda"
                    },
                    {
                        "name":"Limburgish, Limburgan, Limburger",
                        "nativeName":"Limburgs"
                    },
                    {
                        "name":"Lingala",
                        "nativeName":"Lingála"
                    },
                    {
                        "name":"Lao",
                        "nativeName":"ພາສາລາວ"
                    },
                    {
                        "name":"Lithuanian",
                        "nativeName":"lietuvių kalba"
                    },
                    {
                        "name":"Luba-Katanga",
                        "nativeName":""
                    },
                    {
                        "name":"Latvian",
                        "nativeName":"latviešu valoda"
                    },
                    {
                        "name":"Manx",
                        "nativeName":"Gaelg, Gailck"
                    },
                    {
                        "name":"Macedonian",
                        "nativeName":"македонски јазик"
                    },
                    {
                        "name":"Malagasy",
                        "nativeName":"Malagasy fiteny"
                    },
                    {
                        "name":"Malay",
                        "nativeName":"bahasa Melayu, بهاس ملايو‎"
                    },
                    {
                        "name":"Malayalam",
                        "nativeName":"മലയാളം"
                    },
                    {
                        "name":"Maltese",
                        "nativeName":"Malti"
                    },
                    {
                        "name":"Māori",
                        "nativeName":"te reo Māori"
                    },
                    {
                        "name":"Marathi (Marāṭhī)",
                        "nativeName":"मराठी"
                    },
                    {
                        "name":"Marshallese",
                        "nativeName":"Kajin M̧ajeļ"
                    },
                    {
                        "name":"Mongolian",
                        "nativeName":"монгол"
                    },
                    {
                        "name":"Nauru",
                        "nativeName":"Ekakairũ Naoero"
                    },
                    {
                        "name":"Navajo, Navaho",
                        "nativeName":"Diné bizaad, Dinékʼehǰí"
                    },
                    {
                        "name":"Norwegian Bokmål",
                        "nativeName":"Norsk bokmål"
                    },
                    {
                        "name":"North Ndebele",
                        "nativeName":"isiNdebele"
                    },
                    {
                        "name":"Nepali",
                        "nativeName":"नेपाली"
                    },
                    {
                        "name":"Ndonga",
                        "nativeName":"Owambo"
                    },
                    {
                        "name":"Norwegian Nynorsk",
                        "nativeName":"Norsk nynorsk"
                    },
                    {
                        "name":"Norwegian",
                        "nativeName":"Norsk"
                    },
                    {
                        "name":"Nuosu",
                        "nativeName":"ꆈꌠ꒿ Nuosuhxop"
                    },
                    {
                        "name":"South Ndebele",
                        "nativeName":"isiNdebele"
                    },
                    {
                        "name":"Occitan",
                        "nativeName":"Occitan"
                    },
                    {
                        "name":"Ojibwe, Ojibwa",
                        "nativeName":"ᐊᓂᔑᓈᐯᒧᐎᓐ"
                    },
                    {
                        "name":"Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic",
                        "nativeName":"ѩзыкъ словѣньскъ"
                    },
                    {
                        "name":"Oromo",
                        "nativeName":"Afaan Oromoo"
                    },
                    {
                        "name":"Oriya",
                        "nativeName":"ଓଡ଼ିଆ"
                    },
                    {
                        "name":"Ossetian, Ossetic",
                        "nativeName":"ирон æвзаг"
                    },
                    {
                        "name":"Panjabi, Punjabi",
                        "nativeName":"ਪੰਜਾਬੀ, پنجابی‎"
                    },
                    {
                        "name":"Pāli",
                        "nativeName":"पाऴि"
                    },
                    {
                        "name":"Persian",
                        "nativeName":"فارسی"
                    },
                    {
                        "name":"Polish",
                        "nativeName":"polski"
                    },
                    {
                        "name":"Pashto, Pushto",
                        "nativeName":"پښتو"
                    },
                    {
                        "name":"Portuguese",
                        "nativeName":"Português"
                    },
                    {
                        "name":"Quechua",
                        "nativeName":"Runa Simi, Kichwa"
                    },
                    {
                        "name":"Romansh",
                        "nativeName":"rumantsch grischun"
                    },
                    {
                        "name":"Kirundi",
                        "nativeName":"kiRundi"
                    },
                    {
                        "name":"Romanian, Moldavian, Moldovan",
                        "nativeName":"română"
                    },
                    {
                        "name":"Russian",
                        "nativeName":"русский язык"
                    },
                    {
                        "name":"Sanskrit (Saṁskṛta)",
                        "nativeName":"संस्कृतम्"
                    },
                    {
                        "name":"Sardinian",
                        "nativeName":"sardu"
                    },
                    {
                        "name":"Sindhi",
                        "nativeName":"सिन्धी, سنڌي، سندھی‎"
                    },
                    {
                        "name":"Northern Sami",
                        "nativeName":"Davvisámegiella"
                    },
                    {
                        "name":"Samoan",
                        "nativeName":"gagana faa Samoa"
                    },
                    {
                        "name":"Sango",
                        "nativeName":"yângâ tî sängö"
                    },
                    {
                        "name":"Serbian",
                        "nativeName":"српски језик"
                    },
                    {
                        "name":"Scottish Gaelic; Gaelic",
                        "nativeName":"Gàidhlig"
                    },
                    {
                        "name":"Shona",
                        "nativeName":"chiShona"
                    },
                    {
                        "name":"Sinhala, Sinhalese",
                        "nativeName":"සිංහල"
                    },
                    {
                        "name":"Slovak",
                        "nativeName":"slovenčina"
                    },
                    {
                        "name":"Slovene",
                        "nativeName":"slovenščina"
                    },
                    {
                        "name":"Somali",
                        "nativeName":"Soomaaliga, af Soomaali"
                    },
                    {
                        "name":"Southern Sotho",
                        "nativeName":"Sesotho"
                    },
                    {
                        "name":"Spanish; Castilian",
                        "nativeName":"español, castellano"
                    },
                    {
                        "name":"Sundanese",
                        "nativeName":"Basa Sunda"
                    },
                    {
                        "name":"Swahili",
                        "nativeName":"Kiswahili"
                    },
                    {
                        "name":"Swati",
                        "nativeName":"SiSwati"
                    },
                    {
                        "name":"Swedish",
                        "nativeName":"svenska"
                    },
                    {
                        "name":"Tamil",
                        "nativeName":"தமிழ்"
                    },
                    {
                        "name":"Telugu",
                        "nativeName":"తెలుగు"
                    },
                    {
                        "name":"Tajik",
                        "nativeName":"тоҷикӣ, toğikī, تاجیکی‎"
                    },
                    {
                        "name":"Thai",
                        "nativeName":"ไทย"
                    },
                    {
                        "name":"Tigrinya",
                        "nativeName":"ትግርኛ"
                    },
                    {
                        "name":"Tibetan Standard, Tibetan, Central",
                        "nativeName":"བོད་ཡིག"
                    },
                    {
                        "name":"Turkmen",
                        "nativeName":"Türkmen, Түркмен"
                    },
                    {
                        "name":"Tagalog",
                        "nativeName":"Wikang Tagalog, ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔"
                    },
                    {
                        "name":"Tswana",
                        "nativeName":"Setswana"
                    },
                    {
                        "name":"Tonga (Tonga Islands)",
                        "nativeName":"faka Tonga"
                    },
                    {
                        "name":"Turkish",
                        "nativeName":"Türkçe"
                    },
                    {
                        "name":"Tsonga",
                        "nativeName":"Xitsonga"
                    },
                    {
                        "name":"Tatar",
                        "nativeName":"татарча, tatarça, تاتارچا‎"
                    },
                    {
                        "name":"Twi",
                        "nativeName":"Twi"
                    },
                    {
                        "name":"Tahitian",
                        "nativeName":"Reo Tahiti"
                    },
                    {
                        "name":"Uighur, Uyghur",
                        "nativeName":"Uyƣurqə, ئۇيغۇرچە‎"
                    },
                    {
                        "name":"Ukrainian",
                        "nativeName":"українська"
                    },
                    {
                        "name":"Urdu",
                        "nativeName":"اردو"
                    },
                    {
                        "name":"Uzbek",
                        "nativeName":"zbek, Ўзбек, أۇزبېك‎"
                    },
                    {
                        "name":"Venda",
                        "nativeName":"Tshivenḓa"
                    },
                    {
                        "name":"Vietnamese",
                        "nativeName":"Tiếng Việt"
                    },
                    {
                        "name":"Volapük",
                        "nativeName":"Volapük"
                    },
                    {
                        "name":"Walloon",
                        "nativeName":"Walon"
                    },
                    {
                        "name":"Welsh",
                        "nativeName":"Cymraeg"
                    },
                    {
                        "name":"Wolof",
                        "nativeName":"Wollof"
                    },
                    {
                        "name":"Western Frisian",
                        "nativeName":"Frysk"
                    },
                    {
                        "name":"Xhosa",
                        "nativeName":"isiXhosa"
                    },
                    {
                        "name":"Yiddish",
                        "nativeName":"ייִדיש"
                    },
                    {
                        "name":"Yoruba",
                        "nativeName":"Yorùbá"
                    },
                    {
                        "name":"Zhuang, Chuang",
                        "nativeName":"Saɯ cueŋƅ, Saw cuengh"
                    }
                ],
            },
            methods:{
                saveSkill(){
                    const self = this;
                    if(self.skill.skill != null && self.skill.level != null){
                        axios.post('/api/skill/add', {
                            contact_id: self.contact_id,
                            skill: self.skill.skill,
                            level: self.skill.level
                        }).then(function (response) {
                            self.getSkills();
                        }).catch(function (error) {
                            console.log(error);
                        });
                    }else{
                        if(self.skill.skill == null){
                            self.skill_error = 1;
                        }else{
                            self.level_error = 1;
                            self.skill_error = 0;
                        }
                      //  alert('Please add skill and level');
                    }

                },
                deleteSkill(id){
                    const self = this;
                    axios.post('/api/skill/delete', {
                        contact_id: self.contact_id,
                        skill_id: id,
                    }).then(function (response) {
                        self.skills = response.data;
                    }).catch(function (error) {
                        console.log(error);
                    });
                },
                getSkills(){
                    const self = this;
                    axios.post('/api/skills', {
                            contact_id: self.contact_id,
                        }).then(function (response) {
                            self.skills = response.data;
                            self.skill = {
                                id:null,
                                skill:null,
                                level:null,
                            };
                        }).catch(function (error) {
                            console.log(error);
                        });
                },
                savePosition(){
                    const self = this;
                    axios.post('/api/position/add', {
                        contact_id: self.contact_id,
                        position: self.position.position,
                        company: self.position.company,
                        description: self.position.description,
                        from_year: self.position.from_year,
                        to_year: self.position.to_year,
                    }).then(function (response) {
                        self.getPositions();
                    }).catch(function (error) {
                        console.log(error);
                    });
                },
                deletePosition(id){
                    const self = this;
                    axios.post('/api/position/delete', {
                        contact_id: self.contact_id,
                        position_id: id,
                    }).then(function (response) {
                        self.positions = response.data;
                    }).catch(function (error) {
                        console.log(error);
                    });
                },
                getPositions(){
                    const self = this;
                    axios.post('/api/positions', {
                            contact_id: self.contact_id,
                        }).then(function (response) {
                            self.positions = response.data;
                            self.position = {
                                id:null,
                                position:null,
                                description:null,
                                company:null,
                                from_year:null,
                                to_year:null,
                            };
                        }).catch(function (error) {
                            console.log(error);
                        });
                },
                saveEdu(){
                    const self = this;
                    axios.post('/api/degree/add', {
                        contact_id: self.contact_id,
                        degree: self.degree.degree,
                        institution: self.degree.institution,
                        year: self.degree.year,
                    }).then(function (response) {
                        self.getEdus();
                    }).catch(function (error) {
                        console.log(error);
                    });
                },
                deleteEdu(id){
                    const self = this;
                    axios.post('/api/degree/delete', {
                        contact_id: self.contact_id,
                        degree_id: id,
                    }).then(function (response) {
                        self.degrees = response.data;
                    }).catch(function (error) {
                        console.log(error);
                    });
                },
                getEdus(){
                    const self = this;
                    axios.post('/api/degrees', {
                            contact_id: self.contact_id,
                        }).then(function (response) {
                            self.degrees = response.data;
                            self.degree = {
                                id:null,
                                degree:null,
                                institution:null,
                                year:null,
                            };
                        }).catch(function (error) {
                            console.log(error);
                        });
                },
                saveLang(){
                    const self = this;
                    axios.post('/api/language/add', {
                        contact_id: self.contact_id,
                        language: self.language.language,
                        level: self.language.level,
                    }).then(function (response) {
                        self.getLangs();
                    }).catch(function (error) {
                        console.log(error);
                    });
                },
                deleteLang(id){
                    const self = this;
                    axios.post('/api/language/delete', {
                        contact_id: self.contact_id,
                        language_id: id,
                    }).then(function (response) {
                        self.languages = response.data;
                    }).catch(function (error) {
                        console.log(error);
                    });
                },
                getLangs(){
                    const self = this;
                    axios.post('/api/languages', {
                            contact_id: self.contact_id,
                        }).then(function (response) {
                            self.languages = response.data;
                            self.language = {
                                id:null,
                                language:null,
                                level:null,
                            };
                        }).catch(function (error) {
                            console.log(error);
                        });
                },
                saveNation(){
                    const self = this;
                    axios.post('/api/nationality/add', {
                        contact_id: self.contact_id,
                        nationality: self.nation.nationality,
                        permission_to_work: self.nation.permission_to_work,
                    }).then(function (response) {
                        self.getNations();
                    }).catch(function (error) {
                        console.log(error);
                    });
                },
                deleteNation(id){
                    const self = this;
                    axios.post('/api/nationality/delete', {
                        contact_id: self.contact_id,
                        nation_id: id,
                    }).then(function (response) {
                        self.nationalities = response.data;
                    }).catch(function (error) {
                        console.log(error);
                    });
                },
                getNations(){
                    const self = this;
                    axios.post('/api/nationalities', {
                            contact_id: self.contact_id,
                        }).then(function (response) {
                            self.nationalities = response.data;
                            self.nation = {
                                id:null,
                                nationality:null,
                                permission_to_work:null,
                            };
                        }).catch(function (error) {
                            console.log(error);
                        });
                },
                getAllSkills(){
                    const self = this;
                    axios.post('/api/skills/all').then(function (response) {
                        self.skills_list = response.data;
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            },
            created(){
                this.getSkills();
                this.getPositions();
                this.getEdus();
                this.getAllSkills();
                this.getLangs();
                this.getNations();
            }
        })
    </script>
@endsection
