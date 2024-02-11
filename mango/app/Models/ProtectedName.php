<?php

namespace App\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Carbon;

class ProtectedName implements Arrayable
{
    private string $name;
    private Carbon $date;

    public function __construct(string $name, Carbon $date)
    {
        $this->name = $name;
        $this->date = $date;
    }

    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'date' => $this->getDate()->toIso8601String(),
        ];
    }
}
