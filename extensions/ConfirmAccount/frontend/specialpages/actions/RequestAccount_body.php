<?php

class RequestAccountPage extends SpecialPage {
	protected $mUsername;
	protected $mRealName;
	protected $mEmail;
	protected $mBio;
	protected $mNotes;
	protected $mUrls;
	protected $mToS;
	protected $mType;
	/** @var array */
	protected $mAreas;

	protected $mPrevAttachment;
	protected $mForgotAttachment;
	protected $mSrcName;
	protected $mFileSize;
	protected $mTempPath;

	function __construct() {
		parent::__construct( 'RequestAccount' );
	}

	function execute( $par ) {
		global $wgUseRealNamesOnly, $wgAccountRequestToS, $wgAccountRequestExtraInfo;
		global $wgAccountRequestTypes;

		$reqUser = $this->getUser();
		$request = $this->getRequest();

		$block = ConfirmAccount::getAccountRequestBlock( $reqUser );
		if ( $block ) {
			throw new UserBlockedError( $block );
		} elseif ( wfReadOnly() ) {
			throw new ReadOnlyError();
		}

		$this->setHeaders();

		$this->mRealName = trim( $request->getText( 'wpRealName' ) );
		# We may only want real names being used
		$this->mUsername = $wgUseRealNamesOnly
			? $this->mRealName
			: $request->getText( 'wpUsername' );
		$this->mUsername = trim( $this->mUsername );
		# Attachments...
		$this->initializeUpload( $request );
		$this->mPrevAttachment = $request->getText( 'attachment' );
		$this->mForgotAttachment = $request->getBool( 'forgotAttachment' );
		# Other fields...
		$this->mEmail = trim( $request->getText( 'wpEmail' ) );
		$this->mBio = $request->getText( 'wpBio', '' );
		$this->mNotes = $wgAccountRequestExtraInfo ?
			$request->getText( 'wpNotes', '' ) : '';
		$this->mUrls = $wgAccountRequestExtraInfo ?
			$request->getText( 'wpUrls', '' ) : '';
		$this->mToS = $wgAccountRequestToS ?
			$request->getBool( 'wpToS' ) : false;
		$this->mType = $request->getInt( 'wpType' );
		$this->mType = isset( $wgAccountRequestTypes[$this->mType] ) ?
			$this->mType : 0;
		# Load areas user plans to be active in...
		$this->mAreas = array();
		foreach ( ConfirmAccount::getUserAreaConfig() as $name => $conf ) {
			$formName = "wpArea-" . htmlspecialchars( str_replace( ' ', '_', $name ) );
			$this->mAreas[$name] = $request->getInt( $formName, -1 );
		}
		# We may be confirming an email address here
		$emailCode = $request->getText( 'wpEmailToken' );

		$action = $request->getVal( 'action' );
		if ( $request->wasPosted() && $reqUser->matchEditToken( $request->getVal( 'wpEditToken' ) ) ) {
			$this->mPrevAttachment = $this->mPrevAttachment ? $this->mPrevAttachment : $this->mSrcName;
			$this->doSubmit();
		} elseif ( $action == 'confirmemail' ) {
			$this->confirmEmailToken( $emailCode );
		} else {
			$this->showForm();
		}

		$this->getOutput()->addModules( 'ext.confirmAccount' ); // CSS
	}

