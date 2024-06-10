<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ url('/') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ url('/') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <!-- Main | Section -->
                <li class="menu-title"><span>@lang('translation.main')</span></li>

                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                        <i class="ri-dashboard-line"></i> <span>@lang('translation.dashboard')</span>
                    </a>
                </li>

                <!-- Balance -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('balance/') ? 'active' : '' }}" href="{{ url('/balance') }}">
                        <i class="ri-money-dollar-circle-line"></i> <span>@lang('translation.balance')</span>
                    </a>
                </li>

                <!-- User Management | Section -->
                @canany(['View User', 'View Role']) 
                    <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.user-management')</span></li>

                    <!-- Users -->
                    @can('View User')
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->is('user/*') ? 'active' : '' }}" href="{{ url('/user/list') }}">
                                <i class="ri-group-line"></i> <span>@lang('translation.users')</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Roles -->
                    @can('View Role')
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->is('role/*') ? 'active' : '' }}" href="{{ url('/role/list') }}">
                                <i class="ri-tools-line"></i> <span>@lang('translation.roles')</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Admin Structure -->
                    @can('View AdminStructure')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ request()->is('admin/structure/*') ? 'active' : '' }}" href="{{ url('/admin/structure') }}">
                            <i class="ri-group-fill"></i> <span>@lang('translation.admin-structure')</span>
                        </a>
                    </li>
                    @endcan
                @endcanany



                <!-- Marketing -->
                @canany(['View Templates']) 
                    <li class="menu-title"><i class="ri-mail-open-line"></i> <span>@lang('translation.marketing')</span></li>

                    <!-- Templates -->
                    @can('View Templates')
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->is('marketing/templates/*') ? 'active' : '' }}" href="{{ url('/marketing/templates/list') }}">
                                <i class="ri-mail-open-line"></i> <span>@lang('translation.templates')</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Bell Notifications -->
                    @can('View BellNotifications')
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->is('marketing/bell-notifications/*') ? 'active' : '' }}" href="{{ url('/marketing/bell-notifications/list') }}">
                                <i class="ri-notification-3-line"></i> <span>@lang('translation.bell-notifications')</span>
                            </a>
                        </li>
                    @endcan
                @endcanany

                <!-- System Setup -->
                @canany(['View WelcomeNotes', 'View GeneralSettings']) 
                <li class="menu-title"><i class="ri-mail-open-line"></i> <span>@lang('translation.system-setup')</span></li>

                <!-- WelcomeNotes -->
                @can('View WelcomeNotes')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ request()->is('system-setup/welcome-note/*') ? 'active' : '' }}" href="{{ url('/system-setup/welcome-note/list') }}">
                            <i class="ri-article-fill"></i> <span>@lang('translation.welcome-notes')</span>
                        </a>
                    </li>
                @endcan
                <!-- GeneralSettings -->
                @can('Edit GeneralSettings')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('system-setup/general-settings/*') ? 'active' : '' }}" href="{{ url('/system-setup/general-settings/list') }}">
                        <i class="ri-settings-5-line"></i> <span>@lang('translation.general-settings')</span>
                    </a>
                </li>
                @endcan

            @endcanany

                <!-- Digital Assets | Section -->
                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.digital-assets')</span></li>
                
                <!-- Manage Digital Assets -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('digital-assets/*') ? 'active' : '' }}" href="{{ url('/digital-assets/list') }}">
                        <i class="ri-store-2-line"></i> <span>@lang('translation.manage-digital-assets')</span>
                    </a>
                </li>

                <!-- Market place -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('market-place/*') ? 'active' : '' }}" href="{{ url('/market-place/assets') }}">
                        <i class="ri-store-2-line"></i> <span>@lang('translation.market-place')</span>
                    </a>
                </li>

                <!-- Wallet -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('wallet/*') ? 'active' : '' }}" href="{{ url('/wallet/view') }}">
                        <i class="ri-wallet-line"></i> <span>@lang('translation.wallet')</span>
                    </a>
                </li>

                <!-- Invoice -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('invoice/*') ? 'active' : '' }}" href="{{ route('invoice.list') }}">
                        <i class="ri-wallet-line"></i> <span>@lang('translation.invoice')</span>
                    </a>
                </li>
            </ul> 
        </div>
        <!-- Sidebar -->
    </div>
        <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
