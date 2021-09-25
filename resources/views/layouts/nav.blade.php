<nav class="navbar navbar-fixed-top">
    <div class="container">
        <div class="navbar-brand">
            <a href="/"><img src="/assets/images/logo.png" alt="Mangosoft Logo" class="img-responsive logo"></a>
        </div>

        <div class="navbar-right">
            @if(auth()->check())
                <form id="navbar-search" method="post" action="/generalSearch" class="navbar-form search-form">
                    @csrf
                    <input value="" name="search" class="form-control" placeholder="Search here..." type="text">
                    <button type="submit" class="btn btn-default"><i class="icon-magnifier"></i></button>
                </form>
            @endif

            <div id="navbar-menu">
                @if(auth()->check())
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="{!! url("/dashboard") !!}" class="icon-menu d-none d-sm-block rightbar_btn"><i class="icon-user"></i></a>
                        </li>
                        <li>
                            <form action="{!! route("logout") !!}" method="POST">
                                @csrf
                                <a class="icon-menu d-none d-sm-none d-md-none d-lg-block">
                                    <button type="submit" style="border:none;background-color: transparent;"><i class="icon-logout"></i></button></a>
                            </form>
                           </li>
                    </ul>
                @else
                    <ul class="nav navbar-nav">
                        <li>
{{--                            <form action="{!! route("login") !!}" method="POST">--}}
{{--                                @csrf--}}
                                <a class="icon-menu d-none d-sm-none d-md-none d-lg-block" href="/login">
                                    <button type="submit" style="border:none;background-color: transparent;"><i class="icon-login"></i></button></a>
{{--                            </form>--}}
                        </li>
                    </ul>
                @endif
            </div>
        </div>

        <div class="navbar-btn">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                <i class="lnr lnr-menu fa fa-bars"></i>
            </button>
        </div>
    </div>
</nav>
