<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz;

use RuntimeException;
use Throwable;


final class GeocodingFailed extends RuntimeException
{
	public static function invalidResponse(string $message, ?Throwable $previous = null): self
	{
		return new self($message, previous: $previous);
	}

	public static function badStatusCode(int $statusCode): self
	{
		return new self("Server responded with status code '%d'", $statusCode);
	}
}

final class ConnectionToMapyCzApiFailed extends RuntimeException
{}

final class GivenAttributeNotFound extends RuntimeException
{}
