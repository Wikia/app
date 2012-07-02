<?php

class AccountRequestSubmission {
	/* User making the request */
	protected $requester;
	/* Desired name and fields filled from form */
	protected $userName;
	protected $realName;
	protected $tosAccepted;
	protected $email;
	protected $bio;
	protected $notes;
	protected $urls;
	protected $type;
	/** @var array */
	protected $areas;
	protected $registration;
	protected $ip;
	/* File attachment fields */
	protected $attachmentSrcName; // user given attachment base name
	protected $attachmentPrevName; // user given attachment base name last attempt
	protected $attachmentDidNotForget; // user already saw "please re-attach" notice
	protected $attachmentSize; // bytes size of file
	protected $attachmentTempPath; // tmp path file was uploaded to FS

	public function __construct( User $requester, array $params ) {
		$this->requester = $requester;
		$this->userName = trim( $params['userName'] );
		$this->realName = trim( $params['realName'] );
		$this->tosAccepted = $params['tosAccepted'];
		$this->email = $params['email'];
		$this->bio = trim( $params['bio'] );
		$this->notes = trim( $params['notes'] );
		$this->urls = trim( $params['urls'] );
		$this->type = $params['type'];
		$this->areas = $params['areas'];
		$this->ip = $params['ip'];
		$this->registration = wfTimestamp( TS_MW, $params['registration'] );
		$this->attachmentPrevName = $params['attachmentPrevName'];
		$this->attachmentSrcName = $params['attachmentSrcName'];
		$this->attachmentDidNotForget = $params['attachmentDidNotForget'];
		$this->attachmentSize = $params['attachmentSize'];
		$this->attachmentTempPath = $params['attachmentTempPath'];
	}

	/**
	 * @return string
	 */
	public function getAttachmentDidNotForget() {
		return $this->attachmentDidNotForget;
	}

	/**
	 * @return string
	 */
	public function getAttachtmentPrevName() {
		return $this->attachmentPrevName;
	}

