<x-modal
    on="openOrderReportPreviewModal"
    modal-id="modalContact"
    title="PDF Preview"
    size="xl"
    :has-button="false"
    wire:ignore.self
>

    <div class="row gx-4">
        <div class="col-12">
            <embed
                src="{{ $order_report_name }}"
                style="width:100%; min-height:600px;"
                frameborder="0">
        </div>
    </div>
</x-modal>
