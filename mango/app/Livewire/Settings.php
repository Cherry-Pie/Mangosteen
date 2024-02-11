<?php

namespace App\Livewire;

use App\Services\ProtectedNamesService;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Settings extends Component
{
    #[Validate('required')]
    public string $name = '';

    public function render(ProtectedNamesService $service)
    {
        return view('livewire.settings')->with([
            'protected' => $service->list(),
        ]);
    }

    public function add(ProtectedNamesService $service)
    {
        $this->validate();

        $service->add($this->name, now());

        $this->name = '';

        $this->dispatch('toastify', ['text' => 'Added']);
    }

    public function delete(ProtectedNamesService $service, string $name)
    {
        $service->delete($name);

        $this->dispatch('toastify', ['text' => 'Deleted']);
    }
}
