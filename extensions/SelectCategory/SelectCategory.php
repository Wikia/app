<?php

# Setup and Hooks for the SelectCategory extension, an extension of the
# edit box of MediaWiki to provide an easy way to add category links
# to a specific page.

# @addtogroup Extensions
# @author Leon Weber <leon.weber@leonweber.de> & Manuel Schneider <manuel.schneider@wikimedia.ch>
# @copyright © 2006 by Leon Weber & Manuel Schneider
# @licence GNU General Public Licence 2.0 or later

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die();
}

## Load the file containing the hook functions:
require_once( 'SelectCategoryFunctions.php' );

## Options:
# $wgSelectCategoryNamespaces - list of namespaces in which this extension should be active
if( !isset( $wgSelectCategoryNamespaces	) ) $wgSelectCategoryNamespaces = array(
	NS_MEDIA		=> true,
	NS_MAIN			=> true,
	NS_TALK			=> false,
	NS_USER			=> false,
	NS_USER_TALK		=> false,
	NS_PROJECT		=> true,
	NS_PROJECT_TALK		=> false,
	NS_IMAGE		=> true,
	NS_IMAGE_TALK		=> false,
	NS_MEDIAWIKI		=> false,
	NS_MEDIAWIKI_TALK	=> false,
	NS_TEMPLATE		=> false,
	NS_TEMPLATE_TALK	=> false,
	NS_HELP			=> true,
	NS_HELP_TALK		=> false,
	NS_CATEGORY		=> true,
	NS_CATEGORY_TALK	=> false
);
# $wgSelectCategoryRoot	- root category to use for which namespace, otherwise self detection (expensive)
if( !isset( $wgSelectCategoryRoot ) ) $wgSelectCategoryRoot = array(
	NS_MEDIA		=> false,
	NS_MAIN			=> false,
	NS_TALK			=> false,
	NS_USER			=> false,
	NS_USER_TALK		=> false,
	NS_PROJECT		=> false,
	NS_PROJECT_TALK		=> false,
	NS_IMAGE		=> false,
	NS_IMAGE_TALK		=> false,
	NS_MEDIAWIKI		=> false,
	NS_MEDIAWIKI_TALK	=> false,
	NS_TEMPLATE		=> false,
	NS_TEMPLATE_TALK	=> false,
	NS_HELP			=> false,
	NS_HELP_TALK		=> false,
	NS_CATEGORY		=> false,
	NS_CATEGORY_TALK	=> false
);
# $wgSelectCategoryEnableSubpages - if the extension should be active on subpages or not (true, as subpages are disabled by default)
if( !isset( $wgSelectCategoryEnableSubpages ) ) $wgSelectCategoryEnableSubpages = true;

## Register extension setup hook and credits:
$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'SelectCategory',
	'version'        => '0.7dev',
	'author'         => 'Leon Weber & Manuel Schneider',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:SelectCategory',
	'description'    => 'Allows the user to select from existing categories when editing a page',
	'descriptionmsg' => 'selectcategory-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['SelectCategory'] = $dir . 'SelectCategory.i18n.php';

## Set Hook:
global $wgHooks;

## Showing the boxes
# Hook when starting editing:
$wgHooks['EditPage::showEditForm:initial'][] = array( 'fnSelectCategoryShowHook', false );
# Hook for the upload page:
$wgHooks['UploadForm:initial'][] = array( 'fnSelectCategoryShowHook', true );

## Saving the data
# Hook when saving page:
$wgHooks['EditPage::attemptSave'][] = array( 'fnSelectCategorySaveHook', false );
# Hook when saving the upload:
$wgHooks['UploadForm:BeforeProcessing'][] = array( 'fnSelectCategorySaveHook', true );

