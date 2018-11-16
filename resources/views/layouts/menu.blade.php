<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li>
                <a href="{{route('home.index')}}">
                    <i class="la la-home"></i>
                    <span class="menu-title">{{__('Home')}}</span>
                </a>
            </li>

            <li>
                <a href="{{route('wallet.index')}}">
                    <i class="la la-money"></i>
                    <span class="menu-title">{{__('Wallet')}}</span>
                </a>
            </li>

            <li class="navigation-header">
                <span>LiberT Market</span>
            </li>

            <li>
                <a href="{{route('marketplace.buy-coin.index')}}">
                    <i class="la la-shopping-cart"></i>
                    <span class="menu-title">{{__('Buy Coin')}}</span>
                </a>
            </li>
            <li>
                <a href="{{route('marketplace.sell-coin.index')}}">
                    <i class="la la-dollar"></i>
                    <span class="menu-title">{{__('Sell Coin')}}</span>
                </a>
            </li>
            <li>
                <a href="{{route('marketplace.create-offer.sell')}}">
                    <i class="la la-cart-plus"></i>
                    <span class="menu-title">{{__('Create Offer')}}</span>
                </a>
            </li>

            <li class="navigation-header">
                <span>{{__('MY PROFILE')}}</span>
            </li>

            <li>
                <a href="{{route('profile.contacts.index', ['user' => Auth::user()->name])}}">
                    <i class="la la-tty"></i>
                    <span class="menu-title">{{__('Contacts')}}</span>
                </a>
            </li>

            <li>
                <a href="{{route('profile.trades.index', ['user' => Auth::user()->name])}}">
                    <i class="la la-briefcase"></i>
                    <span class="menu-title">{{__('Trades')}}</span>
                </a>
            </li>

            <li>
                <a href="{{route('profile.notifications.index', ['user' => Auth::user()->name])}}">
                    <i class="la la-bell"></i> <span class="menu-title">{{__('Notifications')}}</span>
                </a>
            </li>

            <li>
                <a href="{{route('profile.settings.index', ['user' => Auth::user()->name])}}">
                    <i class="la la-gear"></i>
                    <span class="menu-title">{{__('Settings')}}</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="la la-life-ring"></i>
                    <span class="menu-title">{{__('Help Center')}}</span>
                </a>
            </li>

        </ul>
    </div>
</div>
