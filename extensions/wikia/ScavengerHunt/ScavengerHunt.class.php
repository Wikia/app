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

	protected function getStyleForImageOffset( $offset ) {
		return sprintf("left: %dpx; top: %dpx;",
			intval(@$offset['left']), intval(@$offset['top']));
	}

	public function getStartingClueHtml( ScavengerHuntGame $game ) {
		// build entry form html
		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));
		$template->set_vars(array(
			'text' => $game->getStartingClueText(),
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
			'text' => $article->getClueText(),
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
			'text' => $game->getEntryFormText(),
			'question' => $game->getEntryFormQuestion(),
			'imageSrc' => $game->getEntryFormImage(),
			'imageOffset' => $game->getEntryFormImageOffset(),
		));
		return $template->render('modal-form');
	}

	public function getGoodbyeHtml( ScavengerHuntGame $game ) {
		// build entry form html
		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));
		$template->set_vars(array(
			'title' => $game->getGoodbyeTitle(),
			'text' => $game->getGoodbyeText(),
			'buttonText' => wfMsg('scavengerhunt-goodbye-button-text'),
			'buttonTarget' => '',
			'imageSrc' => $game->getEntryFormImage(),
			'imageOffset' => $game->getEntryFormImageOffset(),
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
				$game = $games->findEnabledById(reset($triggers['start']));
				if (!empty($game)) {
					//variables for starting page
					$vars['ScavengerHuntStart'] = (int)$game->getId();
					$vars['ScavengerHuntStartMsg'] = $game->getLandingButtonText();
					$vars['ScavengerHuntStartClueTitle'] = $game->getStartingClueTitle();
					$vars['ScavengerHuntStartClueHtml'] = $this->getStartingClueHtml($game);
				}
			}
			if (!empty($triggers['article'])) {
				$game = $games->findEnabledById(reset($triggers['article']));
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