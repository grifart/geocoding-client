<?php

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
