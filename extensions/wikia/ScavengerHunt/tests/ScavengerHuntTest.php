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
			$article->setClueButtonText('cbt');
			$article->setClueButtonTarget('cby');

			$data = array(
				'landingTitle' => 'lti',
				'landingArticleId' => 123,
				'landingButtonText' => 'zxc',
				'startingClueTitle' => 'sct',
				'startingClueText' => 'scy',
				'startingClueImage' => 'sci',
				'startingClueButtonText' => 'sbt',
				'startingClueButtonTarget' => 'sby',
				'articles' => array( $article ),
				'entryFormTitle' => 'eft',
				'entryFormText' => 'efy',
				'entryFormImage' => 'efi',
				'entryFormQuestion' => 'efq',
				'goodbyeText' => 'gdt',
				'goodbyeImage' => 'gdi',
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
				'startingClueButtonText' => 'sbt',
				'startingClueButtonTarget' => 'sby',
				'entryFormTitle' => 'eft',
				'entryFormText' => 'efy',
				'entryFormImage' => 'efi',
				'entryFormQuestion' => 'efq',
				'goodbyeText' => 'gdt',
				'goodbyeImage' => 'gdi',
				'articles' => array( $article ),
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

	//	public function test

	}
