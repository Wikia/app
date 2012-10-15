<?php
if ( !defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Ajax Query Pages',
	'url' => 'https://www.mediawiki.org/wiki/Extension:AjaxQueryPages',
	'author' => 'Ashar Voultoiz',
	'descriptionmsg' => 'ajaxquerypages-desc',
);

$dir = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['AjaxQueryPages'] = $dir . 'AjaxQueryPages.i18n.php';

$wgHooks['AjaxAddScript'][] = 'wfAjaxQueryPagesAddJS';
$wgAjaxExportList[] = 'wfAjaxQueryPages';

// Load hooks
require_once( $dir . 'Hooks.php' );

// Set up AJAX entry point:
require_once( $dir . 'Response.php' );
