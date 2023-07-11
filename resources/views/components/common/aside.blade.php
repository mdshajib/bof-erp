<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>
                <x-menu.item text="{{ __('Dashboard') }}" link="{{ route('dashboard') }}" icon="home" class="{{ (request()->is('dashboard*')) ? 'active' : '' }} "/>
                <x-menu.item text="{{ __('Manage Users') }}" link="{{ route('user.manage') }}" icon="users" class="{{ (request()->is('users')) ? 'active' : '' }}"/>

                <x-menu.list text="Category Management" icon="list" class="{{ (request()->is('categor*')) ? 'mm-active' : '' }}">
                    <x-menu.item text="Manage Category" link="{{  route('manage.category') }}" class="{{ (request()->is('categories')) ? 'active' : '' }}"/>
{{--                    <x-menu.item text="Manage Attribute" link="{{  route('manage.category') }}" class="{{ (request()->is('categories')) ? 'active' : '' }}"/>--}}
{{--                    <x-menu.item text="Manage Terms" link="{{  route('manage.category') }}" class="{{ (request()->is('categories')) ? 'active' : '' }}"/>--}}
                </x-menu.list>

                <x-menu.item text="Supplier Management" link="{{ route('supplier.manage') }}" icon="cpu" class="{{ (request()->is('suppliers*')) ? 'active' : '' }} "/>

                <x-menu.list text="Product Management" icon="package" class="{{ (request()->is('product*')) ? 'mm-active' : '' }}">
                    <x-menu.item text="Add Product" link="{{ route('product.create') }}" class="{{ (request()->is('products/create')) ? 'active' : '' }}"/>
                    <x-menu.item text="Manage Products" link="{{ route('product.manage') }}" class="{{ (request()->is('products')) ? 'active' : '' }} "/>
                </x-menu.list>

                <x-menu.list text="Purchase Management" icon="shopping-bag" class="{{ (request()->is('purchases*')) ? 'mm-active' : '' }}">
                    <x-menu.item text="Order Create" link="{{ route('purchase.create') }}" class="{{ (request()->is('purchases/create')) ? 'active' : '' }}"/>
                    <x-menu.item text="Open Order" link="{{ route('purchase.open') }}" class="{{ (request()->is('purchases/open')) ? 'active' : '' }}"/>
                    <x-menu.item text="Confirmed Order" link="{{ route('purchase.confirmed') }}" class="{{ (request()->is('purchases/confirmed')) ? 'active' : '' }}"/>
                    <x-menu.item text="All Purchase" link="{{ route('purchase.manage') }}" class="{{ (request()->is('purchases')) ? 'active' : '' }}"/>
                </x-menu.list>

                <x-menu.list text="Order Management" icon="shopping-cart" class="{{ (request()->is('order*')) ? 'mm-active' : '' }}">
                    <x-menu.item text="Order Create" link="{{ route('order.create') }}" class="{{ (request()->is('order/create')) ? 'active' : '' }}"/>
                    <x-menu.item text="All Orders" link="{{ route('order.manage') }}" class="{{ (request()->is('orders')) ? 'active' : '' }}"/>
                    <x-menu.item text="Unpaid Orders" link="{{ route('order.unpaid') }}" class="{{ (request()->is('orders/unpaid')) ? 'active' : '' }}"/>
                </x-menu.list>

                <x-menu.list text="Inventory Management" icon="book" class="{{ (request()->is('inventory*')) ? 'mm-active' : '' }}">
                    <x-menu.item text="Inventory" link="{{ route('inventory.manage') }}" class="{{ (request()->is('inventory')) ? 'active' : '' }}"/>
                    <x-menu.item text="Stock IN" link="{{ route('inventory.stockin') }}" class="{{ (request()->is('/inventory/stockin')) ? 'active' : '' }}"/>
                    <x-menu.item text="Transactions" link="{{ route('inventory.transactions') }}" class="{{ (request()->is('/inventory/transactions')) ? 'active' : '' }}"/>
                </x-menu.list>

            </ul>
        </div>
    </div>
</div>
