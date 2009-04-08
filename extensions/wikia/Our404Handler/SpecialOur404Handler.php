<?php
/**
 * Lazy loader for Special:Our404Handler
 *
 * @file
 * @ingroup Extensions
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia.com
 * @copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Our404Handler',
	'version' => '1.0',
	'author' => 'Krzysztof Krzyżaniak',
	'description' => 'Our 404 handler for making thumbs and other magic',
);

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Our404Handler'] = $dir . 'SpecialOur404Handler.i18n.php';
$wgAutoloadClasses['Our404HandlerPage'] = $dir. 'SpecialOur404Handler_body.php';
$wgSpecialPages['Our404Handler'] = 'Our404HandlerPage';
