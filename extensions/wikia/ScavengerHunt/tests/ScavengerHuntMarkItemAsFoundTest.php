<?php
require_once dirname(__FILE__) . '/../tests/ScavengerHuntTest.php';

class ScavengerHuntMarkItemsAsFoundTest extends ScavengerHuntTest {

	public function conditions(){

		$finalArray = array();
		$array = array( true, false );
		foreach( $array as $element1 ){
			foreach( $array as $element2 ){
				foreach( $array as $element3 ){
					$finalArray[] = array( $element1, $element2, $element3 );
				}
			}
		}

		return $finalArray;
	}
	
	/**
	 * @dataProvider conditions
	 */

	public function testMarkItemsAsFound( $exists, $huntId, $emptyresponse ) {
		$mockedTitle = $this->getMock( 'Title', array('exists') );
		$mockedTitle
			->expects( $this->any() )
			->method( 'exists' )
			->will(  $this->returnValue( $exists ) );
		
		$this->mockClass( 'Title', $mockedTitle, 'newFromText' );
		$this->mockDatabaseResponse( $emptyresponse );

		// starting conditions
		$scavengerHunt = $this->getMock('ScavengerHunt', array( 'addItemToCache' ) );
		if ( $exists && !empty( $huntId ) ) {
			$scavengerHunt
				->expects( $this->once() )
				->method( 'addItemToCache' )
				->will(  $this->returnValue( false ) );
		} else {
			$scavengerHunt
				->expects( $this->never() )
				->method( 'addItemToCache' )
				->will(  $this->returnValue( false ) );
		}

		$mockedUser = $this->getMock( 'User', array('isAnon') );
		$mockedUser
			->expects( $this->any() )
			->method( 'isAnon' )
			->will(  $this->returnValue( self::MOCK_USER_NAME ) );

		$this->mockClass( 'User', $mockedUser );
		$_COOKIE[ $scavengerHunt->getHuntIdKey() ] = ( $huntId ) ? self::MOCK_GAME_ID : 0;

		$result = $scavengerHunt->markItemAsFound( self::LANDING_ARTICLE_NAME );
		$this->assertEmpty( $result );
	}
}