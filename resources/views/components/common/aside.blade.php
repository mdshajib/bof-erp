<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>
                <x-menu.item text="Dashboard" link="{{ route('dashboard') }}" icon="home" class="{{ (request()->is('dashboard*')) ? 'active' : '' }} "/>
                <x-menu.item text="Manage Users" link="{{ route('user.manage') }}" icon="users" class="{{ (request()->is('users')) ? 'active' : '' }}"/>
                <x-menu.item text="Manage Category" link="{{ route('manage.category') }}" icon="list" class="{{ (request()->is('categories')) ? 'active' : '' }}"/>
            </ul>
        </div>
    </div>
</div>
