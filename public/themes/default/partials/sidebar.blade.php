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
            <a class="navbar-brand" href="{{ url('/') }}">MCOAT</a>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <span class="user-name">{{ \Illuminate\Support\Facades\Auth::user()->first_name.' '.\Illuminate\Support\Facades\Auth::user()->last_name }}</span> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href=""><i class="fa fa-cog fa-fw"></i> Account settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                    @if(\Illuminate\Support\Facades\Auth::user()->user_type == 1)
                        <li>
                            <a href={{ URL('dashboard')  }}><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-list fa-fw"></i> Products<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href={{ URL('admin/mcoat')  }}>MCOAT STOCKS</a>
                                </li>
                                <li>
                                    <a href={{ URL('admin/allied')  }}>ALLIED STOCKS</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-list fa-fw"></i> Manage Products<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a  href={{ URL('admin/manageProduct')  }}>MCOAT STOCKS</a>
                                </li>
                                <li>
                                    <a href={{ URL('admin/alliedmanageproduct')  }}>ALLIED STOCKS</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Product out<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href={{ URL('admin/productout')  }}>MCOAT Product out</a>
                                </li>
                                <li>
                                    <a href={{ URL('admin/alliedproductout')  }}>ALLIED Product out</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-file-text-o fa-fw"></i> Product in<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href={{ URL('admin/productin')  }}>MCOAT Product in</a>
                                </li>
                                <li>
                                    <a href={{ URL('admin/alliedproductin')  }}>ALLIED Product in</a>
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
                            <a href={{ URL('branches')  }}><i class="fa fa-map-marker fa-fw"></i> Branches</a>
                        </li>
                        <li>
                            <a href={{ URL('suppliers')  }}><i class="fa fa-user-plus fa-fw"></i> Suppliers</a>
                        </li>
                        <li>
                            <a href={{ URL('admin/users')  }}><i class="fa fa-user fa-fw"></i> Users</a>
                        </li>
                        <li>
                            <a href={{ URL('admin/employees')  }}><i class="fa fa-users fa-fw"></i> Employees</a>
                        </li>
                        <li>
                            <a href={{ URL('admin/reset')  }}><i class="fa fa-sort-amount-desc fa-fw"></i> Reset Quantity</a>
                        </li>
                        <li>
                            <a href={{ URL('admin/branchsales')  }}><i class="fa fa-map-marker fa-fw"></i> Branch Sales</a>
                        </li>
                        <li>
                            <a href={{ URL('admin/activity')  }}><i class="fa fa-history fa-fw"></i> Activity Logs</a>
                        </li>
                        <li>
                            <a href={{ URL('admin/activity')  }}><i class="fa fa-history fa-fw"></i> Set Price per branch</a>
                        </li>
                    @elseif(\Illuminate\Support\Facades\Auth::user()->user_type == 2)
                        <li>
                            <a href={{ URL('dashboard')  }}><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href={{ URL('semi/products')  }}><i class="fa fa-list fa-fw"></i> Products</a>
                        </li>
                        <li>
                            <a href={{ URL('semi/manage')  }}><i class="fa fa-list fa-fw"></i> Manage product</a>
                        </li>
                        <li>
                            <a href={{ URL('semi/productout')  }}><i class="fa fa-files-o fa-fw"></i> Product out</a>
                        </li>
                        <li>
                            <a href={{ URL('semi/productin')  }}><i class="fa fa-file-text-o fa-fw"></i> Product in</a>
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
                            <a href={{ URL('semi/employees').'/'.\Illuminate\Support\Facades\Auth::user()->id  }}><i class="fa fa-user fa-fw"></i> Bio-data</a>
                        </li>

                    @elseif(\Illuminate\Support\Facades\Auth::user()->user_type == 3)
                        <li>
                            <a href={{ URL('dashboard')  }}><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href={{ URL('user/products')  }}><i class="fa fa-list fa-fw"></i> Products</a>
                        </li>
                        <li>
                            <a href={{ URL('user/employees').'/'.\Illuminate\Support\Facades\Auth::user()->id  }}><i class="fa fa-user fa-fw"></i> Bio-data</a>
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
