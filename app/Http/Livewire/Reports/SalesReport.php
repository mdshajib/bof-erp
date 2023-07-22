<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\BaseComponent;
use App\Services\SalesReportService;
use App\Traits\SalesReportQuery;

class SalesReport extends BaseComponent
{
    use SalesReportQuery;
    public $disabled     = false;
    public $dates = '';

    public function mount()
    {
        $this->dates = date('y-m-d');
        $this->intFilterOptionsData();
        $this->processingData = $this->getSalesData()->toArray();
    }

    public function render()
    {
        $data['orders'] = $this->processingData;
        return $this->view('livewire.reports.sales-report', $data);
    }

    public function updatedGetProductId()
    {
        $this->variationList();
    }

    public function generatePosReport()
    {
        $this->variation_id   = $this->get_variation_id;
        $this->product_id     = $this->get_product_id;
        $this->processingData = $this->getSalesData()->toArray();
        $this->disabled = false;
    }

    public function resetFilter()
    {
        $this->reset('selected_date', 'get_variation_id', 'get_product_id');
        $this->disabled          = true;
    }

    public function updated($name, $value)
    {
        if ($name == 'get_variation_id' || $name == 'get_product_id') {
            $this->disabled = true;
        }
    }

    public function downloadExcel()
    {
        try {
            return (new SalesReportService())->excelDownload($this->dates, $this->product_id, $this->variation_id);
        } catch (\Exception $ex){
            return $ex->getMessage();
        }
    }
}
