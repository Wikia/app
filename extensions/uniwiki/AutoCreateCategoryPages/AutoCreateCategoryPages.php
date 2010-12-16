<?php
/* vim: noet ts=4 sw=4
 * http://www.mediawiki.org/wiki/Extension:Uniwiki_Auto_Create_Category_Pages
 * http://www.gnu.org/licenses/gpl-3.0.txt */

if ( !defined( 'MEDIAWIKI' ) )
	die();

/* ---- CREDITS ---- */
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'AutoCreateCategoryPages',
	'author'         => array ( 'Merrick Schaefer', 'Mark Johnston', 'Evan Wheeler', 'Adam Mckaig (at UNICEF)' ),
	'description'    => 'Create stub Category pages automatically',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Uniwiki_Auto_Create_Category_Pages',
	'descriptionmsg' => 'autocreatecategorypages-desc',
);

$wgExtensionMessagesFiles['AutoCreateCategoryPages'] = dirname( __FILE__ ) . '/AutoCreateCategoryPages.i18n.php';
$wgAutoloadClasses['UniwikiAutoCreateCategoryPages'] = dirname(__FILE__) . '/AutoCreateCategoryPages.body.php';

$wgAutoCreateCategoryPagesObject = new UniwikiAutoCreateCategoryPages();

/* ---- HOOKS ---- */
$wgHooks['ArticleSaveComplete'][] = array($wgAutoCreateCategoryPagesObject,"UW_AutoCreateCategoryPages_Save");
$wgHooks['UserGetReservedNames'][] = array($wgAutoCreateCategoryPagesObject,'UW_OnUserGetReservedNames');
