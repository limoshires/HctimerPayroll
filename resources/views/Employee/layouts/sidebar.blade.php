<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="#">
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
            {{-- </li> --}}
            {{--  <li class={{ Request::is('dashboard')? 'active' : '' }} ><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
            </li>

        <li class={{ Request::is('admin/profile')? 'active' : '' }} ><a href="{{ route('admin.profile') }}"><i class="feather icon-user"></i><span class="menu-title" data-i18n="profile">Admin profile</span></a>
            </li>
              <li class={{ Request::is('company')? 'active' : '' }} ><a href="{{ route('company') }}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Company">Company</span></a>
            </li>  --}}


            <li class={{ Request::is('employee/dashboard')? 'active' : '' }}>
                <a href="{{route('employee.dashboard')}}">
                    <i class="feather icon-home"></i>
                    <span class="menu-title" data-i18n="services">Dashboard</span></a>
                  </li>

            <li class={{ Request::is('employee/attendance_history')? 'active' : '' }}>
                <a href="{{route('employee.attendance_history')}}">
                    <i class="feather icon-clock"></i>
                    <span class="menu-title" data-i18n="services">Attendance History</span></a>
            </li>
            <li class={{ Request::is('employee/user_processed_payroll')? 'active' : '' }}>
                    <a href="{{route('employee.user_processed_payroll')}}">
                        <i class="feather icon-clock"></i>
                        <span class="menu-title" data-i18n="services">Processed Payroll</span></a>
            </li>


                 <li class=" nav-item"><a href="#"><i class="feather icon-layout"></i><span class="menu-title" data-i18n="Content">Holidays</span></a>
                    <ul class="menu-content">
                        <li><a href="{{url('employee/sick-leave')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Grid">Sick Leave</span></a>
                        </li>
                        <li><a href="{{url('employee/vacation-leave')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Grid">Vacation Leave</span></a>
                        </li>
                        @php 
                            use Illuminate\Support\Facades\Auth;
                            use App\Models\User;
                            $id = Auth::user()->id;
                            $user = User::find($id);
                            $gender = $user->gender;
                        @endphp
                        @if(strcmp($gender,"female")==0)
                        <li><a href="{{url('employee/maternity-leave')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Grid">Maternity Leave</span></a>
                        </li>
                        @endif
                    </ul>
                </li>
                <li class={{ Request::is('employee/notices')? 'active' : '' }}>
                    <a href="{{route('employee.notices')}}">
                    <i class="feather icon-edit"></i>
                    <span class="menu-title" data-i18n="services">Noticeboard</span></a>
                </li>
                
        </ul>
    </div>
</div>
