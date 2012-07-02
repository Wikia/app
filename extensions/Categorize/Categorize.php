<?php
/* Categorize Mediawiki Extension
 *
 * @author Thomas Fauré (faure dot thomas at gmail dot com) for Categorize improvments and Andreas Rindler (mediawiki at jenandi dot com) for initial Extension:CategorySuggest
 * @credits Jared Milbank, Leon Weber <leon.weber@leonweber.de> & Manuel Schneider <manuel.schneider@wikimedia.ch>, Daniel Friesen http://wiki-tools.com
 * @licence GNU General Public Licence 3.0
 * @description Adds input box to edit and upload page which allows users to assign categories to the article. When a user starts typing the name of a category, the extension queries the database to find categories that match the user input. Furthermore, a best categories labels cloud is displayed.
 *
 */

## Abort if not used within Mediawiki
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die();
}
## Abort if AJAX is not enabled
if ( !$wgUseAjax ) {
	trigger_error( 'Categorize: please enable $wgUseAjax.', E_USER_WARNING );
	return;
}

## Globals
#
#  these can be set in local settings.php _after_ including this function
#
# $wgCategorizejs, $wgCategorizecss - paths to script and css files if needed to be moved elsewhere
# $wgCategorizeNumToSend  - max number of suggestions to send to browser - not implemented
# $wgCategorizeUnaddedWarning - not implemented
# $wgCategorizeCloud : cloud - use cloud ; anything else - list
#

$dir = dirname( __FILE__ );


$wgCategorizejs  = $wgScriptPath . '/extensions/Categorize/Categorize.js' ;
$wgCategorizecss = $wgScriptPath . '/extensions/Categorize/Categorize.css';
$wgCategorizeNumToSend = '50';
$wgCategorizeUnaddedWarning = 'True';
$wgCategorizeCloud = 'list';

$wgExtensionCredits['other'][] = array(
	'path'        => __FILE__,
	'name'        => 'Categorize',
	'author'      => 'Thomas Fauré',
	'url'         => 'https://www.mediawiki.org/wiki/Extension:Categorize',
	'descriptionmsg' => 'categorize-desc',
	'version'     => '0.1.2'
);

$wgExtensionMessagesFiles['Categorize']      = "$dir/Categorize.i18n.php";
$wgAutoloadClasses['CategorizeHooks']        = "$dir/Categorize.hooks.php";
$wgAutoloadClasses['CategorizeBody']         = "$dir/Categorize.body.php";

$wgAutoloadClasses['ApiQueryCategorize'] = "$dir/Categorize.api.php";
$wgAPIListModules['categorize'] = 'ApiQueryCategorize';

## Set Hooks:

$wgHooks['EditPage::showEditForm:initial'][] = array( 'CategorizeHooks::fnCategorizeShowHook', false );
$wgHooks['UploadForm:initial'][]             = array( 'CategorizeHooks::fnCategorizeShowHook', true );
$wgHooks['EditPage::attemptSave'][]          = array( 'CategorizeHooks::fnCategorizeSaveHook', false );
$wgHooks['UploadForm:BeforeProcessing'][]    = array( 'CategorizeHooks::fnCategorizeSaveHook', true );
$wgHooks['OutputPageParserOutput'][]         = 'CategorizeHooks::fnCategorizeOutputHook';
