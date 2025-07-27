<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <img src="{{asset('assets/brand/logo.svg')}}" alt="Foodymat" class="img-fluid">
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-speedometer"></use>
                </svg> Dashboard
            </a>
        </li>

        <!-- Users Management -->
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                </svg> Users
            </a>
            <ul class="nav-group-items compact">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.index')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> All Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.create')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Add User</a>
                </li>
            </ul>
        </li>

        <!-- Restaurant Management -->
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-restaurant"></use>
                </svg> Restaurants
            </a>
            <ul class="nav-group-items compact">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('restaurants.index')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> All Restaurants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('restaurants.create')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Add Restaurant</a>
                </li>
            </ul>
        </li>

        <!-- Menu Management -->
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-fastfood"></use>
                </svg> Menu
            </a>
            <ul class="nav-group-items compact">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('menus.index')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> All Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('menus.create')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Add Item</a>
                </li>
            </ul>
        </li>

        <!-- Order Management -->
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cart"></use>
                </svg> Orders
            </a>
            <ul class="nav-group-items compact">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('orders.index')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> All Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('orders.pending')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('orders.declined')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Declined</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('orders.completed')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Completed</a>
                </li>
            </ul>
        </li>

        

        <!-- Reviews & Ratings -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-star"></use>
                </svg> Reviews & Ratings
            </a>
        </li>

        <!-- Reports -->
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chart-line"></use>
                </svg> Reports
            </a>
            <ul class="nav-group-items compact">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('reports.sales')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Sales Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('reports.orders')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Order Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('reports.revenue')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Revenue Report</a>
                </li>
            </ul>
        </li>

        <!-- Settings -->
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                        <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                </svg> Settings
            </a>
            <ul class="nav-group-items compact">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('settings.general')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('settings.appearance')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Appearance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('settings.email')}}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Email</a>
                </li>
            </ul>
        </li>

    </ul>

</div>
