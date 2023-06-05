<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz\XML;

use SimpleXMLElement;
use SimpleXMLIterator;


final class Parser
{

	public static function parse(SimpleXMLIterator $iterator): Node
	{
		$rootNode = new Node($iterator->getName());
		self::parseAttributes($iterator->attributes(), $rootNode);

		self::parseChildren($iterator, $rootNode);

		return $rootNode;
	}

	private static function parseChildren(SimpleXMLIterator $iterator, Node $node): void
	{
		for ($iterator->rewind(); $iterator->valid(); $iterator->next()) {
			$child = new Node($iterator->key());

			self::parseAttributes($iterator->current()->attributes(), $child);

			if ($iterator->hasChildren()){
				self::parseChildren($iterator->current(), $child);

			} else {
				$child->setValue((string) $iterator->current());
			}

			$node->addChild($child);
		}
	}

	private static function parseAttributes(SimpleXMLElement $element, Node $node): void
	{
		foreach ($element as $name => $value) {
			$node->addAttribute($name, (string) $value);
		}
	}

}
