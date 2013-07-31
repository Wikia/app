<?php
require_once dirname(__FILE__) . '/../tests/ScavengerHuntTest.php';

class ScavengerHuntGetActiveGameTest extends ScavengerHuntTest {

	public function testLoadingHunt() {

		$fakeRow = $this->getFakeRow();
		$game = $this->getFakeGame();
		$this->assertNotEmpty( $game );

		$this->assertEquals($fakeRow->game_id, $game->getId(),'game_id');
		$this->assertEquals($fakeRow->wiki_id, $game->getWikiId(),'wiki_id');
		$this->assertEquals($fakeRow->game_name, $game->getName(),'game_name');
		$this->assertEquals($fakeRow->game_is_enabled, $game->isEnabled(),'game_is_enabled');
		$this->assertEquals(unserialize($fakeRow->game_data), $game->getData(),'game_data');
	}

	// getActiveGame

	public function testGameAlreadyLoaded() {

		// starting conditions
		$scavengerHunt = new ScavengerHunt();
		$oFakeGame = $this->getFakeGame();
		$scavengerHunt->setGame( $oFakeGame );

		// test
		$oFinalGame = $scavengerHunt->getActiveGame();
		$this->assertEquals( $oFakeGame, $oFinalGame );
	}

	public function conditions(){
		return array(
			array( true, self::MOCK_GAME_ID ),
			array( false, self::MOCK_GAME_ID ),
			array( true, false ),
			array( false, false )
		);
	}

	/**
	 * @dataProvider conditions
	 */

	public function testGameNotLoaded( $isUserAnon, $cookieValue ) {

		// starting conditions
		$scavengerHunt = new ScavengerHunt();
		$scavengerHunt->setGame( null );

		$mockedUser = $this->getMock( 'User', array('isAnon', 'getName') );
		$mockedUser
			->expects( $this->any() )
			->method( 'isAnon' )
			->will(  $this->returnValue( self::MOCK_USER_NAME ) );

		$mockedUser
			->expects( $this->any() )
			->method( 'getName' )
			->will(  $this->returnValue( self::MOCK_USER_NAME ) );

		$this->mockClass( 'User', $mockedUser );
		$_COOKIE[ $scavengerHunt->getHuntIdKey() ] = $cookieValue;

		// mocks
		$oFakeGame = $this->getFakeGame();
		// test
		$oFinalGame = $scavengerHunt->getActiveGame();

		if ( empty( $cookieValue ) ){
			$this->assertEmpty( $oFinalGame );
		} else {
			$this->assertNotEmpty( $oFinalGame );
			$oFakeGameID = $oFinalGame->getId();
			$this->assertEquals( $oFakeGameID, $oFinalGame->getId() );
		}
	}
}
