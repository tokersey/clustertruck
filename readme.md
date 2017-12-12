# ClusterTruck Closest Kitchen Drive Time

This is a test project to get the closest ClusterTruck kitchen to the given destination. It is built using Laravel 5.

There are 3 routes available.

*Kitchens - /api/kitchens*

GET route which returns the list of kitchen addresses.

*Drive Time Using the Directions API - /api/kitchens/getDriveTimeByDirections*

POST route that provides the closest location drive time. This route makes a multiple requests to the Directions API.

This route expects a POST JSON body.

```
{
  "address":"Some Address, Town, State"
}
```

*Drive Time Using the Distance Matrix API - /api/kitchens/getDriveTimeByDistanceMatrix*

POST route that provides the closest location drive time. This route makes a single request to the Distance Matrix API.

This route expects a POST JSON body.

```
{
  "address":"Some Address, Town, State"
}
```

## Install and run

Clone the repo

Run `composer install`

Create a .env file and place the following setting in the file

```
CLUSTERTRUCK_API_URL=https://api.staging.clustertruck.com/api/kitchens

GOOGLE_MAPS_DIRECTIONS_URL=https://maps.googleapis.com/maps/api/directions/json
GOOGLE_MAPS_DISTANCE_URL=https://maps.googleapis.com/maps/api/distancematrix/json
GOOGLE_MAPS_API_KEY=
```

Get an API key from the [Google Maps Directions API](https://developers.google.com/maps/documentation/directions/)

Include the DistanceMatrix in the available apps in for Google's API.

Start up the server

```
$ php artisan serve
```
