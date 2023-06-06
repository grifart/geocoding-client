<?php declare(strict_types = 1);

namespace Grifart\GeocodingClient\Providers\MapyCz\Result;

use Grifart\GeocodingClient\Providers\MapyCz\GivenAttributeNotFound;
use function array_key_exists;
use function count;


final class Node
{

	public function __construct(
		private mixed $name,
		private mixed $value = null,
	) {}

	/** @var array<string, string> */
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
	 * @throws GivenAttributeNotFound
	 */
	public function getAttribute(string $name): string
	{
		if ( ! array_key_exists($name, $this->attributes)) {
			throw new GivenAttributeNotFound();
		}

		return $this->attributes[$name];
	}

	/**
	 * @return array<string, string>
	 */
	public function getAttributes(): array
	{
		return $this->attributes;
	}

	public function addAttribute(string $name, string $value): void
	{
		$this->attributes[$name] = $value;
	}


	/**
	 * @return Node[]
	 */
	public function getChildren(): array
	{
		return $this->children;
	}

	public function addChild(Node $node): void
	{
		$this->children[] = $node;
	}

	public function hasAnyChildren(): bool
	{
		return count($this->children) > 0;
	}

}
