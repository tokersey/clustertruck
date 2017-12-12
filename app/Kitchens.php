<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;

class Kitchens extends Model
{
    static public function getKitchenAddressData()
    {
        $client = new Client();
        $request = $client->request('GET', env('CLUSTERTRUCK_API_URL'));

        $kitchenList = [];
        foreach(json_decode($request->getBody()) as $kitchen){
            $kitchenList[$kitchen->slug]['name']    = $kitchen->name;
            $kitchenList[$kitchen->slug]['address'] = $kitchen->address_1 . "+" . $kitchen->city . "+" . $kitchen->state . "+" . $kitchen->zip_code;
        }

        return $kitchenList;
    }
}
