<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz;

use Grifart\GeocodingClient\Geocoding;
use Grifart\GeocodingClient\Location;
use Grifart\GeocodingClient\MapyCz\Client\ApiClient;
use Grifart\GeocodingClient\MapyCz\Client\Node;
use RuntimeException;
use function array_map;
use function assert;
use function in_array;
use function reset;


final class MapyCzGeocoding implements Geocoding
{

	const ALLOWED_STATUS_CODES = [200, 206]; // mapy.cz returns 206 when there are "too many results"

	public function __construct(
		private ApiClient $apiClient,
	) {}


	/**
	 * @return Location[]
	 * @throws InvalidStatusException
	 * @throws NoResultException
	 * @throws RuntimeException
	 */
	public function geocode(string $address): array
	{
		$result = $this->apiClient->geocode($address);
		if ( ! $result->hasAnyChildren()) {
			throw new NoResultException();
		}

		$resultNodeChildren = $result->getChildren();
		$pointNode = reset($resultNodeChildren);
		assert($pointNode instanceof Node);

		self::verifyStatusCode($pointNode);

		if ( ! $pointNode->hasAnyChildren()) {
			throw new NoResultException();
		}

		return array_map(
			static fn(Node $node) => Location::from(
				(float) $node->getAttribute('y'),
				(float) $node->getAttribute('x'),
				$node->getAttribute('title'),
			),
			$pointNode->getChildren(),
		);
	}

	/**
	 * @throws InvalidStatusException
	 * @throws RuntimeException
	 */
	private static function verifyStatusCode(Node $pointNode): void
	{
		if ( ! in_array($pointNode->getAttribute('status'), self::ALLOWED_STATUS_CODES)) {
			throw new InvalidStatusException();
		}
	}

}
