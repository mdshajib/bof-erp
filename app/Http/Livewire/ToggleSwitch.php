<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;
use App\Jobs\ProductStatusJob;
use App\Models\ApiResponseMapping;
use App\Models\ContactEmail;
use App\Services\ApiBaseService;
use App\Services\ProductStatusService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ToggleSwitch extends BaseComponent
{
    public Model $model;

    public $primaryid;

    public $name;

    public $field;

    public $status;

    public $uniqueId;

    public function mount()
    {
        $this->status   = (bool) $this->model->getAttribute($this->field);
        $this->uniqueId = uniqid();
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();

        if ($value==false) {
            $this->dispatchBrowserEvent('notify', ['type' => 'warning', 'title'=>'Inactive', 'message' => $this->name.' Inactive']);
        } else {
            $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title'=>'Active',  'message' => $this->name.' Active']);
        }
    }

    public function render()
    {
        return view('livewire.toggle-switch');
    }

    public function updated($field, $value)
    {
        if ($this->model->getTable() == 'products') {
            $model  = $this->model;
            $status = $value ? 'publish' : 'draft';
            ProductStatusJob::dispatch($model->id, $status);
           // (new ProductStatusService)->changeProductStatus($model->id, $status);
        } elseif ($this->model->getTable() == 'contacts') {
            $model         = $this->model;
            $getEmail      =ContactEmail::where('contact_id', $model->id)->first();
            if ($getEmail && $getEmail->email !=null) {
                $api           =new ApiBaseService();
                $status        = $value ? 'active' : 'deactive';
                $data['email'] =$getEmail->email;
                $data['status']=$status;
                $api->wp_post('vicafe-users-567276-2080816', $data);
            }
        } elseif ($this->model->getTable() == 'discounts') {
            $api           =new ApiBaseService();
            $model         = $this->model;
            $status        = $value ? 'publish' : 'draft';
            if ($model->type=='coupon') {
                $data['coupon_id'] =$model->remote_id;
                $data['status']    =$status;
                $res               =$api->wp_post('vicafe-coupons-567276-2080816', $data);
            } elseif ($model->type=='basic') {
                $data['discount_id'] =$model->remote_id;
                $data['status']      =$status;
                $res                 =$api->wp_post('vicafe-discounts-567276-2080816', $data);
            }
        }
    }
}
