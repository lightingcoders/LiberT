<div class="admin border-left-blue-grey border-left-lighten-4 d-none d-xl-block">
    <a class="admin-close" href="#">
        <i class="ft-x font-medium-3"></i>
    </a>
    <a class="admin-toggle bg-primary box-shadow-3" href="#">
        <i class="ft-briefcase font-medium-3 white"></i>
    </a>
    <div class="admin-content p-2 ps-container ps-theme-dark">
        <h4 class="text-uppercase mb-0">{{__('SITE ADMINISTRATION')}}</h4>
        <hr>
        <p>{{__('Quick navigation through elevated permissions and settings')}}</p>

        <h5 class="mt-1 mb-1 text-bold-500">{{__('Quick Navigation')}}</h5>
        <hr>

        <ul class="nav flex-column wrap-border">
            @hasanyrole('admin')
            <li class="nav-header">{{__('Administration Menu')}}</li>

            <li class="nav-item">
                <a href="{{route('administration.manage_users.index')}}" class="nav-link active">
                    <i class="la la-user"></i> {{__('Manage Users')}}
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link active">
                    <i class="la la-gears"></i> {{__('Configuration')}}
                </a>
                <ul class="menu-content">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('administration.configuration.general.index')}}">
                            {{__('General')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('administration.configuration.notification.index')}}">
                            {{__('Notifications')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('administration.configuration.settings.index')}}">
                            {{__('Settings')}}
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dropdown-divider"></li>
            @endhasanyrole

            <li class="nav-header">{{__('Moderation Menu')}}</li>

            @hasanyrole('admin|super_moderator')
            <li class="nav-item">
                <a href="{{route('moderation.offer_settings.index')}}" class="nav-link">
                    <i class="la la-gear"></i> {{__('Offer Settings')}}
                </a>
            </li>
            @endhasanyrole

            <li class="nav-item">
                <a href="{{route('moderation.manage_trades.index')}}" class="nav-link">
                    <i class="la la-briefcase"></i> {{__('Manage Trades')}}
                    <span class="badge badge-pill badge-default badge-warning float-right badge-glow">
                        {{\App\Models\Trade::where('status', 'dispute')->count()}}
                        {{__('dispute')}}
                    </span>
                </a>
            </li>
        </ul>

        <h5 class="my-1 text-bold-500">{{__('Site Statistics')}}</h5>
        <hr/>

        <div id="project-info" class="row">
            <div class="project-info-count col-lg-4 col-md-12">
                <div class="project-info-icon info">
                    <h2>{{\App\Models\User::count()}}</h2>
                    <div class="project-info-sub-icon">
                        <span class="la la-user"></span>
                    </div>
                </div>
                <div class="project-info-text pt-1">
                    <h5>{{__('Users')}}</h5>
                </div>
            </div>
            <div class="project-info-count col-lg-4 col-md-12">
                <div class="project-info-icon success">
                    <h2>{{\App\Models\Trade::where('status', 'successful')->count()}}</h2>
                    <div class="project-info-sub-icon">
                        <span class="la la-calendar-check-o"></span>
                    </div>
                </div>
                <div class="project-info-text pt-1">
                    <h5>{{__('Successful Trades')}}</h5>
                </div>
            </div>
            <div class="project-info-count col-lg-4 col-md-12">
                <div class="project-info-icon primary">
                    <h2>{{\App\Models\Offer::count()}}</h2>
                    <div class="project-info-sub-icon">
                        <span class="la la-cart-plus"></span>
                    </div>
                </div>
                <div class="project-info-text pt-1">
                    <h5>{{__('Offers')}}</h5>
                </div>
            </div>
        </div>

        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;">
            <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;">
            <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
        </div>
    </div>
</div>
