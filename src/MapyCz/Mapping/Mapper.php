<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz\Mapping;

use Grifart\GeocodingClient\MapyCz\Client\Node;
use function array_map;


final class Mapper
{

	/**
	 * @param Node[] $nodes
	 * @return ResultItem[]
	 */
	public function mapNodesToResults(array $nodes): array
	{
		return array_map(
			static fn(Node $node) => ResultItem::from(
				(float) $node->getAttribute('y'),
				(float) $node->getAttribute('x'),
				$node->getAttribute('title'),
			),
			$nodes,
		);
	}

}
