<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\MapyCz\XML;


final class Node
{

	/** @var mixed */
	private $name;

	/** @var mixed */
	private $value;

	/** @var array */
	private $attributes = [];

	/** @var Node[] */
	private $children = [];


	public function __construct($name, $value = NULL)
	{
		$this->name = $name;
		$this->value = $value;
	}


	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param mixed $value
	 */
	public function setValue($value)
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
