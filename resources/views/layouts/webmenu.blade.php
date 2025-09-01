<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ url('/dashboard') }}" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <img src="{{ url('/logo.png') }}" alt="" width="200" class="logo logo-lg" />
                <img src="{{ url('assets/images/logo-abbr.png') }}" alt="" class="logo logo-sm" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Home</label>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="{{ route('dashboard') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-airplay"></i></span>
                        <span class="nxl-mtext">Dashboard</span>
                    </a>
                </li>
                @canany(['receipts-list','payments-list'])
                <li class="nxl-item nxl-caption">
                    <label>Transactions</label>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-settings"></i></span>
                        <span class="nxl-mtext">Transactions</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        @can('receipts-list')
                        <li class="nxl-item"><a class="nxl-link" href="{{ url('receipts') }}">Receipts</a></li>
                        @endcan
                        @can('payments-list')
                        <li class="nxl-item"><a class="nxl-link" href="{{ url('payments') }}">Payments</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                @can('purchases-list')
                <li class="nxl-item nxl-caption">
                    <label>Purchase</label>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-settings"></i></span>
                        <span class="nxl-mtext">Purchase</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="{{ url('purchases') }}">Purchase Invoice</a></li>
                    </ul>
                </li>
                @endcan
                @can('sales-list')
                <li class="nxl-item nxl-caption">
                    <label>Sales</label>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-settings"></i></span>
                        <span class="nxl-mtext">Sales</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="{{ url('sales') }}">Sale Invoice</a></li>
                    </ul>
                </li>
                @endcan
                @canany(['accounts-list','products-list','product-categories-list','product-makes-list'])
                <li class="nxl-item nxl-caption">
                    <label>Master</label>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-settings"></i></span>
                        <span class="nxl-mtext">Master</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        @can('accounts-list')
                        <li class="nxl-item"><a class="nxl-link" href="{{ url('accounts') }}">Chart of Accounts</a></li>
                        @endcan
                        @can('products-list')
                        <li class="nxl-item"><a class="nxl-link" href="{{ url('products') }}">Products</a></li>
                        @endcan
                        @can('product-categories-list')
                        <li class="nxl-item"><a class="nxl-link" href="{{ url('product-categories') }}">Product Categories</a></li>
                        @endcan
                        @can('product-makes-list')
                        <li class="nxl-item"><a class="nxl-link" href="{{ url('product-makes') }}">Product Make</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                @canany(['users-list','roles-list'])
                <li class="nxl-item nxl-caption">
                    <label>Administration</label>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-settings"></i></span>
                        <span class="nxl-mtext">Administration</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        @can('users-list')
                        <li class="nxl-item"><a class="nxl-link" href="{{ url('users') }}">Users</a></li>
                        @endcan
                        @can('roles-list')
                        <li class="nxl-item"><a class="nxl-link" href="{{ url('roles') }}">Roles</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany
            </ul>
        </div>
    </div>
</nav>
