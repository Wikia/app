<?php
/**
 * AutomaticWikiAdoptionJobSendMail
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 * Maintenance script - helper class
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-08
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage Maintanance
 *
 */

class AutomaticWikiAdoptionJobSendMail {
	function execute($commandLineOptions, $jobOptions, $wikiId, $wikiData) {
		wfLoadExtensionMessages('AutomaticWikiAdoption');
		//at least one admin has not edited during xx days
		foreach ($wikiData['admins'] as $adminId) {
			//print info
			if (!isset($commandLineOptions['quiet'])) {
				echo "Sending e-mail to user (id:$adminId) on wiki (id:$wikiId).\n";
			}

			$adminUser = User::newFromId($adminId);
			if ($adminUser->isEmailConfirmed()) {
				//TODO: add some parameters (at least link to wiki)
				$adminUser->sendMail(
					wfMsgForContent("automaticwikiadoption-mail-{$jobOptions['mailType']}-subject"),
					wfMsgForContent("automaticwikiadoption-mail-{$jobOptions['mailType']}-content"),
					null, //from
					null, //replyto
					'AutomaticWikiAdoption',
					wfMsgForContent("automaticwikiadoption-mail-{$jobOptions['mailType']}-content-HTML")
				);
			}
		}
	}
}