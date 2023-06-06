<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\Caching;

use Grifart\GeocodingClient\GeocodingProvider;
use Grifart\GeocodingClient\Location;


final class CacheProvider implements GeocodingProvider
{

	public function __construct(
		private CacheManager $cacheManager,
		private GeocodingProvider $inner,
	) {}


	/**
	 * @return Location[]
	 */
	public function geocode(string $address): array
	{
		// obtain results from cache if any
		$cachedLocations = $this->cacheManager->get($address);
		if ($cachedLocations !== null) {
			return $cachedLocations;
		}

		// otherwise make fresh request and cache it
		$locations = $this->inner->geocode($address);
		$this->cacheManager->store($address, $locations);

		return $locations;
	}

}
