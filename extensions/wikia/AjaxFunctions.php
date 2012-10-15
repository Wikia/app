<?php
/*
 * Ajax Functions used by Wikia extensions
 */

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

	if ( $result === true ) {
		$message = '';
		if ( !wfRunHooks("cxValidateUserName",array($uName,&$message)) ) {
			$result = $message;
		}
	}

	if( $result === true ) {
		$data = array('result' => 'OK' );
	} else {
		$data = array('result' => 'INVALID', 'msg' => wfMsg($result), 'msgname' => $result );
	}

	$json = json_encode($data);
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
	wfProfileIn(__METHOD__);

	$result = true;#wfMsg ('username-valid');

	$nt = Title::newFromText( $uName );
	if( !User::isNotMaxNameChars($uName) ) {
		$result = 'userlogin-bad-username-length';

	} elseif ( is_null( $nt ) ) {
		$result = 'userlogin-bad-username-character';
	} else {
		$uName = $nt->getText();

		if ( !User::isCreatableName( $uName ) ) {
			$result = 'userlogin-bad-username-character';
		} else {
			$dbr = wfGetDB (DB_SLAVE);
			$uName = $dbr->strencode($uName);
			if ($uName == '') {
				$result = 'userlogin-bad-username-character';
			} else {
				if(User::idFromName($uName) != 0) {
					$result = 'userlogin-bad-username-taken';
				}

				global $wgReservedUsernames;
				if(in_array($uName, $wgReservedUsernames)){
					$result = 'userlogin-bad-username-taken'; // if we returned 'invalid', that would be confusing once a user checked and found that the name already met the naming requirements.
				}
			}
		}
	}

	wfProfileOut(__METHOD__);
	return $result;
}

$wgAjaxExportList[] = "cxValidateUserName";