	/**
	 * Attempt to validate and submit this data to the DB
	 * @param $context IContextSource
	 * @return array( true or error key string, html error msg or null )
	 */
	public function submit( IContextSource $context ) {
		global $wgAuth, $wgAccountRequestThrottle, $wgMemc, $wgContLang;
		global $wgAccountRequestToS, $wgAccountRequestMinWords;

		$reqUser = $this->requester;

		# Make sure that basic permissions are checked
		$block = ConfirmAccount::getAccountRequestBlock( $reqUser );
		if ( $block ) {
			return array( 'accountreq_permission_denied', wfMsgHtml( 'badaccess-group0' ) );
		} elseif ( wfReadOnly() ) {
			return array( 'accountreq_readonly', wfMsgHtml( 'badaccess-group0' ) );
		}

		# Now create a dummy user ($u) and check if it is valid
		if ( $this->userName === '' ) {
			return array( 'accountreq_no_name', wfMsgHtml( 'noname' ) );
		}
		$u = User::newFromName( $this->userName, 'creatable' );
		if ( !$u ) {
			return array( 'accountreq_invalid_name', wfMsgHtml( 'noname' ) );
		}
		# No request spamming...
		if ( $wgAccountRequestThrottle && $reqUser->isPingLimitable() ) {
			$key = wfMemcKey( 'acctrequest', 'ip', $this->ip );
			$value = (int)$wgMemc->get( $key );
			if ( $value > $wgAccountRequestThrottle ) {
				return array( 'accountreq_throttled',
					wfMsgExt( 'acct_request_throttle_hit', 'parsemag', $wgAccountRequestThrottle )
				);
			}
		}
		# Make sure user agrees to policy here
		if ( $wgAccountRequestToS && !$this->tosAccepted ) {
			return array( 'acct_request_skipped_tos', wfMsgHtml( 'requestaccount-agree' ) );
		}
		# Validate email address
		if ( !Sanitizer::validateEmail( $this->email ) ) {
			return array( 'acct_request_invalid_email', wfMsgHtml( 'invalidemailaddress' ) );
		}
		# Check if biography is long enough
		if ( str_word_count( $this->bio ) < $wgAccountRequestMinWords ) {
			return array( 'acct_request_short_bio',
				wfMsgExt( 'requestaccount-tooshort', 'parsemag',
					$wgContLang->formatNum( $wgAccountRequestMinWords ) )
			);
		}
		# Per security reasons, file dir cannot be pulled from client,
		# so ask them to resubmit it then...
		global $wgAllowAccountRequestFiles, $wgAccountRequestExtraInfo;
		# If the extra fields are off, then uploads are off
		$allowFiles = $wgAccountRequestExtraInfo && $wgAllowAccountRequestFiles;
		if ( $allowFiles && $this->attachmentPrevName && !$this->attachmentSrcName ) {
			# If the user is submitting forgotAttachment as true with no file,
			# then they saw the notice and choose not to re-select the file.
			# Assume that they don't want to send one anymore.
			if ( !$this->attachmentDidNotForget ) {
				$this->attachmentPrevName = '';
				$this->attachmentDidNotForget = 0;
				return array( false, wfMsgHtml( 'requestaccount-resub' ) );
			}
		}
		# Check if already in use
		if ( 0 != $u->idForName() || $wgAuth->userExists( $u->getName() ) ) {
			return array( 'accountreq_username_exists', wfMsgHtml( 'userexists' ) );
		}
		# Set email and real name
		$u->setEmail( $this->email );
		$u->setRealName( $this->realName );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin(); // ready to acquire locks
		# Check pending accounts for name use
		if ( !UserAccountRequest::acquireUsername( $u->getName() ) ) {
			$dbw->rollback();
			return array( 'accountreq_username_pending', wfMsgHtml( 'requestaccount-inuse' ) );
		}
		# Check if someone else has an account request with the same email
		if ( !UserAccountRequest::acquireEmail( $u->getEmail() ) ) {
			$dbw->rollback();
			return array( 'acct_request_email_exists', wfMsgHtml( 'requestaccount-emaildup' ) );
		}
		# Process upload...
		if ( $allowFiles && $this->attachmentSrcName ) {
			global $wgAccountRequestExts, $wgConfirmAccountFSRepos;

			$ext = explode( '.', $this->attachmentSrcName );
			$finalExt = $ext[count( $ext ) - 1];
			# File must have size.
			if ( trim( $this->attachmentSrcName ) == '' || empty( $this->attachmentSize ) ) {
				$this->attachmentPrevName = '';
				$dbw->rollback();
				return array( 'acct_request_empty_file', wfMsgHtml( 'emptyfile' ) );
			}
			# Look at the contents of the file; if we can recognize the
			# type but it's corrupt or data of the wrong type, we should
			# probably not accept it.
			if ( !in_array( $finalExt, $wgAccountRequestExts ) ) {
				$this->attachmentPrevName = '';
				$dbw->rollback();
				return array( 'acct_request_bad_file_ext', wfMsgHtml( 'requestaccount-exts' ) );
			}
			$veri = ConfirmAccount::verifyAttachment( $this->attachmentTempPath, $finalExt );
			if ( !$veri->isGood() ) {
				$this->attachmentPrevName = '';
				$dbw->rollback();
				return array( 'acct_request_corrupt_file', wfMsgHtml( 'verification-error' ) );
			}
			# Start a transaction, move file from temp to account request directory.
			$repo = new FSRepo( $wgConfirmAccountFSRepos['accountreqs'] );
			$key = sha1_file( $this->attachmentTempPath ) . '.' . $finalExt;
			$pathRel = UserAccountRequest::relPathFromKey( $key );
			$triplet = array( $this->attachmentTempPath, 'public', $pathRel );
			$status = $repo->storeBatch( array( $triplet ), FSRepo::OVERWRITE_SAME ); // save!
			if ( !$status->isOk() ) {
				$dbw->rollback();
				return array( 'acct_request_file_store_error',
					wfMsgHtml( 'filecopyerror', $this->attachmentTempPath, $pathRel ) );
			}
		}
		$expires = null; // passed by reference
		$token = ConfirmAccount::getConfirmationToken( $u, $expires );

		# Insert into pending requests...
		$req = UserAccountRequest::newFromArray( array(
			'name' 			=> $u->getName(),
			'email' 		=> $u->getEmail(),
			'real_name' 	=> $u->getRealName(),
			'registration' 	=> $this->registration,
			'bio' 			=> $this->bio,
			'notes' 		=> $this->notes,
			'urls' 			=> $this->urls,
			'filename' 		=> isset( $this->attachmentSrcName )
				? $this->attachmentSrcName
				: null,
			'type' 			=> $this->type,
			'areas' 		=> $this->areas,
			'storage_key' 	=> isset( $key ) ? $key : null,
			'comment' 		=> '',
			'email_token' 	=> md5( $token ),
			'email_token_expires' => $expires,
			'ip' 			=> $this->ip,
		) );
		$req->insertOn();
		# Send confirmation, required!
		$result = ConfirmAccount::sendConfirmationMail( $u, $this->ip, $token, $expires );
		if ( !$result->isOK() ) {
			$dbw->rollback(); // nevermind
			if ( isset( $repo ) && isset( $pathRel ) ) { // remove attachment
				$repo->cleanupBatch( array( array( 'public', $pathRel ) ) );
			}
			return array( 'acct_request_mail_failed',
				wfMsg( 'mailerror', $context->getOutput()->parse( $result->getWikiText() ) ) );
		}
		$dbw->commit();

		# Clear cache for notice of how many account requests there are
		ConfirmAccount::clearAccountRequestCountCache();
		# No request spamming...
		if ( $wgAccountRequestThrottle && $reqUser->isPingLimitable() ) {
			$ip = $context->getRequest()->getIP();
			$key = wfMemcKey( 'acctrequest', 'ip', $ip );
			$value = $wgMemc->incr( $key );
			if ( !$value ) {
				$wgMemc->set( $key, 1, 86400 );
			}
		}
		# Done!
		return array( true, null );
	}
}
