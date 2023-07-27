<div>
    @section('page-title')
        Logs
    @endsection


    @section('header')
        <x-common.header title="Logs">
        </x-common.header>
    @endsection

    <x-action-box>
        <x-slot name="left">
            <div class="row">
                <div class="col-auto">
                    <button wire:click.prevent="clearlogs" class="btn waves-effect btn-primary">
                        <i class="fa fa-clear me-2"></i> Clear All Logs
                    </button>
                </div>
            </div>
        </x-slot>
        <x-slot name="right">
            <div class="d-flex justify-content-between">
                <x-form.select id="perPage" wire:model="perPage">
                    <option value="5"> 5 </option>
                    <option value="10"> 10 </option>
                    <option value="50"> 50 </option>
                    <option value="100"> 100 </option>
                </x-form.select>

                <div class="ms-2">
                    <button
                        class="btn btn-primary"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasFilter"
                        aria-controls="offcanvasFilter">
                        <i class="fa fa-filter pe-2"></i> Search
                    </button>

                    <x-offcanvas id="offcanvasFilter" size="sm" title="Search">

                        <x-form.input id="txt_title_filter" wire:model.defer="filter.date" placeholder="{{ __('Year-Month-Day') }}" />

                        <button type="button" wire:click.prevent="search" class="btn btn-primary">Search</button>
                        <button type="button" wire:click.prevent="resetSearch" class="btn btn-link">Reset</button>

                    </x-offcanvas>
                </div>
            </div>

        </x-slot>

    </x-action-box>

    <x-table.table>
        <x-slot name="head">
            <tr>
                <x-table.th>Action By</x-table.th>
                <x-table.th>Event</x-table.th>
                <x-table.th>Action</x-table.th>
                <x-table.th>Data</x-table.th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @forelse($activity as $log)
                <tr>
                    <td>{{ $log->causer_id }}</td>
                    <td>{{ $log->event }}</td>
                    <td>{{ $log->subject_type }}</td>
                    <td>{{ $log->properties }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Records Found!</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table.table>
    <div class="row">
        <div class="col-sm-12 col-md-5">{{ pagination_stats_text($activity) }} </div>
        <div class="col-sm-12 col-md-7">{{ $activity->links() }}</div>
    </div>
</div>
