<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz\XML;


final class Parser
{

	/**
	 * @return Node
	 */
	public static function parse(\SimpleXMLIterator $iterator)
	{
		$rootNode = new Node($iterator->getName());
		self::parseAttributes($iterator->attributes(), $rootNode);

		self::parseChildren($iterator, $rootNode);

		return $rootNode;
	}

	private static function parseChildren(\SimpleXMLIterator $iterator, Node $node)
	{
		for ($iterator->rewind(); $iterator->valid(); $iterator->next()) {
			$child = new Node($iterator->key());

			self::parseAttributes($iterator->current()->attributes(), $child);

			if ($iterator->hasChildren()){
				self::parseChildren($iterator->current(), $child);
			}
			else {
				$child->setValue((string) $iterator->current());
			}

			$node->addChild($child);
		}
	}

	private static function parseAttributes(\SimpleXMLElement $element, Node $node)
	{
		foreach ($element as $name => $value) {
			$node->addAttribute($name, (string) $value);
		}
	}

}
