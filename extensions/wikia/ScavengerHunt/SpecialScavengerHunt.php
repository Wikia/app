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
 *     require_once("$IP/extensions/wikia/ScavengerHunt/ScavengerHunt_setup.php");
 */

class SpecialScavengerHunt extends SpecialPage {
	public function __construct() {
		$this->app = WF::build('App');
		$this->out = $this->app->getGlobal('wgOut');
		$this->request = $this->app->getGlobal('wgRequest');
		$this->user = $this->app->getGlobal('wgUser');
		parent::__construct('ScavengerHunt', 'scavengerhunt');
	}

	public function execute($subpage) {
		wfProfileIn(__METHOD__);

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor('scavengerhunt');

		if ($this->isRestricted() && !$this->userCanExecute($this->user)) {
			$this->displayRestrictionError();
			return;
		}

		$this->out->addStyle($this->app->runFunction('wfGetSassUrl', 'extensions/wikia/ScavengerHunt/css/scavenger-special.scss'));
		$this->out->addScriptFile($this->app->getGlobal('wgScriptPath') . '/extensions/wikia/ScavengerHunt/js/scavenger-special.js');
		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));

		if ($this->request->wasPosted()) {

			//adding new game
			if ($this->request->getVal('add')) {
				$emptyGame = WF::build('ScavengerHuntGame');
				$template->set_vars($this->getTemplateVarsFromGame($emptyGame));
				$this->out->addHTML($template->render('form'));
			}

			//save changes
			elseif ($this->request->getVal('save')) {

				$game = $this->updatePostedGame();

				$errors = $this->validateGame($game);

				if (empty($errors)) {
					// save changes
					$game->saveToDb();

					$this->out->redirect( $this->mTitle->getFullUrl() );
				} else {
					// errors
					$template->set_vars(array(
						'errors' => $errors,
					));
					$template->set_vars($this->getTemplateVarsFromGame($game));
					$this->out->addHTML($template->render('form'));
				}
			}

			//enable/disable game
			elseif ($this->request->getVal('enable')) {
			}

			//delete game
			elseif ($this->request->getVal('delete')) {
			}

			//export to csv
			elseif ($this->request->getVal('export')) {
			}
		} else {
			//default form - entry point
			$template->set_vars(array(
			));

			$this->out->addHTML($template->render('main'));
		}

		wfProfileOut(__METHOD__);
	}

	protected function updatePostedGame( $game = null ) {
		if (empty($game)) {
			$game = WF::build('ScavengerHuntGame', array('id' => (int)$this->request->getVal('gameId'), 'readWrite' => true));
		}

		// set fields
		$game->setWikiId($this->app->getGlobal('wgCityId'));
		$game->setLandingTitle($this->request->getVal('landing'));
		$game->setStartingClueText($this->request->getVal('startingClue'));
		$game->setFinalFormText($this->request->getVal('entryForm'));
		$game->setFinalFormQuestion($this->request->getVal('finalQuestion'));
		$game->setGoodbyeText($this->request->getVal('goodbyeMsg'));

		//create list of articles
		$pageTitles = $this->request->getArray('pageTitle');
		$hiddenImages = $this->request->getArray('hiddenImage');
		$clueImages = $this->request->getArray('clueImage');
		$clues = $this->request->getArray('clue');

		$articles = array();
		$count = count($pageTitles);
		for ($i = 0; $i < $count; $i++) {
			if (empty($pageTitles[$i])) {
				continue;
			}
			$article = WF::build('ScavengerHuntGameArticle');
			$article->setTitle($pageTitles[$i]);
			$article->setHiddenImage($hiddenImages[$i]);
			$article->setSuccessImage($clueImages[$i]);
			$article->setClueText($clues[$i]);
			$articles[] = $arcicle;
		}
		$game->setArticles($articles);
	}

	protected function validateGame( ScavengerHuntGame $game ) {
		$errors = array();

		$landingTitle = $game->getLandingTitle();
		$landingArticleId = $game->getLandingArticleId();
		if (!empty($landingTitle) && empty($landingArticleId)) {
			$errors[] = wfMsg( 'scavengerhunt-form-invalid-landing-title' );
		}
		$finalFormText = $game->getFinalFormText();
		if (empty($finalFormText)) {
			$errors[] =	wfMsg( 'scavengerhunt-form-no-final-form-text' );
		}

		$articles = $game->getArticle();
		foreach ($articles as $n => $article) {
			$articleId = $article->getArticleId();
			$hiddenImage = $article->getHiddenImage();
			$clueText = $article->getClueText();
			if (empty($articleId)) {
				$errors[] = wfMsg( 'scavengerhunt-form-invalid-article-title' );
			}
			if (empty($hiddenImage)) {
				$errors[] = wfMsg( 'scavengerhunt-form-no-hidden-image' );
			}
			if (empty($clueText)) {
				$errors[] = wfmsg( 'scavengerhunt-form-no-clue-text' );
			}
		}

		return $errors;
	}

	protected function getTemplateVarsFromGame( ScavengerHuntGame $game ) {
		$pageTitles = array();
		$hiddenImages = array();
		$clueImages = array();
		$clues = array();
		foreach ($game->getArticles() as $article) {
			$pageTitles[] = $article->getTitle();
			$hiddenImages[] = $article->getHiddenImage();
			$clueImages[] = $article->getSuccessImage();
			$clues[] = $article->getClueText();
		}
		$vars = array(
			'gameId' => $game->getId(),
			'enabled' => $game->isEnabled(),
			'landing' => $game->getLandingTitle(),
			'startingClue' => $game->getStartingClueText(),
			'entryForm' => $game->getFinalFormText(),
			'finalQuestion' => $game->getFinalFormQuestion(),
			'goodbyeMsg' => $game->getGoodbyeText(),
			'pageTitle' => array_merge( $pageTitles, array('') ),
			'hiddenImage' => array_merge( $hiddenImages, array('') ),
			'clueImage' => array_merge( $clueImages, array('') ),
			'clue' => array_merge( $clues, array('') ),
		);

		return $vars;
	}

}