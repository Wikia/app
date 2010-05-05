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
 * @Author Maciej Błaszkowski <marooned at wikia-inc.com>
 *
 * @Param String $uName
 *
 * @Return String
 */
function cxValidateUserName () {
	global $wgRequest;
	wfProfileIn(__METHOD__);

	$uName = $wgRequest->getVal('uName');
	
	$result = wfValidateUserName($uName);

	$data = array('result' => $result);

	$json = Wikia::json_encode($data);
	$response = new AjaxResponse($json);
	$response->setContentType('application/json; charset=utf-8');
	$response->setCacheDuration(60);
	wfProfileOut(__METHOD__);
	return $response;
}

/**
 * Given a username, returns one of several codes to indicate whether it is valid to be a NEW username or not.
 *
 * Codes:
 * - OK: A user with this username may be created.
 * - INVALID: This is not a valid username.  This may mean that it is too long or has characters that aren't permitted, etc.
 * - EXISTS: A user with this name, so you cannot create one with this name.
 *
 * TODO: Is this a duplicate of user::isCreatableName()? It is important to note that wgWikiaMaxNameChars may be less than wgMaxNameChars which
 * is intentional because there are some long usernames that were created when only wgMaxNameChars limited to 255 characters and we still want
 * those usernames to be valid (so that they can still login), but we just don't want NEW accounts to be created above the length of wgWikiaMaxNameChars.
 */
function wfValidateUserName($uName){
	global $wgWikiaMaxNameChars, $wgExternalSharedDB;
	wfProfileIn(__METHOD__);

//	global $IP;
//	require_once ($IP . '/includes/User.php');
	if( empty($wgWikiaMaxNameChars) ) {
		//emergency fallback
		global $wgMaxNameChars;
		$wgWikiaMaxNameChars = $wgMaxNameChars;
	}

	$result = 'OK';#wfMsg ('username-valid');

	$nt = Title::newFromText( $uName );
	if( is_null( $nt ) ) {
		# Illegal name
		$result = 'INVALID';
	} elseif ( mb_strlen($uName) > $wgWikiaMaxNameChars ) {
		# Too long (for wikia)
		$result = 'INVALID';
	} else {
		$uName = $nt->getText();

		$dbr = wfGetDB (DB_SLAVE);
		$uName = $dbr->strencode($uName);
		if ($uName == '') {
			$result = 'INVALID';
		} else {

			// TODO: Is it any faster just to test 0 == User::idFromName($uName)?  It appears that first we're checking the current wiki, then the external.

			$oRow = $dbr->selectRow( 'user', 'user_name', array('user_name' => $uName), __METHOD__);
			if ($oRow !== false) {
				$result = 'EXISTS';#wfMsg ('username-exists');
			} else {
				$dbExt = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
				if ($dbExt->NumRows ($dbResults = $dbExt->Query ("SELECT User_Name FROM `user` WHERE User_Name = '$uName';"))) {
					$result = 'EXISTS';#wfMsg ('username-exists');
				} else {
					global $wgReservedUsernames;
					if(in_array($uName, $wgReservedUsernames)){
						$result = 'EXISTS'; // if we returned 'invalid', that would be confusing once a user checked and found that the name already met the naming requirements.
					}
				}
			}
		}
	}
	
	wfProfileOut(__METHOD__);
	return $result;
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
