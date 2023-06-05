<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz;

use Grifart\GeocodingClient\MapyCz\XML\Node;
use Grifart\GeocodingClient\MapyCz\XML\Parser;
use RuntimeException;
use SimpleXMLIterator;
use function file_get_contents;
use function rawurlencode;
use function sprintf;


final class Communicator
{

	const MAPYCZ_GEOCODING_API_URL = 'https://api.mapy.cz/geocode?query=%s';


	/**
	 * @throws RuntimeException
	 */
	public function makeRequest(string $address): Node
	{
		$url = sprintf(self::MAPYCZ_GEOCODING_API_URL, rawurlencode($address));
		$data = @file_get_contents($url);

		if ( ! $data) {
			throw new RuntimeException('There was a problem with requesting given URL (' . $url . ').');
		}

		return Parser::parse(new SimpleXMLIterator($data));
	}

}
