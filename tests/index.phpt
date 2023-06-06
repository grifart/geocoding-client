<?php declare(strict_types = 1);

use Grifart\GeocodingClient\GeocodingProvider;
use Grifart\GeocodingClient\Providers\Cache\CacheManager;
use Grifart\GeocodingClient\Providers\Cache\CacheProvider;
use Grifart\GeocodingClient\Providers\MapyCz\MapyCzProvider;
use Tester\Assert;


require_once __DIR__ . '/bootstrap.php';


$testOn = function (
	GeocodingProvider $provider,
	float $expectedX,
	float $expectedY,
): void {
	$results = $provider->geocode('Botanická 68a, Brno');
	$result = reset($results);

	Assert::same($expectedX, $result->getLongitude());
	Assert::same($expectedY, $result->getLatitude());
};


// mapy.cz
$testOn(
	new MapyCzProvider(),
	16.598916307925386,
	49.20998332072665,
);

// cached mapy.cz
$testOn(
	$client = new CacheProvider(
		new CacheManager(__DIR__ . '/tmp/cache/deeper'),
		new MapyCzProvider(),
	),
	16.598916307925386,
	49.20998332072665,
);
