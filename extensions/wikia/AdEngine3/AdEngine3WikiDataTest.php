<?php

use PHPUnit\Framework\TestCase;

class AdEngine3ResourceTest extends TestCase {
	public function testOldWikiaVertical() {
		$vertical = AdEngine3WikiData::getVerticalName('Wikia', 'games');

		$this->assertEquals('wikia', $vertical);
	}

	public function testMapVerticalName() {
		$this->assertEquals('life', AdEngine3WikiData::getVerticalName('Ent', 'other'));
		$this->assertEquals('ent', AdEngine3WikiData::getVerticalName('Ent', 'tv'));
		$this->assertEquals('gaming', AdEngine3WikiData::getVerticalName('Ent', 'games'));
		$this->assertEquals('ent', AdEngine3WikiData::getVerticalName('Ent', 'books'));
		$this->assertEquals('ent', AdEngine3WikiData::getVerticalName('Ent', 'comics'));
		$this->assertEquals('life', AdEngine3WikiData::getVerticalName('Ent', 'lifestyle'));
		$this->assertEquals('ent', AdEngine3WikiData::getVerticalName('Ent', 'music'));
		$this->assertEquals('ent', AdEngine3WikiData::getVerticalName('Ent', 'movies'));
	}
}
