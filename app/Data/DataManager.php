<?php

namespace App\Data;

class DataManager
{
    public function getCombinedJsonPath(): string
    {
        return storage_path().'/combined-items.json';
    }

    public function getCombinedItems(): object
    {
        return json_decode(file_get_contents($this->getCombinedJsonPath()));
    }

    public function getJsonPath(string $filename): string
    {
        return __DIR__.'/../../animal-crossing-scraper/data/'.$filename.'.json';
    }

    public function getFileData(string $filename): object
    {
        $path = $this->getJsonPath($filename);
        $contents = file_get_contents($path);
        return json_decode($contents);
    }

    public function findItem(string $name): ?object
    {
        $name = self::sanitizeName($name);
        $allItems = $this->getCombinedItems();

        if (!empty($allItems->{$name})) {
            return $allItems->{$name};
        }

        // Try with no spaces.
        $name = str_replace(' ', '', $name);
        if (!empty($allItems->{$name})) {
            return $allItems->{$name};
        }

        return null;
    }

    public static function sanitizeName(string $name): string
    {
        return ucwords(strtolower($name));
    }
}
