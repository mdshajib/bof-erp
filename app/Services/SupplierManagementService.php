<?php

namespace App\Services;

use App\Models\Supplier;
use Exception;

class SupplierManagementService
{
     public function showSupplier($supplier_id)
     {
        try
        {
            $supplier       = Supplier::query()->findOrFail($supplier_id);
            $supplier_data = [
                'name'     => $supplier->name,
                'phone'    => $supplier->phone,
                'address'  => $supplier->address,
                'active'   => $supplier->is_active,
            ];
           return $supplier_data;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }

    public function save($supplier)
    {
        try {
            $data['name']      = $supplier['name'];
            $data['phone']     = $supplier['phone'];
            $data['address']   = $supplier['address'];
            $data['is_active'] = $supplier['active'];

            return Supplier::create($data);

        } catch(Exception $ex) {
            throw $ex;
        }
    }

    public function update($supplier_id, $supplier)
    {
        try {
            $supplier_info             = Supplier::find($supplier_id);
            $supplier_info->name       = $supplier['name'];
            $supplier_info->phone      = $supplier['phone'];
            $supplier_info->address    = $supplier['address'];
            $supplier_info->is_active  = $supplier['active'];
            $supplier_info->save();

            return $supplier_info;

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function delete($supplierIdBeingRemoved)
    {
        try {
            if ($supplierIdBeingRemoved != null) {
                $supplier  = Supplier::findorFail($supplierIdBeingRemoved);
                $supplier->delete();
            }
            return $supplier;
        }
        catch (Exception $ex) {
            throw $ex;
        }
    }
}
