<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\BaseComponent;

class WeeklyReport extends BaseComponent
{
    public function render()
    {
        return $this->view('livewire.reports.weekly-report');
    }
}
