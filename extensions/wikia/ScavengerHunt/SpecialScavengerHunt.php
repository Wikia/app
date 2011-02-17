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

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor('scavengerhunt');

		if ($this->isRestricted() && !$this->userCanExecute($this->user)) {
			$this->displayRestrictionError();
			return;
		}

		@list( $action, $id ) = explode('/', $subpage);
		$action = !empty($action) ? $action : 'list';
		$id = (int)$id;
		$game = $this->games->findHereById($id);
		if (empty($game)) $game = $this->games->newGame();

		// check edit tokens
		if ($this->request->wasPosted() && !$this->user->matchEditToken($this->request->getVal('wpEditToken'))) {
			NotificationsModule::addConfirmation(
				wfMsg('scavengerhunt-edit-token-mismatch'),
				NotificationsModule::CONFIRMATION_ERROR
			);
			$this->out->redirect( $this->mTitle->getFullUrl() );
			return;
		}


		$this->out->addStyle($this->app->runFunction('wfGetSassUrl', 'extensions/wikia/ScavengerHunt/css/scavenger-special.scss'));
		$this->out->addScriptFile($this->app->getGlobal('wgScriptPath') . '/extensions/wikia/ScavengerHunt/js/scavenger-special.js');
		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));

		$errors = array();
		switch ($action) {
			case 'list':
				$button = "<a class='wikia-button scavengerhunt-add-button' href='" . $this->mTitle->getFullUrl() . "/add'>".
					XML::element("img", array( "class" => "sprite new", "src" => $this->app->getGlobal('wgBlankImgUrl'))) . wfMsg('scavengerhunt-button-add') . "</a>";

				$this->out->mPagetitle .= $button;
				$this->out->mPageLinkTitle = true;

				// Games list
				$pager = WF::build('ScavengerHuntGamesPager', array($this->games, $this->mTitle->getFullUrl(), $template));
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
						$errors = $this->validateGame($game);

						if (empty($errors)) {
							$game->save();

							NotificationsModule::addConfirmation(
								$enabled
								? wfMsg('scavengerhunt-game-has-been-enabled')
								: wfMsg('scavengerhunt-game-has-been-disabled')
							);

							$this->out->redirect( $this->mTitle->getFullUrl() . "/edit/$id" );
							return;
						}
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
				$template->set('editToken', $this->user->editToken());
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
			$game = $this->games->findHereById($gameId, true);
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
		$articleHiddenImageTopOffsets = $this->request->getArray('articleHiddenImageTopOffset');
		$articleHiddenImageLeftOffsets = $this->request->getArray('articleHiddenImageLeftOffset');
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
				'hiddenImageTopOffset' => $articleHiddenImageTopOffsets[$i],
				'hiddenImageLeftOffset' => $articleHiddenImageLeftOffsets[$i],
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

		$data = $game->getAll();
		if (empty($data['name'])) {
			$errors[] = wfMsg( 'scavengerhunt-form-error-name' );
		}

		if (!$game->isEnabled()) {
			return;
		}

		if ( empty($data['landingTitle']) ) {
			$errors[] = wfMsg( 'scavengerhunt-form-error-no-landing-title' );
		} else if ( empty($data['landingArticleId']) ) {
			$errors[] = wfMsg( 'scavengerhunt-form-error-invalid-title', $data['landingTitle'] );
		}
		if (empty($data['landingButtonText'])) {
			$errors[] = wfMsg( 'scavengerhunt-form-error-landing-button-text' );
		}
		if (empty($data['startingClueTitle']) || empty($data['startingClueText']) || empty($data['startingClueImage'])
				|| empty($data['startingClueButtonText']) || empty($data['startingClueButtonTarget']) ) {
			$errors[] = wfMsg( 'scavengerhunt-form-error-starting-clue' );
		}
		if (empty($data['entryFormTitle']) || empty($data['entryFormText']) || empty($data['entryFormImage'])
				|| empty($data['entryFormQuestion']) ) {
			$errors[] = wfMsg( 'scavengerhunt-form-error-entry-form' );
		}
		if (empty($data['goodbyeTitle']) || empty($data['goodbyeText']) || empty($data['goodbyeImage']) ) {
			$errors[] = wfMsg( 'scavengerhunt-form-error-goodbye' );
		}

		foreach ($data['articles'] as $article) {
			$article = $article->getAll();
			if ( empty($article['title']) ) {
				$errors[] = wfMsg( 'scavengerhunt-form-error-no-article-title' );
			} else if ( empty($article['articleId']) ) {
				$errors[] = wfMsg( 'scavengerhunt-form-error-invalid-title', $article['title'] );
			}
			if ( empty($article['hiddenImage']) ) {
				$errors[] = wfMsg( 'scavengerhunt-form-error-article-hidden-image' );
			}
			if ( empty($article['clueTitle']) || empty($article['clueText']) || empty($article['clueImage'])
					|| empty($article['clueButtonText']) || empty($article['clueButtonTarget']) ) {
				$errors[] = wfMsg( 'scavengerhunt-form-error-article-clue', $article['title'] );
			}
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
		while ($entries = $game->listEntries($startId, $limit)) {
			$rows = array();
			$entriesInLoop = min(count($entries), $limit-1);
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
		$wikiId = WF::build('App')->getGlobal('wgCityId');
		return array(
			'tables' => ScavengerHuntGames::GAMES_TABLE_NAME,
			'fields' => '*',
			'conds' => array(
				'wiki_id' => $wikiId,
			),
		);
	}

	public function getIndexField() {
		return 'game_id';
	}
}