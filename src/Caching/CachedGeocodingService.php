<?php

namespace Grifart\GeocodingClient\Caching;

use Grifart\GeocodingClient\GeocodingService;
use Grifart\GeocodingClient\Location;


final class CachedGeocodingService implements GeocodingService
{

	/** @var CacheManager */
	private $cacheManager;

	/** @var GeocodingService */
	private $geocodingService;


	public function __construct(CacheManager $cacheManager, GeocodingService $geocodingService)
	{
		$this->cacheManager = $cacheManager;
		$this->geocodingService = $geocodingService;
	}


	/**
	 * @param string $address
	 * @return Location[]
	 */
	public function geocodeAddress($address)
	{
		// if possible, get results from cache
		$cachedLocations = $this->cacheManager->get($address);
		if ($cachedLocations !== NULL) {
			return $cachedLocations;
		}

		// otherwise make a request to API...
		$locations = $this->geocodingService->geocodeAddress($address);
		$this->cacheManager->store($address, $locations); // ...and cache it
		return $locations;
	}



}
