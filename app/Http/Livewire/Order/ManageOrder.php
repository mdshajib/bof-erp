<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\BaseComponent;
use App\Models\SalesOrder;
use App\Services\OrderManagementService;
use App\Services\ThermalPrintService;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;

class ManageOrder extends BaseComponent
{
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;
    use WithBulkActions;

    public $order_number;
    public $view_row_section = [];
    public $order_summary    = [];
    public $order_info       = [];
    public $order_id;
    public $filter = [
        'order_number'    => ''
    ];

    public function render()
    {
        $data['orders'] = $this->rows;
        return $this->view('livewire.order.manage-order', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = SalesOrder::query()
            ->with(['user:id,first_name,last_name'])
            ->select('id','order_number','order_date','paid_amount','due_amount','gross_amount','net_payment_amount','generated_by','is_paid')
            ->when($this->filter['order_number'], fn ($q, $order_number) => $q->where('order_number', 'like', "%{$order_number}%"));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function search()
    {
        $this->hideOffCanvas();
        $this->resetPage();

        return $this->rows;
    }

    public function resetSearch()
    {
        $this->reset('filter');
        $this->hideOffCanvas();
    }

    public function OrderView($order_id)
    {
        $this->order_id = $order_id;

        $order_data = (new OrderManagementService())->viewOrderDetails($order_id);
        if(count($order_data) > 0){
            $this->view_row_section = $order_data['items'];
            $this->order_summary    = $order_data['summary'];
            $this->order_info       = $order_data['order_info'];
            $this->order_number = $this->order_info['order_number'];
        }
        $this->dispatchBrowserEvent('openOrderViewModal');
    }

    public function printOrder($order_id)
    {
        try {
            return (new ThermalPrintService())->print($order_id);
        }
        catch(\Exception $ex) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Error', 'message' => $ex->getMessage() ]);
        }
    }

    private function columnify($leftCol, $centerCol, $rightCol, $leftWidth, $centerWidth, $rightWidth, $space = 4)
    {
        $leftWrapped   = wordwrap($leftCol, $leftWidth, "\n", true);
        $centerWrapped = wordwrap($centerCol, $centerWidth, "\n", true);
        $rightWrapped  = wordwrap($rightCol, $rightWidth, "\n", true);

        $leftLines   = explode("\n", $leftWrapped);
        $centerLines = explode("\n", $centerWrapped);
        $rightLines  = explode("\n", $rightWrapped);
        $allLines = array();
        for ($i = 0; $i < max(count($leftLines),count($centerLines), count($rightLines)); $i ++) {
            $leftPart   = str_pad($leftLines[$i] ?? "", $leftWidth, " ");
            $centerPart = str_pad($centerLines[$i] ?? "", $centerWidth, " ");
            $rightPart  = str_pad($rightLines[$i] ?? "", $rightWidth, " ");
            $allLines[] = $leftPart . str_repeat(" ", $space) . $centerPart . str_repeat(" ", $space). $rightPart;
        }
        return implode("\n", $allLines) . "\n";
    }
}
