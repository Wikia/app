<?php
/* vim: noet ts=4 sw=4
 * http://www.mediawiki.org/wiki/Extension:Uniwiki_Category_Box_at_Top
 * http://www.gnu.org/licenses/gpl-3.0.txt */

if ( !defined( "MEDIAWIKI" ) )
	die();

/* ---- CREDITS ---- */

$wgExtensionCredits['other'][] = array(
	'name'           => 'CatBoxAtTop',
	'author'         => 'Merrick Schaefer, Mark Johnston, Evan Wheeler and Adam Mckaig (at UNICEF)',
	'description'    => 'Adds a category box to the top right of pages',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Uniwiki_Category_Box_at_Top',
	'svn-date'       => '$LastChangedDate',
	'svn-revision'   => '$LastChangedRevision: 43745 $',
	'descriptionmsg' => 'catboxattop-desc',
);

$wgExtensionMessagesFiles['CatBoxAtTop'] = dirname( __FILE__ ) . '/CatBoxAtTop.i18n.php';

/* ---- HOOKS ---- */
$wgHooks['BeforePageDisplay'][] = "UW_CatBoxAtTop_CSS";
$wgHooks['OutputPageBeforeHTML'][] = "UW_CatBoxAtTop_Rejig";

function UW_CatBoxAtTop_CSS ( &$out ) {
	global $wgScriptPath;
	$href = "$wgScriptPath/extensions/uniwiki/CatBoxAtTop/style.css";
	$out->addScript ( "<link rel='stylesheet' href='$href' />" );
	return true;
}

function UW_CatBoxAtTop_Rejig ( &$out, &$text ) {
	global $wgVersion;

	// no categories = no box
	if ( !$out->mCategoryLinks )
		return true;

	wfLoadExtensionMessages( 'CatBoxAtTop' );

	/* add a category box to the top of the output,
	 * to be dropped into the top right via CSS */
	$catbox = "<div id=\"catbox\"><div>\n";
	$catbox .= "<h5>" . wfMsgForContent( 'catboxattop-categories' ) . "</h5><ul>\n";
	$catlinks = array();

	if ( array_key_exists( 'normal', $out->mCategoryLinks ) ) {
		$catlinks = $out->mCategoryLinks['normal'];
	} else {
		$catlinks = $out->mCategoryLinks;
	}

	foreach ( $catlinks as $cat )
		$catbox .= "<li>$cat</li>\n";
	$catbox .= "</ul></div></div>\n";

	$text = $catbox . $text;
	return true;
}
