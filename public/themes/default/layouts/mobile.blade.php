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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
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
    </style>
</head>

<body>
<input type="hidden" id="baseURL" value="{{ url('') }}" >
<div class="navbar-fixed">
    <a href="#" data-activates="slide-out" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
    <nav>
        <div class="nav-wrapper">
            <a href="#!" class="brand-logo"><img src="images/mcoat-png.png"> </a>
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
                <img src="images/office.jpg">
            </div>
            <a href="#!user"><img class="circle" src="images/yuna.jpg"></a>
            <a href="#!name"><span class="white-text name">John Doe</span></a>
            <a href="#!email"><span class="white-text email">jdandturk@gmail.com</span></a>
        </div></li>
    <li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li>
    <li><a href="#!">Second Link</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">Subheader</a></li>
    <li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
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
