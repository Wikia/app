<?php
/**
 * CommunityMessages
 *
 * A CommunityMessages extension for MediaWiki
 * Helper extension for Community Messages
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-07-30
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/CommunityMessages/CommunityMessages_setup.php");
 */

class CommunityMessagesAjax {

	/**
	 * Dismisses notification
	 *
	 * @author Macbre
	 */
	public static function dismissMessage() {
		wfProfileIn(__METHOD__);
		global $wgRequest;

		$result = false;

		// this request should be posted
		if ($wgRequest->wasPosted()) {
			CommunityMessages::dismissMessage();
			$result = true;
		}

		wfProfileOut(__METHOD__);
		return array('result' => $result);
	}
}
