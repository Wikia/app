<?php

declare( strict_types=1 );

namespace Wikia\Search\Test\UnifiedSearch;

use PHPUnit\Framework\TestCase;
use Wikia\Search\UnifiedSearch\UnifiedSearchResultItems;

final class UnifiedSearchResultItemsTest extends TestCase {
	public function testReturnsItemsUntouchedForNonSpecifiedFields()
	{
		$items = [
			[
				'foo' => 'bar',
				'baz' => 'zaz'
			]
		];

		$searchResultItems = new UnifiedSearchResultItems($items);
		$result = $searchResultItems->toArray();

		self::assertSame($items, $result);
	}

	public function testReturnsFilteredItemsRemovingNonSpecifiedFields()
	{
		$items = [
			[
			'foo' => 'bar',
			'baz' => 'zaz',
			]
		];

		$searchResultItems = new UnifiedSearchResultItems($items);
		$result = $searchResultItems->toArray(['baz']);

		$expected = [
			[
				'baz' => 'zaz',
			]
		];

		self::assertSame($expected, $result);
	}

	public function testReturnsFilteredItemsWithMappedKeys()
	{
		$items = [
			[
				'foo' => 'bar',
				'baz' => 'zaz',
				'woof' => 'bark'
			]
		];

		$searchResultItems = new UnifiedSearchResultItems($items);
		$result = $searchResultItems->toArray(['baz' => 'not-baz', 'woof']);

		$expected = [
			[
				'not-baz' => 'zaz',
				'woof' => 'bark',
			]
		];

		self::assertSame($expected, $result);
	}
}
