<?php

namespace App\Http\Livewire\Log;

use App\Http\Livewire\BaseComponent;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class AppActivityLog extends BaseComponent
{
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;
    use WithBulkActions;

    public $filter = [
        'date'    => null
    ];

    public function render()
    {
        $data['activity'] = $this->rows;
        return $this->view('livewire.log.app-activity-log', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = Activity::query()
            ->when($this->filter['date'], fn ($q, $date) => $q->where('created_at', 'like', "%{$date}%"));

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

    public function clearlogs()
    {
        Activity::query()->delete();
        DB::statement("OPTIMIZE TABLE activity_log;");
    }
}
