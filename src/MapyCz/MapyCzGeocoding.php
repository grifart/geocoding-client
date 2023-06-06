<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz;

use Grifart\GeocodingClient\Geocoding;
use Grifart\GeocodingClient\Location;
use RuntimeException;
use SimpleXMLIterator;
use function array_map;
use function assert;
use function file_get_contents;
use function in_array;
use function rawurlencode;
use function reset;
use function sprintf;


final class MapyCzGeocoding implements Geocoding
{

	private const API_URL = 'https://api.mapy.cz';
	private const ALLOWED_STATUS_CODES = [200, 206]; // mapy.cz returns 206 when there are "too many results"


	/**
	 * @return Location[]
	 * @throws InvalidStatusException
	 * @throws NoResultException
	 * @throws RuntimeException
	 */
	public function geocode(string $address): array
	{
		$url = sprintf('%s/geocode?query=%s', self::API_URL, rawurlencode($address));
		$data = @file_get_contents($url);
		if ( ! $data) {
			throw new RuntimeException('There was a problem with requesting given URL (' . $url . ').');
		}

		$result = Parser::parse(new SimpleXMLIterator($data));
		if ( ! $result->hasAnyChildren()) {
			throw new NoResultException();
		}

		$resultNodeChildren = $result->getChildren();
		$pointNode = reset($resultNodeChildren);
		assert($pointNode instanceof Node);

		if ( ! in_array($pointNode->getAttribute('status'), self::ALLOWED_STATUS_CODES)) {
			throw new InvalidStatusException();
		}

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

}
