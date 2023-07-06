<div class="main-menu material-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Admin'))
            <li class="nav-item {{ Route::is('common.dashboard') ? 'open' : '' }}">
                <a href="{{ route('common.dashboard') }}"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
            </li>
            @elseif(Auth::user()->hasRole('HR'))
            <li class="nav-item {{ Route::is('common.dashboard') ? 'open' : '' }}">
                <a href="{{ route('common.dashboard') }}"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
            </li>
            @elseif(Auth::user()->hasRole('Vendor'))
            <li class="nav-item {{ Route::is('common.dashboard') ? 'open' : '' }}">
                <a href="{{ route('common.dashboard') }}"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
            </li>
            @elseif(Auth::user()->hasRole('HR Manager'))
            <li class="nav-item {{ Route::is('common.dashboard') ? 'open' : '' }}">
                <a href="{{ route('common.dashboard') }}"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
            </li>
            @endif
            @can('configuration_access')
            <li class="nav-item {{ Route::is('admin.department.*') || Route::is('admin.designation.*') || Route::is('admin.job_type.*') || Route::is('admin.locations.*') || Route::is('admin.educational_level.*') ? 'open' : '' }}">
                <a href="#"><i class="material-icons">settings</i><span class="menu-title">Cofiguration</span></a>
                <ul class="menu-content">
                    @can('department_access')
                    <li class="nav-item {{ Route::is('admin.department.*') ? 'selected' : '' }}">
                        <a href="{{ route('admin.department.index') }}"><i class="material-icons inside-icons">business</i><span class="menu-title">Department</span></a>
                    </li>
                    @endcan
                    @can('designation_access')
                    <li class="nav-item {{ Route::is('admin.designation.*') ? 'selected' : '' }}">
                        <a href="{{ route('admin.designation.index') }}"><i class="material-icons inside-icons">school</i><span class="menu-title">Designation</span></a>
                    </li>
                    @endcan
                    @can('job_type_access')
                    <li class="nav-item {{ Route::is('admin.job_type.*') ? 'selected' : '' }}">
                        <a href="{{ route('admin.job_type.index') }}"><i class="material-icons inside-icons">event_note</i><span class="menu-title">Job Type</span></a>
                    </li>
                    @endcan
                    @can('location_access')
                    <li class="nav-item {{ Route::is('admin.locations.*') ? 'selected' : '' }}">
                        <a href="{{ route('admin.locations.index') }}"><i class="material-icons inside-icons">location_on</i><span class="menu-title">Location</span></a>
                    </li>
                    <li class="nav-item {{ Route::is('admin.educational_level.*') ? 'selected' : '' }}">
                        <a href="{{ route('admin.educational_level.index') }}"><i class="material-icons inside-icons" style="width:23px">cast_for_education</i><span class="menu-title">Educational Level</span></a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('job_access')
            <li class="nav-item {{ Route::is('common.jobs.*') ? 'open' : '' }}">
                <a href="{{ route('common.jobs.index') }}"><i class="material-icons">card_travel</i><span class="menu-title">{{ trans('global.job.title') }}</span></a>
            </li>
            @endcan
            @can('job_unapproved')
            <li class=" nav-item {{ Route::is('common.unapproved_jobs') ? 'open' : '' }}">
                <a href="{{ route('common.unapproved_jobs') }}">
                    <i class="material-icons inside-icons">visibility_off</i>
                    <span class="menu-title">Unapproved Jobs</span>
                </a>
            </li>
            @endcan
            @can('job_approved')
            <li class="nav-item {{ Route::is('common.approved_jobs') ? 'open' : '' }}">
                <a href="{{ route('common.approved_jobs') }}">
                    <i class="material-icons inside-icons">visibility</i>
                    <span class="menu-title">Approved Jobs</span>
                </a>
            </li>
            @endcan
            @can('hr_manager_access')
            <li class="nav-item {{ Route::is('admin.hr_manager.*') ? 'open' : '' }}">
                <a href="{{ route('admin.hr_manager.index') }}">
                    <i class="material-icons"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" fill="white" width="18px" height="18px"><g><rect fill="none" height="24" width="24"/></g><g><path d="M4,7h16v2H4V7z M4,13h16v-2H4V13z M4,17h7v-2H4V17z M4,21h7v-2H4V21z M15.41,18.17L14,16.75l-1.41,1.41L15.41,21L20,16.42 L18.58,15L15.41,18.17z M4,3v2h16V3H4z"/></g></svg></i>
                    <span class="menu-title">HR Manager</span>
                </a>
            </li>
            @endcan
            @can('vendor_access')
            <li class=" nav-item {{ Route::is('admin.vendor.*') ? 'open' : '' }}">
                <a href="{{ route('admin.vendor.index') }}"><i class="material-icons">supervisor_account</i><span class="menu-title">Man-power Agency</span></a>
            </li>
            @endcan
            @can('hr_access')
            <li class=" nav-item {{ Route::is('admin.hr.*') ? 'open' : '' }}">
                <a href="{{ route('admin.hr.index') }}"><i class="material-icons">assignment_turned_in</i><span class="menu-title">HR</span></a>
            </li>
            @endcan
            <!-- Add by shubham -->
            @can('kfupm_user_access')
            {{-- <li class=" nav-item {{ Route::is('admin.kfupm_user.*') ? 'open' : '' }}">
                <a href="{{ route('admin.kfupm_user.index') }}"><i class="material-icons">assignment_turned_in</i><span class="menu-title">KFUPM</span></a>
            </li> --}}
            @endcan
            <!-- End -->
            @can('candidate_access')
         
            <li class="nav-item {{ Route::is('common.candidate.*') ? 'open' : '' }}">
                <a href="{{ route('common.candidate.index') }}"><i class="material-icons inside-icons">person_outline</i><span class="menu-title">Candidate</span></a>
            </li>

            @endcan
            @can('user_management_access')
            <li class="nav-item {{ Route::is('superadmin.permissions.*') || Route::is('superadmin.roles.*') ? 'open' : '' }}">
                <a href="#"><i class="material-icons">playlist_add</i><span class="menu-title inside-icons">User Access</span></a>
                <ul class="menu-content">
                    @can('permission_access')
                    <li class="nav-item {{ Route::is('superadmin.permissions.*') ? 'selected' : '' }}">
                        <a href="{{ route('superadmin.permissions.index') }}"><i class="material-icons inside-icons">https</i><span class="menu-title">{{ trans('global.permission.title') }}</span></a>
                    </li>
                    @endcan
                    @can('role_access')
                    <li class="nav-item {{ Route::is('superadmin.roles.*') ? 'selected' : '' }}">
                        <a href="{{ route('superadmin.roles.index') }}"><i class="material-icons inside-icons">group_work</i><span class="menu-title">{{ trans('global.role.title') }}</span></a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
        </ul>
    </div>
</div>