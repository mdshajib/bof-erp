<?php

namespace App\Observers;

use App\Models\SalesOrder;

class SalesOrderObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the SalesOrder "created" event.
     */
    public function created(SalesOrder $salesOrder): void
    {
        $OrderNumber                = 'BOF#'.str_pad($salesOrder->id, '6', '0', STR_PAD_LEFT);
        $salesOrder->order_number   = $OrderNumber;
        $salesOrder->saveQuietly();
    }

    /**
     * Handle the SalesOrder "updated" event.
     */
    public function updated(SalesOrder $salesOrder): void
    {
        //
    }

    /**
     * Handle the SalesOrder "deleted" event.
     */
    public function deleted(SalesOrder $salesOrder): void
    {
        //
    }

    /**
     * Handle the SalesOrder "restored" event.
     */
    public function restored(SalesOrder $salesOrder): void
    {
        //
    }

    /**
     * Handle the SalesOrder "force deleted" event.
     */
    public function forceDeleted(SalesOrder $salesOrder): void
    {
        //
    }
}
