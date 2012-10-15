<?php
/** 
* @addtogroup Extensions 
*/
// Check environment
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die( -1 );
}

/* Configuration */

// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'CreditTab',
	'author' => '[http://www.dasch-tour.de DaSch]',
	'version' =>  '1.2.2',
	'descriptionmsg' => 'credits-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CreditTab',
);

$dir = dirname( __FILE__ ) . '/';

// Internationalization
$wgExtensionMessagesFiles['CreditTab'] = $dir . 'CreditTab.i18n.php';

$wgHooks['BeforePageDisplay'][] = 'addAuthorHeadLink';
$wgHooks['SkinTemplateNavigation'][] = 'displayTab';

function addAuthorHeadLink ( &$out, &$sk ) {
	$out->addLink( array(
		'rel'   => 'author',
		'type'  => 'text/html',
		'title' => wfMsg( 'credits-tab' ),
		'href'  => $out->getTitle()->getLocalURL( 'action=credits' ),
	) );
	return true;
}
	
function displayTab( $obj, &$links ) {
	// the old '$content_actions' array is thankfully just a
	// sub-array of this one
	$views_links = $links['views'];
	showCredits( $obj, $views_links );
	$links['views'] = $views_links;
	return true;
}

function showCredits( $obj, &$content_actions ) {
	global $wgRequest, $wgCreditTabNamespaces;
	if ( method_exists ( $obj, 'getTitle' ) ) {
		$title = $obj->getTitle();
	} else {
		$title = $obj->mTitle;
	}
	$ctNamespace = $title->getNamespace();
	$ctInsert=false;
	if ( count( $wgCreditTabNamespaces ) > 0 ) {
		if ( in_array( $ctNamespace, $wgCreditTabNamespaces ) ) {
			$ctInsert = true;
		}
		if ( is_bool( $wgCreditTabNamespaces ) ) {
			$ctInsert = $wgCreditTabNamespaces;
		}
	} else {
		if ($title->isContentPage()) {
			$ctInsert=true;
		} else {
			$ctInsert=false;
		}
	}

	$class_name = ( $wgRequest->getVal( 'action' ) == 'credits' ) ? 'selected' : '';
	if ( $title->exists() && $ctInsert ) {
		$credit_tab = array(
			'class' => $class_name,
			'text' => wfMsg( 'credits-tab' ),
			'title' => wfMsg( 'credits-tab-title' ),
			'href' => $title->getLocalURL( 'action=credits' ),
		);
		// find the location of the 'edit' tab, and add
		// 'edit with form' right before it.
		// this is a "key-safe" splice - it preserves
		// both the keys and the values of the array,
		// by editing them separately and then
		// rebuilding the array.
		// based on the example at
		// http://us2.php.net/manual/en/function.array-splice.php#31234
		$tab_keys = array_keys( $content_actions );
		$tab_values = array_values( $content_actions );
		$edit_tab_location = array_search('history', $tab_keys);
		$edit_tab_location++;
		// If there's no 'edit' tab, look for the 'view source' tab
		// instead.
		if ( $edit_tab_location == null ) {
			$edit_tab_location = array_search( 'viewsource', $tab_keys );
		}

		// This should rarely happen, but if there was no edit *or*
		// view source tab, set the location index to -1, so the
		// tab shows up near the end.
		if ( $edit_tab_location == null ) {
			$edit_tab_location = - 1;
		}
		array_splice( $tab_keys, $edit_tab_location, 0, 'credits' );
		array_splice( $tab_values, $edit_tab_location, 0, array( $credit_tab ) );
		$content_actions = array();
		$tabCnt = count( $tab_keys );
		for ( $i = 0; $i < $tabCnt; $i++ ) {
			$content_actions[ $tab_keys[$i] ] = $tab_values[$i];
		}
	}
	return true;
}
