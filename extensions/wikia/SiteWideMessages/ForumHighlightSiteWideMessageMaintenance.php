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

$links = [
	'en' => 'https://community.wikia.com/wiki/Thread:1565872',
	'de' => 'http://de.community.wikia.com/wiki/Benutzer_Blog:Mira_Laime/Ab_Mitte_Dezember_k%C3%B6nnen_Foren-Threads_nicht_mehr_hervorgehoben_werden',
	'es' => 'https://comunidad.wikia.com/wiki/Hilo:151586',
	'it' => 'http://it.community.wikia.com/wiki/Conversazione:18835',
	'ja' => 'http://ja.community.wikia.com/wiki/%E3%82%B9%E3%83%AC%E3%83%83%E3%83%89:9887',
	'pl' => 'http://spolecznosc.wikia.com/wiki/W%C4%85tek:51360',
	'pt-br' => 'https://comunidade.wikia.com/wiki/Conversa:27521',
	'ru' => 'http://ru.community.wikia.com/wiki/%D0%A2%D0%B5%D0%BC%D0%B0:139214',
	'zh' => 'http://zh.community.wikia.com/wiki/%E5%B8%96%E5%AD%90:20761',
];


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
			$language = Language::newFromCode( $lang );
			// Set timestamp to a projected date of releasing code that removes forum highlight
			$timestamp = 0;
			$date = $language->date( $timestamp );
			$link = $links[$lang] || $links['en'];

			$message = wfMessage( 'forum-highlight-retirement-sitewide-message' )
				->inLanguage( $language )
				->text();

			//this needs to get filled with list of admins and a message
			$taskArgs = [
				'sendModeWikis' => 'WIKIS',
				// fill out the rest of params
			];

			$task = new \Wikia\Tasks\Tasks\SiteWideMessagesTask();
			$task->call( 'send', $taskArgs );
		}
	}
}
