<?php
/**
 * Lazy loader for Special:Sitemap
 *
 * @file
 * @ingroup Extensions
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia.com
 * @copyright © 2010, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

/**
 * Extension credits that will show up on Special:Version
 */
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Sitemap',
	'version' => '1.0',
	'author' => array( 'Krzysztof Krzyżaniak' ),
	'description' => 'Generate Sitemaps for wiki on fly',
	'description-msg' => 'special-sitemap-desc',
);

/**
 * Set up the new special page
 */
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles[ "Sitemap" ] = $dir . "SpecialSitemap.i18n.php";
$wgAutoloadClasses[ "SitemapPage" ] = $dir. "SpecialSitemap_body.php";
$wgSpecialPages['Sitemap'] = 'SitemapPage';
$wgSpecialPageGroups['Sitemap'] = 'wikia';
