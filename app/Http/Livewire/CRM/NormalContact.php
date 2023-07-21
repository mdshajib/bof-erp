<?php

namespace App\Http\Livewire\CRM;

use App\Http\Livewire\BaseComponent;
use App\Services\ContactService;
use App\Models\Contact;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;
use Illuminate\Validation\Rule;

class NormalContact extends BaseComponent
{
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;
    use WithBulkActions;

    protected $listeners = ['deleteConfirm' => 'contactDelete', 'deleteCancel' => 'contactDeleteCancel'];

    public $contact_id = null;
    public $contactIdBeingRemoved = null;

    public $filter = [
        'name'          => null,
        'phone'          => null
    ];

    public $contact = [
        'name'     => null,
        'phone'    => null,
        'email'    => null,
        'address'  => null,
        'special'  => 0,
    ];

    public function render()
    {
        $data['contacts'] = $this->rows;
        return $this->view('livewire.c-r-m.contact', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = Contact::query()
            ->where('special' , 0)
            ->when($this->filter['name'], fn ($q, $name) => $q->where('name', 'like', "%{$name}%"))
            ->when($this->filter['phone'], fn ($q, $phone) => $q->where('phone', 'like', "%{$phone}%"));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function openNewContactModal()
    {
        $this->resetErrorBag();
        $this->reset();
        $this->dispatchBrowserEvent('openNewContactModal');
    }

    public function openEditContactModal($contact_id)
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->contact_id = $contact_id;
        $contact_data = (new ContactService())->getContact($contact_id);
        $this->contact = [
            'name'     => $contact_data->name,
            'phone'    => $contact_data->phone,
            'email'    => $contact_data->email,
            'address'  => $contact_data->address,
        ];
        $this->dispatchBrowserEvent('openNewContactModal');
    }

    public function submit()
    {
        try {
            $rules = [
                'contact.name'  => 'required',
            ];

            if (! $this->contact_id) {
                $rules['contact.email']    = 'nullable|email|unique:contacts,email,NULL,id,deleted_at,NULL';
                $rules['contact.phone']    = 'required|unique:contacts,phone,NULL,id,deleted_at,NULL';
                $this->validate($rules);

                $status = (new ContactService())->save($this->contact);
                if($status){
                    $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Contact Create', 'message' => 'Contact create successfully']);
                }
            } else {
                $rules['contact.phone']    = 'required|unique:contacts,phone,'.$this->contact_id.',id,deleted_at,NULL';
                $rules['contact.email']    = 'nullable|email|unique:contacts,email,'.$this->contact_id.',id,deleted_at,NULL';

                $this->validate($rules);

                $status = (new ContactService())->update($this->contact_id, $this->contact);
                if($status){
                    $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Contact Update', 'message' => 'Contact update successfully']);
                }
            }
            $this->reset();
            $this->hideModal();
        } catch (\Exception $ex) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Contact', 'message' => $ex->getMessage() ]);
        }

    }

    public function UserconfirmDelete($contact_id)
    {
        $this->contactIdBeingRemoved = $contact_id;
        $this->dispatchBrowserEvent('show-delete-notification');
    }

    public function contactDeleteCancel()
    {
        $this->contactIdBeingRemoved = null;
    }

    public function contactDelete()
    {
        if ($this->contactIdBeingRemoved != null) {
            $status = (new ContactService())->deleteContact($this->contactIdBeingRemoved);
            if($status) {
                $this->dispatchBrowserEvent('deleted', ['message' => 'Contact delete successfully']);
            }
        }
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
}
