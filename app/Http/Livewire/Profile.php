<?php

namespace App\Http\Livewire;


class Profile extends BaseComponent
{
    public $email;
    public $first_name;
    public $last_name;
    public $lang = 'en';
    public $current_password;
    public $password;
    public $password_confirmation;

    public function render()
    {
        $this->getProfile();
        return $this->view('livewire.profile');
    }

    private function getProfile()
    {
        $this->email      = auth()->user()->email;
        $this->first_name = auth()->user()->first_name;
        $this->last_name  = auth()->user()->last_name;
        $this->lang       = auth()->user()->lang;
    }
}
