<?php
/**
 * Page protector file for the SharedCssJs extension
 *
 * @since 1.0
 *
 * @file SharedCssJsProtector.php
 * @ingroup SharedCssJs
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @author Tim Weyer (SVG) <svg@tim-weyer.org>
 */

if(!defined('MEDIAWIKI')) {
    echo("This is an extension to the MediaWiki software and cannot be used standalone");
    die(1);
}

$wgHooks['getUserPermissionsErrors'][] = 'fnProtectSharedCssJs';

function fnProtectSharedCssJs( &$title, &$user, $action, &$result ) {
	global $wgSharedCssJsDB, $wgDBname;

	// only protect MediaWiki:Global.css and MediaWiki:Global.js on non-central wikis
	if( $wgSharedCssJsDB != $wgDBname ) {

	// block actions 'edit' and 'create'
	if( $action != 'edit' && $action != 'create' ) {
		return true;
	}
	
	// check pagenames (includes subpages)
	if( $title->getBaseText() != 'Global.css' && $title->getBaseText() != 'Global.js' ) {
		return true;
	}
	
	$ns = $title->getNamespace();
	
	// check namespaces
	if( $ns == 8 || $ns == 9 ) {
		
		// error message if action is blocked
		$result = array( 'sharedcssjs-error' );
		
		// bail, and stop the request
		return false;
	}
	
	}

	return true;
}
