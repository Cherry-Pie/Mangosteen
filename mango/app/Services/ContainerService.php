<?php

namespace App\Services;

use Illuminate\Support\Str;

class ContainerService
{
    public function list(string $search = null)
    {
        $result = shell_exec('docker ps -a --filter network=mangosteen --format json');
        $lines = array_filter(explode("\n", $result));

        $containers = array_map(static function (string $line): array {
            return json_decode($line, true);
        }, $lines);

        if ($search) {
            $containers = collect($containers)->filter(function ($container) use ($search) {
                return Str::contains($container['ID'], $search, true)
                    || Str::contains($container['Names'], $search, true)
                    || Str::contains($container['Image'], $search, true);
            });
        }

        return $containers;
    }

    public function getNameFromId($id): string
    {

        $result = shell_exec(sprintf('docker ps -a --filter id=%s --format json', $id));
        $lines = array_filter(explode("\n", $result));

        $containers = array_map(static function (string $line): array {
            return json_decode($line, true);
        }, $lines);

        return (string)$containers[0]['Names'];
    }
}
