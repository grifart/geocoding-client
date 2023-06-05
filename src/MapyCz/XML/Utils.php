<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz\XML;


final class Utils
{

	/**
	 * @param string $data
	 * @return \SimpleXMLIterator
	 */
	public static function convertXmlStringToIterator($data)
	{
		return new \SimpleXMLIterator($data);
	}

}
