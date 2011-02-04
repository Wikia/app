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
				$template->set_vars(array(
					'enabled' => false,
					'gameId' => 0
				));

				$this->out->addHTML($template->render('form'));
			}

			//save changes
			elseif ($this->request->getVal('save')) {
				//TODO: add data validation, show error if required fields are empty
				$game = WF::build('ScavengerHuntGame', array('id' => $this->request->getVal('gameId'), 'readWrite' => true));

				//set fields
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
					$article->setTitle();
					$article->setHiddenImage();
					$article->setSuccessImage();
					$article->setClueText();
					$articles[] = $arcicle;
				}

				$game->setArticles();

				//save to DB
				$game->saveToDb();
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
}