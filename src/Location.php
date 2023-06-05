<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient;

use Serializable;


interface Location extends Serializable
{

	public function getLatitude(): float;

	public function getLongitude(): float;

}
