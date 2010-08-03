<?php

/**
 * A MediaWiki extension that adds the following tags:
 * <chemform>: for the formatting of chemical formulae.
 *
 * The i18n file is required for operation!
 * Installation: copy this file and ChemFunctions.i18n.php into the extensions directory
 *   and add "require_once( "$IP/extensions/ChemFunctions.php" );" to localsettings.php (using the correct path)
 *
 * @addtogroup Extensions
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if (!defined('MEDIAWIKI')) die();

$wgExtensionCredits['other'][] = array(
	'name'           => 'ChemFunctions',
	'svn-date' => '$LastChangedDate: 2008-05-06 13:59:58 +0200 (wto, 06 maj 2008) $',
	'svn-revision' => '$LastChangedRevision: 34306 $',
	'description'    => 'Adds the tag <nowiki><chemform></nowiki>, for chemical formulae',
	'descriptionmsg' => 'chemicalsource-desc',
	'author'         => 'Dirk Beetstra',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Chemistry',
);

/** Chemform wikipedia extension.
 *
 *   Formats the text between the tags as a chemical formula,
 *    First: all numericals are put in subscript.
 *    Second:  and - are put in superscript
 *    Third: all numericals preceding a + or a - are converted from subscript to superscript.
 *
 * usage: <chemform query="formula to be searched for" link wikilink>formula</chemform>
 *  (all parameters are optional).
 * Parameters:
 *   query: alternate (e.g. CAS-sorted) formula to search for (plain formula, e.g. "C12H22O11")
 *   link: results in the text between the tags to be a link to special:chemicalsources.
 *     N.B.  : use noprocess with the searchfor parameter, otherwise search results may (!) be garbage/broken links.
 *     N.B.2 : the text between the tags is interpreted as HTML, not as wikitext!
 *   wikilink: makes the text between the tags a wikilink.
 *
 * Written by Dirk Beetstra, Oct. 2, 2006.
 */

$wgExtensionMessagesFiles['ChemFunctions'] = dirname(__FILE__) . '/ChemFunctions.i18n.php';

$wgExtensionFunctions[] = "wfChemFormExtension";

function wfChemFormExtension() {
	global $wgParser;
	$wgParser->setHook( "chemform", "RenderChemForm" );
}

function RenderChemForm( $input, $argv ) {

	# add messages
	wfLoadExtensionMessages( 'ChemFunctions' );

	$link = false;
	$wikilink = false;
	$showthis = $input;
	$searchfor = $input;

	if ( isset( $argv["link"] ) )
		$link =  $argv["link"];

	if ( isset($argv["wikilink"] ) )
		$wikilink = $argv["wikilink"];

	if ( isset( $argv["query"] ) )
		$searchfor = $argv["query"];

	if (!$showthis)
		$showthis = $searchfor;

	$showthis = htmlentities( Sanitizer::StripAllTags ( $showthis ) );                   # tagstripping
	$showthis = preg_replace("/[0-9]+/", "<sub>$0</sub>", $showthis);                    # All numbers down
	$showthis = preg_replace("/[\+\-]/", "<sup>$0</sup>", $showthis);                    # + and - up
	$showthis = preg_replace("/<\/sub><sup>/", "", $showthis);                           # </sub><sup> should not occur
	$showthis = preg_replace("/<sub>([0-9\+\-]+)<\/sup>/", "<sup>$1</sup>", $showthis);  # and <sub>whatever</sup> to <sup>..</sup>

	$searchfor = htmlentities( Sanitizer::StripAllTags ( $searchfor ) );

	if (! ( $showthis . $searchfor ) )
		return wfMsg('chemFunctions_ChemFormInputError');

	if ( $link ) {
		$title = Title::makeTitleSafe( NS_SPECIAL, 'Chemicalsources' );
		$output = "<a href=\"" . $title->getFullUrl() . "?Formula=" . $searchfor .  "\">" . $showthis . "</a>";
	} elseif ( $wikilink) {
		$title = Title::makeTitleSafe( NS_MAIN, $searchfor );

		if ($title) {
			$revision = Revision::newFromTitle( $title );

			if ($revision ) {
				$output = "<a href=\"" . $title->getFullUrl() . "\">" . $showthis . "</a>";
			} else {
				$output = "<a href=\"" . $title->getFullUrl() . "?action=edit\" class=\"new\">" . $showthis . "</a>";
			}
		} else {
			$output = wfMsg('chemFunctions_ChemFormInputError');
		}
	} else {
		$output = $showthis;
	}

	return $output;
}
