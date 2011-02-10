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

class ScavengerHuntAjax {

	static public function getArticleData() {
		wfProfileIn(__METHOD__);

		$app = WF::build('App');
		$helper = WF::build('ScavengerHunt');
		$request = $app->getGlobal('wgRequest');

		$games = WF::build('ScavengerHuntGames');
		$gameId = $request->getVal('gameId', false);
		$game = $games->findEnabledById((int)$gameId);

		$articleId = $request->getInt('articleId', false);
		$article = $game->findArticleById($articleId);

		if (!empty($game) && !empty($article)) {
			$visitedIds = isset($_COOKIE['ScavengerHuntArticlesFound']) ? explode(',',(string)$_COOKIE['ScavengerHuntArticlesFound']) : array();
			$visitedIds[] = $articleId;
			$completed = $helper->updateVisitedIds($game,$visitedIds);
			$visitedIds = implode(',',$visitedIds);

			if ($completed) {
				$result = array(
					'status' => true,
					'completed' => true,
					'visitedIds' => $visitedIds,
					'hiddenImage' => $article->getHiddenImage(),
					'hiddenImageOffset' => $article->getHiddenImageOffset(),
					'entryFormTitle' => $game->getEntryFormTitle(),
					'entryFormContent' => $helper->getEntryFormHtml($game),
				);
			} else {
				if (!empty($article)) {
					$result = array(
						'status' => true,
						'completed' => false,
						'visitedIds' => $visitedIds,
						'hiddenImage' => $article->getHiddenImage(),
						'hiddenImageOffset' => $article->getHiddenImageOffset(),
						'clueTitle' => $article->getClueTitle(),
						'clueContent' => $helper->getClueHtml($article),
					);
				} else {
					// article is not in game
					$result = array(
						'status' => false,
						'error' => 'article-not-in-game',
					);
				}
			}
		} else {
			// game not found
			$result = array(
				'status' => false,
				'error' => 'game-not-found',
			);
		}

		wfProfileOut(__METHOD__);
		return $result;
	}

	static public function pushEntry() {
		wfProfileIn(__METHOD__);

		$app = WF::build('App');
		$helper = WF::build('ScavengerHunt');
		$request = $app->getGlobal('wgRequest');

		$games = WF::build('ScavengerHuntGames');
		$gameId = $request->getVal('gameId', false);
		$game = $games->findEnabledById((int)$gameId);

		if (!empty($game)) {
			$visitedIds = $request->getVal('visitedIds');
			$visitedIds = $visitedIds ? explode(',',(string)$visitedIds) : array();
			$completed = $helper->updateVisitedIds($game,$visitedIds);
			if ($completed) {
				$name = $request->getVal('name','');
				$email = $request->getVal('email','');
				$answer = $request->getVal('answer','');

				// XXX: validate data

				$user = $app->getGlobal('wgUser');

				$entry = $games->getEntries()->newEntry();
				$entry->setUserId($user->getId());
				$entry->setName($name);
				$entry->setEmail($email);
				$entry->setAnswer($answer);

				if ($game->addEntry($entry)) {
					$result = array(
						'status' => true,
						'goodbyeTitle' => $game->getGoodbyeTitle(),
						'goodbyeContent' => $helper->getGoodbyeHtml($game),
					);
				} else {
					// entry could not be added
					$result = array(
						'status' => false,
						'error' => 'entry-save-error',
					);
				}
			} else {
				// game was not completed
				$result = array(
					'status' => false,
					'error' => 'game-was-not-completed',
				);
			}
		} else {
			// game not found
			$result = array(
				'status' => false,
				'error' => 'game-not-found',
			);
		}

		wfProfileOut(__METHOD__);
		return $result;
	}

}
