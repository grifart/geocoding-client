<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient;


interface GeocodingProvider
{

	/**
	 * Finds a geographical location for given address
	 * @return Location[]
	 * @throws GeocodingFailed
	 */
	public function geocode(string $address): array;

}
