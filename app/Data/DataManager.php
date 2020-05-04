<?php

namespace App\Data;

use Doctrine\Common\Inflector\Inflector;

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

    public function getAlexaSlotValuesCsvPath(): string
    {
        return storage_path().'/alexa-slot-values.csv';
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
        $allItems = $this->getCombinedItems();

        $searches = [
            $name,
            rtrim($name, 's'), // Remove 's' at the end
            Inflector::singularize($name),
        ];

        foreach ($searches as $q) {
            $q = self::sanitizeName($q);

            if (!empty($allItems->{$q})) {
                return $allItems->{$q};
            }
        }

        return null;
    }

    private function getItem(string $name): ?object
    {
        $allItems = $this->getCombinedItems();

        if (!empty($allItems->{$name})) {
            return $allItems->{$name};
        }

        return null;
    }

    public static function sanitizeName(string $name): string
    {
        return preg_replace('/[^a-zA-Z0-9]+/', '', strtolower($name));
    }
}
