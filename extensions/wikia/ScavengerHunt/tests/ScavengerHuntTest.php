<?php
require_once dirname(__FILE__) . '/../ScavengerHunt_setup.php';
wfLoadAllExtensions();

class ScavengerHuntTest extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		$this->app = F::build( 'App' );
	}

	protected function tearDown() {
		F::setInstance( 'App', $this->app );
		F::reset( 'EasyTemplate' );
	}

	public static function setUpBeforeClass() {
		//ScavengerHuntSetup();
	}

	public function getFakeSprite() {
		return array( 'X' => 50, 'Y' => 50, 'X1' => 0, 'Y1' => 0, 'X2' => 10, 'Y2' => 20 );
	}

	public function getFakeWrongSprite() {
		return array( 'X' => 50, 'Y' => 50, 'X1' => 20, 'Y1' => 30, 'X2' => 10, 'Y2' => 20 );
	}

	const LANDING_WIKI_ID = 411;
	const LANDING_ARTICLE_NAME = 'this will be so mocked';
	const LANDING_ARTICLE_ID = 666;
	const MOCK_TEXT = 'Lorem ipsum';
	const MOCK_URL = 'http://firefly.wikia.com/wiki/test';
	const MOCK_GAME_ID = 1001;
	const MOCK_INT = 666;

	public function appServiceCallback( $sGlobal ) {
		switch ( $sGlobal ) {
			case 'wgDevEnvironment' : return false;	break;
			default: $return = $this->app->getGlobal( $sGlobal );
		}
		return $return;
	}


	public function getFakeRow() {

		$article = WF::build('ScavengerHuntGames')->newGameArticle();

		$article->setArticleName( self::MOCK_TEXT );
		$article->setWikiId( self::LANDING_WIKI_ID );

		foreach( array( 'spriteNotFound', 'spriteInProgressBar', 'spriteInProgressBarHover', 'spriteInProgressBarNotFound' ) as $spriteName ) {
			$methodName = 'set'.ucfirst( $spriteName );
			$article->$methodName( $this->getFakeSprite() );
		}
		$article->setSpriteNotFound( self::MOCK_URL );
		$article->setClueText( self::MOCK_TEXT );
		$article->setCongrats( self::MOCK_TEXT );

		$row = new stdClass();
		$row->game_id = self::MOCK_GAME_ID;
		$row->wiki_id = self::LANDING_WIKI_ID;
		$row->game_name = self::MOCK_TEXT;
		$row->game_is_enabled = 0;
		$row->game_data = serialize(array(
			'clueColor' => '#fff',
			'clueFont' => 'bold',
			'clueSize' => '14',
			'name' => self::MOCK_TEXT,
			'hash' => self::MOCK_TEXT,
			'landingTitle' => self::MOCK_TEXT,
			'landingArticleName' => self::MOCK_TEXT,
			'landingArticleWikiId' => self::LANDING_WIKI_ID,
			'landingButtonText' => self::MOCK_TEXT,
			'landingButtonX' => self::MOCK_INT,
			'landingButtonY' => self::MOCK_INT,
			'startingClueTitle' => self::MOCK_TEXT,
			'startingClueText' => self::MOCK_TEXT,
			'startingClueButtonText' => self::MOCK_TEXT,
			'startingClueButtonTarget' => self::MOCK_URL,
			'entryFormTitle' => self::MOCK_TEXT,
			'entryFormText' => self::MOCK_TEXT,
			'entryFormButtonText' => self::MOCK_TEXT,
			'entryFormQuestion' => self::MOCK_TEXT,
			'goodbyeTitle' => self::MOCK_TEXT,
			'goodbyeText' => self::MOCK_TEXT,
			'goodbyeImage' => self::MOCK_TEXT,
			'spriteImg' => self::MOCK_URL,
			'entryFormEmail' => self::MOCK_TEXT,
			'entryFormUsername' => self::MOCK_TEXT,
			'articles' => array( $article ),
			'progressBarBackgroundSprite' => $this->getFakeSprite(),
			'progressBarExitSprite' => $this->getFakeSprite(),
			'progressBarHintLabel' => $this->getFakeSprite(),
			'startPopupSprite' => $this->getFakeSprite(),
			'finishPopupSprite' => $this->getFakeSprite()
		));

		return $row;
	}

	public function testLoadingHunt() {
		$app = WF::build('App');

		$fakeRow = $this->getFakeRow();
		$where = array(
			'game_id' => self::MOCK_GAME_ID,
		);

		$db = $this->getMock('DatabaseBase');
		$db->expects($this->once())
			->method('selectRow')
			->with($this->anything(), $this->anything(), $this->equalTo($where), $this->anything(), $this->anything())
			->will($this->returnValue($fakeRow));

		$games = $this->getMock('ScavengerHuntGames', array('getDb'), array($app));
		$games->expects($this->once())
			->method('getDb')
			->will($this->returnValue($db));
//		$games->expects($this->never())
//			->method('clearCache')
//			->will($this->returnValue(null));

		$game = $games->findById( self::MOCK_GAME_ID );
		$this->assertNotEmpty($game);

		$this->assertEquals($fakeRow->game_id, $game->getId());
		$this->assertEquals($fakeRow->wiki_id, $game->getWikiId());
		$this->assertEquals($fakeRow->game_name, $game->getName());
		$this->assertEquals($fakeRow->game_is_enabled, $game->isEnabled());
		$this->assertEquals(unserialize($fakeRow->game_data), $game->getData());
	}
}