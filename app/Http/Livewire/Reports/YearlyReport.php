<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\BaseComponent;
use App\Traits\SalesReportQuery;
use Carbon\Carbon;

class YearlyReport extends BaseComponent
{
    use SalesReportQuery;
    public $disabled     = false;
    public $selected_date;
    public $get_selected_date;

    public function mount()
    {
        $this->selected_date     = date('Y');
        $this->get_selected_date = date('Y');
        $this->selectedDateRange();
        $this->intFilterOptionsData();
        $this->processingData = $this->getSalesData()->toArray();
    }


    public function render()
    {
        $data['orders'] = $this->processingData;
        return $this->view('livewire.reports.yearly-report', $data);
    }

    public function updatedGetProductId()
    {
        $this->variationList();
    }

    public function addedMinus()
    {
        if ($this->get_selected_date > 2023) {
            $this->get_selected_date = $this->get_selected_date - 1;
        }
    }

    public function addedPlus()
    {
        if ($this->get_selected_date < 2023) {
            $this->get_selected_date = $this->get_selected_date + 1;
        }
    }

    private function selectedDateRange(): Carbon
    {
        $dates       = Carbon::parse($this->get_selected_date.'-03-12');
        $this->end   = $dates->copy()->endOfYear()->toDateString();
        $this->start = $dates->copy()->startOfYear()->toDateString();

        return $dates;
    }

    public function generatePosReport()
    {
        $this->selectedDateRange();
        $this->variation_id   = $this->get_variation_id;
        $this->product_id     = $this->get_product_id;
        $this->selected_date  = $this->get_selected_date;
        $this->processingData = $this->getSalesData();
        $this->disabled = false;
    }

    public function resetFilter()
    {
        $this->reset('selected_date', 'get_variation_id', 'get_product_id');
        $this->get_selected_date = date('Y');
        $this->disabled          = true;
    }

    public function updated($name, $value)
    {
        if ($name == 'get_variation_id' || $name == 'get_product_id' || $name == 'get_selected_date') {
            $this->disabled = true;
        }
    }
}
