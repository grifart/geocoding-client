<?php

use Grifart\GeocodingClient\MapyCz\Communicator;
use Grifart\GeocodingClient\MapyCz\Mapping\Mapper;
use Grifart\GeocodingClient\MapyCz\MapyCzGeocodingService;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

$client = new MapyCzGeocodingService(new Communicator(), new Mapper());
$results = $client->geocodeAddress('Botanická 68a, Brno');
$result = \reset($results);

Assert::same(49.2099833207, $result->getLatitude());
Assert::same(16.5989163079, $result->getLongitude());
