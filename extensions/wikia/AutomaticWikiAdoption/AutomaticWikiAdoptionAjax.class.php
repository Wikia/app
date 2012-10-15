<?php
/**
 * AutomaticWikiAdoption
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-05
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/AutomaticWikiAdoption/AutomaticWikiAdoption_setup.php");
 */

class AutomaticWikiAdoptionAjax {
	/**
	 * dismiss notification
	 *
	 * @author Marooned
	 */
	public static function dismiss() {
		wfProfileIn(__METHOD__);
		global $wgRequest;

		$result = false;

		// this request should be posted
		if ($wgRequest->wasPosted()) {
			AutomaticWikiAdoptionHelper::dismissNotification();
			$result = true;
		}

		wfProfileOut(__METHOD__);
		return array('result' => $result);
	}
}