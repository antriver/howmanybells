<?php

namespace App\Console\Commands;

use App\Data\DataManager;
use App\Data\ItemTypeEnum;
use App\DripEmailer;
use App\User;
use Illuminate\Console\Command;

class CombineJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'combine-json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Combine all the data from the animal-crossing-scraper project into a single JSON file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param DataManager $dataManager
     */
    public function handle(DataManager $dataManager)
    {
        $filenames = ItemTypeEnum::allFilenames();
        $itemTypes = array_flip($filenames);

        $allItems = [];

        /**
         * Slot values for the Alexa skill. This is basically just a list of all item names.
         * VALUE, ID, SYNONYM1, SYNONYM2, …
         */
        $slotValues = [];

        foreach ($filenames as $filename) {
            $theseItems = $dataManager->getFileData($filename);
            foreach ($theseItems as $key => $thisItem) {
                $thisItem = (array) $thisItem;
                $key = DataManager::sanitizeName($key);

                $slotValues[] = [
                    $thisItem['name'],
                    count($slotValues) + 1
                ];

                $thisItem['type'] = $itemTypes[$filename];

                if (array_key_exists($key, $allItems)) {
                    echo "Duplicate key {$key}".PHP_EOL;
                    print_r($allItems[$key]);
                    print_r($thisItem);
                    die();
                }

                $allItems[$key] = $thisItem;
            }
        }

        // Write the combined json file.
        file_put_contents($dataManager->getCombinedJsonPath(), json_encode($allItems, JSON_PRETTY_PRINT));

        // Write a csv file for the Alexa skill containing all possible slot values.
        $slotFile = fopen($dataManager->getAlexaSlotValuesCsvPath(), 'w+');
        foreach ($slotValues as $line) {
            fputcsv($slotFile, $line);
        }
    }
}
