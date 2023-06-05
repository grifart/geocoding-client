<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient;


interface GeocodingService
{

	/**
	 * Finds a geographical location for given address
	 * @return Location[]
	 */
	public function geocodeAddress(string $address): array;

}
