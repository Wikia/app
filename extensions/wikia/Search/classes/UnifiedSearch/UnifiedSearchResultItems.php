<?php

declare( strict_types=1 );

namespace Wikia\Search\UnifiedSearch;

final class UnifiedSearchResultItems implements \IteratorAggregate {
	/** @var UnifiedSearchResultItem[] */
	private $items;

	public function __construct( array $items) {
		$this->items = array_map(
			static function ($item) {
				return new UnifiedSearchResultItem($item);
			},
			$items
		);
	}

	public function toArray($selectedFieldsMap = []): array
	{
		if (empty($selectedFieldsMap)) {
			return $this->items;
		}

		return array_map(function ($item) use ($selectedFieldsMap) {
			$mappedItem = [];

			foreach ($item as $k => $v) {
				if (isset($selectedFieldsMap[$k]) || in_array($k, $selectedFieldsMap, true)) {
					$mappedItem[$selectedFieldsMap[$k] ?? $k] = $v;
				}
			}

			return $mappedItem;
		}, $this->items);
	}

	public function getIterator() {
		return  new \ArrayIterator($this->items);
	}
}
