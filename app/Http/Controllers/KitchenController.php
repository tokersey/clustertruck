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
        $client = new Client();

        $closestLocation = [];
        foreach($kitchens as $kitchen){
            $directionsUrl = env("GOOGLE_MAPS_DIRECTIONS_URL") . "?origin=" . $request->address . "&destination=" . $kitchen['address'] . "&key=" . env("GOOGLE_MAPS_API_KEY");

            $direction_request = $client->request('GET', str_replace(' ', '+', $directionsUrl));
            $json = json_decode($direction_request->getBody());

            if(!isset($closestLocation['driveTime']) || $json->routes[0]->legs[0]->duration->value < $closestLocation['minutes']){
                $closestLocation['address'] = $json->routes[0]->legs[0]->end_address;
                $closestLocation['driveTime'] = $json->routes[0]->legs[0]->duration->text;
                $closestLocation['minutes'] = $json->routes[0]->legs[0]->duration->value;
            }
        }

        return $closestLocation;
    }

    public function getDriveTimeByDistanceMatrix($request)
    {
        // https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=Washington,DC&destinations=New+York+City,NY&key=YOUR_API_KEY
        $kitchens = $this->getKitchens();
        $client = new Client();

        $destinationAddresses = "";
        foreach($kitchens as $kitchen){
            $destinationAddresses = $destinationAddresses . "|" . str_replace(' ', '+', $kitchen['address']);
        }

        $distanceUrl = env("GOOGLE_MAPS_DISTANCE_URL") . "?origins=" . $request->address . "&destinations=" . $destinationAddresses . "&key=" . env("GOOGLE_MAPS_API_KEY");

        $distanceRequest = $client->request('GET', str_replace(' ', '+', $distanceUrl));
        $json = json_decode($distanceRequest->getBody());

        $closestLocation = [];
        foreach($json->rows[0]->elements as $key => $kitchen){
            if(!isset($closestLocation['driveTime']) || $kitchen->duration->value < $closestLocation['minutes']){
                $closestLocation['address'] = $json->destination_addresses[$key];
                $closestLocation['driveTime'] = $kitchen->duration->text;
                $closestLocation['minutes'] = $kitchen->duration->value;
            }
        }

        return $closestLocation;
    }
}
