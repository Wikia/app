<?php
	require_once dirname(__FILE__) . '/../ScavengerHunt_setup.php';
	wfLoadAllExtensions();

	class ScavengerHuntTest extends PHPUnit_Framework_TestCase {

		public function testAddingHunt() {
//			$this->markTestIncomplete();
//			return;

			$app = WF::build('App');
			$games = WF::build('ScavengerHuntGames');

			$article = WF::build('ScavengerHuntGames')->newGameArticle();
			$article->setTitleAndId('bnm',333);
			$article->setHiddenImage('him');
			$article->setClueTitle('clt');
			$article->setClueText('cly');
			$article->setClueImage('cli');
			$article->setClueImageTopOffset('100');
			$article->setClueImageLeftOffset('-100');
			$article->setClueButtonText('cbt');
			$article->setClueButtonTarget('cby');

			$data = array(
				'landingTitle' => 'lti',
				'landingArticleId' => 123,
				'landingButtonText' => 'zxc',
				'startingClueTitle' => 'sct',
				'startingClueText' => 'scy',
				'startingClueImage' => 'sci',
				'startingClueImageTopOffset' => '10',
				'startingClueImageLeftOffset' => '-10',
				'startingClueButtonText' => 'sbt',
				'startingClueButtonTarget' => 'sby',
				'articles' => array( $article ),
				'entryFormTitle' => 'eft',
				'entryFormText' => 'efy',
				'entryFormImage' => 'efi',
				'entryFormImageTopOffset' => '20',
				'entryFormImageLeftOffset' => '-20',
				'entryFormQuestion' => 'efq',
				'goodbyeTitle' => 'gdw',
				'goodbyeText' => 'gdt',
				'goodbyeImage' => 'gdi',
				'goodbyeImageTopOffset' => '30',
				'goodbyeImageLeftOffset' => '-30',
			);

			$fields = array(
				'wiki_id' => 412,
				'game_name' => 'asd',
				'game_is_enabled' => true,
				'game_data' => serialize( $data ),
			);

			$db = $this->getMock('DatabaseBase');
			$db->expects($this->once())
				->method('insert')
				->with($this->anything(),$this->equalTo($fields),$this->anything());

			$games = $this->getMock('ScavengerHuntGames',array('getDb','clearIndexCache'),array($app));
			$games->expects($this->once())
				->method('getDb')
				->will($this->returnValue($db));
			$games->expects($this->once())
				->method('clearIndexCache')
				->will($this->returnValue(null));

			$game = $games->newGame();
			$this->assertEquals(0, $game->getId());
			$this->assertFalse($game->isEnabled());

			$articles = array();
			$article = $game->newGameArticle();
			$article->setTitleAndId('bnm',333);
			$article->setHiddenImage('him');
			$article->setClueTitle('clt');
			$article->setClueText('cly');
			$article->setClueImage('cli');
			$article->setClueImageTopOffset('100');
			$article->setClueImageLeftOffset('-100');
			$article->setClueButtonText('cbt');
			$article->setClueButtonTarget('cby');
			$articles[] = $article;

			$game->setWikiId(412);
			$game->setName('asd');
			$game->setEnabled(true);
			$game->setData($data);

			$this->assertTrue($game->save());
		}

		public function getFakeRow() {
			$app = WF::build('App');

			$article = WF::build('ScavengerHuntGames')->newGameArticle();
			$article->setTitleAndId('bnm',333);
			$article->setHiddenImage('him');
			$article->setClueTitle('clt');
			$article->setClueText('cly');
			$article->setClueImage('cli');
			$article->setClueImageTopOffset('100');
			$article->setClueImageLeftOffset('-100');
			$article->setClueButtonText('cbt');
			$article->setClueButtonTarget('cby');

			$row = new stdClass();
			$row->game_id = 1001;
			$row->wiki_id = 412;
			$row->game_name = 'asd';
			$row->game_is_enabled = 0;
			$row->game_data = serialize(array(
				'landingTitle' => 'lti',
				'landingArticleId' => 123,
				'landingButtonText' => 'zxc',
				'startingClueTitle' => 'sct',
				'startingClueText' => 'scy',
				'startingClueImage' => 'sci',
				'startingClueImageTopOffset' => '10',
				'startingClueImageLeftOffset' => '-10',
				'startingClueButtonText' => 'sbt',
				'startingClueButtonTarget' => 'sby',
				'articles' => array( $article ),
				'entryFormTitle' => 'eft',
				'entryFormText' => 'efy',
				'entryFormImage' => 'efi',
				'entryFormImageTopOffset' => '20',
				'entryFormImageLeftOffset' => '-20',
				'entryFormQuestion' => 'efq',
				'goodbyeTitle' => 'gdw',
				'goodbyeText' => 'gdt',
				'goodbyeImage' => 'gdi',
				'goodbyeImageTopOffset' => '30',
				'goodbyeImageLeftOffset' => '-30',
			));

			return $row;
		}

		public function testLoadingHunt() {
//			$this->markTestIncomplete();
//			return;

			$app = WF::build('App');

			$fakeRow = $this->getFakeRow();
			$where = array(
				'game_id' => 1001,
			);

			$db = $this->getMock('DatabaseBase');
			$db->expects($this->once())
				->method('selectRow')
				->with($this->anything(),$this->anything(),$this->equalTo($where),$this->anything(),$this->anything())
				->will($this->returnValue($fakeRow));

			$games = $this->getMock('ScavengerHuntGames',array('getDb'),array($app));
			$games->expects($this->once())
				->method('getDb')
				->will($this->returnValue($db));
			$games->expects($this->never())
				->method('clearIndexCache')
				->will($this->returnValue(null));

			$game = $games->findById(1001);
			$this->assertNotEmpty($game);

			$this->assertEquals($fakeRow->game_id,$game->getId());
			$this->assertEquals($fakeRow->wiki_id,$game->getWikiId());
			$this->assertEquals($fakeRow->game_name,$game->getName());
			$this->assertEquals($fakeRow->game_is_enabled,$game->isEnabled());
			$this->assertEquals(unserialize($fakeRow->game_data), $game->getData());
		}

		public function testDeletingHunt() {
			$app = WF::build('App');

			$where = array(
				'game_id' => 412,
			);

			$db = $this->getMock('DatabaseBase');
			$db->expects($this->once())
				->method('delete')
				->with($this->anything(),$this->equalTo($where))
				->will($this->returnValue(true));

			$games = $this->getMock('ScavengerHuntGames',array('getDb','clearIndexCache'),array($app));
			$games->expects($this->once())
				->method('getDb')
				->will($this->returnValue($db));
			$games->expects($this->once())
				->method('clearIndexCache')
				->will($this->returnValue(null));

			$game = $games->newGame();
			$game->setId(412);
			$this->assertNotEmpty($game->delete());
		}

		public function mock_Games_getTitleDbKey( $text) {
			return str_replace(' ', '_', $text);
		}

		public function testIndexCacheGeneration() {
			$app = WF::build('App');

			$cacheData = array(
				'About_Wikia' => array(
					'start' => array( 10001 ),
					'article' => array( 10002 ),
				),
				'The_new_look_2' => array(
					'article' => array( 10001, 10002 ),
				),
				'Alice_Soft' => array(
					'start' => array( 10002 ),
					'article' => array( 10001 ),
				),
			);

			$cache = $this->getMock('stdClass',array('get','set'));
			$cache->expects($this->once())
				->method('get')
				->will($this->returnValue(null));
			$cache->expects($this->once())
				->method('set')
				->with($this->anything(),$this->equalTo($cacheData),$this->anything());

			$article1 = WF::build('ScavengerHuntGameArticle');
			$article1->setAll(array(
				'title' => 'The new look 2',
				'articleId' => 123,
			));
			$article2 = WF::build('ScavengerHuntGameArticle');
			$article2->setAll(array(
				'title' => 'About Wikia',
				'articleId' => 234,
			));
			$article3 = WF::build('ScavengerHuntGameArticle');
			$article3->setAll(array(
				'title' => 'Alice_Soft',
				'articleId' => 345,
			));

			$game1 = WF::build('ScavengerHuntGame');
			$game1->setAll(array(
				'id' => 10001,
				'idEnabled' => true,
				'landingTitle' => 'About Wikia',
				'landingArticleId' => 123,
				'articles' => array( $article1, $article3 ),
			));
			$game2 = WF::build('ScavengerHuntGame');
			$game2->setAll(array(
				'id' => 10002,
				'idEnabled' => true,
				'landingTitle' => 'Alice Soft',
				'landingArticleId' => 345,
				'articles' => array( $article2, $article1 ),
			));
			$gamesData = array( $game1, $game2 );

			$games = $this->getMock('ScavengerHuntGames',array('getCache','findAllEnabledByWikiId','getTitleDbKey'),array($app));
			$games->expects($this->exactly(2))
				->method('getCache')
				->will($this->returnValue($cache));
			$games->expects($this->once())
				->method('findAllEnabledByWikiId')
				->will($this->returnValue($gamesData));
			$games->expects($this->any())
				->method('getTitleDbKey')
				->will($this->returnCallback(array($this,'mock_Games_getTitleDbKey')));

			$this->assertEquals($cacheData,$games->getIndexCache());
		}

		public function testIndexCacheReading() {
			$app = WF::build('App');

			$cacheData = array(
				'About_Wikia' => array(
					'start' => array( 10001 ),
					'article' => array( 10002 ),
				),
				'The_new_look_2' => array(
					'article' => array( 10001, 10002 ),
				),
				'Alice_Soft' => array(
					'start' => array( 10002 ),
					'article' => array( 10001 ),
				),
			);

			$cache = $this->getMock('stdClass',array('get','set'));
			$cache->expects($this->once())
				->method('get')
				->will($this->returnValue($cacheData));
			$cache->expects($this->never())
				->method('set');

			$games = $this->getMock('ScavengerHuntGames',array('getCache','findAllEnabledByWikiId','getTitleDbKey'),array($app));
			$games->expects($this->once())
				->method('getCache')
				->will($this->returnValue($cache));
			$games->expects($this->never())
				->method('findAllEnabledByWikiId');
			$games->expects($this->never())
				->method('getTitleDbKey');

			$this->assertEquals($cacheData,$games->getIndexCache());
		}

	}
