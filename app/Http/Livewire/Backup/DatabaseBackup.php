<?php

namespace App\Http\Livewire\Backup;

use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class DatabaseBackup extends BaseComponent
{
    public function render()
    {
        return $this->view('livewire.backup.database-backup',[]);
    }

    public function runBackup()
    {
        try {
            Artisan::call('backup:clean', []);
            Artisan::call('backup:run', []);

            $output = Artisan::output();
            \Log::info($output);
        } catch (\Exception $e){
            throw $e;
        }
    }
}
