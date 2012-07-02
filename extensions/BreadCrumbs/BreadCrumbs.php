<?php
/* The BreadCrumbs extension, an extension for providing an breadcrumbs
 * navigation to users.
 *
 * @file
 * @ingroup Extensions
 * @author Manuel Schneider <manuel.schneider@wikimedia.ch>
 * @copyright © 2007 by Manuel Schneider
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die();
}

# Options:
# $wgBreadCrumbsDelimiter - set the delimiter
$wgBreadCrumbsDelimiter = ' &gt; ';
# $wgBreadCrumbsCount - number of breadcrumbs to use
$wgBreadCrumbsCount = 5;
# Whether to provide the links also for anonymous users
$wgBreadCrumbsShowAnons = true;

$wgExtensionMessagesFiles['Breadcrumbs'] = dirname( __FILE__ ) . '/BreadCrumbs.i18n.php';

# Register extension credits:
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'BreadCrumbs',
	'author'         => 'Manuel Schneider',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:BreadCrumbs',
	'descriptionmsg' => 'breadcrumbs-desc',
);

# Ressource loader
$wgResourceModules['ext.breadCrumbs'] = array(
	'styles' => 'BreadCrumbs.css',

	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'BreadCrumbs'
);

# Set Hook:

# Showing and updating the breadcrumbs trail
# Hook when viewing article header:
$wgHooks['ArticleViewHeader'][] = 'fnBreadCrumbsShowHook';

# Infrastructure
# Hook our own CSS:
$wgHooks['OutputPageParserOutput'][] = 'fnBreadCrumbsOutputHook';

# Load the file containing the hook functions:
require_once( 'BreadCrumbsFunctions.php' );