	protected function showForm( $msg = '', $forgotFile = 0 ) {
		global $wgUseRealNamesOnly, $wgAllowRealName;
		global $wgAccountRequestToS, $wgAccountRequestTypes, $wgAccountRequestExtraInfo,
			$wgAllowAccountRequestFiles, $wgMakeUserPageFromBio;

		$reqUser = $this->getUser();

		$this->mForgotAttachment = $forgotFile;

		$out = $this->getOutput();
		$out->setPagetitle( wfMsgHtml( "requestaccount" ) );
		# Output failure message if any
		if ( $msg ) {
			$out->addHTML( '<div class="errorbox">' . $msg . '</div><div class="visualClear"></div>' );
		}
		# Give notice to users that are logged in
		if ( $reqUser->getID() ) {
			$out->addWikiMsg( 'requestaccount-dup' );
		}

		$out->addWikiMsg( 'requestaccount-text' );

		$form  = Xml::openElement( 'form', array( 'method' => 'post', 'name' => 'accountrequest',
			'action' => $this->getTitle()->getLocalUrl(), 'enctype' => 'multipart/form-data' ) );
		$form .= '<fieldset><legend>' . wfMsgHtml( 'requestaccount-leg-user' ) . '</legend>';
		$form .= wfMsgExt( 'requestaccount-acc-text', 'parse' ) . "\n";
		$form .= '<table cellpadding=\'4\'>';
		if ( $wgUseRealNamesOnly ) {
			$form .= "<tr><td>" . wfMsgHtml( 'username' ) . "</td>";
			$form .= "<td>" . wfMsgHtml( 'requestaccount-same' ) . "</td></tr>\n";
		} else {
			$form .= "<tr><td>" . Xml::label( wfMsgHtml( 'username' ), 'wpUsername' ) . "</td>";
			$form .= "<td>" . Xml::input( 'wpUsername', 30, $this->mUsername, array( 'id' => 'wpUsername' ) ) . "</td></tr>\n";
		}
		$form .= "<tr><td>" . Xml::label( wfMsgHtml( 'requestaccount-email' ), 'wpEmail' ) . "</td>";
		$form .= "<td>" . Xml::input( 'wpEmail', 30, $this->mEmail, array( 'id' => 'wpEmail' ) ) . "</td></tr>\n";
		if ( count( $wgAccountRequestTypes ) > 1 ) {
			$form .= "<tr><td>" . wfMsgHtml( 'requestaccount-reqtype' ) . "</td><td>";
			$options = array();
			foreach ( $wgAccountRequestTypes as $i => $params ) {
				$options[] = Xml::option( wfMsg( "requestaccount-level-$i" ), $i, ( $i == $this->mType ) );
			}
			$form .= Xml::openElement( 'select', array( 'name' => "wpType" ) );
			$form .= implode( "\n", $options );
			$form .= Xml::closeElement( 'select' ) . "\n";
			$form .= '</td></tr>';
		}
		$form .= '</table></fieldset>';

		$userAreas = ConfirmAccount::getUserAreaConfig();
		if ( count( $userAreas ) > 0 ) {
			$form .= '<fieldset>';
			$form .= '<legend>' . wfMsgHtml( 'requestaccount-leg-areas' ) . '</legend>';
			$form .=  wfMsgExt( 'requestaccount-areas-text', 'parse' ) . "\n";

			$form .= "<div style='height:150px; overflow:scroll; background-color:#f9f9f9;'>";
			$form .= "<table cellspacing='5' cellpadding='0' style='background-color:#f9f9f9;'><tr valign='top'>";
			$count = 0;
			foreach ( $userAreas as $name => $conf ) {
				$count++;
				if ( $count > 5 ) {
					$form .= "</tr><tr valign='top'>";
					$count = 1;
				}
				$formName = "wpArea-" . htmlspecialchars( str_replace( ' ', '_', $name ) );
				if ( $conf['project'] != '' ) {
					$pg = Linker::link( Title::newFromText( $conf['project'] ),
						wfMsgHtml( 'requestaccount-info' ), array(), array(), "known" );
				} else {
					$pg = '';
				}
				$form .= "<td>" .
					Xml::checkLabel( $name, $formName, $formName, $this->mAreas[$name] > 0 ) .
					" {$pg}</td>\n";
			}
			$form .= "</tr></table></div>";
			$form .= '</fieldset>';
		}

		$form .= '<fieldset>';
		$form .= '<legend>' . wfMsgHtml( 'requestaccount-leg-person' ) . '</legend>';
		if ( $wgMakeUserPageFromBio ) {
			$form .= wfMsgExt( 'requestaccount-bio-text-i', 'parse' ) . "\n";
		}
		$form .= wfMsgExt( 'requestaccount-bio-text', 'parse' ) . "\n";

		if ( $wgUseRealNamesOnly  || $wgAllowRealName ) {
			$form .= '<table cellpadding=\'4\'>';
			$form .= "<tr><td>" . Xml::label( wfMsgHtml( 'requestaccount-real' ), 'wpRealName' ) . "</td>";
			$form .= "<td>" . Xml::input( 'wpRealName', 35, $this->mRealName, array( 'id' => 'wpRealName' ) ) . "</td></tr>\n";
			$form .= '</table>';
		}
		$form .= "<p>" . wfMsgWikiHtml( 'requestaccount-bio' ) . "\n";
		$form .= "<textarea tabindex='1' name='wpBio' id='wpBio' rows='12' cols='80' style='width:100%; background-color:#f9f9f9;'>" .
			htmlspecialchars( $this->mBio ) . "</textarea></p>\n";
		$form .= '</fieldset>';
		if ( $wgAccountRequestExtraInfo ) {
			$form .= '<fieldset>';
			$form .= '<legend>' . wfMsgHtml( 'requestaccount-leg-other' ) . '</legend>';
			$form .= wfMsgExt( 'requestaccount-ext-text', 'parse' ) . "\n";
			if ( $wgAllowAccountRequestFiles ) {
				$form .= "<p>" . wfMsgHtml( 'requestaccount-attach' ) . " ";
				$form .= Xml::input( 'wpUploadFile', 35, '',
					array( 'id' => 'wpUploadFile', 'type' => 'file' ) ) . "</p>\n";
			}
			$form .= "<p>" . wfMsgHtml( 'requestaccount-notes' ) . "\n";
			$form .= "<textarea tabindex='1' name='wpNotes' id='wpNotes' rows='3' cols='80' style='width:100%;background-color:#f9f9f9;'>" .
				htmlspecialchars( $this->mNotes ) .
				"</textarea></p>\n";
			$form .= "<p>" . wfMsgHtml( 'requestaccount-urls' ) . "\n";
			$form .= "<textarea tabindex='1' name='wpUrls' id='wpUrls' rows='2' cols='80' style='width:100%; background-color:#f9f9f9;'>" .
				htmlspecialchars( $this->mUrls ) .
				"</textarea></p>\n";
			$form .= '</fieldset>';
		}
		if ( $wgAccountRequestToS ) {
			$form .= '<fieldset>';
			$form .= '<legend>' . wfMsgHtml( 'requestaccount-leg-tos' ) . '</legend>';
			$form .= "<p>" . Xml::check( 'wpToS', $this->mToS, array( 'id' => 'wpToS' ) ) .
				' <label for="wpToS">' . wfMsgExt( 'requestaccount-tos', array( 'parseinline' ) ) . "</label></p>\n";
			$form .= '</fieldset>';
		}
		# FIXME: do this better...
		global $wgConfirmAccountCaptchas, $wgCaptchaClass, $wgCaptchaTriggers;
		if ( $wgConfirmAccountCaptchas && isset( $wgCaptchaClass )
			&& $wgCaptchaTriggers['createaccount'] && !$reqUser->isAllowed( 'skipcaptcha' ) )
		{
			$captcha = new $wgCaptchaClass;
			# Hook point to add captchas
			$form .= '<fieldset>';
			$form .= wfMsgExt( 'captcha-createaccount', 'parse' );
			$form .= $captcha->getForm();
			$form .= '</fieldset>';
		}
		$form .= Html::Hidden( 'title', $this->getTitle()->getPrefixedDBKey() ) . "\n";
		$form .= Html::Hidden( 'wpEditToken', $reqUser->editToken() ) . "\n";
		$form .= Html::Hidden( 'attachment', $this->mPrevAttachment ) . "\n";
		$form .= Html::Hidden( 'forgotAttachment', $this->mForgotAttachment ) . "\n";
		$form .= "<p>" . Xml::submitButton( wfMsgHtml( 'requestaccount-submit' ) ) . "</p>";
		$form .= Xml::closeElement( 'form' );

		$out->addHTML( $form );

		$out->addWikiMsg( 'requestaccount-footer' );
	}

