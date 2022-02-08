<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="html/ltr/vertical-menu-template/index.html">
                        <div class="">&nbsp;&nbsp;</div>
                        <h2 class="brand-text mb-0"> {{ Auth::User()->first_name }}</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                {{--  <li class=" nav-item"><a href="index.html"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span><span class="badge badge badge-warning badge-pill float-right mr-2">2</span></a>
                    <ul class="menu-content">
                        <li class="active"><a href="dashboard-analytics.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Analytics">Analytics</span></a>
                        </li>
                        <li><a href="dashboard-ecommerce.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="eCommerce">eCommerce</span></a>
                        </li>
                    </ul>
                </li>  --}}
                  {{--  <li class=" navigation-header"><span>Apps</span>  --}}
                </li>
                {{--  <li class={{ Request::is('dashboard')? 'active' : '' }} ><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
                </li>

            <li class={{ Request::is('admin/profile')? 'active' : '' }} ><a href="{{ route('admin.profile') }}"><i class="feather icon-user"></i><span class="menu-title" data-i18n="profile">Admin profile</span></a>
                </li>
                  <li class={{ Request::is('company')? 'active' : '' }} ><a href="{{ route('company') }}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Company">Company</span></a>
                </li>  --}}


                <li class={{ Request::is('admin/dashboard')? 'active' : '' }}><a href="{{route('admin.dashboard')}}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="services">Dashboard</span></a>  </li>

                <li class={{ Request::is('admin/employees')? 'active' : '' }}>
                    <a href="{{route('admin.employees')}}">
                        <i class="feather icon-user"></i>
                        <span class="menu-title" data-i18n="services">Employees</span>
                    </a>
                  </li>
                  <li class={{ Request::is('admin/department')? 'active' : '' }}>
                    <a href="{{route('admin.department')}}">
                        <i class="feather icon-list"></i>
                        <span class="menu-title" data-i18n="services">Department</span>
                    </a>
                  </li>
                  <li class={{ Request::is('admin/attendance_history')? 'active' : '' }}>
                    <a href="{{route('admin.attendance_history')}}">
                        <i class="feather icon-clock"></i>
                        <span class="menu-title" data-i18n="services">Attendance History</span>
                    </a>
                  </li>
                  <li class={{ Request::is('admin/notices')? 'active' : '' }}>
                    <a href="{{url('admin/notices')}}">
                        <i class="feather icon-list"></i>
                        <span class="menu-title" data-i18n="services">Notices</span>
                    </a>
                </li>
                  <li class={{ Request::is('admin/payroll')? 'active' : '' }}>
                    <a href="{{url('admin/payroll')}}">
                        <i class="feather icon-list"></i>
                        <span class="menu-title" data-i18n="services">Payroll</span>
                    </a>
                  </li>
                  <li class={{ Request::is('admin/payroll_start')? 'active' : '' }}>
                    <a href="{{url('admin/payroll_start')}}">
                        <i class="feather icon-list"></i>
                        <span class="menu-title" data-i18n="services">Payroll Start Date</span>
                    </a>
                  </li>
                  <li class=" nav-item"><a href="#"><i class="feather icon-layout"></i><span class="menu-title" data-i18n="Content">Leaves</span></a>
                    <ul class="menu-content">
                        <li><a href="{{url('admin/sick-leave')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Grid">Sick Leave</span></a>
                        </li>
                        <li><a href="{{url('admin/vacation-leave')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Grid">Vacation  Leave</span></a>
                        </li>
                        <li><a href="{{ url('admin/holidays') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Grid">Holidays</span></a>
                        </li>
                       
                    </ul>
                </li>
                  <li class={{ Request::is('admin/threshold')? 'active' : '' }}>
                    <a href="{{url('admin/threshold')}}">
                        <i class="feather icon-list"></i>
                        <span class="menu-title" data-i18n="services">Threshold</span>
                    </a>
                  </li>

                   <li class={{ Request::is('admin/deduction')? 'active' : '' }}>
                    <a href="{{route('deduction')}}">
                        <i class="feather icon-list"></i>
                        <span class="menu-title" data-i18n="services">Deduction</span>
                    </a>
                  </li>
                  <li class={{ Request::is('admin/bonus')? 'active' : '' }}>
                    <a href="{{route('bonus')}}">
                        <i class="feather icon-list"></i>
                        <span class="menu-title" data-i18n="services">Add Bonus</span>
                    </a>
                  </li>
                  <li class={{ Request::is('admin/viewbonus')? 'active' : '' }}>
                    <a href="{{route('viewbonus')}}">
                        <i class="feather icon-list"></i>
                        <span class="menu-title" data-i18n="services">Bonus</span>
                    </a>
                  </li>
                  <li class={{ Request::is('admin/processedPayroll')? 'active' : '' }}>
                        <a href="{{route('processedPayroll')}}">
                            <i class="feather icon-list"></i>
                            <span class="menu-title" data-i18n="services">Process Payroll</span>
                        </a>
                    </li>
                    <li class={{ Request::is('admin/equipmentManagment')? 'active' : '' }}>
                        <a href="{{route('eqManagment')}}">
                            <i class="feather icon-list"></i>
                            <span class="menu-title" data-i18n="services">Equipment Managment</span>
                        </a>
                    </li>
            </ul>
        </div>
    </div>
