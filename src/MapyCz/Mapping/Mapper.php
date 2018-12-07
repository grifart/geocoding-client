<?php

namespace Grifart\GeocodingClient\MapyCz\Mapping;

use Grifart\GeocodingClient\MapyCz\XML\Node;


final class Mapper
{

	/**
	 * @param Node[] $nodes
	 *
	 * @return ResultItem[]
	 */
	public function mapNodesToResults(array $nodes)
	{
		return \array_map(function (Node $node) {
			return ResultItem::from(
				(float) $node->getAttribute('y'),
				(float) $node->getAttribute('x'),
				$node->getAttribute('title')
			);
		}, $nodes);
	}

}
