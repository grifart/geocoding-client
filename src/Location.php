<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient;

use Serializable;
use function json_decode;
use function json_encode;


final class Location implements Serializable
{

	private function __construct(
		private float $latitude,
		private float $longitude,
		private ?string $title,
	) {}


	public static function from(
		float $latitude,
		float $longitude,
		?string $title = null,
	): self
	{
		return new self($latitude, $longitude, $title);
	}


	public function getLatitude(): float
	{
		return $this->latitude;
	}

	public function getLongitude(): float
	{
		return $this->longitude;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}


	public function serialize()
	{
		return json_encode([
			'latitude' => $this->latitude,
			'longitude' => $this->longitude,
		]);
	}

	public function unserialize($serialized)
	{
		$data = json_decode($serialized);
		$this->latitude = $data->latitude;
		$this->longitude = $data->longitude;
	}

}
