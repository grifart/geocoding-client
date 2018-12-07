<?php

namespace Grifart\GeocodingClient\MapyCz\Mapping;

use Grifart\GeocodingClient\Location;


final class ResultItem implements Location
{

	/** @var float */
	private $latitude;

	/** @var float */
	private $longitude;

	/** @var string|NULL */
	private $title;


	/**
	 * @param float $latitude
	 * @param float $longitude
	 * @param string|NULL $title
	 */
	private function __construct($latitude, $longitude, $title = NULL)
	{
		$this->latitude = $latitude;
		$this->longitude = $longitude;
		$this->title = $title;
	}

	/**
	 * @param float $latitude
	 * @param float $longitude
	 * @param string|NULL $title
	 *
	 * @return ResultItem
	 */
	public static function from($latitude, $longitude, $title = NULL)
	{
		return new self($latitude, $longitude, $title);
	}


	/**
	 * @return float
	 */
	public function getLatitude()
	{
		return $this->latitude;
	}

	/**
	 * @return float
	 */
	public function getLongitude()
	{
		return $this->longitude;
	}

	/**
	 * @return string|NULL
	 */
	public function getTitle()
	{
		return $this->title;
	}


	public function serialize()
	{
		return \json_encode([
			'latitude' => $this->latitude,
			'longitude' => $this->longitude,
		]);
	}

	public function unserialize($serialized)
	{
		$data = \json_decode($serialized);
		$this->latitude = $data->latitude;
		$this->longitude = $data->longitude;
	}

}
