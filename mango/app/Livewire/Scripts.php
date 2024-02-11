<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Scripts extends Component
{
    public string $activeTab = 'beforeRun';
    public string $codeBeforeRun = '';
    public string $codeAfterRun = '';
    public string $codeBeforeStop = '';
    public string $codeAfterStop = '';

    public function mount()
    {
        $this->codeBeforeRun = Storage::disk('scripts')->get('run.before.sh');
        $this->codeAfterRun = Storage::disk('scripts')->get('run.after.sh');
        $this->codeBeforeStop = Storage::disk('scripts')->get('stop.before.sh');
        $this->codeAfterStop = Storage::disk('scripts')->get('stop.after.sh');
    }

    public function saveBeforeRun()
    {
        $this->activeTab = 'beforeRun';

        Storage::disk('scripts')->put('run.before.sh', $this->codeBeforeRun);

        $this->dispatch('toastify', ['text' => 'Saved']);
    }

    public function saveAfterRun()
    {
        $this->activeTab = 'afterRun';

        Storage::disk('scripts')->put('run.after.sh', $this->codeAfterRun);

        $this->dispatch('toastify', ['text' => 'Saved']);
    }

    public function saveBeforeStop()
    {
        $this->activeTab = 'beforeStop';

        Storage::disk('scripts')->put('stop.before.sh', $this->codeBeforeStop);

        $this->dispatch('toastify', ['text' => 'Saved']);
    }

    public function saveAfterStop()
    {
        $this->activeTab = 'afterStop';

        Storage::disk('scripts')->put('stop.after.sh', $this->codeAfterStop);

        $this->dispatch('toastify', ['text' => 'Saved']);
    }

    public function render()
    {
        return view('livewire.scripts');
    }
}
