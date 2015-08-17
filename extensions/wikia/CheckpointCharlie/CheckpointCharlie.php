<?php
/**
 * @file CheckpointCharlie.php
 * @brief The CheckpointCharlie MediaWiki extension setup and code.
 * @author Michał ‘Mix’ Roszka <mix@wikia-inc.com>
 * @date Thursday, 7 August 2014 (created)
 */

/**
 * Extension credits.
 */
$wgExtensionCredits['other'][] = array(
	'path'              => __FILE__,
	'name'              => 'CheckpointCharlie',
	'descriptionmsg'    => 'checkpointcharlie-desc',
	'version'           => '1.0',
	'author'            => array( '[http://community.wikia.com/wiki/User:Mroszka Michał ‘Mix’ Roszka]' ),
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CheckpointCharlie/',
);

/**
 * Displays an error message if the IP address or the special page has not been whitelisted.
 */
function efGuardCheckpointCharlie( $oTitle, $unused, $oOutputPage, $oUser, $oWebRequest, $oMediaWiki) {
	global $wgCheckpointCharlieSpecialPagesWhitelist;

	$oRestrictedSessions = new \RestrictSessions\RestrictSessionsHooks();

	if ( !$oRestrictedSessions->isWhiteListedIP( $oWebRequest->getIP() )
		&& NS_SPECIAL == $oTitle->getNamespace()
		&& !in_array( $oTitle->getDBkey(), $wgCheckpointCharlieSpecialPagesWhitelist )
	) {
		throw new ErrorPageError( 'checkpointcharlie-title', 'checkpointcharlie-content' );
	}

	return true;
}

/**
 * Internationalisation
 */
$wgExtensionMessagesFiles['CheckpointCharlie'] = __DIR__ . '/CheckpointCharlie.i18n.php';

/**
 * Hooks.
 */
$wgHooks['BeforeInitialize'][] = 'efGuardCheckpointCharlie';
