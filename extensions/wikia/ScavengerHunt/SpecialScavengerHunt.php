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

	protected function getBlankImgUrl() {
		return $this->app->getGlobal('wgBlankImgUrl');
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
				$button = "<a class='wikia-button scavengerhunt-add-button' href='".$this->mTitle->getFullUrl()."/add'>".
					XML::element("img",array( "class" => "sprite new", "src" => $this->app->getGlobal('wgBlankImgUrl'))).wfMsg('scavengerhunt-button-add')."</a>";

				$this->out->mPagetitle .= $button;
				$this->out->mPageLinkTitle = true;

				// Games list
				$pager = WF::build('ScavengerHuntGamesPager',array($this->games,$this->mTitle->getFullUrl(),$template));
				$this->out->addHTML(
					$pager->getBody() .
					$pager->getNavigationBar()
				);

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
						/*
						$entries = $game->listEntries();

						$csvService = new CsvService();
						$csvService->output($headers, $entries);
						*/

						$this->printEntriesAsCsv($game);

						return;
					}
				}
				// no "break" on purpose
			case 'add':
				$errors = array();
				if ($this->request->wasPosted()) {
					if ($this->request->getVal('save')) {
						$game = $this->updatePostedGame($game);
						// move the validation process to the moment of enabling the game
						$errors = $this->validateGame($game);
						// save changes
						if (empty($errors) && $game->save()) {
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

		if ($game->getId() == 0) {
			$game->setWikiId($this->app->getGlobal('wgCityId'));
		}


		$game->setAll(array(
			'name' => $this->request->getVal('name'),
			'landingTitle' => $this->request->getVal('landingTitle'),
			'landingButtonText' => $this->request->getVal('landingButtonText'),
			'startingClueTitle' => $this->request->getVal('startingClueTitle'),
			'startingClueText' => $this->request->getVal('startingClueText'),
			'startingClueImage' => $this->request->getVal('startingClueImage'),
			'startingClueImageTopOffset' => $this->request->getVal('startingClueImageTopOffset'),
			'startingClueImageLeftOffset' => $this->request->getVal('startingClueImageLeftOffset'),
			'startingClueButtonText' => $this->request->getVal('startingClueButtonText'),
			'startingClueButtonTarget' => $this->request->getVal('startingClueButtonTarget'),
			'entryFormTitle' => $this->request->getVal('entryFormTitle'),
			'entryFormText' => $this->request->getVal('entryFormText'),
			'entryFormImage' => $this->request->getVal('entryFormImage'),
			'entryFormImageTopOffset' => $this->request->getVal('entryFormImageTopOffset'),
			'entryFormImageLeftOffset' => $this->request->getVal('entryFormImageLeftOffset'),
			'entryFormQuestion' => $this->request->getVal('entryFormQuestion'),
			'goodbyeTitle' => $this->request->getVal('goodbyeTitle'),
			'goodbyeText' => $this->request->getVal('goodbyeText'),
			'goodbyeImage' => $this->request->getVal('goodbyeImage'),
			'goodbyeImageTopOffset' => $this->request->getVal('goodbyeImageTopOffset'),
			'goodbyeImageLeftOffset' => $this->request->getVal('goodbyeImageLeftOffset'),
		));

		//create list of articles
		$articleTitles = $this->request->getArray('articleTitle');
		$articleHiddenImages = $this->request->getArray('articleHiddenImage');
		$articleClueTitles = $this->request->getArray('articleClueTitle');
		$articleClueTexts = $this->request->getArray('articleClueText');
		$articleClueImages = $this->request->getArray('articleClueImage');
		$articleClueImageTopOffsets = $this->request->getArray('articleClueImageTopOffset');
		$articleClueImageLeftOffsets = $this->request->getArray('articleClueImageLeftOffset');
		$articleClueButtonTexts = $this->request->getArray('articleClueButtonText');
		$articleClueButtonTargets = $this->request->getArray('articleClueButtonTarget');

		$articles = array();
		$count = count($articleTitles);
		for ($i = 0; $i < $count; $i++) {
			if (empty($articleTitles[$i])) {
				continue;
			}
			$article = $game->newGameArticle();
			$article->setAll(array(
				'title' => $articleTitles[$i],
				'hiddenImage' => $articleHiddenImages[$i],
				'clueTitle' => $articleClueTitles[$i],
				'clueText' => $articleClueTexts[$i],
				'clueImage' => $articleClueImages[$i],
				'clueImageTopOffset' => $articleClueImageTopOffsets[$i],
				'clueImageLeftOffset' => $articleClueImageLeftOffsets[$i],
				'clueButtonText' => $articleClueButtonTexts[$i],
				'clueButtonTarget' => $articleClueButtonTargets[$i],
			));
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
		$entryFormText = $game->getEntryFormQuestion();
		if (empty($entryFormText)) {
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
			/*
			if (empty($hiddenImage)) {
				$errors[] = wfMsg( 'scavengerhunt-form-no-hidden-image' );
			}
			if (empty($clueText)) {
				$errors[] = wfmsg( 'scavengerhunt-form-no-clue-text' );
			}
			*/
		}

		wfProfileOut(__METHOD__);
		return $errors;
	}

	protected function getTemplateVarsFromGame( ScavengerHuntGame $game ) {
		wfProfileIn(__METHOD__);

		$vars = $game->getAll();
		$vars['gameId'] = $vars['id'];
		$vars['enabled'] = $vars['isEnabled'];
		foreach ($vars['articles'] as $k => $v) {
			$vars['articles'][$k] = $vars['articles'][$k]->getAll();
		}
		$vars['articles'][] = $game->newGameArticle()->getAll();
		unset($vars['id']);
		unset($vars['isEnabled']);

		wfProfileOut(__METHOD__);
		return $vars;
	}

	protected function printEntriesAsCsv( ScavengerHuntGame $game ) {
		$csv = new CsvService();
		// print header
		$csv->printHeaders('game_entries.csv');
		$csv->printRow(array(
			'Name',
			'Email',
			'Answer',
		));

		$startId = 0;
		$limit = 501;
		while ($entries = $game->listEntries($startId,$limit)) {
			$rows = array();
			$entriesInLoop = min(count($entries),$limit-1);
			for ($i=0;$i<$entriesInLoop;$i++) {
				$entry = $entries[$i];
				$rows[] = array(
					$entry->getName(),
					$entry->getEmail(),
					$entry->getAnswer(),
				);
			}
			$csv->printRows($rows);
			if (count($entries) < $limit) {
				break;
			} else {
				$startId = $entries[$limit-1]->getEntryId();
			}
		}
	}

}

class ScavengerHuntGamesPager extends AlphabeticPager {

	protected $games = null;
	protected $url = '';
	/**
	 * @var EasyTemplate
	 */
	protected $tpl = null;

	public function __construct( ScavengerHuntGames $games, $url, $tpl ) {
		parent::__construct();
		$this->games = $games;
		$this->url = $url;
		$this->tpl = $tpl;
		$this->mDb = $this->games->getDb();
	}

	public function formatRow( $row ) {
		$this->tpl->reset();
		$game = $this->games->newGameFromRow($row);
		$this->tpl->set_vars(array(
			'editUrl' => $this->url . "/edit/" . ((int)$game->getId()),
			'game' => $game,
		));
		return $this->tpl->render('game-list-item');
	}

	public function getStartBody() {
		$this->tpl->reset();
		return $this->tpl->render('game-list-top');
	}

	public function getEndBody() {
		$this->tpl->reset();
		return $this->tpl->render('game-list-bottom');
	}

	public function getQueryInfo() {
		return array(
			'tables' => ScavengerHuntGames::GAMES_TABLE_NAME,
			'fields' => '*',
		);
	}

	public function getIndexField() {
		return 'game_id';
	}
}