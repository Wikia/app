<?php
require_once dirname(__FILE__) . '/../tests/ScavengerHuntTest.php';

/**
 * @group Broken
 */
class ScavengerHuntGetFinalModalArrayTest extends ScavengerHuntTest {

	public function conditions(){

		return array(
			array( false, array( 0, 1 ), array( 0, 1 ), false ),
			array( false, array( 0, 1 ), array( 1 ), false ),
			array( true, array( 0, 1 ), array( 0, 1 ), true ),
			array( true, array( 0, 1 ), array( 1 ), false )
		);
	}
	
	/**
	 * @dataProvider conditions
	 */

	public function testGetFinalModalArray( $gameExists, $articles, $foundArticles, $expectedResult ) {
		
		// mocking game object
		// get articles
		$mockedGame = $this->getMock( 'ScavengerHuntGame', array( 'getArticles' ), array( $this->app ) );
		$mockedGame
			->expects( $this->any() )
			->method( 'getArticles' )
			->will( $this->onConsecutiveCalls( array( new ScavengerHuntGameArticle(), new ScavengerHuntGameArticle() ), $articles ) );

		$this->mockClass( 'ScavengerHuntGame', $mockedGame );

		$game = $this->getFakeGame();

		// mocking scavenger hunt and passing game to the hunt
		$scavengerHunt = $this->getMock( 'ScavengerHunt', array( 'getFoundIndexes' ) );
		$scavengerHunt->setGame( $gameExists ? $game : null );

		$scavengerHunt
			->expects( $this->any() )
			->method( 'getFoundIndexes' )
			->will( $this->returnValue( $foundArticles ) );

		// mocking user
		$mockedUser = $this->getMock( 'User', array('isAnon') );
		$mockedUser
			->expects( $this->any() )
			->method( 'isAnon' )
			->will(  $this->returnValue( self::MOCK_USER_NAME ) );

		$this->mockClass( 'User', $mockedUser );

		// setting cookie values
		$_COOKIE[ $scavengerHunt->getHuntIdKey() ] = ( $gameExists ) ? self::MOCK_GAME_ID : 0;

		// test and assertions
		$result = $scavengerHunt->generateFullInfo();

		$this->assertEquals( $expectedResult, isset( $result['completed'] ) );
	}
}