<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth as IlluminateAuth;

class LogoutButton extends Component
{
    public function render()
    {
        return view('livewire.logout-button');
    }

    public function logout()
    {
        IlluminateAuth::logout();

        $this->redirectRoute('login');
    }
}
