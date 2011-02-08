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

	/**
	 * @var ScavengerHuntGames
	 */
	protected $games = null;

	public function __construct() {
		$this->app = WF::build('App');
		$this->out = $this->app->getGlobal('wgOut');
		$this->request = $this->app->getGlobal('wgRequest');
		$this->user = $this->app->getGlobal('wgUser');
		parent::__construct('ScavengerHunt', 'scavengerhunt');
	}

	public function execute( $subpage ) {
		wfProfileIn(__METHOD__);

		$this->games = WF::build('ScavengerHuntGames');

		@list( $action, $id ) = explode('/',$subpage);
		$action = !empty($action) ? $action : 'list';
		$id = (int)$id;
		$game = $this->games->findById($id);
		if (empty($game)) $game = $this->games->newGame();

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor('scavengerhunt');

		if ($this->isRestricted() && !$this->userCanExecute($this->user)) {
			$this->displayRestrictionError();
			return;
		}

		$this->out->addStyle($this->app->runFunction('wfGetSassUrl', 'extensions/wikia/ScavengerHunt/css/scavenger-special.scss'));
		$this->out->addScriptFile($this->app->getGlobal('wgScriptPath') . '/extensions/wikia/ScavengerHunt/js/scavenger-special.js');
		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));

		switch ($action) {
			case 'list':
				$template->set_vars(array(
					'addUrl' => $this->mTitle->getFullUrl() . "/add",
				));

				$this->out->addHTML($template->render('main'));
				break;
			case 'edit':
				if ($this->request->wasPosted()) {
					if ($this->request->getVal('enable')) {
						$enabled = !$this->request->getVal('prevEnabled');
						$game->setEnabled($enabled);
						$game->save();

						NotificationsModule::addConfirmation(
							$enabled
							? wfMsg('scavengerhunt-game-has-been-enabled')
							: wfMsg('scavengerhunt-game-has-been-disabled')
						);

						$this->out->redirect( $this->mTitle->getFullUrl() . "/edit/$id" );
						return;
					} else if ($this->request->getVal('delete')) {

						$game->delete();

						NotificationsModule::addConfirmation(
							wfMsg('scavengerhunt-game-has-been-deleted')
						);
						$this->out->redirect( $this->mTitle->getFullUrl() );
						return;
					} else if ($this->request->getVal('export')) {

						$entries = $game->listEntries();

						$csvService = new CsvService();
						$csvService->output($headers, $entries);

						return;
					}
				}
				// no "break" on purpose
			case 'add':
				$errors = array();
				if ($this->request->wasPosted()) {
					if ($this->request->getVal('save')) {
						$game = $this->updatePostedGame($game);
						if ($action == 'add') {
							$game->setWikiId($this->app->getGlobal('wgCityId'));
						}
						$errors = $this->validateGame($game);
						if (empty($errors)) {
							// save changes
							$game->save();

							NotificationsModule::addConfirmation(
								$action == 'add'
								? wfMsg('scavengerhunt-game-has-been-created')
								: wfMsg('scavengerhunt-game-has-been-saved')
							);

							$this->out->redirect( $this->mTitle->getFullUrl() );
							return;
						} else {
							NotificationsModule::addConfirmation(
								wfMsg('scavengerhunt-game-has-not-been-saved'),
								NotificationsModule::CONFIRMATION_PREVIEW
							);
						}
					}
				}
				$template->set('errors', $errors);
				$template->set_vars($this->getTemplateVarsFromGame($game));
				$this->out->addHTML($template->render('form'));
				break;
		}

		wfProfileOut(__METHOD__);
	}

	protected function updatePostedGame( $game = null ) {
		wfProfileIn(__METHOD__);

		if (empty($game)) {
			$gameId = (int)$this->request->getVal('gameId');
			$game = $this->games->findById($gameId,true);
			if (empty($game)) {
				throw new WikiaException("Could not retrieve specified game");
			}
		}

		// set fields
//		$game->setWikiId($this->app->getGlobal('wgCityId'));
		$game->setName($this->request->getVal('gameName'));
		$game->setLandingTitle($this->request->getVal('landing'));
		$game->setStartingClueText($this->request->getVal('startingClue'));
		$game->setStartingClueImage($this->request->getVal('startingImage'));
		$game->setFinalFormText($this->request->getVal('entryForm'));
		$game->setFinalFormQuestion($this->request->getVal('finalQuestion'));
		$game->setGoodbyeText($this->request->getVal('goodbyeMsg'));
		$game->setGoodbyeImage($this->request->getVal('goodbyeImage'));

		//create list of articles
		$pageTitles = $this->request->getArray('pageTitle');
		$hiddenImages = $this->request->getArray('hiddenImage');
		$clueImages = $this->request->getArray('clueImage');
		$clues = $this->request->getArray('clue');
		$clueLinks = $this->request->getArray('clueLink');

		$articles = array();
		$count = count($pageTitles);
		for ($i = 0; $i < $count; $i++) {
			if (empty($pageTitles[$i])) {
				continue;
			}
			$article = WF::build('ScavengerHuntGameArticle');
			$article->setTitle($pageTitles[$i]);
			$article->setHiddenImage($hiddenImages[$i]);
			$article->setClueImage($clueImages[$i]);
			$article->setClueText($clues[$i]);
			$article->setLink($clueLinks[$i]);
			$articles[] = $article;
		}
		$game->setArticles($articles);

		wfProfileOut(__METHOD__);
		return $game;
	}

	protected function validateGame( ScavengerHuntGame $game ) {
		wfProfileIn(__METHOD__);

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

		$articles = $game->getArticles();
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

		wfProfileOut(__METHOD__);
		return $errors;
	}

	protected function getTemplateVarsFromGame( ScavengerHuntGame $game ) {
		wfProfileIn(__METHOD__);

		$pageTitles = array();
		$hiddenImages = array();
		$clueImages = array();
		$clues = array();
		$clueLinks = array();
		foreach ($game->getArticles() as $article) {
			$pageTitles[] = $article->getTitle();
			$hiddenImages[] = $article->getHiddenImage();
			$clueImages[] = $article->getClueImage();
			$clues[] = $article->getClueText();
			$clueLinks[] = $article->getLink();
		}
		$vars = array(
			'gameId' => $game->getId(),
			'enabled' => $game->isEnabled(),
			'gameName' => $game->getName(),
			'landing' => $game->getLandingTitle(),
			'startingClue' => $game->getStartingClueText(),
			'startingImage' => $game->getStartingClueImage(),
			'entryForm' => $game->getFinalFormText(),
			'finalQuestion' => $game->getFinalFormQuestion(),
			'goodbyeMsg' => $game->getGoodbyeText(),
			'goodbyeImage' => $game->getGoodbyeImage(),
			'pageTitle' => array_merge( $pageTitles, array('') ),
			'hiddenImage' => array_merge( $hiddenImages, array('') ),
			'clueImage' => array_merge( $clueImages, array('') ),
			'clue' => array_merge( $clues, array('') ),
			'clueLink' => array_merge( $clueLinks, array('') ),
		);

		wfProfileOut(__METHOD__);
		return $vars;
	}
}