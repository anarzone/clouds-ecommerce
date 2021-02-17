<nav class="pcoded-navbar">
{{--    {{dd(request()->is('manage/dashboard'))}}--}}
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            <div class="pcoded-navigation-label">{{__('nav.navigation')}}</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu {{ request()->is('manage/dashboard', 'manage/dashboard/*') ? 'active pcoded-trigger' : '' }} ">
                    <a href="javascript:void(0)"
                       class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">{{__('nav.dashboard')}}</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('manage/dashboard') ? 'active' : '' }}">
                            <a href="{{route('dashboard')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">{{__('nav.main')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu {{ request()->is('manage/categories', 'manage/categories/*') ? 'active pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-tag"></i>
                        </span>
                        <span class="pcoded-mtext">{{__('nav.category')}}</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('manage/categories') ? 'active' : '' }}">
                            <a href="{{route('categories.all')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">{{__('nav.categories')}}</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('manage/categories/groups') ? 'active' : '' }}">
                            <a href="{{route('categories.groups')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">{{__('nav.categoriesGroup')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu {{ request()->is('manage/brands', 'manage/brands/*') ? 'active pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-tag"></i>
                        </span>
                        <span class="pcoded-mtext">{{__('nav.brand')}}</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('manage/brands') ? 'active' : '' }}">
                            <a href="{{route('brands.all')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">{{__('nav.brands')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu {{ request()->is('manage/customers', 'manage/customers/*') ? 'active pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-briefcase"></i>
                        </span>
                        <span class="pcoded-mtext">{{__('nav.customer')}}</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('manage/customers') ? 'active' : '' }}">
                            <a href="{{route('customers.index')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">{{__('nav.customers')}}</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('manage/customers/create') ? 'active' : '' }}">
                            <a href="{{route('customers.create')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">{{__('nav.customers.new')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu {{ request()->is('manage/products', 'manage/products/*') ? 'active pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-shopping-cart"></i>
                        </span>
                        <span class="pcoded-mtext">{{__('nav.product')}}</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('manage/products') ? 'active' : '' }}">
                            <a href="{{route('products.index')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">{{__('nav.products')}}</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('manage/products/create') ? 'active' : '' }}">
                            <a href="{{route('products.create')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">{{__('nav.products.new')}}</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('manage/products/types') ? 'active' : '' }}">
                            <a href="{{route('products.types.index')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">{{__('nav.products.types')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu {{ request()->is('manage/campaigns', 'manage/campaigns/*') ? 'active pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-bar-chart-2"></i>
                        </span>
                        <span class="pcoded-mtext">{{__('nav.campaign')}}</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('manage/campaigns') ? 'active' : '' }}">
                            <a href="{{route('campaigns.index')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">{{__('nav.campaigns')}}</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('manage/campaigns/create') ? 'active' : '' }}">
                            <a href="{{route('campaigns.create')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">{{__('nav.campaigns.new')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="pcoded-navigation-label">{{__('nav.management')}}</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu {{ request()->is('manage/admins', 'manage/admins/*') ? 'active pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-briefcase"></i>
                        </span>
                        <span class="pcoded-mtext">{{__('nav.user')}}</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('manage/admins') ? 'active' : '' }}">
                            <a href="{{route('admins.index')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">{{__('nav.users')}}</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('manage/admins/create') ? 'active' : '' }}">
                            <a href="{{route('admins.create')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">{{__('nav.newUser')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
