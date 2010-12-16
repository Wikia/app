<?php
/**
 * FCKeditor extension - a WYSIWYG editor for MediaWiki
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Frederico Caldeira Knabben
 * @author Wiktor Walc <w.walc(at)fckeditor(dot)net>
 * @copyright Copyright © Frederico Caldeira Knabben, Wiktor Walc, other FCKeditor team members and other contributors
 * @license GNU Lesser General Public License 2.1 or later
 */
/*
This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA
*/

# Not a valid entry point, skip unless MEDIAWIKI is defined
if( !defined( 'MEDIAWIKI' ) ) {
	echo <<<HEREDOC
To install FCKeditor extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/FCKeditor/FCKeditor.php" );
HEREDOC;
	exit( 1 );
}

# Configuration variables
// Path to this extension
$wgFCKEditorExtDir = 'extensions/FCKeditor';

// Path to the actual editor
$wgFCKEditorDir = 'extensions/FCKeditor/fckeditor/';

$wgFCKEditorToolbarSet = 'Wiki';

// '0' for automatic ('300' minimum).
$wgFCKEditorHeight = '0';

// Array of namespaces that FCKeditor is disabled for. Use constants like NS_MEDIAWIKI here.
$wgFCKEditorExcludedNamespaces = array();

/**
 * Enable use of AJAX features.
 */
require_once('FCKeditorSajax.body.php');
$wgAjaxExportList[] = 'wfSajaxSearchImageFCKeditor';
$wgAjaxExportList[] = 'wfSajaxSearchArticleFCKeditor';
$wgAjaxExportList[] = 'wfSajaxSearchCategoryFCKeditor';
$wgAjaxExportList[] = 'wfSajaxWikiToHTML';
$wgAjaxExportList[] = 'wfSajaxGetImageUrl';
$wgAjaxExportList[] = 'wfSajaxGetMathUrl';
$wgAjaxExportList[] = 'wfSajaxSearchTemplateFCKeditor';
$wgAjaxExportList[] = 'wfSajaxSearchSpecialTagFCKeditor';
$wgAjaxExportList[] = 'wfSajaxToggleFCKeditor';

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'FCKeditor',
	'author' => array( 'Frederico Caldeira Knabben', 'Wiktor Walc', 'others', 'Jack Phoenix' ),
	'version' => '1.0.1',
	'url' => 'http://www.mediawiki.org/wiki/Extension:FCKeditor_(Official)',
	'description' => 'FCKeditor extension for editing wiki pages (WYSIWYG editor)',
	'descriptionmsg' => 'fckeditor-desc',
);

// Autoloadable classes
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['FCKeditor'] = $dir . 'fckeditor/fckeditor.php';
$wgAutoloadClasses['FCKeditorParser'] = $dir . 'FCKeditorParser.body.php';
$wgAutoloadClasses['FCKeditorParserOptions'] = $dir . 'FCKeditorParserOptions.body.php';
$wgAutoloadClasses['FCKeditorParserWrapper'] = $dir . 'FCKeditorParserWrapper.body.php';
$wgAutoloadClasses['FCKeditorSkin'] = $dir . 'FCKeditorSkin.body.php';
$wgAutoloadClasses['FCKeditorEditPage'] = $dir . 'FCKeditorEditPage.body.php';
$wgAutoloadClasses['FCKeditor_MediaWiki'] = $dir . 'FCKeditor.body.php';

// Path to internationalization file
$wgExtensionMessagesFiles['FCKeditor'] = $dir . 'FCKeditor.i18n.php';

// Initialize FCKeditor and the MediaWiki extension
$fckeditor = new FCKeditor('fake');
$wgFCKEditorIsCompatible = $fckeditor->IsCompatible();

$oFCKeditorExtension = new FCKeditor_MediaWiki();

// Hooked functions
$wgHooks['ParserAfterTidy'][]                   = array( $oFCKeditorExtension, 'onParserAfterTidy' );
$wgHooks['EditPage::showEditForm:initial'][]    = array( $oFCKeditorExtension, 'onEditPageShowEditFormInitial' );
$wgHooks['EditPage::showEditForm:fields'][]		= array( $oFCKeditorExtension, 'onEditPageShowEditFormFields' );
$wgHooks['EditPageBeforePreviewText'][]         = array( $oFCKeditorExtension, 'onEditPageBeforePreviewText' );
$wgHooks['EditPagePreviewTextEnd'][]            = array( $oFCKeditorExtension, 'onEditPagePreviewTextEnd' );
$wgHooks['CustomEditor'][]                      = array( $oFCKeditorExtension, 'onCustomEditor' );
$wgHooks['LanguageGetMagic'][]					= 'FCKeditor_MediaWiki::onLanguageGetMagic';
$wgHooks['ParserBeforeStrip'][]					= 'FCKeditor_MediaWiki::onParserBeforeStrip';
$wgHooks['ParserBeforeInternalParse'][]			= 'FCKeditor_MediaWiki::onParserBeforeInternalParse';
$wgHooks['EditPageBeforeConflictDiff'][]		= 'FCKeditor_MediaWiki::onEditPageBeforeConflictDiff';
$wgHooks['SanitizerAfterFixTagAttributes'][]	= 'FCKeditor_MediaWiki::onSanitizerAfterFixTagAttributes';
$wgHooks['MakeGlobalVariablesScript'][]			= 'FCKeditor_MediaWiki::onMakeGlobalVariablesScript';
$wgHooks['GetPreferences'][]					= 'FCKeditor_MediaWiki::onGetPreferences';

// Defaults for new preferences options
$wgDefaultUserOptions['riched_use_toggle'] = 1;
$wgDefaultUserOptions['riched_start_disabled'] = 1;
$wgDefaultUserOptions['riched_use_popup'] = 1;
$wgDefaultUserOptions['riched_toggle_remember_state'] = 1;