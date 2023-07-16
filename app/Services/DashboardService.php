<?php

namespace App\Services;

use App\Models\SalesOrder;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
    }

     public function weeklyData()
     {
        try
        {
            $response['last_week']    = 0;
            $response['current_week'] = 0;

            $weekly = SalesOrder::query()->selectRaw('SUM(net_payment_amount) as amount, WEEK(created_at) as week_no')
                ->whereBetween('created_at',
                    [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->endOfWeek()]
                )->groupBy(DB::raw('WEEK(created_at)'))
                ->get();
            if(count($weekly) > 0) {
                $data = $weekly->where('week_no', Carbon::now()->subWeek()->week())->first();
                $response['last_week']    = $data?->amount ?? 0;

                $data = $weekly->where('week_no', Carbon::now()->week())->first();
                $response['current_week'] = $data?->amount ?? 0;
            }

            return $response;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }

    public function dayData()
    {
        try {
            $response['last_day']    = 0;
            $response['current_day'] = 0;

            $days = SalesOrder::query()->selectRaw('SUM(net_payment_amount) as amount, DAY(created_at) as day')
                ->whereBetween('created_at',
                    [Carbon::now()->subDay(), Carbon::now()]
                )->groupBy(DB::raw('DAY(created_at)'))
                ->get();

            if (count($days) > 0) {

                $data = $days->where('day', Carbon::now()->subDay()->day )->first();
                $response['last_day']    = $data?->amount ?? 0;

                $data = $days->where('day', Carbon::now()->day )->first();
                $response['current_day'] = $data?->amount ?? 0;
            }

            return $response;
        } catch(Exception $ex)
        {
            throw $ex;
        }
     }

    public function monthData()
    {
        try {
            $response['last_month']    = 0;
            $response['current_month'] = 0;

            $months = SalesOrder::query()->selectRaw('SUM(net_payment_amount) as amount, MONTH(created_at) as month')
                ->whereBetween('created_at',
                    [Carbon::now()->subMonth(), Carbon::now()]
                )->groupBy(DB::raw('MONTH(created_at)'))
                ->get();

            if (count($months) > 0) {

                $data = $months->where('month', Carbon::now()->subMonth()->month )->first();
                $response['last_month']    = $data?->amount ?? 0;

                $data = $months->where('month', Carbon::now()->month )->first();
                $response['current_month'] = $data?->amount ?? 0;
            }

            return $response;
        } catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function yearData()
    {
        try {
            $response['last_year']    = 0;
            $response['current_year'] = 0;

            $result = SalesOrder::query()->selectRaw('SUM(net_payment_amount) as amount, YEAR(created_at) as year')
                ->whereBetween('created_at',
                    [Carbon::now()->subYear(), Carbon::now()]
                )->groupBy(DB::raw('YEAR(created_at)'))
                ->get();

            if (count($result) > 0) {

                $data = $result->where('year', Carbon::now()->subYear()->year )->first();
                $response['last_year']    = $data?->amount ?? 0;

                $data = $result->where('year', Carbon::now()->year )->first();
                $response['current_year'] = $data?->amount ?? 0;
            }

            return $response;
        } catch(Exception $ex)
        {
            throw $ex;
        }
    }
}
