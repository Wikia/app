<?php
/**
 * A super-simple one-file extension that just adds "Lyrics" to the end of H1s
 * on Lyrics pages with the intention of making the SEO better.
 *
 * @author Sean Colombo <sean.colombo@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'Lyrics on H1s',
	'author' => array( '[http://seancolombo.com Sean Colombo]' ),
	'url' => 'http://lyrics.wikia.cmo',
	'descriptionmsg' => 'Adds the word "Lyrics" to the end of H1s on Lyrics pages to make it easier for web spiders to know that these are lyrics.',
);

//$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'lyricsH1_onSkinTemplateOutputPageBeforeExec';

// Note: in normal MediaWiki, the SkinTemplateOutputPageBeforeExec is probably the right place
// to change this, but in Wikia code, that isn't applied late enough, and skin 'title' is overridden
// by wgOut->getPageTitle() after that hook is called.
$wgHooks['BeforePageDisplay'][] = 'lyricsH1_onBeforePageDisplay';

function lyricsH1_onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
	global $wgTitle;

	// lyrics pages will only be in the main namespace after the merge
	if($wgTitle->getNamespace() == NS_MAIN){
		$origTitle = $out->getPageTitle();
		if((0 == preg_match("/\([12][0-9]{3}\)$/", $origTitle)) // make sure this is not an album page
			&& (0 < preg_match("/.+:+/", $origTitle))){
			$out->setPageTitle( $origTitle. wfMsg('H1-lyricssuffix')); // added as a message so that it can be translated
		}
	}

	return true;
} // end lyricsH1_onBeforePageDisplay()
