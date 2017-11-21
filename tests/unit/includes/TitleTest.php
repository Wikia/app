<?php

class TitleTest extends WikiaDatabaseTest {
	public function testNewFromId() {
		$title = Title::newFromID( 1 );

		$this->assertInstanceOf( Title::class, $title );
		$this->assertEquals( NS_MAIN, $title->getNamespace() );
		$this->assertEquals( 'Foo', $title->getText() );
	}

	protected function getDataSet() {
		return $this->createFlatXMLDataSet( __DIR__ . "/../../fixtures/TitleTest.xml" );
	}
}
