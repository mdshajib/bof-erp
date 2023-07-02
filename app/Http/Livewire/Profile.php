<?php

namespace App\Http\Livewire;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Profile extends BaseComponent
{
    public $email;
    public $first_name;
    public $last_name;
    public $lang = 'en';
    public $activeTab = 'profile';
    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $this->getProfile();
    }

    public function render()
    {
        return $this->view('livewire.profile');
    }

    private function getProfile()
    {
        $user = User::find(auth()->user()->id);
        $this->email      = $user->email;
        $this->first_name = $user->first_name;
        $this->last_name  = $user->last_name;
        $this->lang       = $user->lang;
    }

    public function updateProfile()
    {
        try {
            $rules = [
                'email'       => 'required|email|unique:users,email,'.auth()->user()->id.',id',
                'first_name'  => 'required',
                'last_name'   => 'required',
                'lang'        => 'required',
            ];

            $this->validate($rules);

            User::where('id', auth()->user()->id)->update([
                'email'      => $this->email,
                'first_name' => $this->first_name,
                'last_name'  => $this->last_name,
                'lang'       => $this->lang,
            ]);
            auth()->user()->fresh();
            $this->getProfile();

            $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Profile Update', 'message' => 'Profile Update successfully']);
        } catch (\Exception $e){
            $this->getProfile();
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Profile Update', 'message' => $e->getMessage() ]);
        }
    }

    public function updatePassword()
    {
        try {

            $rules = [
                'current_password' => 'required',
                'password'         => 'required|min:6|confirmed',
            ];

            $this->validate($rules);

            $user = User::find(auth()->user()->id);
            if(!Hash::check($this->current_password, $user->password)){
                throw new \Exception("Current Password not match");
            }

            $user->password = bcrypt($this->password);
            $user->save();
            auth()->user()->fresh();
            $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Password Update', 'message' => 'Password Update successfully']);
        } catch (\Exception $e){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Password Update', 'message' => $e->getMessage() ]);
        }
    }

    public function stepActive($step)
    {
        if ($step==1) {
            $this->activeTab='profile';
        } elseif ($step==2) {
            $this->activeTab='password';
        }
    }
}
