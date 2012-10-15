<?php

require_once( dirname( __FILE__ ) . '/../HelloWorld.class.php');

class HelloWorldTest extends WikiaBaseTest {

	const TEST_WIKI_ID = 1;
	const TEST_TITLE = 'Test Title';
	const TEST_URL = 'http://test.wikia.com';

	public function testGettingWikiData() {

		$testRow = new stdClass();
		$testRow->city_title = self::TEST_TITLE;
		$testRow->city_url = self::TEST_URL;

		$dbMock = $this->getMock( 'DatabaseMysql', array( 'selectRow' ) );
		$dbMock->expects( $this->once() )
		       ->method( 'selectRow')
		       ->will( $this->returnValue( $testRow ) );

		$this->mockGlobalVariable( 'wgExternalSharedDB', '' );
		$this->mockGlobalFunction( 'getDB', $dbMock );
		$this->mockGlobalFunction( 'profileIn', null );
		$this->mockGlobalFunction( 'profileOut', null );

		$this->mockApp();

		$object = new HelloWorld;
		$result = $object->getWikiData( self::TEST_WIKI_ID );

		$this->assertEquals( self::TEST_TITLE, $result['title'] );
		$this->assertEquals( self::TEST_URL, $result['url'] );
	}

}
