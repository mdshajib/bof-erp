<?php

namespace App\Http\Livewire\Supplier;

use App\Http\Livewire\BaseComponent;
use App\Models\Supplier;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;

class ManageSupplier extends BaseComponent
{
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;
    use WithBulkActions;

    protected $listeners = ['deleteConfirm' => 'supplierDelete', 'deleteCancel' => 'supplierDeleteCancel'];

    public $supplierIdBeingRemoved = null;
    public $supplier_id;
    public $name;

    public $address;

    public $phone;

    public $active = true;

    public $filter = [
        'name'     => null,
        'address'  => null
    ];

    public function render()
    {
        $data['suppliers'] = $this->rows;
        return $this->view('livewire.supplier.manage-supplier', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = Supplier::query()
            ->when($this->filter['name'], fn ($q, $name)  => $q->where('name', 'like', "%{$name}%"))
            ->when($this->filter['address'], fn ($q, $address)  => $q->where('address', 'like', "%{$address}%"));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function openNewSupplierModal()
    {
        $this->resetErrorBag();
        $this->reset();
        $this->dispatchBrowserEvent('openNewSupplierModal');
    }

    public function supplierConfirmDelete($supplier_id)
    {
        $this->supplierIdBeingRemoved = $supplier_id;
        $this->dispatchBrowserEvent('show-delete-notification');
    }

    public function supplierDeleteCancel()
    {
        $this->supplierIdBeingRemoved = null;
    }

    public function supplierDelete()
    {
        if ($this->supplierIdBeingRemoved != null) {
            $supplier  = Supplier::findorFail($this->supplierIdBeingRemoved);
            $supplier->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Supplier deleted successfully']);
        }
        return redirect()->back();
    }

    public function openEditSupplierModal($supplier_id)
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->supplier_id = $supplier_id;

        $supplier       = Supplier::query()->findOrFail($supplier_id);
        $this->name     = $supplier->name;
        $this->phone    = $supplier->phone;
        $this->address  = $supplier->address;
        $this->active   = $supplier->is_active;

        $this->dispatchBrowserEvent('openNewSupplierModal');
    }

    public function submit()
    {
        $rules = [
            'name'    => 'required',
            'address' => 'required',
        ];

        $messages = [
            'name.required'    => 'Name field id required',
            'address.required' => 'Address field is required'
        ];

        $this->validate($rules, $messages);

        if (! $this->supplier_id) {
            $this->save();
        } else {
            $this->update();
        }

        $this->reset();
        $this->hideModal();
    }

    public function save()
    {
        $data['name']      = $this->name;
        $data['phone']     = $this->phone;
        $data['address']   = $this->address;
        $data['is_active'] = $this->active;
        Supplier::create($data);

        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Supplier', 'message' => 'Supplier created successfully']);
    }

    public function update()
    {
        try {
            $supplier             = Supplier::find($this->supplier_id);
            $supplier->name       = $this->name;
            $supplier->phone      = $this->phone;
            $supplier->address    = $this->address;
            $supplier->is_active  = $this->active;
            $supplier->save();

            $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Supplier', 'message' => 'Supplier updated successfully']);
        } catch (\Exception $ex) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Supplier', 'message' => 'Unable to update']);
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
