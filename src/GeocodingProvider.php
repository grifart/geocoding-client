<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient;


interface GeocodingProvider
{

	/**
	 * Finds a geographical location for given address
	 * @return Location[]
	 */
	public function geocode(string $address): array;

}
