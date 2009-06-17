<?php
/*
 * Ajax Functions used by Wikia extensions
 */

function getSuggestedArticleURL( $text )
{
    $title = Title::newFromText( rawurldecode( $text ) );
    $result = "";
    if (is_object($title) && ($title instanceof Title)) {
        $result = $title->getFullURL();
    }
    return $result;
}

/**
 * Validates user names.
 *
 * @Author CorfiX (corfix@wikia.com)
 *
 * @Param String $uName
 *
 * @Return String
 */
function cxValidateUserName ($uName) {
	global $IP, $wgDBname, $wgExternalSharedDB;

	require_once ($IP . '/includes/User.php');


	$nt = Title::newFromText( $uName );
	if( is_null( $nt ) ) {
		# Illegal name
		return 'INVALID';
	}

	$uName = $nt->getText();

	$dbr = wfGetDB (DB_SLAVE);
	$uName = $dbr->strencode($uName);
	if ($uName == '') {
		return 'INVALID';
	}

	$oRow = $dbr->selectRow( 'user', 'user_name', array('user_name' => $uName), __METHOD__);
	if ($oRow !== false) {
		return 'EXISTS';#wfMsg ('username-exists');
	}

	$dbExt = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
	if ($dbExt->NumRows ($dbResults = $dbExt->Query ("SELECT User_Name FROM `user` WHERE User_Name = '$uName';"))) {
		return 'EXISTS';#wfMsg ('username-exists');
	}

	return 'OK';#wfMsg ('username-valid');
}

function wfSignForReview() {
	global $wgRequest, $wgUser;
	wfProfileIn( __METHOD__ );
	$reason = $wgRequest->getVal('reason');
	$rev_id = $wgRequest->getVal('rev_id');
	if(is_numeric($reason) && is_numeric($rev_id)) {
		$revision = Revision::newFromId($rev_id);
		if($revision) {
			$dbw = & wfGetDB( DB_MASTER );
			$fields = array(
				'reviews_id' => NULL,
				'reviews_page_id' => $revision->getPage(),
				'reviews_rev_id' => $revision->getId(),
				'reviews_reason' => $reason,
				'reviews_user_id' => $wgUser->getID(),
				'reviews_user_name' => $wgUser->getName(),
				'reviews_timestamp' => $dbw->timestamp()
			);
			$dbw->insert('reviews', $fields, __METHOD__);
			return new AjaxResponse(true);
		}
	}
	wfProfileOut( __METHOD__ );
	return new AjaxResponse(false);
}

/*
 * author: Inez Korczyński (inez at wikia dot com)
 */
function wfDragAndDropReorder() {
	wfProfileIn( __METHOD__ );

	global $wgRequest;

	$memc = & wfGetCache(CACHE_MEMCACHED);

	if ( empty ( $_COOKIE['orderid'] ) ) {
		$orderid = uniqid();
		global $wgCookieExpiration, $wgCookiePath, $wgCookieDomain, $wgCookieSecure;
		setcookie('orderid', $orderid, time() + $wgCookieExpiration, $wgCookiePath, $wgCookieDomain, $wgCookieSecure );
	} else {
		$orderid = $_COOKIE['orderid'];
	}

	$oldOrder = $memc->get($orderid);
	if(!is_array($oldOrder)) $oldOrder = array();
	$newOrder = explode('|',$wgRequest->getVal('order'));

	if( count($newOrder) > 1 ) {
		$memc->set($orderid, array_unique(array_merge($newOrder, array_diff($oldOrder, $newOrder))));
	}

	wfProfileOut( __METHOD__ );

	return new AjaxResponse(true);
}

$wgAjaxExportList[] = "wfDragAndDropReorder";
$wgAjaxExportList[] = "getSuggestedArticleURL";
$wgAjaxExportList[] = "cxValidateUserName";
$wgAjaxExportList[] = "searchSuggest";
