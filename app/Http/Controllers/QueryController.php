<?php

namespace App\Http\Controllers;

use App\Data\DataManager;
use App\Data\ItemTypeEnum;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class QueryController extends Controller
{
    public function query(
        Request $request,
        DataManager $dataManager
    ) {
        $q = $request->input('q');

        $item = $dataManager->findItem($q);

        if (empty($item)) {
            echo "Sorry, I couldn't find that item.";
            return;
        }

        echo "A {$item->name} is worth {$item->price} bells.";

        if ($item->type === ItemTypeEnum::FISH) {
            $cjPrice = $item->price * 1.5;
            echo " Or {$cjPrice} bells if sold to C.J.";
        } elseif ($item->type === ItemTypeEnum::BUG) {
            $flickPrice = $item->price * 1.5;
            echo " Or {$flickPrice} bells if sold to Flick.";
        }

        return;
    }
}
