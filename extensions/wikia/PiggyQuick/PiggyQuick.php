<?php
/**
 * @file PiggyQuick.php
 * @brief The PiggyQuick MediaWiki extension setup.
 * @author Michał Roszka (Mix) <michal@wikia-inc.com>
 * @date Friday, 25 May 2012 (created)
 */

// Protect the code of the extension to be executed via a direct request.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

/**
 * @var array $wgExtensionCredits
 * @brief Basic human language information about the extension.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionCredits
 */
$wgExtensionCredits['other'][] = array(
	'path'			=> __FILE__,
	'name'			=> 'PiggyQuick',
	'description'		=> 'Piggyback on steroids. Appears on user profile pages.',
	'descriptionmsg'	=> 'piggyquick-desc',
	'version'		=> '1.0',
	'author'		=> array( '[http://community.wikia.com/wiki/User:Mroszka Michał Roszka (Mix)]' ),
	'url'			=> 'http://trac.wikia-code.com/browser/wikia/trunk/extensions/wikia/PiggyQuick/',
);


/**
 * @var array $wgExtensionMessagesFiles
 * @brief Mapping the extension name to the filename where i18n could be found.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionMessagesFiles
 */
$wgExtensionMessagesFiles['PiggyQuick'] = __DIR__ . '/PiggyQuick.i18n.php';

/**
 * @fn wfPiggyQuickExecute()
 * @param object AccountNavigationController $oController
 * @return boolean true
 * @brief Hooks PiggyQuick feature into the Oasis toolbar.
 */
function wfPiggyQuickExecute( $oController ) {
	global $wgEnablePiggybackExt, $wgUser, $wgTitle;
	// First, make sure the original Piggyback extension is enabled and available.
	$bDependenciesMet = $wgEnablePiggybackExt // true, if the original Piggyback extension is enabled in the config
		&& class_exists( 'Piggyback' ) // true, if the Piggyback's classes are available
		&& class_exists( 'PBLoginForm' )
		&& class_exists( 'PiggybackTemplate' );

	// Find out, whether we are in the right context.
	if (    $bDependenciesMet				// dependencies are met
		&& $wgUser->isAllowed( 'piggyback' )		// user rights are sufficient
		&& NS_USER == $wgTitle->getNamespace()		// we are on a user's profile page
		&& $wgUser->getName() != $wgTitle->getDBkey()	// but not on our own one
	) {
		// OK, we're good to go.
		// $oController->itemsBefore = array( '<li> ... the PiggyQuick thingy comes here .. </li>' );
	}
	return true;
}

/**
 * @var array $wgHooks
 * @brief Global list of hooks.
 */
$wgHooks['AccountNavigationIndexAfterExecute'][] = 'wfPiggyQuickExecute';
