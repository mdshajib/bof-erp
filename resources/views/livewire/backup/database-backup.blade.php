<div>
    @section('page-title')
        Backup
    @endsection

    @section('header')
        <x-common.header title="Backup">
        </x-common.header>
    @endsection
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3 order-create">
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-xs-8">
                            <button wire:click.prevent="runBackup" class="btn btn-block btn-primary">RUN Backup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
