<?php
/**
 * Implements the server side functionality of Proxy Connect
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Travis Derouin <travis@wikihow.com>
 * @link http://www.mediawiki.org/wiki/Extension:ProxyConnect Documentation
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['special'][] = array(
	'path' => __FILE__,
	'name' => 'ProxyConnect',
	'version' => '1.0.1',
	'author' => 'Travis Derouin',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ProxyConnect',
	'descriptionmsg' => 'proxyconnect-desc',
);

// Set up the new special page
$wgSpecialPages['ProxyConnect'] = 'ProxyConnect';

$dir = dirname( __FILE__ );
$wgAutoloadClasses['ProxyConnect'] =  $dir. '/ProxyConnect.body.php';
$wgExtensionMessagesFiles['ProxyConnect'] = $dir . '/ProxyConnect.i18n.php';

