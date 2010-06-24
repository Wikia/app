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
 *
 * @example lighttpd configuration:
 * url.rewrite += ( "^/(sitemap.+\.xml[.gz]*)$" => "/index.php?title=Special:Sitemap/$1" )
 *
 * @example apache configuration
 * RewriteRule ^/(sitemap.+\.xml[.gz]*)$ /index.php?title=Special:Sitemap/$1 [L,QSA]
 *
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
	'version' => '1.1',
	'author' => 'Krzysztof Krzyżaniak',
	'description' => 'Generate Sitemaps for the wiki on the fly',
	'description-msg' => 'sitemap-desc',
);

/**
 * Set up the new special page
 */
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Sitemap'] = $dir . 'Sitemap.i18n.php';
$wgExtensionAliasesFiles['Sitemap'] = $dir . 'Sitemap.alias.php';
$wgAutoloadClasses['SitemapPage'] = $dir . 'SpecialSitemap_body.php';
$wgSpecialPages['Sitemap'] = 'SitemapPage';
$wgSpecialPageGroups['Sitemap'] = 'wikia';
