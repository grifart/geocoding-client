<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\Caching;

use Grifart\GeocodingClient\GeocodingService;
use Grifart\GeocodingClient\Location;


final class CachedGeocodingService implements GeocodingService
{

	public function __construct(
		private CacheManager $cacheManager,
		private GeocodingService $geocodingService,
	) {}


	/**
	 * @return Location[]
	 */
	public function geocodeAddress(string $address): array
	{
		// obtain results from cache if any
		$cachedLocations = $this->cacheManager->get($address);
		if ($cachedLocations !== null) {
			return $cachedLocations;
		}

		// otherwise make fresh request and cache it
		$locations = $this->geocodingService->geocodeAddress($address);
		$this->cacheManager->store($address, $locations);

		return $locations;
	}

}
