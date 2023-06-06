<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\Providers\MapyCz;

use SimpleXMLElement;
use SimpleXMLIterator;
use function assert;


final class Parser
{

	public static function parse(SimpleXMLIterator $iterator): Node
	{
		$rootNode = new Node($iterator->getName());
		$attributes = $iterator->attributes();
		assert($attributes !== null);
		self::parseAttributes($attributes, $rootNode);

		self::parseChildren($iterator, $rootNode);

		return $rootNode;
	}

	private static function parseChildren(SimpleXMLIterator $iterator, Node $node): void
	{
		for ($iterator->rewind(); $iterator->valid(); $iterator->next()) {
			$child = new Node($iterator->key());

			$attributes = $iterator->current()->attributes();
			assert($attributes !== null);
			self::parseAttributes($attributes, $child);

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
