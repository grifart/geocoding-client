<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz;

use Grifart\GeocodingClient\MapyCz\XML\Node;
use Grifart\GeocodingClient\MapyCz\XML\Parser;
use Grifart\GeocodingClient\MapyCz\XML\Utils;


final class Communicator
{

	const MAPYCZ_GEOCODING_API_URL = 'https://api.mapy.cz/geocode?query=%s';


	/**
	 * @param $address
	 * @return Node
	 * @throws \RuntimeException
	 */
	public function makeRequest($address)
	{
		$url = \sprintf(self::MAPYCZ_GEOCODING_API_URL, \rawurlencode($address));
		$data = @\file_get_contents($url);

		if ( ! $data) {
			throw new \RuntimeException('There was a problem with requesting given URL (' . $url . ').');
		}

		return Parser::parse(Utils::convertXmlStringToIterator($data));
	}

}
