<?php

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
