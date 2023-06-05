<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz;

use RuntimeException;


final class NoResponseException extends RuntimeException
{}

final class InvalidStatusException extends RuntimeException
{}

final class NoResultException extends RuntimeException
{}
