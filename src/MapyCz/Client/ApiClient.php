<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz\Client;

use RuntimeException;
use SimpleXMLIterator;
use function file_get_contents;
use function rawurlencode;
use function sprintf;


final class ApiClient
{

	const API_URL = 'https://api.mapy.cz';


	/**
	 * @throws RuntimeException
	 */
	public function geocode(string $address): Node
	{
		$url = self::API_URL .
			sprintf('/geocode?query=%s', rawurlencode($address));
		$data = @file_get_contents($url);

		if ( ! $data) {
			throw new RuntimeException('There was a problem with requesting given URL (' . $url . ').');
		}

		return Parser::parse(new SimpleXMLIterator($data));
	}

}
