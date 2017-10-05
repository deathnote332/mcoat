
<style>
    .user-name{
        text-transform: capitalize;
    }
</style>
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">MCOAT PAINT COMMERCIAL AND GENERAL MERCHANDISE</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">

            {{--<!-- /.dropdown -->--}}
            {{--<li class="dropdown">--}}
                {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
                    {{--<i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu dropdown-alerts">--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<i class="fa fa-comment fa-fw"></i> New Comment--}}
                                {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<i class="fa fa-twitter fa-fw"></i> 3 New Followers--}}
                                {{--<span class="pull-right text-muted small">12 minutes ago</span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<i class="fa fa-envelope fa-fw"></i> Message Sent--}}
                                {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<i class="fa fa-tasks fa-fw"></i> New Task--}}
                                {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<i class="fa fa-upload fa-fw"></i> Server Rebooted--}}
                                {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a class="text-center" href="#">--}}
                            {{--<strong>See All Alerts</strong>--}}
                            {{--<i class="fa fa-angle-right"></i>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<!-- /.dropdown-alerts -->--}}
            {{--</li>--}}
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <span class="user-name">{{ \Illuminate\Support\Facades\Auth::user()->first_name.' '.\Illuminate\Support\Facades\Auth::user()->last_name }}</span> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{ url('/logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out fa-fw"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    {{--<li class="sidebar-search">--}}
                        {{--<div class="input-group custom-search-form">--}}
                            {{--<input type="text" class="form-control" placeholder="Search...">--}}
                            {{--<span class="input-group-btn">--}}
                                    {{--<button class="btn btn-default" type="button">--}}
                                        {{--<i class="fa fa-search"></i>--}}
                                    {{--</button>--}}
                                {{--</span>--}}
                        {{--</div>--}}
                        {{--<!-- /input-group -->--}}
                    {{--</li>--}}
                    @if(\Illuminate\Support\Facades\Auth::user()->user_type == 1)
                    <li>
                        <a href={{ URL('dashboard')  }}><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-list fa-fw"></i> Products<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href={{ URL('mcoat')  }}>MCOAT STOCKS</a>
                            </li>
                            <li>
                                <a href={{ URL('allied')  }}>ALLIED STOCKS</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-list fa-fw"></i> Manage Products<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a  href={{ URL('manageProduct')  }}>MCOAT STOCKS</a>
                            </li>
                            <li>
                                <a href={{ URL('alliedmanageproduct')  }}>ALLIED STOCKS</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-files-o fa-fw"></i> Product out<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href={{ URL('productout')  }}>MCOAT Product out</a>
                            </li>
                            <li>
                                <a href={{ URL('alliedproductout')  }}>ALLIED Product out</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-file-text-o fa-fw"></i> Product in<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href={{ URL('productin')  }}>MCOAT Product in</a>
                            </li>
                            <li>
                                <a href={{ URL('alliedproductin')  }}>ALLIED Product in</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>

                    <li>
                        <a href={{ URL('receipts')  }}><i class="fa fa-files-o fa-fw"></i> Receipts</a>
                    </li>

                    <li>
                        <a href={{ URL('receiptin')  }}><i class="fa fa-file-text-o fa-fw"></i> Product in receipt</a>
                    </li>
                    <li>
                        <a href={{ URL('stocksreport')  }}><i class="fa fa-list fa-fw"></i> Stocks Report</a>
                    </li>
                    <li>
                        <a href={{ URL('branches')  }}><i class="fa fa-user fa-fw"></i> Branches</a>
                    </li>
                    <li>
                        <a href={{ URL('suppliers')  }}><i class="fa fa-user fa-fw"></i> Suppliers</a>
                    </li>
                    <li>
                        <a href={{ URL('users')  }}><i class="fa fa-user fa-fw"></i> Users</a>
                    </li>
                    @else
                        <li>
                            <a href={{ URL('dashboard')  }}><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        @if(\Illuminate\Support\Facades\Auth::user()->warehouse == 1)
                            <li>
                                <a href={{ URL('mcoat')  }}><i class="fa fa-list fa-fw"></i> Mcoat Stocks</a>
                            </li>
                        @else
                            <li>
                                <a href={{ URL('allied')  }}><i class="fa fa-list fa-fw"></i> Allied Stocks</a>
                            </li>
                        @endif

                        @if(\Illuminate\Support\Facades\Auth::user()->warehouse == 1)
                            <li>
                                <a href={{ URL('manageProduct')  }}><i class="fa fa-list fa-fw"></i> Manage product</a>
                            </li>
                        @else
                            <li>
                                <a href={{ URL('alliedmanageproduct')  }}><i class="fa fa-list fa-fw"></i> Manage product</a>
                            </li>
                        @endif

                        @if(\Illuminate\Support\Facades\Auth::user()->warehouse == 1)
                            <li>
                                <a href={{ URL('productout')  }}><i class="fa fa-files-o fa-fw"></i> Product out</a>
                            </li>
                        @else
                            <li>
                                <a href={{ URL('alliedproductout')  }}><i class="fa fa-files-o fa-fw"></i> Product out</a>
                            </li>
                        @endif

                        @if(\Illuminate\Support\Facades\Auth::user()->warehouse == 1)
                            <li>
                                <a href={{ URL('productin')  }}><i class="fa fa-file-text-o fa-fw"></i> Product in</a>
                            </li>
                        @else
                            <li>
                                <a href={{ URL('alliedproductin')  }}><i class="fa fa-file-text-o fa-fw"></i> Product in</a>
                            </li>
                        @endif
                        <li>
                            <a href={{ URL('receipts')  }}><i class="fa fa-files-o fa-fw"></i> Receipts</a>
                        </li>

                        <li>
                            <a href={{ URL('receiptin')  }}><i class="fa fa-file-text-o fa-fw"></i> Product in receipt</a>
                        </li>
                        <li>
                            <a href={{ URL('stocksreport')  }}><i class="fa fa-list fa-fw"></i> Stocks Report</a>
                        </li>
                        <li>
                            <a href={{ URL('branches')  }}><i class="fa fa-user fa-fw"></i> Branches</a>
                        </li>
                        <li>
                            <a href={{ URL('suppliers')  }}><i class="fa fa-user fa-fw"></i> Suppliers</a>
                        </li>

                    @endif
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    {!! Theme::content() !!}
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
