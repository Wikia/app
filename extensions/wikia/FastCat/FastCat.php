<?php
/**
 * FastCat
 *
 * This extension displays a form with predefined categories and
 * enables one-click categorization.
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @author Jochen Kornitzky
 * @date 2010-01-13
 * @copyright Copyright © 2010 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
        echo "This is a MediaWiki extension named FastCat.\n";
        exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
        'name' => 'FastCat',
        'author' => array( "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]", 'Jochen Kornitzky' ),
        'description' => 'One-click categorization from a predefined list of categories.'
);

$dir = dirname( __FILE__ );

$wgAutoloadClasses['FastCat'] = $dir . '/SpecialFastCat.body.php';
$wgSpecialPages['FastCat'] = 'FastCat';

$wgExtensionMessagesFiles['FastCat'] = $dir . '/FastCat.i18n.php';

$wgHooks['OutputPageMakeCategoryLinks'][] = 'efFastCatInit';

/*
 * Determine whether or not we want a FastCat module displayed
 */
function efFastCatInit($out, $categories, $links) {

	global $wgUser, $wgTitle, $wgHooks;

	if ( $wgUser->isAnon() || $wgTitle->getNamespace() != NS_MAIN || $wgTitle->isRedirect() ) {
		return true;
	}	

	wfLoadExtensionMessages( 'FastCat' );

	if ( count( $categories ) != 1 || !array_key_exists( wfMsgForContent( 'fastcat-marker-category' ), $categories ) ) {
		return true;
	}

	// Getting here means the module should be displayed
	// Attach the hook
	$wgHooks['Skin::getCategoryLinks::end'][] = 'efFastCatSelector';

	return true;
}

/*
 * Display the selector
 */
function efFastCatSelector( &$categories ) {

  global $wgTitle, $wgArticle;

  $kat = explode( "\n", wfMsgForContent( 'fastcat-categories-list' ) );

  $artname = $wgTitle->getText();
  $artid = $wgArticle->getID();


  $spice = sha1("Kroko-katMeNot-" . $artid . "-" . $artname . "-NotMekat-Schnapp");

  $catUrl = Title::newFromText( 'FastCat', NS_SPECIAL )->getFullURL();

  $ret = "<form action=\"$catUrl\" method='post'>
<p><b>" . wfMsg( 'fastcat-box-title' ) . "</b><br>
<small>" . wfMsg( 'fastcat-box-intro' ) . "</small>
</p>
<input type='hidden' name='id' value='$artid'>
<input type='hidden' name='spice' value='$spice'>
<input type='hidden' name='artname' value='$artname'>
<p style=\"text-indent:-1em;margin-left:1em\">";

  foreach($kat as $k) {

    if( strpos( $k, '* ' ) === 0 ) {
      $k = trim( $k, '* ' );
      $ret .= "</p><p style=\"text-indent:-1em;margin-left:1em\">\n";
      $ret .= "<button style=\"font-size:smaller;\" name=\"cat\" value=\"$k\"><b>$k</b></button>\n";
    } else {
      $k = trim( $k, '* ' );
      $ret .= "<button style=\"font-size:smaller;\" name=\"cat\" value=\"$k\">$k</button>\n";
    }

  }

  $ret .=<<< EORET
</p>
</form>
EORET;

	$categories = $ret;

	return true;
}
