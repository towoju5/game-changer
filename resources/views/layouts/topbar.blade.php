@php
    // Assigning Full Name or N/A
    if (Auth::user()->first_name || Auth::user()->last_name) {
        $full_name = Auth::user()->first_name.' '.Auth::user()->last_name;
    }else{
        $full_name = 'N/A';
    }

    //Account Review Notification
    $accountReviewNotifications = \App\Models\User::where('account_verification', 'Under Review')
                                        ->whereNotNull('username')                                                
                                        ->get();

    $userNotification = \Auth::user()->notification()->get();

    //Notifications Count
    $adminCount = count($accountReviewNotifications);
    $userCount = count($userNotification);

    //Checking Roles
    $IsSuperAdmin = Auth::user()->hasRole('Super Admin');
    $IsAdministrator = Auth::user()->hasRole('Administrator');
    $IsUser = Auth::user()->hasRole('User');

    //Chat Indicator
    $UnreadMessages = \App\Models\ChMessage::where('to_id', Auth::id())->where('seen', 0)->count();
@endphp

<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ url('/') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('assets/images/gc7-logo.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img style="margin-top:-4px;" src="{{ URL::asset('assets/images/gc7-logo.png') }}" alt="" height="55px">
                        </span>
                    </a>

                    <a href="{{ url('/') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('assets/images/gc7-logo.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img style="margin-top:-4px;" src="{{ URL::asset('assets/images/gc7-logo.png') }}" alt="" height="55px">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">
                <!-- Language Option -->
                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @switch(Session::get('lang'))
                        @case('ru')
                            <img src="{{ URL::asset('/assets/images/flags/russia.svg') }}" class=" rounded" alt="Header Language"
                                height="20">
                        @break
                        @case('it')
                            <img src="{{ URL::asset('/assets/images/flags/italy.svg') }}" class=" rounded" alt="Header Language"
                                height="20">
                        @break
                        @case('sp')
                            <img src="{{ URL::asset('/assets/images/flags/spain.svg') }}" class=" rounded" alt="Header Language"
                                height="20">
                        @break
                        @case('ch')
                            <img src="{{ URL::asset('/assets/images/flags/china.svg') }}" class=" rounded" alt="Header Language"
                                height="20">
                        @break
                        @case('fr')
                            <img src="{{ URL::asset('/assets/images/flags/french.svg') }}" class=" rounded" alt="Header Language"
                                height="20">
                        @break
                        @case('gr')
                            <img src="{{ URL::asset('/assets/images/flags/germany.svg') }}" class=" rounded" alt="Header Language"
                                height="20">
                        @break
                        @default
                            <img src="{{ URL::asset('/assets/images/flags/us.svg') }}" class=" rounded" alt="Header Language" height="20">
                    @endswitch
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">

                        <!-- item-->
                        <a href="{{ url('index/en') }}" class="dropdown-item notify-item language py-2" data-lang="en"
                            title="English">
                            <img src="{{ URL::asset('assets/images/flags/us.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">English</span>
                        </a>

                        <!-- item-->
                        <a href="{{ url('index/sp') }}" class="dropdown-item notify-item language" data-lang="sp"
                            title="Spanish">
                            <img src="{{ URL::asset('assets/images/flags/spain.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">Española</span>
                        </a>

                        <!-- item-->
                        <a href="{{ url('index/gr') }}" class="dropdown-item notify-item language" data-lang="gr"
                            title="German">
                            <img src="{{ URL::asset('assets/images/flags/germany.svg') }}" alt="user-image" class="me-2 rounded"
                                height="20"> <span class="align-middle">Deutsche</span>
                        </a>

                        <!-- item-->
                        <a href="{{ url('index/it') }}" class="dropdown-item notify-item language" data-lang="it"
                            title="Italian">
                            <img src="{{ URL::asset('assets/images/flags/italy.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">Italiana</span>
                        </a>

                        <!-- item-->
                        <a href="{{ url('index/ru') }}" class="dropdown-item notify-item language" data-lang="ru"
                            title="Russian">
                            <img src="{{ URL::asset('assets/images/flags/russia.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">русский</span>
                        </a>

                        <!-- item-->
                        <a href="{{ url('index/ch') }}" class="dropdown-item notify-item language" data-lang="ch"
                            title="Chinese">
                            <img src="{{ URL::asset('assets/images/flags/china.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">中国人</span>
                        </a>

                        <!-- item-->
                        <a href="{{ url('index/fr') }}" class="dropdown-item notify-item language" data-lang="fr"
                            title="French">
                            <img src="{{ URL::asset('assets/images/flags/french.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">français</span>
                        </a>
                    </div>
                </div>

                <!-- Full Screen Option -->
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <!-- Dark Mode Option -->
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <!-- Chat -->
                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <a href="{{ url('/chat') }}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle">
                        <i class='bx bx-message-dots fs-22'></i>
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ $UnreadMessages}}<span class="visually-hidden">unread messages</span></span>
                    </a>
                </div>

                <!-- Notifications -->
                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">@if($IsSuperAdmin || $IsAdministrator) {{ $adminCount }} @else {{ $userCount }} @endif<span class="visually-hidden">unread messages</span></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-dark bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        @if(($IsSuperAdmin || $IsAdministrator) && $adminCount > 0)
                                            <span class="badge badge-soft-light fs-13">{{ $adminCount }} New</span>
                                        @elseif($IsUser && $userCount > 0)
                                            <span class="badge badge-soft-light fs-13">{{ $userCount }} New</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 pt-2">
                                <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true"
                                    id="notificationItemsTab" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active text-dark" data-bs-toggle="tab" href="#all-noti-tab" role="tab"
                                            aria-selected="true">
                                            <!-- All Notifications -->
                                            @if($IsSuperAdmin || $IsAdministrator)
                                                All ({{ $adminCount }})
                                            @else
                                                All ({{ $userCount }})
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content" id="notificationItemsTabContent">
                            <!-- All Notifications Tab -->
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                @if (($IsSuperAdmin || $IsAdministrator) && $adminCount > 0)
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                        <!-- Account Review Notification -->
                                        @can('Verify User Documents')
                                            @foreach ($accountReviewNotifications as $user)
                                                <div class="text-reset notification-item d-block dropdown-item position-relative">
                                                    <div class="d-flex">
                                                        <div class="avatar-xs me-3">
                                                            <span class="avatar-title bg-soft-success text-success rounded-circle fs-16">
                                                                <i class="ri-shield-check-line"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-1">
                                                            <a href="{{ url('/user/verify/account/'.encrypt($user->id)) }}" class="stretched-link">
                                                                <h6 class="mt-0 mb-2 lh-base">
                                                                    {{ $user->first_name }} has completed their profile and is now awaiting <span class="text-success"> account review.</span>
                                                                </h6>
                                                            </a>
                                                            <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                                <span><i class="mdi mdi-clock-outline"></i> {{ $user->updated_at->diffForHumans() }}</span>
                                                            </p>
                                                        </div>
                                                        <div class="px-2 fs-15"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endcan
                                    </div>
                                @elseif(!($IsSuperAdmin || $IsAdministrator) && $userCount > 0)
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    <!-- Account Review Notification -->
                                        @foreach ($userNotification as $usernotify)
                                            <div class="text-reset notification-item d-block dropdown-item position-relative">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-soft-success text-success rounded-circle fs-16">
                                                            <i class="ri-shield-check-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <a href="" class="stretched-link">
                                                            <h6 class="mt-0 mb-2 lh-base">
                                                                 {{ $usernotify->messages }} {{-- <span class="text-success"> account review.</span> --}}
                                                            </h6>
                                                        </a>
                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                            <span><i class="mdi mdi-clock-outline"></i> {{ $usernotify->updated_at->diffForHumans() }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="px-2 fs-15"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                </div>
                                @else
                                    <div class="p-4">
                                        <div class="w-25 w-sm-50 pt-3 mx-auto">
                                            <img src="{{ URL::asset('assets/images/svg/bell.svg') }}" class="img-fluid" alt="user-pic">
                                        </div>
                                        <div class="text-center pb-5 mt-2">
                                            <h6 class="fs-18 fw-semibold lh-base">Hey! You have no new notifications </h6>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Toggle Option -->
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="@if (Auth::user()->profile_picture != 'avatar-1.jpg') {{ URL::asset(Auth::user()->profile_picture) }} @else {{ URL::asset('images/avatar-1.jpg') }} @endif"
                                alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ $full_name}}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ Auth::user()->roles[0]->name }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <h6 class="dropdown-header">Welcome {{ $full_name }}!</h6>
                        <!-- Profile -->
                        <a class="dropdown-item" href="{{ url('/profile') }}">
                            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle">Profile</span>
                        </a>
                        <!-- Logout -->
                        <a class="dropdown-item " href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off font-size-16 align-middle me-1"></i> 
                            <span key="t-logout">@lang('translation.logout')</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
