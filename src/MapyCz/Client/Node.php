<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz\Client;


final class Node
{

	public function __construct(
		private mixed $name,
		private mixed $value = null,
	) {}

	private array $attributes = [];
	/** @var Node[] */
	private array $children = [];


	public function getName(): mixed
	{
		return $this->name;
	}


	public function getValue(): mixed
	{
		return $this->value;
	}

	public function setValue(mixed $value): void
	{
		$this->value = $value;
	}


	/**
	 * @param string $name
	 * @return mixed
	 * @throws \RuntimeException
	 */
	public function getAttribute($name)
	{
		if ( ! \array_key_exists($name, $this->attributes)) {
			throw new \RuntimeException('Attribute ' . $name . ' does not exist.');
		}

		return $this->attributes[$name];
	}

	/**
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}

	/**
	 * @param mixed $name
	 * @param mixed $value
	 */
	public function addAttribute($name, $value)
	{
		$this->attributes[$name] = $value;
	}


	/**
	 * @return Node[]
	 */
	public function getChildren()
	{
		return $this->children;
	}

	public function addChild(Node $node)
	{
		$this->children[] = $node;
	}

	public function hasAnyChildren()
	{
		return \count($this->children) > 0;
	}

}
