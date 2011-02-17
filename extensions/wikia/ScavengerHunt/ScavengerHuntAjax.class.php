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
			$visitedIds = isset($_COOKIE['ScavengerHuntArticlesFound']) ? explode(',', (string)$_COOKIE['ScavengerHuntArticlesFound']) : array();
			$visitedIds[] = $articleId;
			$completed = $helper->updateVisitedIds($game, $visitedIds);
			$visitedIds = implode(',', $visitedIds);

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
			$visitedIds = $visitedIds ? explode(',', (string)$visitedIds) : array();
			$completed = $helper->updateVisitedIds($game, $visitedIds);
			if ($completed) {
				$name = $request->getVal('name', '');
				$email = $request->getVal('email', '');
				$answer = $request->getVal('answer', '');

				if (!empty($name) && !empty($email) && !empty($answer)) {
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
					// validation failed
					$result = array(
						'status' => false,
						'error' => 'validation-failed',
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

	/**
	 * generate modal preview
	 * @author Marooned
	 */
	static public function getPreviewForm() {
		wfProfileIn(__METHOD__);

		$app = WF::build('App');
		$helper = WF::build('ScavengerHunt');
		$request = $app->getGlobal('wgRequest');
		$type = $request->getVal('type');
		$data = json_decode($request->getVal('formData'), true);

		$template = WF::build('EasyTemplate', array(dirname( __FILE__ ) . '/templates/'));

		switch ($type) {
			case 'scavenger-starting':
				$tmplName = 'modal-clue';
				$title = $data['startingClueTitle'];
				$template->set_vars(array(
					'text' => $helper->parse( $data['startingClueText'] ),
					'buttonText' => $data['startingClueButtonText'],
					'buttonTarget' => $data['startingClueButtonTarget'],
					'imageSrc' => $data['startingClueImage'],
					'imageOffset' => array(
						'top' => $data['startingClueImageTopOffset'],
						'left' => $data['startingClueImageLeftOffset']
					)
				));
				break;

			case 'scavenger-article':
				$tmplName = 'modal-clue';
				$title = $data['articleClueTitle[]'];
				$template->set_vars(array(
					'text' => $helper->parse( $data['articleClueText[]'] ),
					'buttonText' => $data['articleClueButtonText[]'],
					'buttonTarget' => $data['articleClueButtonTarget[]'],
					'imageSrc' => $data['articleClueImage[]'],
					'imageOffset' => array(
						'top' => $data['articleClueImageTopOffset[]'],
						'left' => $data['articleClueImageLeftOffset[]']
					)
				));
				break;

			case 'scavenger-entry':
				$tmplName = 'modal-form';
				$title = $data['entryFormTitle'];
				$template->set_vars(array(
					'text' => $helper->parse( $data['entryFormText'] ),
					'question' => $helper->parse( $data['entryFormQuestion'] ),
					'imageSrc' => $data['entryFormImage'],
					'imageOffset' => array(
						'top' => $data['entryFormImageTopOffset'],
						'left' => $data['entryFormImageLeftOffset']
					)
				));
				break;

			case 'scavenger-goodbye':
				$tmplName = 'modal-clue';
				$title = $data['goodbyeTitle'];

				$landingTitle = null;
				if (isset($data['landingTitle'])) {
					if ($landingTitle = WF::build('Title', array($data['landingTitle']), 'newFromText')) {
						$landingTitle = $landingTitle->getFullURL();
					}
				}

				$template->set_vars(array(
					'text' => $helper->parse( $data['goodbyeText'] ),
					'imageSrc' => $data['goodbyeImage'],
					'imageOffset' => array(
						'top' => $data['goodbyeImageTopOffset'],
						'left' => $data['goodbyeImageLeftOffset']
					),
					'shareUrl' => $landingTitle
				));
				break;
		}

		$result = array(
			'title' => $title,
			'content' => $template->render($tmplName),
		);

		wfProfileOut(__METHOD__);
		return $result;
	}
}