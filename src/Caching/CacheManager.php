<?php

namespace Grifart\GeocodingClient\Caching;

use Grifart\GeocodingClient\Location;


final class CacheManager
{

	/** @var string */
	private $cachePath;


	public function __construct($cachePath)
	{
		// ensure cache path exists
		if ( ! \is_dir($cachePath)) {
			if ( ! @mkdir($cachePath, recursive: true)) {
				throw new \RuntimeException('Can not create cache path.');
			}
		}

		$this->cachePath = $cachePath;
	}


	/**
	 * @param string $address
	 * @return Location[]|NULL
	 */
	public function get($address)
	{
		$fileName = $this->resolveFileName($address);
		$cachedFilePath = $this->cachePath . '/' . $fileName;

		if (!\file_exists($cachedFilePath)) {
			return NULL;
		}

		$content = \file_get_contents($cachedFilePath);
		if ( ! $content) {
			throw new \RuntimeException('Unable to open cached file.'); // @todo: use logger and return null instead
		}

		return \unserialize($content);
	}

	/**
	 * @param string $address
	 * @param mixed $results
	 */
	public function store($address, $results)
	{
		if ( ! \file_put_contents(
			$this->cachePath . '/' . $this->resolveFileName($address),
			\serialize($results)
		)) {
			throw new \RuntimeException('Could not cache results.'); // @todo: use logger and continue instead
		}
	}


	/**
	 * @param string $address
	 * @return string
	 */
	private function resolveFileName($address)
	{
		return \md5($address);
	}

}
