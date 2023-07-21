<?php

namespace App\Services;

use App\Models\Contact;
use Exception;

class ContactService
{
     public function getContact($contact_id)
     {
        try
        {
            return Contact::query()->find($contact_id);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }

    public function getAllSpecialContacts()
    {
        try
        {
            return Contact::query()->where('special', 1)->get();
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function save($contact)
    {
        try
        {
            $data ['name']     = $contact['name'];
            $data ['phone']    = $contact['phone'];
            $data ['email']    = $contact['email'] ?? null;
            $data ['batch_no'] = $contact['batch_no'] ?? null;
            $data ['address']  = $contact['address'] ?? null;
            $data ['special']  = $contact['special'] ?? 0;
            return Contact::create($data);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function update($contact_id, $contact)
    {
        try {
            $contact_find           = Contact::query()->find($contact_id);
            $contact_find->name     = $contact['name'];
            $contact_find->phone    = $contact['phone'];
            $contact_find->email    = $contact['email'] ?? null;
            $contact_find->batch_no = $contact['batch_no'] ?? null;
            $contact_find->address  = $contact['address'] ?? null;
            $contact_find->save();
            return $contact_find;
        } catch ( Exception $ex) {
            throw $ex;
        }
    }

    public function deleteContact($contactIdBeingRemoved)
    {
        try {
            $contact  = Contact::findorFail($contactIdBeingRemoved);
            $contact->delete();
            return true;
        } catch ( Exception $ex) {
            throw $ex;
        }
    }

    public function contactFindByPhone($phone)
    {
        try {
            return Contact::query()
                ->select('id','name','special')
                ->where('phone', $phone)->first();
        } catch ( Exception $ex) {
            throw $ex;
        }
    }

}
