<?php
/**
 * Adds top title edit button (RT #37771)
 *
 * @author Bartek Lapinski <bartek@wikia-inc.com>
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'TitleEdit',
	'description' => 'Adds top title edit buttons',
	'descriptionmsg' => 'titleedit-desc',
	'version' => '1.0',
	'author' => array('Bartek Lapinski')
);

$wgExtensionMessagesFiles['TitleEdit'] = dirname(__FILE__) . '/TitleEdit.i18n.php';
$wgHooks['MonacoPrintFirstHeading'][] = 'wfTitleEditPrintFirstHeading';

function wfTitleEditPrintFirstHeading() {
	global $wgTitle, $wgUser, $wgRequest, $wgArticle;

	if ( $wgTitle->isProtected( 'edit' ) ) {
		return true;
	}

	if( 'edit' == $wgRequest->getVal( 'action', false ) ) {
		return true;
	}

	$ns = $wgTitle->getNamespace();
	if( defined( 'NS_BLOG_ARTICLE' ) && in_array( $ns, array( NS_BLOG_ARTICLE, NS_BLOG_LISTING ) ) ) {
		return true;
	}

	wfLoadExtensionMessages( 'TitleEdit' );
	$sk = $wgUser->getSkin();
	$result = '';

	// build the query string for the correct revision
	$query = array( 'action' => 'edit' );
	if ( is_object( $wgArticle ) && $wgArticle->getOldID() !== 0 ) {
		$query['oldid'] = $wgArticle->getOldid();
	}


	$attributes = array(
		'onclick' => 'WET.byStr("articleAction/topedit")',
		'rel' => 'nofollow',
	);

	if (is_object($wgUser) && $wgUser->isLoggedIn()) {
		$link = $sk->link( $wgTitle, wfMsg('titleedit'),
			$attributes,
			$query,
			array( 'noclasses', 'known' )
			);
		$link = wfMsgHtml( 'editsection-brackets', $link );
	} else { // anon
		// prompt to login or not?
		if(is_object($wgUser) && $wgUser->isAllowed('edit')){
			$attributes['id'] = 'te-editsection-noprompt';
		} else {
			$attributes['id'] = 'te-editanon';
		}

		$attributes['class'] = 'wikia-button';

		$link = $sk->link(
			$wgTitle,
			wfMsg( 'titleedit' ),
			$attributes,
			$query
		);
	}

	$result = "<span class=\"editsection-upper\">$link</span>";

	echo $result;
	return true;
}
