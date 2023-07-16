<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\BaseComponent;
use Livewire\Component;

class DailyReport extends BaseComponent
{
    public function render()
    {
        return $this->view('livewire.reports.daily-report', []);
    }
}
