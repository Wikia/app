<?php
/**
 * SiteMetrics extension - displays statistics about social tools for
 * privileged users.
 *
 * @file
 * @ingroup Extensions
 * @version 1.1
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author David Pean <david.pean@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extensions:SiteMetrics Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SiteMetrics',
	'version' => '1.1',
	'author' => array( 'Aaron Wright', 'David Pean', 'Jack Phoenix' ),
	'description' => '[[Special:SiteMetrics|Displays statistics about social tools]]',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SiteMetrics',
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['SiteMetrics'] = $dir . 'SiteMetrics.i18n.php';
$wgAutoloadClasses['SiteMetrics'] = $dir . 'SpecialSiteMetrics.php';
$wgSpecialPages['SiteMetrics'] = 'SiteMetrics';

// New user right, required to use Special:SiteMetrics
$wgAvailableRights[] = 'metricsview';
$wgGroupPermissions['sysop']['metricsview'] = true;
$wgGroupPermissions['staff']['metricsview'] = true;

// ResourceLoader support for MediaWiki 1.17+
$wgResourceModules['ext.siteMetrics'] = array(
	'styles' => 'SiteMetrics.css',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'SiteMetrics'
);