<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Auth as IlluminateAuth;

#[Layout('layouts.auth')]
class Auth extends Component
{
    #[Validate('required')]
    public $password = '';

    public function render()
    {
        return view('livewire.auth');
    }

    public function login()
    {
        $credentials = $this->validate();

        if (IlluminateAuth::attempt($credentials, true)) {
            $this->redirectRoute('dashboard');
            return;
        }

        $this->password = '';

        $this->dispatch('toastify', ['text' => 'Wrong credentials', 'type' => 'danger']);
    }
}
