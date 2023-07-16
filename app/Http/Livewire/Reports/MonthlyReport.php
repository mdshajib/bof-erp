<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\BaseComponent;

class MonthlyReport extends BaseComponent
{
    public function render()
    {
        return $this->view('livewire.reports.monthly-report',[]);
    }
}
