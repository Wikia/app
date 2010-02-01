<?php
/**
 * Adds top title edit button (RT #37771)
 *
 * @author Bartek Lapinski <bartek@wikia-inc.com>
 */
$wgExtensionCredits['other'][] = array(
		'name' => 'TitleEdit',
		'description' => 'Adds top title edit buttons',
		'version' => '1.0',
		'author' => array('Bartek Lapinski')
		);

$wgExtensionMessagesFiles['TitleEdit'] = dirname(__FILE__) . '/TitleEdit.i18n.php';
$wgHooks['MonacoPrintFirstHeading'][] = 'wfTitleEditPrintFirstHeading';


function wfTitleEditPrintFirstHeading() {
	global $wgTitle, $wgUser, $wgRequest;
	
	if ( $wgTitle->isProtected( 'edit' ) ) {
		return true;
	}

	if( 'edit' == $wgRequest->getVal( 'action', false ) ) {
		return true;
	}

	wfLoadExtensionMessages( 'TitleEdit' );
	$sk = $wgUser->getSkin();
	$result = '';

	if (is_object($wgUser) && $wgUser->isLoggedIn()) {
		$link = $sk->link( $wgTitle, wfMsg('titleedit'),
			array( 'onclick' => 'WET.byStr("articleAction/topedit")'),
			array( 'action' => 'edit'),
			array( 'noclasses', 'known' )
			);
		$result = wfMsgHtml( 'editsection-brackets', $link );
		$result = "<span class=\"editsection-upper\">$result</span>";
	} else { // anon
		if ( empty($wgDisableAnonymousEditig)) {
			$link = "<a id=\"te-editanon\" class=\"wikia_button\" onclick=\"WET.byStr('articleAction/topedit')\" href=\"" . $wgTitle->getEditUrl() . "\"><span>" . wfMsg( 'titleedit' ) . "</span></a>";
			$result = "<span class=\"editsection-upper\">$link</span>";
		}
	}

	echo $result;
	return true;
}


