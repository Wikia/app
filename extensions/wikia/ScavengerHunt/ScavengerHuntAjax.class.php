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
		$articleId = $request->getVal('articleId', false);
		$gameId = $request->getVal('gameId', false);
		$result = array(
			'buttonLink' => 'TODO: link here',
			'clue' => 'TODO: clue here',
			'img' => 'TODO: img here'
		);

		wfProfileOut(__METHOD__);
		return $result;
	}
}