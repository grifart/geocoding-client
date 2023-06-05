<?php declare(strict_types = 1);

use Grifart\GeocodingClient\Caching\CachedGeocoding;
use Grifart\GeocodingClient\Caching\CacheManager;
use Grifart\GeocodingClient\Geocoding;
use Grifart\GeocodingClient\MapyCz\Client\ApiClient;
use Grifart\GeocodingClient\MapyCz\MapyCzGeocoding;
use Tester\Assert;


require_once __DIR__ . '/bootstrap.php';


$testOn = function (
	Geocoding $service,
	float $expectedX,
	float $expectedY,
): void {
	$results = $service->geocode('Botanická 68a, Brno');
	$result = reset($results);

	Assert::same($expectedX, $result->getLongitude());
	Assert::same($expectedY, $result->getLatitude());
};


// mapy.cz
$testOn(
	new MapyCzGeocoding(new ApiClient()),
	16.598916307925386,
	49.20998332072665,
);

// cached mapy.cz
$testOn(
	$client = new CachedGeocoding(
		new CacheManager(__DIR__ . '/tmp/cache/deeper'),
		new MapyCzGeocoding(new ApiClient()),
	),
	16.598916307925386,
	49.20998332072665,
);
