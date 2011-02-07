<?php

	class ScavengerHuntGameTest extends PHPUnit_Framework_TestCase {

		public function testAddingHunt() {
			$app = WF::build('App');

			$article = WF::build('ScavengerHuntGames')->newGameArticle();
			$article->setTitleAndId('bnm',333);
			$article->setHiddenImage('him');
			$article->setClueImage('cim');
			$article->setClueText('clu');
			$article->setLink('lin');

			$fields = array(
				'wiki_id' => 412,
				'game_name' => 'asd',
				'game_is_enabled' => false,
				'game_data' => serialize( array(
					'landingTitle' => 'tgb',
					'landingArticleId' => 123,
					'startingClueText' => 'zxc',
					'startingClueImage' => 'ikm',
					'articles' => array( $article ),
					'finalFormText' => 'qwe',
					'finalFormQuestion' => 'qwe?',
					'goodbyeText' => 'edc',
					'goodbyeImage' => 'wsx',
				) ),
			);

			$db = $this->getMock('DatabaseBase');
			$db->expects($this->once())
				->method('insert')
				->with($this->anything(),$this->equalTo($fields),$this->anything());

			$games = $this->getMock('ScavengerHuntGames',array('getDb'),array($app));
			$games->expects($this->once())
				->method('getDb')
				->will($this->returnValue($db));

			$game = $games->newGame();
			$this->assertEquals(0, $game->getId());
			$this->assertFalse($game->isEnabled());

			$articles = array();
			$article = $game->newGameArticle();
			$article->setTitleAndId('bnm',333);
			$article->setHiddenImage('him');
			$article->setClueImage('cim');
			$article->setClueText('clu');
			$article->setLink('lin');
			$articles[] = $article;

			$game->setWikiId(412);
			$game->setName('asd');
			$game->setLandingTitleAndId('tgb',123);
			$game->setStartingClueText('zxc');
			$game->setStartingClueImage('ikm');
			$game->setArticles($articles);
			$game->setFinalFormText('qwe');
			$game->setFinalFormQuestion('qwe?');
			$game->setGoodbyeText('edc');
			$game->setGoodbyeImage('wsx');

			$this->assertTrue($game->save());
		}

	}
