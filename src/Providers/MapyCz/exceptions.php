<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\Providers\MapyCz;

use RuntimeException;


final class ConnectionToMapyCzApiFailed extends RuntimeException
{}

final class GivenAttributeNotFound extends RuntimeException
{}
