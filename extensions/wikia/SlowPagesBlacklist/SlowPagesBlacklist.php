<?php
/**
 * @file SlowPagesBlacklist.php
 * @brief The SlowPagesBlacklist MediaWiki extension setup and code.
 * @author Michał ‘Mix’ Roszka <mix@wikia-inc.com>
 * @date Tuesday, 17 December 2013 (created)
 */

/**
 * Extension credits.
 */
$wgExtensionCredits['other'][] = array(
    'path'              => __FILE__,
    'name'              => 'SlowPagesBlacklist',
    'description'       => 'Blacklist slow pages to prevent them from being rendered.',
    'descriptionmsg'    => 'slowpagesblacklist-desc',
    'version'           => '1.0',
    'author'            => array( '[http://community.wikia.com/wiki/User:Mroszka Michał ‘Mix’ Roszka]' ),
    'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SlowPagesBlacklist/',
);

/**
 * Displays an error message if the page has been blacklisted and the action implies parsing and rendering.
 */
function efSlowPagesBlacklist( $oTitle, $unused, $oOutputPage, $oUser, $oWebRequest, $oMediaWiki) {
	global $wgSlowPagesBlacklist;
	$sFullUrl = $oTitle->getFullURL();
	if ( in_array( $sFullUrl, $wgSlowPagesBlacklist ) ) {
		switch ( $oMediaWiki->getAction() ) {
			case 'delete':
			case 'history':
			case 'raw':
			case 'rollback':
			case 'submit':
				// Let through.
				break;
			case 'edit':
				// Force text editor since the visual editor implies parsing.
				if ( 'source' != $oWebRequest->getVal( 'useeditor', '' ) ) {
					$oResponse = $oWebRequest->response();
					$iCode = 303;
					$sMessage = HttpStatus::getMessage( $iCode );
					$oResponse->header( "HTTP/1.1 $iCode $sMessage" );
					$oResponse->header( "Location: {$sFullUrl}?action=edit&useeditor=source" );
				}
				break;
			default:
				// If a staff user requested forceview, let through.
				if ( !$oUser->isAllowed( 'forceview' ) || !$oWebRequest->getInt( 'forceview' ) ) {
					throw new ErrorPageError( 'slowpagesblacklist-title', 'slowpagesblacklist-content' );
				}
				break;
		}
	}
	return true;
}

/**
 * Internationalisation
 */
$wgExtensionMessagesFiles['SlowPagesBlacklist'] = __DIR__ . '/SlowPagesBlacklist.i18n.php';

/**
 * Hooks.
 */
$wgHooks['BeforeInitialize'][]   = 'efSlowPagesBlacklist';
