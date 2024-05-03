<?php

namespace App\Data;

use Doctrine\Inflector\InflectorFactory;
use stdClass;

class DataManager
{
    public function getCombinedJsonPath(): string
    {
        return storage_path().'/combined-items.json';
    }

    public function getCombinedItems(): stdClass
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

    public function getFileData(string $filename): stdClass
    {
        $path = $this->getJsonPath($filename);
        $contents = file_get_contents($path);

        return json_decode($contents);
    }

    public function findItem(string $name): ?stdClass
    {
        $allItems = $this->getCombinedItems();

        $stripped = preg_replace("/^(a|an|are)\s/", '', $name); // Remove 'are' at the start which Alexa likes to add
        $stripped =  preg_replace("/\s(as)$/", '', $stripped);

        $inflector = InflectorFactory::create()->build();

        $searches = [
            $name,
            rtrim($name, 's'), // Remove 's' at the end
            $inflector->singularize($name),
            $stripped,
            $inflector->singularize($stripped),
        ];

        foreach ($searches as $q) {
            $q = self::sanitizeName($q);

            if (!empty($allItems->{$q})) {
                return $allItems->{$q};
            }
        }

        return null;
    }

    private function getItem(string $name): ?stdClass
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
