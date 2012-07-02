<?php
/**
 * Lightweight variable page redirection
 */

//Alert the user that this is not a valid entry point to MediaWiki if they try to access the setup file directly.
if ( !defined( 'MEDIAWIKI' ) ) { 
	echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/VariablePage/VariablePage.php" );
EOT;
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'VariablePage',
	'version' => '0.1',
	'author' => 'Arthur Richards',
	'descriptionmsg' => 'variablepage-desc',
);

/**
 * An array of pages and the probability of a user being redirected to each page.
 * 
 * The key in the array is the full URL path, the value is an integer representing
 * a percentage (0-100) probability of a user being redirected to that page.
 *
 * The percentages here MUST add up to 100 -or- a value must be set for
 * $wgVariablePageDefault
 *
 * The following will redirect a user to http://foo.com/bar 90% of the time:
 *		$wgVariablePagePossibilities = array(
 *			'http://foo.com/bar' => 90,
 *		);
 */
$wgVariablePagePossibilities = array();

/**
 * The default URL to send a user to in the event that one of the URLs in 
 * $wgVariablePagePossibilities not selected.
 *
 * Either this must be set or the probabilities in $wgVariablePagePossibiliites
 * must add up to 100.
 */
$wgVariablePageDefault = 'http://wikimediafoundation.org/wiki/Support_Wikipedia';

/** 
 * If this is set to TRUE, a sidebar nav link to Special:VariablePage will be displayed
 */
$wgVariablePageShowSidebarLink = false;

/**
 * If you need to add a query to the sidebar nav link, set them with this.
 *
 * array( $key => $value ) will become ?key=value
 */
$wgVariablePageSidebarLinkQuery = array();

/**
 * Edit the sidebar navigation
 */
$wgHooks['SkinBuildSidebar'][] = 'efVariablePageSidebarLink';

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'SpecialVariablePage' ] = $dir . 'VariablePage.body.php';
$wgExtensionMessagesFiles[ 'VariablePage' ] = $dir . 'VariablePage.i18n.php';
$wgExtensionMessagesFiles[ 'VariablePageAlias' ] = $dir . 'VariablePage.alias.php';
$wgSpecialPages[ 'VariablePage' ] = 'SpecialVariablePage';
$wgSpecialPageGroups[ 'VariablePage' ] = 'contribution';

/**
 * Place a link to Special:VariablePage in the navigation sidebar
 * @return bool
 */
function efVariablePageSidebarLink( $skin, &$bar ) {
	global $wgVariablePageShowSidebarLink, $wgVariablePageSidebarLinkQuery;

	// make sure that we should be showing a sidebar link
	if ( $wgVariablePageShowSidebarLink ) {
		$title = SpecialPage::getTitleFor( 'VariablePage' );
		$bar['navigation'][] = array(
			'text' => wfMsg( 'variablepage-navlink_text' ),
			'href' => $title->getLocalUrl( $wgVariablePageSidebarLinkQuery ),
			'id' => 'n-variablepage',
			'active' => true,
		);
	}

	return true;
}
