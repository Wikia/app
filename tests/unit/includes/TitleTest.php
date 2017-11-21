<?php

class TitleTest extends WikiaDatabaseTest {
	protected static function getSchemaFiles() {
		return [
			wfGetDB( DB_SLAVE )->getSchemaPath()
		];
	}

	public function testNewFromId() {
		$title = Title::newFromID( 1 );

		$this->assertInstanceOf( Title::class, $title );
		$this->assertEquals( NS_MAIN, $title->getNamespace() );
		$this->assertEquals( 'Foo', $title->getText() );
	}

	protected function getDataSet() {
		global $IP;

		return $this->createFlatXMLDataSet( "$IP/tests/fixtures/TitleTest.xml" );
	}
}
