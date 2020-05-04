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

        foreach ($filenames as $filename) {
            $theseItems = $dataManager->getFileData($filename);
            foreach ($theseItems as $key => $thisItem) {
                $thisItem = (array) $thisItem;
                $key = DataManager::sanitizeName($key);

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

        file_put_contents($dataManager->getCombinedJsonPath(), json_encode($allItems, JSON_PRETTY_PRINT));
    }
}
