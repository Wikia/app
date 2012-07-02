<?php
/**
 * Special404 - provides a special page based 404 destination.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Friesen
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:Special404 Documentation
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "Special404 extension";
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'author' => 'Daniel Friesen',
	'name' => 'Special404',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Special404',
	'descriptionmsg' => 'special404-desc',
);

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['Special404'] = $dir . '/Special404.i18n.php';
$wgExtensionMessagesFiles['Special404Alias'] = $dir . '/Special404.alias.php';

$wgSpecialPages['Error404'] = 'Special404';
$wgAutoloadClasses['Special404'] = $dir . '/Special404_body.php';

// Enable this to force an automatic 301 Moved Permanently redirect if a matching title exists
// This might be useful if you used to use root /Article urls and moved to something else
$egSpecial404RedirectExistingRoots = false;

