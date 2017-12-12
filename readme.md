# ClusterTruck Closest Kitchen Drive Time

This is a test project to get the closest ClusterTruck kitchen to the given destination. It is built using Laravel 5.

There are 3 routes available.

Kitchens - /kitchens

GET route which returns the list of kitchen addresses.

Drive Time Using the Directions API - /api/kitchens/getDriveTimeByDirections

POST route that provides the closest location drive time. This route makes a multiple requests to the Directions API.

Drive Time Using the Distance Matrix API - /api/kitchens/getDriveTimeByDistanceMatrix

POST route that provides the closest location drive time. This route makes a single request to the Distance Matrix API.

## Install