	protected function doSubmit() {
		# Now create a dummy user ($u) and check if it is valid
		$name = trim( $this->mUsername );
		$u = User::newFromName( $name, 'creatable' );
		if ( !$u ) {
			$this->showForm( wfMsgHtml( 'noname' ) );
			return;
		}
		# Set some additional data so the AbortNewAccount hook can be
		# used for more than just username validation
		$u->setEmail( $this->mEmail );
		$u->setRealName( $this->mRealName );
		# FIXME: Hack! If we don't want captchas for requests, temporarily turn it off!
		global $wgConfirmAccountCaptchas, $wgCaptchaTriggers;
		if ( !$wgConfirmAccountCaptchas && isset( $wgCaptchaTriggers ) ) {
			$old = $wgCaptchaTriggers['createaccount'];
			$wgCaptchaTriggers['createaccount'] = false;
		}
		$abortError = '';
		if ( !wfRunHooks( 'AbortNewAccount', array( $u, &$abortError ) ) ) {
			// Hook point to add extra creation throttles and blocks
			wfDebug( "RequestAccount::doSubmit: a hook blocked creation\n" );
			$this->showForm( $abortError );
			return;
		}
		# Set it back!
		if ( !$wgConfirmAccountCaptchas && isset( $wgCaptchaTriggers ) ) {
			$wgCaptchaTriggers['createaccount'] = $old;
		}

		# Build submission object...
		$areaSet = array(); // make a simple list of interests
		foreach ( $this->mAreas as $area => $val ) {
			if ( $val > 0 ) {
				$areaSet[] = $area;
			}
		}
		$submission = new AccountRequestSubmission(
			$this->getUser(),
			array(
				'userName'                  => $name,
				'realName'                  => $this->mRealName,
				'tosAccepted'               => $this->mToS,
				'email'                     => $this->mEmail,
				'bio'                       => $this->mBio,
				'notes'                     => $this->mNotes,
				'urls'                      => $this->mUrls,
				'type'                      => $this->mType,
				'areas'                     => $areaSet,
				'registration'              => wfTimestampNow(),
				'ip'                        => $this->getRequest()->getIP(),
				'attachmentPrevName'        => $this->mPrevAttachment,
				'attachmentSrcName'         => $this->mSrcName,
				'attachmentDidNotForget'    => $this->mForgotAttachment, // confusing name :)
				'attachmentSize'            => $this->mFileSize,
				'attachmentTempPath'        => $this->mTempPath
			)
		);

		# Actually submit!
		list( $status, $msg ) = $submission->submit( $this->getContext() );
		# Account for state changes
		$this->mForgotAttachment = $submission->getAttachmentDidNotForget();
		$this->mPrevAttachment = $submission->getAttachtmentPrevName();
		# Check for error messages
		if ( $status !== true ) {
			$this->showForm( $msg );
			return;
		}

		# Done!
		$this->showSuccess();
	}

