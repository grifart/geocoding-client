<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient;


interface Location extends \Serializable
{

	/**
	 * @return float
	 */
	public function getLatitude();

	/**
	 * @return float
	 */
	public function getLongitude();

}
