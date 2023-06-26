<?php

namespace App\Http\Livewire\Users;

use App\Http\Livewire\BaseComponent;
use App\Models\Role;
use App\Models\User;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;

class ManageUser extends BaseComponent
{
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;
    use WithBulkActions;

    protected $listeners = ['deleteConfirm' => 'userDelete', 'deleteCancel' => 'userDeleteCancel'];

    public $user_id;

    public $first_name;

    public $last_name;

    public $email;

    public $password;

    public $role;

    public $active = true;

    protected $userRepository;

    public $filter = [
        'name'     => null,
        'email'    => null
    ];


    public function mount()
    {
        //
    }

    public function render()
    {
        $data['users'] = $this->rows;
        $data['roles'] = Role::query()->orderBy('name','ASC')->get();
        return $this->view('livewire.users.manage-user', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = User::query()
            ->when($this->filter['name'], fn ($q, $name)  => $q->where('first_name', 'like', "%{$name}%"))
            ->when($this->filter['email'], fn ($q, $email)  => $q->where('email', 'like', "%{$email}%"));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function openNewUserModal()
    {
        $this->resetErrorBag();
        $this->reset();
        $this->dispatchBrowserEvent('openNewUserModal');
    }

    public function openEditUserModal($user_id)
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->user_id = $user_id;

        $user             = User::query()->findOrFail($user_id);
        $this->first_name = $user->first_name;
        $this->last_name  = $user->last_name;
        $this->email      = $user->email;
        $this->role       = $user->role;
        $this->active     = $user->is_active;

        $this->dispatchBrowserEvent('openNewUserModal');
    }

    public function submit()
    {
        $rules = [
            'first_name' => 'required',
            'role'       => 'required',
        ];

        if (! $this->user_id) {
            $rules['email']    = 'required|email|unique:users,email';
            $rules['password'] = 'required';
        }

        $messages = [
            'first_name.required' => 'First Name required',
            'email.required'      => 'Email required',
            'password.required'   => 'Password required',
            'role.required'       => 'Role required',
        ];

        $this->validate($rules, $messages);

        if (! $this->user_id) {
            $this->save();
        } else {
            $this->update();
        }

        $this->reset();
        $this->hideModal();
    }

    public function save()
    {
        $data['first_name'] = $this->first_name;
        $data['last_name']  = $this->last_name;
        $data['email']      = $this->email;
        $data['password']   = bcrypt($this->password);
        $data['is_active']  = $this->active;
        $data['role']       = $this->role;
        User::create($data);

        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Active', 'message' => 'User created successfully']);
    }

    public function update()
    {
        try {
            $user             = User::find($this->user_id);
            $user->first_name = $this->first_name;
            $user->last_name  = $this->last_name;
            $user->is_active  = $this->active;
            $user->role       = $this->role;
            $user->save();

            $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Active', 'message' => 'User updated successfully']);
        } catch (\Exception $ex) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Active', 'message' => 'Unable to update']);
        }
    }

    public function UserconfirmDelete($contact_id)
    {
        $this->userIdBeingRemoved = $contact_id;
        $this->dispatchBrowserEvent('show-delete-notification');
    }

    public function userDeleteCancel()
    {
        $this->userIdBeingRemoved = null;
    }

    public function userDelete()
    {
        if ($this->userIdBeingRemoved != null) {
            $user  = User::findorFail($this->userIdBeingRemoved);
            $user->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'User deleted successfully']);
        }
        return redirect()->back();
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
