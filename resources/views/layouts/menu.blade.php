@if(auth()->check())
<div class="main_menu">
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            @php $pathUrl = Request::path(); @endphp
            <div class="navbar-collapse align-items-center collapse" id="navbar">
                <ul class="navbar-nav">

                    <li class="nav-item @if(strpos($pathUrl,'dashboard')!==false) active @endif "><a href="{{url('/dashboard')}}" class="nav-link"><i class="icon-speedometer"></i> <span> Home</span></a></li>
                    <li class="nav-item @if(strpos($pathUrl,'contact')!==false) active @endif "><a href="{{url('/contact/list')}}" class="nav-link"><i class="icon-users"></i> <span> Contacts</span></a></li>
                    <li class="nav-item @if(strpos($pathUrl,'search')!==false) active @endif "><a href="{{url('/search')}}" class="nav-link"><i class="icon-magnifier"></i> <span> Search</span></a></li>
                    <li class="nav-item @if(strpos($pathUrl,'tasks')!==false) active @endif "><a href="{{url('/tasks')}}" class="nav-link"><i class="icon-grid"></i> <span> Tasks</span></a></li>
                    <li class="nav-item @if(strpos($pathUrl,'statuses')!==false) active @endif "><a href="{{url('/statuses')}}" class="nav-link"><i class="icon-list"></i> <span> Status</span></a></li>
                    <li class="nav-item @if(strpos($pathUrl,'users')!==false) active @endif "><a href="{!! url("/users") !!}" class="nav-link" ><i class="icon-user"></i> <span> Administrators</span></a></li>

                </ul>
            </div>

        </div>
    </nav>
</div>
@endif

