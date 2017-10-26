<!DOCTYPE html>
<html>
<head>
    <title>{!! Theme::get('title') !!}</title>
    <link rel="icon" href="../images/mcoat-logo.png.png" type="image/png"/>
    <meta charset="utf-8">
    <meta name="keywords" content="{!! Theme::get('keywords') !!}">
    <meta name="description" content="{!! Theme::get('description') !!}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    {!! Theme::asset()->styles() !!}
    {!! Theme::asset()->scripts() !!}

   <style>
       a.button-collapse.top-nav.full.hide-on-large-only {
           position: fixed;
           z-index: 999;
           left: 20px;
           top: 15px;
           color: white;
           float:none;
       }
        a.page-title {
            padding-left: 30px;
            line-height: 4.4;
        }
       .brand-logo img{
           height: 30px;
       }
       .user-view span{
           color: black;
           font-weight: 700;
       }
       span.logout {
           position: relative;
           top: -7px;
           padding-left: 10px;
           color: #4a89be;
       }
       .background{
           background: url('../../images/mcoat-bg.jpg');
       }
    </style>
</head>

<body>
<input type="hidden" id="baseURL" value="{{ url('') }}" >
<div class="navbar-fixed">
    <a href="#" data-activates="slide-out" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
    <nav>
        <div class="nav-wrapper">
            <a href="#!" class="brand-logo"><img src="../images/mcoat-png.png"> </a>
            <ul class="right hide-on-med-and-down">
                <li><a href="sass.html">Sass</a></li>
                <li><a href="badges.html">Components</a></li>
            </ul>
        </div>
    </nav>
</div>
<ul id="slide-out" class="side-nav">
    <li><div class="user-view">
            <div class="background">
                <img src="">
            </div>
            <a><img class="circle" src="images/yuna.jpg"></a>
            <a><span class="name">{{ \Illuminate\Support\Facades\Auth::user()->first_name.' '.\Illuminate\Support\Facades\Auth::user()->last_name }}</span></a>
            <a><span class="email">{{ \Illuminate\Support\Facades\Auth::user()->email }}</span></a>
            <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="material-icons">exit_to_app</i><span class="logout">Logout</span></a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div></li>
    @if(\Illuminate\Support\Facades\Auth::user()->user_type == 1)
        <li><a class="waves-effect" href="{{ url('dashboard') }}"><i class="material-icons">dashboard</i>Dashboard</a></li>
        <li><div class="divider"></div></li>
        <li><a class="subheader"><i class="material-icons">format_list_bulleted</i>Products</a></li>
        <li><a class="waves-effect" href="{{ URL('admin/mcoat')  }}"><i class="material-icons"></i>Mcoat</a></li>
        <li><a class="waves-effect" href="{{ URL('admin/allied')  }}"><i class="material-icons"></i>Allied</a></li>
        <li><div class="divider"></div></li>
        <li><a class="subheader"><i class="material-icons">format_list_bulleted</i>Manage Products</a></li>
        <li><a class="waves-effect" href=""><i class="material-icons"></i>Mcoat</a></li>
        <li><a class="waves-effect" href=""><i class="material-icons"></i>Allied</a></li>
        <li><div class="divider"></div></li>
        <li><a class="subheader"><i class="material-icons">arrow_upward</i>Product out</a></li>
        <li><a class="waves-effect" href=""><i class="material-icons"></i>Mcoat</a></li>
        <li><a class="waves-effect" href=""><i class="material-icons"></i>Allied</a></li>
        <li><div class="divider"></div></li>
        <li><a class="subheader"><i class="material-icons">arrow_downward</i>Product in</a></li>
        <li><a class="waves-effect" href=""><i class="material-icons"></i>Mcoat</a></li>
        <li><a class="waves-effect" href=""><i class="material-icons"></i>Allied</a></li>
        <li><div class="divider"></div></li>
        <li><a class="waves-effect" href=""><i class="material-icons">receipt</i>Receipts</a></li>
        <li><a class="waves-effect" href=""><i class="material-icons">receipt</i>Product in receipts</a></li>
        <li><a class="waves-effect" href=""><i class="material-icons">person_pin</i>Branches</a></li>
        <li><a class="waves-effect" href=""><i class="material-icons">group</i>Suppliers</a></li>
        <li><a class="waves-effect" href=""><i class="material-icons">person</i>Users</a></li>
        <li><a class="waves-effect" href=""><i class="material-icons">group</i>Employees</a></li>
    @elseif(\Illuminate\Support\Facades\Auth::user()->user_type == 2)

    @elseif(\Illuminate\Support\Facades\Auth::user()->user_type == 3)
        <li><a class="waves-effect" href="{{ url('dashboard') }}"><i class="material-icons">dashboard</i>Dashboard</a></li>
        <li><a class="waves-effect" href="{{ url('user/products') }}"><i class="material-icons">format_list_bulleted</i>Products</a></li>
        <li><a class="waves-effect" href="{{ url('user/employees/'.\Illuminate\Support\Facades\Auth::user()->user_id) }}"><i class="material-icons">person</i>Bio-data</a></li>
    @endif

    {{--<li><div class="divider"></div></li>--}}

</ul>

<div class="container">
   {!! Theme::content() !!}

</div>


</body>
<script>
    $(document).ready(function () {
        // Initialize collapse button
        $(".button-collapse").sideNav({
            menuWidth: 300, // Default is 300
            // Choose the horizontal origin
            closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
            draggable: true, // Choose whether you can drag to open on touch screens,

        });
        // Initialize collapsible (uncomment the line below if you use the dropdown variation)
        //$('.collapsible').collapsible();
    })

</script>
</html>
