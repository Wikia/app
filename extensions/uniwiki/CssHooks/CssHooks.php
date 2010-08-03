<?php
/* vim: noet ts=4 sw=4
 * http://www.mediawiki.org/wiki/Extension:Uniwiki_CSS_Hooks
 * http://www.gnu.org/licenses/gpl-3.0.txt */

if ( !defined( "MEDIAWIKI" ) )
	die();

/* ---- CREDITS ---- */

$wgExtensionCredits['other'][] = array(
	'name'        => 'CssHooks',
	'author'      => 'Merrick Schaefer, Mark Johnston, Evan Wheeler and Adam Mckaig (at UNICEF)',
	'description' => 'Add some CSS hooks to the HTML output of articles, for better styling',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Uniwiki_CSS_Hooks',
	'svn-date'       => '$LastChangedDate: 2008-11-02 03:15:45 +0100 (ndz, 02 lis 2008) $',
	'svn-revision'   => '$LastChangedRevision: 43063 $',
	'descriptionmsg' => 'csshooks-desc',
);

$wgExtensionMessagesFiles['CssHooks'] = dirname( __FILE__ ) . '/CssHooks.i18n.php';

/* ---- HOOKS ---- */
$wgHooks['OutputPageBeforeHTML'][] = 'UW_CssHooks_AddHooks';

function UW_CssHooks_AddHooks ( &$out, &$text ) {
	global $wgRequest;

	// break the page into sections via their <h2>s
	$sections = preg_split ( "/(<a name=\".+?\"><\/a><h2>.+?<\/h2>)/",
		$text, -1, PREG_SPLIT_DELIM_CAPTURE );

	// remove the first empty section
	if ( $sections[0] == "" )
		array_shift ( $sections );

	$index = 0;
	$output = '';
	$div_open = false;
	for ( $i = 0; $i < count ( $sections ); $i++ ) {

		/* is this block of text a header? (check for mw-headline
		 * to only include actual section headers, and dodge toc) */
		if ( substr ( $sections[$i], 0, 7 ) == "<a name" ) {
			if ( strstr ( $sections[$i], "<span class=\"mw-headline\">" ) !== false ) {
				$index++;

				/* close current section div, if one exists,
				 * and always open a new one with hooks */
				if ( $div_open ) $output .= "</div>";
				$output .= "<div class=\"uw-section sect-$index\">";
				$div_open = true;
			}
		}

		// re-add the original text
		$output .= $sections[$i];

		// close the last section, if one is open
		if ( ( $i == count ( $sections ) - 1 ) && $div_open )
			$output .= "</div>";
	}

	$text = $output;
	return true;
}
