<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "ConfirmAccount extension\n";
	exit( 1 );
}

# Add messages
wfLoadExtensionMessages( 'ConfirmAccount' );

class RequestAccountPage extends SpecialPage {

	function __construct() {
		parent::__construct( 'RequestAccount' );
	}

	function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $action, $wgUseRealNamesOnly,
			$wgAccountRequestToS, $wgAccountRequestExtraInfo, $wgAccountRequestTypes;
		# If a user cannot make accounts, don't let them request them either
		global $wgAccountRequestWhileBlocked;
		if( !$wgAccountRequestWhileBlocked && $wgUser->isBlockedFromCreateAccount() ) {
			$wgOut->blockedPage();
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		$this->setHeaders();

		$this->mRealName = trim( $wgRequest->getText( 'wpRealName' ) );
		# We may only want real names being used
		if( $wgUseRealNamesOnly )
			$this->mUsername = $this->mRealName;
		else
			$this->mUsername = trim( $wgRequest->getText( 'wpUsername' ) );
		# Attachments...
		$this->initializeUpload( $wgRequest );
		$this->mPrevAttachment = $wgRequest->getText( 'attachment' );
		$this->mForgotAttachment = $wgRequest->getBool( 'forgotAttachment' );
		# Other fields...
		$this->mEmail = trim( $wgRequest->getText( 'wpEmail' ) );
		$this->mBio = $wgRequest->getText( 'wpBio', '' );
		$this->mNotes = $wgAccountRequestExtraInfo ? 
			$wgRequest->getText( 'wpNotes', '' ) : '';
		$this->mUrls = $wgAccountRequestExtraInfo ? 
			$wgRequest->getText( 'wpUrls', '' ) : '';
		$this->mToS = $wgAccountRequestToS ? 
			$wgRequest->getBool('wpToS') : false;
		$this->mType = $wgRequest->getInt( 'wpType' );
		$this->mType = isset($wgAccountRequestTypes[$this->mType]) ? $this->mType : 0;
		# Load areas user plans to be active in...
		$this->mAreas = $this->mAreaSet = array();
		if( !wfEmptyMsg( 'requestaccount-areas', wfMsg('requestaccount-areas') ) ) {
			$areas = explode("\n*","\n".wfMsg('requestaccount-areas'));
			foreach( $areas as $n => $area ) {
				$set = explode("|",$area,2);
				if( $set[0] && isset($set[1]) ) {
					$formName = "wpArea-" . htmlspecialchars(str_replace(' ','_',$set[0]));
					$this->mAreas[$formName] = $wgRequest->getInt( $formName, -1 );
					# Make a simple list of interests
					if( $this->mAreas[$formName] > 0 )
						$this->mAreaSet[] = str_replace( '_', ' ', $set[0] );
				}
			}
		}
		# We may be confirming an email address here
		$emailCode = $wgRequest->getText( 'wpEmailToken' );

		$this->skin = $wgUser->getSkin();

		if( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal('wpEditToken') ) ) {
			$this->mPrevAttachment = $this->mPrevAttachment ? $this->mPrevAttachment : $this->mSrcName;
			$this->doSubmit();
		} else if( $action == 'confirmemail' ) {
			$this->confirmEmailToken( $emailCode );
		} else {
			$this->showForm();
		}
	}

	function showForm( $msg='', $forgotFile=0 ) {
		global $wgOut, $wgUser, $wgUseRealNamesOnly, $wgAllowRealName, $wgAccountRequestToS, 
			$wgAccountRequestTypes, $wgAccountRequestExtraInfo, $wgAllowAccountRequestFiles;

		$this->mForgotAttachment = $forgotFile;

		$wgOut->setPagetitle( wfMsgHtml( "requestaccount" ) );
		# Output failure message if any
		if( $msg ) {
			$wgOut->addHTML( '<div class="errorbox">'.$msg.'</div><div class="visualClear"></div>' );
		}
		# Give notice to users that are logged in
		if( $wgUser->getID() ) {
			$wgOut->addWikiText( wfMsg( "requestaccount-dup" ) );
		}

		$wgOut->addWikiText( wfMsg( "requestaccount-text" ) );

		$titleObj = Title::makeTitle( NS_SPECIAL, 'RequestAccount' );
		
		$form  = wfOpenElement( 'form', array( 'method' => 'post', 'name' => 'accountrequest',
			'action' => $titleObj->getLocalUrl(), 'enctype' => 'multipart/form-data' ) );
		$form .= '<fieldset><legend>' . wfMsgHtml('requestaccount-leg-user') . '</legend>';
		$form .= wfMsgExt( 'requestaccount-acc-text', array('parse') )."\n";
		$form .= '<table cellpadding=\'4\'>';
		if( $wgUseRealNamesOnly ) {
			$form .= "<tr><td>".wfMsgHtml('username')."</td>";
			$form .= "<td>".wfMsgHtml('requestaccount-same')."</td></tr>\n";
		} else {
			$form .= "<tr><td>".Xml::label( wfMsgHtml('username'), 'wpUsername' )."</td>";
			$form .= "<td>".Xml::input( 'wpUsername', 30, $this->mUsername, array('id' => 'wpUsername') )."</td></tr>\n";
		}
		$form .= "<tr><td>".Xml::label( wfMsgHtml('requestaccount-email'), 'wpEmail' )."</td>";
		$form .= "<td>".Xml::input( 'wpEmail', 30, $this->mEmail, array('id' => 'wpEmail') )."</td></tr>\n";
		if( count($wgAccountRequestTypes) > 1 ) {
			$form .= "<tr><td>".wfMsgHtml('requestaccount-reqtype')."</td><td>";
			foreach( $wgAccountRequestTypes as $i => $params ) {
				$options[] = Xml::option( wfMsg( "requestaccount-level-$i" ), $i, ($i == $this->mType) );
			}
			$form .= Xml::openElement( 'select', array( 'name' => "wpType" ) );
			$form .= implode( "\n", $options );
			$form .= Xml::closeElement('select')."\n";
		}
		$form .= '</td></tr></table></fieldset>';
		
		if( !wfEmptyMsg( 'requestaccount-areas', wfMsg('requestaccount-areas') ) ) {
			$form .= '<fieldset>';
			$form .= '<legend>' . wfMsgHtml('requestaccount-leg-areas') . '</legend>';
			$form .=  wfMsgExt( 'requestaccount-areas-text', array('parse') )."\n";
			
			$areas = explode("\n*","\n".wfMsg('requestaccount-areas'));
			$form .= "<div style='height:150px; overflow:scroll; background-color:#f9f9f9;'>";
			$form .= "<table cellspacing='5' cellpadding='0' style='background-color:#f9f9f9;'><tr valign='top'>";
			$count = 0;
			foreach( $areas as $area ) {
				$set = explode("|",$area,3);
				if( $set[0] && isset($set[1]) ) {
					$count++;
					if( $count > 5 ) {
						$form .= "</tr><tr valign='top'>";
						$count = 1;
					}
					$formName = "wpArea-" . htmlspecialchars(str_replace(' ','_',$set[0]));
					if( isset($set[1]) ) {
						$pg = $this->skin->makeKnownLink( $set[1], wfMsgHtml('requestaccount-info') );
					} else {
						$pg = '';
					}
					
					$form .= "<td>".wfCheckLabel( $set[0], $formName, $formName, $this->mAreas[$formName] > 0 )." {$pg}</td>\n";
				}
			}
			$form .= "</tr></table></div>";
			$form .= '</fieldset>';
		}

		$form .= '<fieldset>';
		$form .= '<legend>' . wfMsgHtml('requestaccount-leg-person') . '</legend>';
		$form .= wfMsgExt( 'requestaccount-bio-text', array('parse') )."\n";
		if( $wgUseRealNamesOnly  || $wgAllowRealName ) {
			$form .= '<table cellpadding=\'4\'>';
			$form .= "<tr><td>".Xml::label( wfMsgHtml('requestaccount-real'), 'wpRealName' )."</td>";
			$form .= "<td>".Xml::input( 'wpRealName', 35, $this->mRealName, array('id' => 'wpRealName') )."</td></tr>\n";
			$form .= '</table>';
		}
		$form .= "<p>".wfMsgHtml('requestaccount-bio')."\n";
		$form .= "<textarea tabindex='1' name='wpBio' id='wpBio' rows='12' cols='80' style='width:100%; background-color:#f9f9f9;'>" .
			htmlspecialchars($this->mBio) . "</textarea></p>\n";
		$form .= '</fieldset>';
		if( $wgAccountRequestExtraInfo ) {
			$form .= '<fieldset>';
			$form .= '<legend>' . wfMsgHtml('requestaccount-leg-other') . '</legend>';
			$form .= wfMsgExt( 'requestaccount-ext-text', array('parse') )."\n";
			if( $wgAllowAccountRequestFiles ) {
				$form .= "<p>".wfMsgHtml('requestaccount-attach')." ";
				$form .= Xml::input( 'wpUploadFile', 35, '', 
					array('id' => 'wpUploadFile', 'type' => 'file') )."</p>\n";
			}
			$form .= "<p>".wfMsgHtml('requestaccount-notes')."\n";
			$form .= "<textarea tabindex='1' name='wpNotes' id='wpNotes' rows='3' cols='80' style='width:100%;background-color:#f9f9f9;'>" .
				htmlspecialchars($this->mNotes) .
				"</textarea></p>\n";
			$form .= "<p>".wfMsgHtml('requestaccount-urls')."\n";
			$form .= "<textarea tabindex='1' name='wpUrls' id='wpUrls' rows='2' cols='80' style='width:100%; background-color:#f9f9f9;'>" .
				htmlspecialchars($this->mUrls) .
				"</textarea></p>\n";
			$form .= '</fieldset>';
		}
		# Pseudo template for extensions
		# FIXME: do this better...
		global $wgConfirmAccountCaptchas, $wgCaptchaClass, $wgCaptchaTriggers;
		if( $wgConfirmAccountCaptchas && isset($wgCaptchaClass) && $wgCaptchaTriggers['createaccount'] ) {
			global $wgExtensionMessagesFiles;
		
			$captcha = new $wgCaptchaClass;
			# Hook point to add captchas
			wfLoadExtensionMessages( 'ConfirmEdit' );
			if( isset( $wgExtensionMessagesFiles[$wgCaptchaClass] ) ) {
				wfLoadExtensionMessages( $wgCaptchaClass );
			}
			$form .= '<fieldset>';
			$form .= wfMsgExt('captcha-createaccount','parse');
			$form .= $captcha->getForm();
			$form .= '</fieldset>';
		}
		if( $wgAccountRequestToS ) {
			$form .= "<p>".Xml::check( 'wpToS', $this->mToS, array('id' => 'wpToS') ).
				' <label for="wpToS">'.wfMsgExt( 'requestaccount-tos', array('parseinline') )."</label></p>\n";
		}
		$form .= Xml::hidden( 'title', $titleObj->getPrefixedUrl() )."\n";
		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() )."\n";
		$form .= Xml::hidden( 'attachment', $this->mPrevAttachment )."\n";
		$form .= Xml::hidden( 'forgotAttachment', $this->mForgotAttachment )."\n";
		$form .= "<p>".Xml::submitButton( wfMsgHtml( 'requestaccount-submit') )."</p>";
		$form .= wfCloseElement( 'form' );

		$wgOut->addHTML( $form );
		
		$wgOut->addWikiText( wfMsg( "requestaccount-footer" ) );
	}

	function doSubmit() {
		global $wgOut, $wgUser, $wgAuth, $wgAccountRequestThrottle;
		# Now create a dummy user ($u) and check if it is valid
		$name = trim( $this->mUsername );
		$u = User::newFromName( $name, 'creatable' );	
		if( is_null($u) ) {
			$this->showForm( wfMsgHtml('noname') );
			return;
		}
		# FIXME: Hack! If we don't want them for requests, temporarily turn it off!
		global $wgConfirmAccountCaptchas, $wgCaptchaTriggers;
		if( !$wgConfirmAccountCaptchas && isset($wgCaptchaTriggers) ) {
			$old = $wgCaptchaTriggers['createaccount'];
			$wgCaptchaTriggers['createaccount'] = false;
		}
		$abortError = '';
		if( !wfRunHooks( 'AbortNewAccount', array( $u, &$abortError ) ) ) {
			// Hook point to add extra creation throttles and blocks
			wfDebug( "RequestAccount::doSubmit: a hook blocked creation\n" );
			$this->showForm( $abortError );
			return;
		}
		# Set it back!
		if( !$wgConfirmAccountCaptchas && isset($wgCaptchaTriggers) ) {
			$wgCaptchaTriggers['createaccount'] = $old;
		}
		# No request spamming...
		if( $wgAccountRequestThrottle && ( !method_exists($wgUser,'isPingLimitable') || $wgUser->isPingLimitable() ) ) {
			global $wgMemc;
			
			$key = wfMemcKey( 'acctrequest', 'ip', wfGetIP() );
			$value = $wgMemc->get( $key );
			if( $value > $wgAccountRequestThrottle ) {
				$this->throttleHit( $wgAccountRequestThrottle );
				return;
			}
		}
		# Check if already in use
		if( 0 != $u->idForName() || $wgAuth->userExists( $u->getName() ) ) {
			$this->showForm( wfMsgHtml('userexists') );
			return;
		}
		# Check pending accounts for name use
		$dbw = wfGetDB( DB_MASTER );
		$dup = $dbw->selectField( 'account_requests', '1',
			array( 'acr_name' => $u->getName() ),
			__METHOD__ );
		if( $dup ) {
			$this->showForm( wfMsgHtml('requestaccount-inuse') );
			return;
		}
		# Make sure user agrees to policy here
		global $wgAccountRequestToS;
		if( $wgAccountRequestToS && !$this->mToS ) {
			$this->showForm( wfMsgHtml('requestaccount-agree') );
			return;
		}
		# Validate email address
		if( !$u->isValidEmailAddr( $this->mEmail ) ) {
			$this->showForm( wfMsgHtml('invalidemailaddress') );
			return;
		}
		global $wgAccountRequestMinWords;
		# Check if biography is long enough
		if( str_word_count($this->mBio) < $wgAccountRequestMinWords ) {
			$this->showForm( wfMsgHtml('requestaccount-tooshort',$wgAccountRequestMinWords) );
			return;
		}
		# Set some additional data so the AbortNewAccount hook can be
		# used for more than just username validation
		$u->setEmail( $this->mEmail );
		# Check if someone else has an account request with the same email
		$dup = $dbw->selectField( 'account_requests', '1',
			array( 'acr_email' => $u->getEmail() ),
			__METHOD__ );
		if( $dup ) {
			$this->showForm( wfMsgHtml('requestaccount-emaildup') );
			return;
		}
		$u->setRealName( $this->mRealName );
		# Per security reasons, file dir cannot be pulled from client,
		# so ask them to resubmit it then...
		global $wgAllowAccountRequestFiles, $wgAccountRequestExtraInfo;
		# If the extra fields are off, then uploads are off
		$allowFiles = $wgAccountRequestExtraInfo && $wgAllowAccountRequestFiles;
		if( $allowFiles && $this->mPrevAttachment && !$this->mSrcName ) {
			# If the user is submitting forgotAttachment as true with no file, 
			# then they saw the notice and choose not to re-select the file. 
			# Assume that they don't want to send one anymore.
			if( !$this->mForgotAttachment ) {
				$this->mPrevAttachment = '';
				$this->showForm( wfMsgHtml('requestaccount-resub'), 1 );
				return false;
			}
		}
		# Process upload...
		if( $allowFiles && $this->mSrcName ) {
			$ext = explode('.',$this->mSrcName);
			$finalExt = $ext[count($ext)-1];
			# File must have size.
			if( trim( $this->mSrcName ) == '' || empty( $this->mFileSize ) ) {
				$this->mPrevAttachment = '';
				$this->showForm( wfMsgHtml( 'emptyfile' ) );
				return false;
			}
    		# Look at the contents of the file; if we can recognize the
		 	# type but it's corrupt or data of the wrong type, we should
		 	# probably not accept it.
		 	global $wgAccountRequestExts;
		 	if( !in_array($finalExt,$wgAccountRequestExts) ) {
		 		$this->mPrevAttachment = '';
				$this->showForm( wfMsgHtml( 'requestaccount-exts' ) );
				return false;
		 	}
			$veri = $this->verify( $this->mTempPath, $finalExt );
			if( $veri !== true ) {
				$this->mPrevAttachment = '';
				$this->showForm( wfMsgHtml( 'uploadcorrupt' ) );
				return false;
			}
			# Start a transaction, move file from temp to account request directory.
			$transaction = new FSTransaction();
			if( !FileStore::lock() ) {
				wfDebug( __METHOD__.": failed to acquire file store lock, aborting\n" );
				return false;
			}
			$store = FileStore::get( 'accountreqs' );
			if( !$store ) {
				wfDebug( __METHOD__.": invalid storage group '{$store}'.\n" );
				return false;
			}

			$key = FileStore::calculateKey( $this->mTempPath, $finalExt );
			
			$transaction->add( $store->insert( $key, $this->mTempPath, FileStore::DELETE_ORIGINAL ) );
			if( $transaction === false ) {
				// Failed to move?
				wfDebug( __METHOD__.": import to file store failed, aborting\n" );
				throw new MWException( "Could not insert file {$this->mTempPath}" );
				return false;
			}
		}
		$expires = null; // passed by reference
		$token = $this->getConfirmationToken( $u, $expires );
		# Insert into pending requests...
		$acr_id = $dbw->nextSequenceValue( 'account_requests_acr_id_seq' );
		$dbw->begin();
		$dbw->insert( 'account_requests',
			array( 
				'acr_id' => $acr_id,
				'acr_name' => $u->getName(),
				'acr_email' => $u->getEmail(),
				'acr_real_name' => $u->getRealName(),
				'acr_registration' => $dbw->timestamp(),
				'acr_bio' => $this->mBio,
				'acr_notes' => $this->mNotes,
				'acr_urls' => $this->mUrls,
				'acr_filename' => isset($this->mSrcName) ? $this->mSrcName : null,
				'acr_type' => $this->mType,
				'acr_areas' => self::flattenAreas( $this->mAreaSet ),
				'acr_storage_key' => isset($key) ? $key : null,
				'acr_comment' => '',
				'acr_email_token' => md5($token),
			    'acr_email_token_expires' => $dbw->timestamp( $expires ),
				'acr_ip' => wfGetIP() // Possible use for spam blocking
			),
			__METHOD__ 
		);
		# Clear cache for notice of how many account requests there are
		global $wgMemc;
		$key = wfMemcKey( 'confirmaccount', 'noticecount' );
		$wgMemc->delete( $key );
		# Send confirmation, required!
		$result = $this->sendConfirmationMail( $u, $token, $expires );
		if( WikiError::isError( $result ) ) {
			$dbw->rollback(); // Nevermind
			$error = wfMsg( 'mailerror', htmlspecialchars( $result->toString() ) );
			$this->showForm( $error );
			return false;
		}
		$dbw->commit();
		if( isset($transaction) ) {
			wfDebug( __METHOD__.": set db items, applying file transactions\n" );
			$transaction->commit();
			FileStore::unlock();
		}
		# No request spamming...
		# BC: check if isPingLimitable() exists
		if( $wgAccountRequestThrottle && ( !method_exists($wgUser,'isPingLimitable') || $wgUser->isPingLimitable() ) ) {
			global $wgMemc;
			$key = wfMemcKey( 'acctrequest', 'ip', wfGetIP() );
			$value = $wgMemc->incr( $key );
			if( !$value ) {
				$wgMemc->set( $key, 1, 86400 );
			}
		}
		# Done!
		$this->showSuccess();
	}

	function showSuccess() {
		global $wgOut;
		$wgOut->setPagetitle( wfMsg( "requestaccount" ) );
		$wgOut->addWikiText( wfMsg( "requestaccount-sent" ) );
		$wgOut->returnToMain();
	}
	
	/**
	 * Flatten areas of interest array
	 * @access private
	 */
	static function flattenAreas( $areas ) {
		$flatAreas = '';
		foreach( $areas as $area ) {
			$flatAreas .= $area."\n";
		}
		return $flatAreas;
	}
	
	/**
	 * Expand areas of interest to array
	 * @access private
	 */
	static function expandAreas( $areas ) {
		$list = explode("\n",$areas);
		foreach( $list as $n => $item ) {
			$list[$n] = trim("wpArea-".str_replace( ' ', '_', $item ));
		}
		unset( $list[count($list)-1] );
		return $list;
	}
	
	/**
	 * Initialize the uploaded file from PHP data
	 * @access private
	 */
	function initializeUpload( $request ) {
		$this->mTempPath       = $request->getFileTempName( 'wpUploadFile' );
		$this->mFileSize       = $request->getFileSize( 'wpUploadFile' );
		$this->mSrcName        = $request->getFileName( 'wpUploadFile' );
		$this->mRemoveTempFile = false; // PHP will handle this
	}
	
	/**
	 * Verifies that it's ok to include the uploaded file
	 *
	 * @param string $tmpfile the full path of the temporary file to verify
	 * @param string $extension The filename extension that the file is to be served with
	 * @return mixed true of the file is verified, a WikiError object otherwise.
	 */
	function verify( $tmpfile, $extension ) {
		#magically determine mime type
		$magic=& MimeMagic::singleton();
		$mime = $magic->guessMimeType($tmpfile,false);

		#check mime type, if desired
		global $wgVerifyMimeType;
		if ($wgVerifyMimeType) {

		  wfDebug ( "\n\nmime: <$mime> extension: <$extension>\n\n");
			#check mime type against file extension
			if( !UploadForm::verifyExtension( $mime, $extension ) ) {
				return new WikiErrorMsg( 'uploadcorrupt' );
			}

			#check mime type blacklist
			global $wgMimeTypeBlacklist;
			if( isset($wgMimeTypeBlacklist) && !is_null($wgMimeTypeBlacklist)
				&& $this->checkFileExtension( $mime, $wgMimeTypeBlacklist ) ) {
				return new WikiErrorMsg( 'filetype-badmime', htmlspecialchars( $mime ) );
			}
		}

		wfDebug( __METHOD__.": all clear; passing.\n" );
		return true;
	}
	
	/**
	 * Perform case-insensitive match against a list of file extensions.
	 * Returns true if the extension is in the list.
	 *
	 * @param string $ext
	 * @param array $list
	 * @return bool
	 */
	function checkFileExtension( $ext, $list ) {
		return in_array( strtolower( $ext ), $list );
	}
	
	/**
	 * @private
	 */
	function throttleHit( $limit ) {
		global $wgOut;

		$wgOut->addWikiText( wfMsgHtml( 'acct_request_throttle_hit', $limit ) );
	}
	
	function confirmEmailToken( $code ) {
		global $wgUser, $wgOut;
		# Confirm if this token is in the pending requests
		$name = $this->requestFromEmailToken( $code );
		if( $name !== false ) {
			# Send confirmation email to prospective user
			$this->confirmEmail( $name );
			# Send mail to admin after e-mail has been confirmed;
			global $wgConfirmAccountContact;
			if( $wgConfirmAccountContact ) {
				$u = User::newFromName( $name, 'creatable' );
				$u->setEmail( $wgConfirmAccountContact );
				$title = Title::makeTitle( NS_SPECIAL, 'ConfirmAccounts' );
				$url = $title->getFullUrl();
				$u->sendMail( wfMsg('requestaccount-email-subj-admin'),
					wfMsg( 'requestaccount-email-body-admin', $name, $url ) );
			}
			$wgOut->addWikiText( wfMsgHtml( 'request-account-econf' ) );
			$wgOut->returnToMain();
			return;
		}
		# Maybe the user confirmed after account was created...
		$user = User::newFromConfirmationCode( $code );
		if( is_object( $user ) ) {
			if( $user->confirmEmail() ) {
				$message = $wgUser->isLoggedIn() ? 'confirmemail_loggedin' : 'confirmemail_success';
				$wgOut->addWikiText( wfMsg( $message ) );
				if( !$wgUser->isLoggedIn() ) {
					$title = SpecialPage::getTitleFor( 'Userlogin' );
					$wgOut->returnToMain( true, $title->getPrefixedUrl() );
				}
			} else {
				$wgOut->addWikiText( wfMsg( 'confirmemail_error' ) );
			}
		} else {
			$wgOut->addWikiText( wfMsg( 'confirmemail_invalid' ) );
		}
	}
	
	/**
	 * Get a request name from an emailconfirm token
	 *
	 * @param sring $code
	 * @returns string $name
	 */		
	function requestFromEmailToken( $code ) {	
		$dbr = wfGetDB( DB_SLAVE );
		$reqID = $dbr->selectField( 'account_requests', 'acr_name', 
			array( 'acr_email_token' => md5($code),
				'acr_email_token_expires > ' . $dbr->addQuotes( $dbr->timestamp() ),
			) 
		);
		return $reqID;
	}
	
	/**
	 * Flag a user's email as confirmed in the db
	 *
	 * @param sring $name
	 */	
	function confirmEmail( $name ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'account_requests', 
			array( 'acr_email_authenticated' => $dbw->timestamp() ),
			array( 'acr_name' => $name ),
			__METHOD__ );
		# Clear cache for notice of how many account requests there are
		global $wgMemc;
		$key = wfMemcKey( 'confirmaccount', 'noticecount' );
		$wgMemc->delete( $key );
	}
	
	/**
	 * Generate a new e-mail confirmation token and send a confirmation
	 * mail to the user's given address.
	 *
	 * @param User $user
	 * @param string $token
	 * @param string $expiration
	 * @return mixed True on success, a WikiError object on failure.
	 */
	function sendConfirmationMail( $user, $token, $expiration ) {
		global $wgContLang;
		$url = $this->confirmationTokenUrl( $token );
		return $user->sendMail( wfMsg( 'requestaccount-email-subj' ),
			wfMsg( 'requestaccount-email-body',
				wfGetIP(),
				$user->getName(),
				$url,
				$wgContLang->timeanddate( $expiration, false ) ) );
	}	
	
	/**
	 * Generate and store a new e-mail confirmation token, and return
	 * the URL the user can use to confirm.
	 * @param string $token
	 * @return string
	 * @private
	 */
	function confirmationTokenUrl( $token ) {
		$title = Title::makeTitle( NS_SPECIAL, 'RequestAccount' );
		return $title->getFullUrl( 'action=confirmemail&wpEmailToken='.$token );
	}
	
	/**
	 * Generate, store, and return a new e-mail confirmation code.
	 * A hash (unsalted since it's used as a key) is stored.
	 * @param User $user
	 * @param string $expiration
	 * @return string
	 * @private
	 */
	function getConfirmationToken( $user, &$expiration ) {
		global $wgConfirmAccountRejectAge;
		
		$expires = time() + $wgConfirmAccountRejectAge;
		$expiration = wfTimestamp( TS_MW, $expires );

		$token = $user->generateToken( $user->getName() . $user->getEmail() . $expires );

		return $token;
	}
	
}

