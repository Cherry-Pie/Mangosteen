<?php

namespace App\Services;

use App\Models\ProtectedName;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProtectedNamesService
{
    private const FILENAME = 'protected_names.json';

    /**
     * @return Collection<ProtectedName>
     */
    public function list(): Collection
    {
        $protectedNames = json_decode(Storage::disk('scripts')->get($this->filepath()) ?? '[]', true);
        $protectedNames = array_map(static function ($item): ProtectedName {
            return new ProtectedName($item['name'], Carbon::parse($item['date']));
        }, $protectedNames);

        return collect($protectedNames);
    }

    public function add(string $name, Carbon $date): void
    {
        $protectedNames = $this->list();
        $protectedNames->add(new ProtectedName($name, Carbon::parse($date)));
        $protectedNames = $protectedNames->unique(fn(ProtectedName $protected) => $protected->getName());

        Storage::disk('scripts')->put($this->filepath(), json_encode($protectedNames->toArray(), JSON_PRETTY_PRINT));
    }

    public function delete(string $name): void
    {
        $protectedNames = $this->list();
        $protectedNames = $protectedNames->filter(static function (ProtectedName $protectedName) use ($name): bool {
            return $protectedName->getName() != $name;
        });

        Storage::disk('scripts')->put($this->filepath(), json_encode($protectedNames->toArray(), JSON_PRETTY_PRINT));
    }

    private function filepath(): string
    {
        return self::FILENAME;
    }

    public function isProtected(string $name): bool
    {
        foreach ($this->list() as $protectedName) {
            if ($protectedName->getName() == $name) {
                return true;
            }
        }

        return false;
    }
}
