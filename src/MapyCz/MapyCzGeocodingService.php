<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz;

use Grifart\GeocodingClient\GeocodingService;
use Grifart\GeocodingClient\Location;
use Grifart\GeocodingClient\MapyCz\Mapping\Mapper;
use Grifart\GeocodingClient\MapyCz\XML\Node;


final class MapyCzGeocodingService implements GeocodingService
{

	const ALLOWED_STATUS_CODES = [200, 206]; // mapy.cz returns 206 when there are "too many results", dunno why


	/** @var Communicator */
	private $communicator;

	/** @var Mapper */
	private $mapper;


	public function __construct(
		Communicator $communicator,
		Mapper $mapper
	) {
		$this->communicator = $communicator;
		$this->mapper = $mapper;
	}


	/**
	 * @param string $address
	 * @return Location[]
	 * @throws InvalidStatusException
	 * @throws NoResultException
	 * @throws \RuntimeException
	 */
	public function geocodeAddress($address)
	{
		$result = $this->communicator->makeRequest($address);

		if ( ! $result->hasAnyChildren()) {
			throw new NoResultException();
		}

		$resultNodeChildren = $result->getChildren();
		$pointNode = \reset($resultNodeChildren);
		\assert($pointNode instanceof Node);

		$this->verifyStatusCode($pointNode);

		if ( ! $pointNode->hasAnyChildren()) {
			throw new NoResultException();
		}

		return $this->mapper->mapNodesToResults($pointNode->getChildren());
	}

	/**
	 * @param Node $pointNode
	 * @throws InvalidStatusException
	 * @throws \RuntimeException
	 */
	private function verifyStatusCode(Node $pointNode)
	{
		if ( ! \in_array($pointNode->getAttribute('status'), self::ALLOWED_STATUS_CODES)) {
			throw new InvalidStatusException();
		}
	}

}
