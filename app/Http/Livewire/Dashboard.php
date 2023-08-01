<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;
use App\Services\DashboardService;

class Dashboard extends BaseComponent
{
    public function render()
    {
        $data['weekly'] = $this->getWeeklyData();
        $data['day']    = $this->getDayData();
        $data['month']  = $this->getMonthData();
        $data['year']   = $this->getYearData();

        $data['analytics'] = $this->productsAnalytics();
        return $this->view('livewire.dashboard', $data);
    }

    public function getWeeklyData()
    {
        try {
            return (new DashboardService())->weeklyData();
        } catch (\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function getDayData()
    {
        try {
            return (new DashboardService())->dayData();
        } catch (\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function getMonthData()
    {
        try {
            return (new DashboardService())->monthData();
        } catch (\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function getYearData()
    {
        try {
            return (new DashboardService())->yearData();
        } catch (\Exception $ex){
            return $ex->getMessage();
        }
    }

    private function productsAnalytics()
    {
        try {
            return (new DashboardService())->productAnalytics();
        } catch (\Exception $ex){
            return $ex->getMessage();
        }
    }
}
