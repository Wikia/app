<?php

/**
 * ScavengerHunt
 *
 * A ScavengerHunt extension for MediaWiki
 * Alows to create a scavenger hunt game on a wiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2011-01-31
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     include("$IP/extensions/wikia/ScavengerHunt/ScavengerHunt_setup.php");
 */

class ScavengerHunt {

	const HASH_SALT = 'ScavengerHuntSalt';
	const CACHE_TTL = 7200;

	protected $parser = null;
	protected $parserOptions = null;
	protected $fakeTitle = null;

	protected function getCache() {
		return WF::build('App')->getGlobal('wgMemc');
	}
	protected function getMemcKey( $arguments = null ) {
		$args = func_get_args();
		array_unshift($args, 'wfMemcKey');
		return call_user_func_array(array(WF::build('App'), 'runFunction'), $args);
	}

	public function parse( $text ) {
		if (empty($this->parser)) {
			$this->parser = WF::build('Parser');
			$this->parser->setOutputType(OT_HTML);
			$this->parserOptions = WF::build('ParserOptions');
			$this->fakeTitle = WF::build('FakeTitle', array(''));
		}

		return $this->parser->parse($text, $this->fakeTitle, $this->parserOptions, false)->getText();
	}

	public function parseCached( $text ) {
		$hash = md5(self::HASH_SALT . $text);
		$key = $this->getMemcKey(__CLASS__, 'parse-text-cache', $hash);
		$cache = $this->getCache();
		$parsed = $cache->get($key);
		if (!is_string($parsed)) {
			$parsed = $this->parse($text);
			$cache->set($key, $parsed, self::CACHE_TTL);
		}
		return $parsed;
	}

	protected function getStyleForImageOffset( $offset ) {
		return sprintf("left: %dpx; top: %dpx;",
			intval(@$offset['left']), intval(@$offset['top']));
	}

	public function getStartingClueHtml( ScavengerHuntGame $game ) {
		// build entry form html
		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));
		$template->set_vars(array(
			'text' => $this->parseCached( $game->getStartingClueText() ),
			'buttonText' => $game->getStartingClueButtonText(),
			'buttonTarget' => $game->getStartingClueButtonTarget(),
			'imageSrc' => $game->getStartingClueImage(),
			'imageOffset' => $game->getStartingClueImageOffset(),
		));
		return $template->render('modal-clue');
	}

	public function getClueHtml( ScavengerHuntGameArticle $article ) {
		// build entry form html
		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));
		$template->set_vars(array(
			'text' => $this->parseCached( $article->getClueText() ),
			'buttonText' => $article->getClueButtonText(),
			'buttonTarget' => $article->getClueButtonTarget(),
			'imageSrc' => $article->getClueImage(),
			'imageOffset' => $article->getClueImageOffset(),
		));
		return $template->render('modal-clue');
	}

	public function getEntryFormHtml( ScavengerHuntGame $game ) {
		// build entry form html
		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));
		$template->set_vars(array(
			'title' => $game->getEntryFormTitle(),
			'text' => $this->parseCached( $game->getEntryFormText() ),
			'question' => $this->parseCached( $game->getEntryFormQuestion() ),
			'imageSrc' => $game->getEntryFormImage(),
			'imageOffset' => $game->getEntryFormImageOffset(),
		));
		return $template->render('modal-form');
	}

	public function getGoodbyeHtml( ScavengerHuntGame $game ) {
		// build entry form html
		$landingTitle = WF::build('Title', array($game->getLandingTitle()), 'newFromText');
		$landingTitle = empty($landingTitle) ? null : $landingTitle->getFullURL();

		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));
		$template->set_vars(array(
			'title' => $game->getGoodbyeTitle(),
			'text' => $this->parseCached( $game->getGoodbyeText() ),
			'shareUrl' => $landingTitle,
			'imageSrc' => $game->getGoodbyeImage(),
			'imageOffset' => $game->getGoodbyeImageOffset(),
		));
		return $template->render('modal-clue');
	}


	public function updateVisitedIds( ScavengerHuntGame $game, &$visitedIds ) {
		$articleIds = $game->getArticleIds();
		$visitedIds = array_unique( array_map( 'intval', $visitedIds ) );
		$visitedIds = array_intersect( $articleIds, $visitedIds );
		sort($visitedIds);
		return count($articleIds) == count($visitedIds);
	}

	/*
	 * hook handler
	 *
	 * @author Marooned
	 * @author wladek
	 */
	public function onMakeGlobalVariablesScript( &$vars ) {
		wfProfileIn(__METHOD__);

		$app = WF::build('App');
		$out = $app->getGlobal('wgOut');
		$title = $app->getGlobal('wgTitle');
		$articleId = $title->getArticleId();

		// skip the rest if the title does not have article id
		if (!$articleId) {
			return true;
		}

		$games = WF::build('ScavengerHuntGames');

		//TODO: limit below code to content namespaces?
		$triggers = $games->getTitleTriggers($title);
		if (!empty($triggers)) {
			if (!empty($triggers['start'])) {
				$game = $games->findHereEnabledById(reset($triggers['start']));
				if (!empty($game)) {
					//variables for starting page
					$vars['ScavengerHuntStart'] = (int)$game->getId();
					$vars['ScavengerHuntStartMsg'] = $game->getLandingButtonText();
					$vars['ScavengerHuntStartClueTitle'] = $game->getStartingClueTitle();
					$vars['ScavengerHuntStartClueHtml'] = $this->getStartingClueHtml($game);
				}
			}
			if (!empty($triggers['article'])) {
				$game = $games->findHereEnabledById(reset($triggers['article']));
				if (!empty($game)) {
					$article = $game->findArticleById($articleId);
					if (!empty($article)) {
						//variables for article page
						$vars['ScavengerHuntArticleGameId'] = (int)$game->getId();
					}
				}
			}

			//include JS and CSS when on any page connected to the game
			$out->addScriptFile($app->getGlobal('wgScriptPath') . '/extensions/wikia/ScavengerHunt/js/scavenger-game.js');
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/*
	 * hook handler
	 *
	 * @author Marooned
	 * @author wladek
	 */
	public function onBeforePageDisplay($out, $skin) {
		wfProfileIn(__METHOD__);

		//TODO: check if page from game
		$app = WF::build('App');
		$out->addStyle($app->runFunction('wfGetSassUrl', 'extensions/wikia/ScavengerHunt/css/scavenger-game.scss'));

		wfProfileOut(__METHOD__);
		return true;
	}
}