	protected function showSuccess() {
		$out = $this->getOutput();
		$out->setPagetitle( wfMsg( "requestaccount" ) );
		$out->addWikiMsg( 'requestaccount-sent' );
		$out->returnToMain();
	}

	/**
	 * Initialize the uploaded file from PHP data
	 * @param $request WebRequest
	 */
	protected function initializeUpload( $request ) {
		$this->mTempPath = $request->getFileTempName( 'wpUploadFile' );
		$this->mFileSize = $request->getFileSize( 'wpUploadFile' );
		$this->mSrcName = $request->getFileName( 'wpUploadFile' );
	}

	/**
	 * (a) Try to confirm an email address via a token
	 * (b) Notify $wgConfirmAccountContact on success
	 * @param $code string The token
	 * @return void
	 */
	protected function confirmEmailToken( $code ) {
		global $wgConfirmAccountContact, $wgPasswordSender, $wgPasswordSenderName;
		$reqUser = $this->getUser();
		$out = $this->getOutput();
		# Confirm if this token is in the pending requests
		$name = ConfirmAccount::requestNameFromEmailToken( $code );
		if ( $name !== false ) {
			# Send confirmation email to prospective user
			ConfirmAccount::confirmEmail( $name );
			# Send mail to admin after e-mail has been confirmed
			if ( $wgConfirmAccountContact != '' ) {
				$target = new MailAddress( $wgConfirmAccountContact );
				$source = new MailAddress( $wgPasswordSender, $wgPasswordSenderName );
				$title = SpecialPage::getTitleFor( 'ConfirmAccounts' );
				$subject = wfMsgForContent( 'requestaccount-email-subj-admin' );
				$body = wfMsgForContent(
					'requestaccount-email-body-admin', $name, $title->getFullUrl() );
				# Actually send the email...
				$result = UserMailer::send( $target, $source, $subject, $body );
				if ( !$result->isOK() ) {
					wfDebug( "Could not sent email to admin at $target\n" );
				}
			}
			$out->addWikiMsg( 'request-account-econf' );
			$out->returnToMain();
		} else {
			# Maybe the user confirmed after account was created...
			$user = User::newFromConfirmationCode( $code );
			if ( is_object( $user ) ) {
				if ( $user->confirmEmail() ) {
					$message = $reqUser->isLoggedIn() ? 'confirmemail_loggedin' : 'confirmemail_success';
					$out->addWikiMsg( $message );
					if ( !$reqUser->isLoggedIn() ) {
						$title = SpecialPage::getTitleFor( 'Userlogin' );
						$out->returnToMain( true, $title->getPrefixedUrl() );
					}
				} else {
					$out->addWikiMsg( 'confirmemail_error' );
				}
			} else {
				$out->addWikiMsg( 'confirmemail_invalid' );
			}
		}
	}
}
