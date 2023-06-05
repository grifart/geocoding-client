<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient;


interface GeocodingService
{

	/**
	 * Finds a geographical location for given address.
	 *
	 * @param string $address
	 * @return Location[]
	 */
	public function geocodeAddress($address);

}
