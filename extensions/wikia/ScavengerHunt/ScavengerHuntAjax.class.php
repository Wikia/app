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

class ScavengerHuntAjax {
	static public function getArticleData() {
		wfProfileIn(__METHOD__);

		$app = WF::build('App');
		$request = $app->getGlobal('wgRequest');
		$games = WF::build('ScavengerHuntGames');
		$gameId = $request->getVal('gameId', false);
		$game = $games->findById((int)$gameId);

		if (!empty($game)) {
			$articleId = (int)$request->getVal('articleId', false);
			$visitedIds = explode(',',(string)$_COOKIE['ScavengerHuntArticlesFound']);
			$visitedIds[] = $articleId;
			if ($game->isGameCompleted($visitedIds)) {
				// game has just been completed
				$result = array(
					'status' => true,
					'completed' => true,
					'entryForm' => array(
						'title' => $game->getEntryFormTitle(),
						'image' => $game->getEntryFormImage(),
						'question' => $game->getEntryFormQuestion(),
					),
				);
			} else {
				$article = $game->findArticleById($articleId);
				if (!empty($article)) {
					// article is a part of the game
					$result = array(
						'status' => true,
						'completed' => false,
						'clue' => array(
							'title' => $article->getClueTitle(),
							'text' => $article->getClueText(),
							'image' => $article->getClueImage(),
							'buttonText' => $article->getClueButtonText(),
							'buttonTarget' => $article->getClueButtonTarget(),
						),
					);
				} else {
					// article is not in game
					$result = array(
						'status' => false,
					);
				}
			}
		} else {
			// game not found
			$result = array(
				'status' => false,
			);
		}

		wfProfileOut(__METHOD__);
		return $result;
	}
}