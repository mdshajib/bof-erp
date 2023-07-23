<?php

namespace App\Http\Livewire\Supplier;

use App\Http\Livewire\BaseComponent;
use App\Models\Supplier;
use App\Services\SupplierManagementService;
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

    public $filter = [
        'name'     => null,
        'address'  => null
    ];

    public $supplier = [
        'name'     => null,
        'phone'    => null,
        'address'  => null,
        'active'   => true,
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
        try {
            if ($this->supplierIdBeingRemoved != null) {
                $status = (new SupplierManagementService())->delete($this->supplierIdBeingRemoved );
                if($status) {
                    $this->dispatchBrowserEvent('deleted', ['message' => 'Supplier deleted successfully']);
                }
            }
        }
        catch(Exception $ex) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Supplier', 'message' => $ex->getMessage() ]);
        }
    }

    public function openEditSupplierModal($supplier_id)
    {
        try{
            $this->resetErrorBag();
            $this->resetValidation();
            $this->supplier_id = $supplier_id;
            $supplier = (new SupplierManagementService())->showSupplier($supplier_id);
            if(count($supplier) > 0) {
                $this->supplier = $supplier;
            }
            $this->dispatchBrowserEvent('openNewSupplierModal');

        } catch(Exception $ex) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Supplier', 'message' => $ex->getMessage() ]);
        }

    }

    public function submit()
    {
        $rules = [
            'supplier.name'    => 'required',
            'supplier.address' => 'required',
            'supplier.phone'   => 'nullable|numeric',
        ];

        $messages = [
            'supplier.name.required'    => 'Name field id required',
            'supplier.address.required' => 'Address field is required'
        ];

        $this->validate($rules, $messages);

        try {
            if (! $this->supplier_id) {
                $status = (new SupplierManagementService())->save( $this->supplier);
                if($status) {
                    $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Supplier', 'message' => 'Supplier created successfully']);
                }
            } else {
                $status = (new SupplierManagementService())->update($this->supplier_id, $this->supplier);
                if($status) {
                    $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Supplier', 'message' => 'Supplier updated successfully']);
                }
            }

            $this->reset();
            $this->hideModal();
        } catch (Exception $ex) {

            $this->reset();
            $this->hideModal();
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Supplier', 'message' => $ex->getMessage() ]);
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
