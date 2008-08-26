<?php

# The BreadCrumbs extension, an extension for providing an breadcrumbs
# navigation to users.

# @addtogroup Extensions
# @author Manuel Schneider <manuel.schneider@wikimedia.ch>
# @copyright © 2007 by Manuel Schneider
# @licence GNU General Public Licence 2.0 or later


if( !defined( 'MEDIAWIKI' ) ) {
  echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
  die();
}
                
## Options:
# $wgBreadCrumbsDelimiter - set the delimiter
$wgBreadCrumbsDelimiter = ' &gt; ';
# $wgBreadCrumbsCount - number of breadcrumbs to use
$wgBreadCrumbsCount = 5;

$wgExtensionMessagesFiles['Breadcrumbs'] = dirname(__FILE__) . '/BreadCrumbs.i18n.php';

## Register extension setup hook and credits:
$wgExtensionFunctions[] = 'fnBreadCrumbs';
$wgExtensionCredits['parserhook'][] = array(
  'name'          => 'BreadCrumbs',
  'author'        => 'Manuel Schneider',
  'url'           => 'http://www.mediawiki.org/wiki/Extension:BreadCrumbs',
  'description'   => 'Shows a breadcrumb navigation.',
  'descriptionmsg' => 'breadcrumbs-desc',
);
                                
## Set Hook:
function fnBreadCrumbs() {
  global $wgHooks;

  ## Showing and updating the breadcrumbs trail
  # Hook when viewing article header:
  $wgHooks['ArticleViewHeader'][] = 'fnBreadCrumbsShowHook';

  ## Infrastructure
  # Hook our own CSS:
  $wgHooks['OutputPageParserOutput'][] = 'fnBreadCrumbsOutputHook';
}

## Load the file containing the hook functions:
require_once( 'BreadCrumbsFunctions.php' );
