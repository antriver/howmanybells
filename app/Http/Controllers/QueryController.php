<?php

namespace App\Http\Controllers;

use App\Data\DataManager;
use App\Data\ItemTypeEnum;
use App\Data\QueryLogger;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class QueryController extends Controller
{
    public function query(
        Request $request,
        DataManager $dataManager,
        QueryLogger $logger
    ) {
        $q = $request->input('q', '');

        if (empty($q)) {
            return "Sorry, I didn't recognise that.";
        }

        $logger->info($q);

        $item = $dataManager->findItem($q);

        if (empty($item)) {
            return "Sorry, I couldn't find any info about a \"".htmlentities($q)."\".";
        }

        $response = "A {$item->name} is worth ".number_format($item->price)." bells";

        if ($item->type === ItemTypeEnum::FISH) {
            $cjPrice = $item->price * 1.5;
            $response .= ", or ".number_format($cjPrice)." bells if you sell it to C.J.";
        } elseif ($item->type === ItemTypeEnum::BUG) {
            $flickPrice = $item->price * 1.5;
            $response .= ", or ".number_format($flickPrice)." bells if you sell it to Flick";
        }

        $response .= ".";

        return $response;
    }
}
