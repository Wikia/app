<?php

/**
 * @package MediaWiki
 * @subpackage SiteWideMessages
 * @author Bartłomiej Kowalczyk <bkowalczyk at wikia-inc.com> for Wikia.com
 * @copyright (C) 2018, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */

use Wikia\Logger\Loggable;

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

/**
 * @name ForumHighlightSiteWideMessageMaintenance
 *
 * class used by maintenance/background script
 */
class SiteWideMessagesMaintenance {

	use Loggable;

	/**
	 * execute
	 *
	 * Main entry point, only public function
	 * Function runs once to send sitewide message about retiring forum higlight feature
	 *
	 * @author bkoval
	 * @access public
	 * @throws MWException
	 */
	public function execute() {
		// Get all the Wikis with forum enabled
		$wikisWithForumEnabled = WikiFactory::getListOfWikisWithVar( 'wgEnableForumExt', 'bool', '=', true );
		$siteWideMessageReceiversWithLang = [];
		$wikiService = new WikiService();

		foreach ( $wikisWithForumEnabled as $wikiId => $wikiData ) {
			$wikiLang = $wikiData['lang'];
			$messageLang = Localizer::isSupportedLanguage( $wikiLang ) ? $wikiLang : 'en';
			// Get all admins of each wiki
			$adminsOfCurrentWiki = $wikiService->getWikiAdminIds( $wikiId, false, true );

			if ( sizeof( $adminsOfCurrentWiki ) > 0 ) {
				// array uses language codes as keys and lists of admins as values
				if ( !array_key_exists( $messageLang, $siteWideMessageReceiversWithLang ) ) {
					$siteWideMessageReceiversWithLang[$messageLang] = [];
				}

				$siteWideMessageReceiversWithLang[$messageLang] = array_merge(
					$siteWideMessageReceiversWithLang[$messageLang],
					$adminsOfCurrentWiki
				);
			}
		}

		// For each specific language, send a forum higlight removal message, but localized in their language
		foreach ( $siteWideMessageReceiversWithLang as $lang => $receiversInLang ) {
			$language = Language::newFromCode($lang);
			// Set timestamp to a projected date of releasing code that removes forum highlight
			$timestamp = 0;
			$date = $language->date($timestamp);

			//this needs to gett filled with list of admins and a (parsed?) message localized in $language
			$taskArgs = [
				'sendModeWikis' => 'WIKIS',

			];

			$task = new \Wikia\Tasks\Tasks\SiteWideMessagesTask();
			$task->call( 'send', $taskArgs );
		}
	}
}
