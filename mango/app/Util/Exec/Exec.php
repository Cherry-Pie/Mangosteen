<?php

namespace App\Util\Exec;

class Exec
{
    private array $out = [];
    private int $code;

    private function __construct(array $out, int $code)
    {
        $this->out = $out;
        $this->code = $code;
    }

    public static function run(string $command, array $envs = [])
    {
        $envs = array_map(static function($value, $name): string {
            return $name .'='. $value;
        }, $envs, array_keys($envs));

        $command = implode(' ', $envs) .' '. $command;

        exec($command, $out, $code);

        logger($out);
        return new self($out, $code);
    }

    public function output(): array
    {
        return $this->out;
    }

    public function code(): int
    {
        return $this->code;
    }

    public function ok(): bool
    {
        return $this->code === 0;
    }
}
