<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kitchens;
use GuzzleHttp\Client;

class KitchenController extends Controller
{
    public function getKitchens()
    {
        return Kitchens::getKitchenAddressData();
    }

    public function getDriveTimeByDirections($request)
    {
        // https://maps.googleapis.com/maps/api/directions/json?origin=Disneyland&destination=Universal+Studios+Hollywood4&key=
        $kitchens = $this->getKitchens();
        $url = env("GOOGLE_MAPS_DIRECTIONS_URL");
        $key = env("GOOGLE_MAPS_API_KEY");
        $client = new Client();

        foreach($kitchens as $kitchen){
            $gmaps = $url . "?origin=" . $request->address . "&destination=" . $kitchen['address'] . "&key=" .$key;

            $grequest = $client->request('GET', str_replace(' ', '+', $gmaps));
            $json = json_decode($grequest->getBody());

            if(!isset($closestLocation) || $json->routes[0]->legs[0]->duration->value < $closestLocation['driveTimeMinutes']){
                $closestLocation['address'] = $json->routes[0]->legs[0]->end_address;
                $closestLocation['totalDriveTime'] = $json->routes[0]->legs[0]->duration->text;
                $closestLocation['driveTimeMinutes'] = $json->routes[0]->legs[0]->duration->value;
            }
        }

        return $closestLocation;
    }

    public function getDriveTimeByDistanceMatrix()
    {
        // https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=Washington,DC&destinations=New+York+City,NY&key=YOUR_API_KEY
    }
}
