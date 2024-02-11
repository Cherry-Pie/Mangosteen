<?php

namespace App\Livewire;

use App\Models\ProtectedName;
use App\Services\ContainerService;
use App\Services\ProtectedNamesService;
use App\Util\Exec\Exec;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Containers extends Component
{
    #[Validate('required')]
    public string $name = '';

    #[Validate('required')]
    public string $image = '';

    #[Validate('required')]
    public string $virtualhost = '';

    #[Validate('required')]
    public string $letsencrypthost = '';

    #[Validate('required|integer|between:1,65535')]
    public int $virtualport;

    public array $beforeOutput = [];
    public ?int $beforeFailureCode;
    public array $afterOutput = [];
    public ?int $afterFailureCode;
    public array $dockerOutput = [];
    public ?int $dockerFailureCode;

    public string $search = '';

    public function render(ContainerService $service)
    {
        return view('livewire.containers')->with([
            'containers' => $service->list($this->search),
        ]);
    }

    public function add(ContainerService $service)
    {
        $this->validate();

        $result = Exec::run(app_path('run.before.sh'), [
            'CONTAINER_NAME' => $this->name,
            'VIRTUAL_PORT' => $this->virtualport,
            'VIRTUAL_HOST' => sprintf('%s.%s', $this->virtualhost, config('mango.mangosteen_domain')),
            'LETSENCRYPT_HOST' => sprintf('%s.%s', $this->letsencrypthost, config('mango.mangosteen_domain')),
            'SUBDOMAIN_VIRTUAL_HOST' => $this->virtualhost,
            'SUBDOMAIN_LETSENCRYPT_HOST' => $this->letsencrypthost,
            'IMAGE' => $this->image,
        ]);
        $this->beforeOutput = $result->output();
        $this->beforeFailureCode = $result->code();
        if (!$result->ok()) {
            $this->dispatch('toastify', ['text' => 'Before script failed']);
            return;
        }

        $command = sprintf(
            'docker run --rm --name %s --label=com.centurylinklabs.watchtower.enable=true -e VIRTUAL_HOST=%s -e LETSENCRYPT_HOST=%s -e VIRTUAL_PORT=%s --network mangosteen -d %s',
            $this->name,
            sprintf('%s.%s', $this->virtualhost, config('mango.mangosteen_domain')),
            sprintf('%s.%s', $this->letsencrypthost, config('mango.mangosteen_domain')),
            $this->virtualport,
            $this->image
        );
        $result = Exec::run($command);
        $this->dockerOutput = $result->output();
        $this->dockerFailureCode = $result->code();
        if (!$result->ok()) {
            $this->dispatch('toastify', ['text' => 'Docker run failed']);
            return;
        }


        $result = Exec::run(app_path('run.after.sh'), [
            'CONTAINER_NAME' => $this->name,
            'VIRTUAL_PORT' => $this->virtualport,
            'VIRTUAL_HOST' => sprintf('%s.%s', $this->virtualhost, config('mango.mangosteen_domain')),
            'LETSENCRYPT_HOST' => sprintf('%s.%s', $this->letsencrypthost, config('mango.mangosteen_domain')),
            'SUBDOMAIN_VIRTUAL_HOST' => $this->virtualhost,
            'SUBDOMAIN_LETSENCRYPT_HOST' => $this->letsencrypthost,
            'IMAGE' => $this->image,
        ]);
        $this->afterOutput = $result->output();
        $this->afterFailureCode = $result->code();
        if (!$result->ok()) {
            $this->dispatch('toastify', ['text' => 'After script failed']);
            return;
        }


        $this->dispatch('toastify', ['text' => 'Processing']);
    }

    public function flushBeforeOutput()
    {
        $this->beforeFailureCode = null;
        $this->beforeOutput = [];
    }

    public function flushAfterOutput()
    {
        $this->afterFailureCode = null;
        $this->afterOutput = [];
    }

    public function flushDockerOutput()
    {
        $this->dockerFailureCode = null;
        $this->dockerOutput = [];
    }

    public function stop(ContainerService $service, ProtectedNamesService $protectedNamesService, $id)
    {
        $containerName = $service->getNameFromId($id);
        if ($protectedNamesService->isProtected($containerName)) {
            $this->dispatch('toastify', ['text' => 'Protected container', 'type' => 'danger']);
            return;
        }

        $result = Exec::run(app_path('stop.before.sh'), [
            'CONTAINER_ID' => $id,
            'CONTAINER_NAME' => $containerName,
        ]);
        $this->beforeOutput = $result->output();
        $this->beforeFailureCode = $result->code();
        if (!$result->ok()) {
            $this->dispatch('toastify', ['text' => 'Before script failed']);
            return;
        }

        $result = Exec::run(sprintf('docker stop %s', $id));
        $this->dockerOutput = $result->output();
        $this->dockerFailureCode = $result->code();
        if (!$result->ok()) {
            $this->dispatch('toastify', ['text' => 'Docker stop failed']);
            return;
        }

        $result = Exec::run(app_path('stop.after.sh'), [
            'CONTAINER_ID' => $id,
            'CONTAINER_NAME' => $containerName,
        ]);
        $this->afterOutput = $result->output();
        $this->afterFailureCode = $result->code();
        if (!$result->ok()) {
            $this->dispatch('toastify', ['text' => 'After script failed']);
            return;
        }

        $this->dispatch('toastify', ['text' => 'Stopped']);
//        $this->dispatch('$refresh');
    }
}
