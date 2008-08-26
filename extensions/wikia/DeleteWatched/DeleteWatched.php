<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Notification of watched page deletion
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Tomasz Klim <tomek@wikia.com>
 * @copyright Copyright (C) 2007 Tomasz Klim, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
LocalSettings.php:
+ require_once( "$IP/extensions/DeleteWatched/DeleteWatched.php" );
 *
 */


$wgDeleteWatchedMessages = array();
$wgDeleteWatchedMessages['en'] = array(
	'enotif_subject_del' 	=> '{{SITENAME}} page $PAGETITLE has been deleted by $PAGEEDITOR',
	'enotif_body_del' => 'Dear $WATCHINGUSERNAME,

the {{SITENAME}} page $PAGETITLE has been deleted on $PAGEEDITDATE by $PAGEEDITOR.

Reason of deletion: $PAGESUMMARY $PAGEMINOREDIT

Contact the editor:
mail: $PAGEEDITOR_EMAIL
wiki: $PAGEEDITOR_WIKI

             Your friendly {{SITENAME}} notification system

--
To change your watchlist settings, visit
{{fullurl:{{ns:special}}:Watchlist/edit}}

Feedback and further assistance:
{{fullurl:{{ns:help}}:Contents}}',



	'enotif_subject_move' 	=> '{{SITENAME}} page $PAGETITLE_OLD has been moved by $PAGEEDITOR',
	'enotif_body_move' => 'Dear $WATCHINGUSERNAME,

the {{SITENAME}} page $PAGETITLE_OLD has been moved on $PAGEEDITDATE by $PAGEEDITOR, see $PAGETITLE_URL for the current version.

Contact the editor:
mail: $PAGEEDITOR_EMAIL
wiki: $PAGEEDITOR_WIKI

             Your friendly {{SITENAME}} notification system

--
To change your watchlist settings, visit
{{fullurl:{{ns:special}}:Watchlist/edit}}

Feedback and further assistance:
{{fullurl:{{ns:help}}:Contents}}');



$wgDeleteWatchedMessages['pl'] = array(
	'enotif_subject_del' 	=> 'Strona $PAGETITLE w {{SITENAME}} zostala usunieta przez $PAGEEDITOR',
	'enotif_body_del' => 'Drogi $WATCHINGUSERNAME,

strona $PAGETITLE w {{SITENAME}} zostala usunieta $PAGEEDITDATE przez $PAGEEDITOR.

Powod usuniecia: $PAGESUMMARY $PAGEMINOREDIT

Mozesz sie skontaktowac z usuwajacym:
mail: $PAGEEDITOR_EMAIL
wiki: $PAGEEDITOR_WIKI

             Twoj przyjazny system powiadomien {{SITENAME}}

--
Aby zmienic ustawienia obserwowanych stron, idz do
{{fullurl:{{ns:special}}:Watchlist/edit}}

Komentarze i pomoc:
{{fullurl:{{ns:help}}:Contents}}',



	'enotif_subject_move' 	=> 'Strona $PAGETITLE_OLD w {{SITENAME}} zostala przeniesiona przez $PAGEEDITOR',
	'enotif_body_move' => 'Drogi $WATCHINGUSERNAME,

strona $PAGETITLE_OLD w {{SITENAME}} zostala przeniesiona $PAGEEDITDATE przez $PAGEEDITOR, zobacz jej aktualna wersje pod adresem $PAGETITLE_URL

Mozesz sie skontaktowac z przenoszacym:
mail: $PAGEEDITOR_EMAIL
wiki: $PAGEEDITOR_WIKI

             Twoj przyjazny system powiadomien {{SITENAME}}

--
Aby zmienic ustawienia obserwowanych stron, idz do
{{fullurl:{{ns:special}}:Watchlist/edit}}

Komentarze i pomoc:
{{fullurl:{{ns:help}}:Contents}}');



$wgHooks['ArticleDelete'][] = 'wfArticleDelete';
$wgExtensionCredits['other'][] = array(
	'name' => 'Notify on delete',
	'description' => 'notification of watched page deletion',
	'author' => 'Tomasz Klim'
);

$wgHooks['SpecialMovepageAfterMove'][] = 'wfSpecialMovepageAfterMove';
$wgExtensionCredits['other'][] = array(
	'name' => 'Notify on move',
	'description' => 'notification of watched page move',
	'author' => 'Tomasz Klim'
);


function wfArticleDelete( &$objTitle, &$objUser, &$reason ) {
	global $wgMessageCache, $wgDeleteWatchedMessages, $wgUseEnotif;

	wfProfileIn( __METHOD__ );

	foreach ( $wgDeleteWatchedMessages as $key => $value ) {
		$wgMessageCache->addMessages( $wgDeleteWatchedMessages[$key], $key );
	}

	if ( $wgUseEnotif ) {
		$enotif = new EmailNotification();
		$enotif->notifyOnPageChange( $objTitle->mTitle, wfTimestampNow(), $reason, false, $objTitle->mTitle->getLatestRevID(), '_del' );
	}

	wfProfileOut( __METHOD__ );
	return true;
}


function wfSpecialMovepageAfterMove( &$unused, &$ot, &$nt ) {
	global $wgMessageCache, $wgDeleteWatchedMessages, $wgUseEnotif;

	wfProfileIn( __METHOD__ );

	foreach ( $wgDeleteWatchedMessages as $key => $value ) {
		$wgMessageCache->addMessages( $wgDeleteWatchedMessages[$key], $key );
	}

	if ( $wgUseEnotif ) {
		$enotif = new EmailNotification();
		$enotif->notifyOnPageChange( $nt, wfTimestampNow(), '', false, $nt->getLatestRevID(), '_move', $ot );
	}

	wfProfileOut( __METHOD__ );
	return true;
}


?>
