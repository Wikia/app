<?php
/**
 * Replace Text - a MediaWiki extension that provides a special page to
 * allow administrators to do a global string find-and-replace on all the
 * content pages of a wiki.
 *
 * http://www.mediawiki.org/wiki/Extension:Replace_Text
 *
 * The special page created is 'Special:ReplaceText', and it provides
 * a form to do a global search-and-replace, with the changes to every
 * page showing up as a wiki edit, with the administrator who performed
 * the replacement as the user, and an edit summary that looks like
 * "Text replace: 'search string' * to 'replacement string'".
 *
 * If the replacement string is blank, or is already found in the wiki,
 * the page provides a warning prompt to the user before doing the
 * replacement, since it is not easily reversible.
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

// credits
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Replace Text',
	'version' => '0.9.3',
	'author' => array( 'Yaron Koren', 'Niklas Laxström' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Replace_Text',
	'descriptionmsg'  => 'replacetext-desc',
);

$rtgIP = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['ReplaceText'] = $rtgIP . 'ReplaceText.i18n.php';
$wgExtensionMessagesFiles['ReplaceTextAlias'] = $rtgIP . 'ReplaceText.alias.php';
$wgJobClasses['replaceText'] = 'ReplaceTextJob';

// This extension uses its own permission type, 'replacetext'
$wgAvailableRights[] = 'replacetext';
$wgGroupPermissions['sysop']['replacetext'] = true;

$wgHooks['AdminLinks'][] = 'rtAddToAdminLinks';

$wgSpecialPages['ReplaceText'] = 'ReplaceText';
$wgSpecialPageGroups['ReplaceText'] = 'wiki';
$wgAutoloadClasses['ReplaceText'] = $rtgIP . 'SpecialReplaceText.php';
$wgAutoloadClasses['ReplaceTextJob'] = $rtgIP . 'ReplaceTextJob.php';

// This function should really go into a "ReplaceText_body.php" file.
function rtAddToAdminLinks( &$admin_links_tree ) {
	$general_section = $admin_links_tree->getSection( wfMsg( 'adminlinks_general' ) );
        $extensions_row = $general_section->getRow( 'extensions' );
	if ( is_null( $extensions_row ) ) {
		$extensions_row = new ALRow( 'extensions' );
		$general_section->addRow( $extensions_row );
	}
	$extensions_row->addItem( ALItem::newFromSpecialPage( 'ReplaceText' ) );
	return true;
}
