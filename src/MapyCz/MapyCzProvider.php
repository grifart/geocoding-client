<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz;

use Grifart\GeocodingClient\GeocodingProvider;
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


final class MapyCzProvider implements GeocodingProvider
{

	private const API_URL = 'https://api.mapy.cz';
	private const ALLOWED_STATUS_CODES = [200, 206]; // mapy.cz returns 206 when there are "too many results"


	/**
	 * @return Location[]
	 * @throws ConnectionToMapyCzApiFailed
	 * @throws GeocodingFailed
	 */
	public function geocode(string $address): array
	{
		// obtain data from API
		$url = sprintf('%s/geocode?query=%s', self::API_URL, rawurlencode($address));
		$data = @file_get_contents($url);
		if ( ! $data) {
			throw new ConnectionToMapyCzApiFailed();
		}

		/**
		 * parse response
		 *
		 * expected structure:
		 * <result>
		 * 		<point
		 * 			query = queried address
		 * 			status = status code
		 * 		>
		 * 			<item
		 * 				x y = coords
		 * 				id = mapy cz identifier
		 * 				source type = ref to type of result item
		 * 				title = name of the point
					/>
		 * 		</point>
		 * </result>
		 */
		$resultNode = Parser::parse(new SimpleXMLIterator($data));


		// check response is valid

		if ( ! $resultNode->hasAnyChildren()) {
			throw GeocodingFailed::invalidResponse('Result node should contain point child node');
		}

		$children = $resultNode->getChildren();
		$pointNode = reset($children);
		assert($pointNode instanceof Node);

		try {
			$statusCode = (int) $pointNode->getAttribute('status');
			if ( ! in_array($statusCode, self::ALLOWED_STATUS_CODES, strict: true)) {
				throw GeocodingFailed::badStatusCode($statusCode);
			}

		} catch (GivenAttributeNotFound $e) {
			throw GeocodingFailed::invalidResponse('Status attribute is missing', previous: $e);
		}

		if ( ! $pointNode->hasAnyChildren()) {
			throw GeocodingFailed::invalidResponse('Point node should contain item children nodes');
		}


		// map
		try {
			return array_map(
				static fn(Node $node) => Location::from(
					(float) $node->getAttribute('y'),
					(float) $node->getAttribute('x'),
					$node->getAttribute('title'),
				),
				$pointNode->getChildren(),
			);

		} catch (GivenAttributeNotFound $e) {
			throw GeocodingFailed::invalidResponse('One of result item attribute is missing, check attached underlying exception', previous: $e);
		}
	}

}
