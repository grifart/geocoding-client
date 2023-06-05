<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\Caching;

use Grifart\GeocodingClient\Location;
use RuntimeException;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function is_dir;
use function md5;
use function mkdir;
use function serialize;
use function unserialize;


final class CacheManager
{

	private string $cachePath;

	public function __construct(string $cachePath)
	{
		// ensure cache path exists
		if ( ! is_dir($cachePath)) {
			if ( ! @mkdir($cachePath, recursive: true)) {
				throw new RuntimeException('Can not create cache path.');
			}
		}

		$this->cachePath = $cachePath;
	}


	/**
	 * @return Location[]|null
	 */
	public function get(string $address): ?array
	{
		$fileName = self::resolveFileName($address);
		$cachedFilePath = $this->cachePath . '/' . $fileName;

		if ( ! file_exists($cachedFilePath)) {
			return null;
		}

		$content = file_get_contents($cachedFilePath);
		if ( ! $content) {
			throw new RuntimeException('Unable to open cached file.'); // @todo: use logger and return null instead
		}

		return unserialize($content);
	}


	public function store(string $address, mixed $results): void
	{
		if ( ! file_put_contents(
			$this->cachePath . '/' . self::resolveFileName($address),
			serialize($results),
		)) {
			throw new RuntimeException('Could not cache results.'); // @todo: use logger and continue instead
		}
	}


	private static function resolveFileName(string $address): string
	{
		return md5($address);
	}

}
