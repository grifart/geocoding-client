<?php

use Grifart\GeocodingClient\Caching\CachedGeocodingService;
use Grifart\GeocodingClient\Caching\CacheManager;
use Grifart\GeocodingClient\GeocodingService;
use Grifart\GeocodingClient\MapyCz\Communicator;
use Grifart\GeocodingClient\MapyCz\Mapping\Mapper;
use Grifart\GeocodingClient\MapyCz\MapyCzGeocodingService;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';


$testOn = function (
	GeocodingService $client,
	float $expectedX,
	float $expectedY,
): void {
	$results = $client->geocodeAddress('Botanická 68a, Brno');
	$result = \reset($results);

	Assert::same($expectedX, $result->getLongitude());
	Assert::same($expectedY, $result->getLatitude());
};


// mapy.cz
$testOn(
	new MapyCzGeocodingService(new Communicator(), new Mapper()),
	16.598916307925386,
	49.20998332072665,
);

// cached mapy.cz
$testOn(
	$client = new CachedGeocodingService(
		new CacheManager(__DIR__ . '/tmp/cache/deeper'),
		new MapyCzGeocodingService(new Communicator(), new Mapper()),
	),
	16.598916307925386,
	49.20998332072665,
);
