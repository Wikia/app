<?php

/**
 * Send a test email to the address provided.  Require a challenge token to
 * make sure this tool can't be abused.  Allow for a confirmation token so
 * the script reading the mail accounts at the other end can verify which
 * email is which.
 *
 */

$wgSpecialPages['EmailTest'] = 'SpecialEmailTest';

class SpecialEmailTest extends UnlistedSpecialPage {

	private	$mAccount;
	private $mChallengeToken;
	private $mConfirmToken;
	private $mText;

	public function __construct() {
		global $wgEmailTestSecretToken;

		parent::__construct( 'EmailTest', 'emailtest' );

		$this->mChallengeToken = $wgEmailTestSecretToken;
		$this->mConfirmToken = time().'-'.rand(10000, 99999).'_emailtest';
		$this->mText = "The quick brown fox jumps over the lazy dog";
	}

	public function execute( $subpage ) {
		global $wgRequest, $wgEnableWikiaDBEmail, $wgEnablePostfixEmail;

		wfProfileIn( __METHOD__ );

		// Don't allow just anybody to use this
		if ( !Wikia\Security\Utils::matchToken( $this->mChallengeToken, $wgRequest->getVal('challenge') ) ) {
			header("Status: 400");
			header("Content-type: text/plain");
			print("Challenge incorrect");

			wfProfileOut( __METHOD__ );
			exit;
		}

		// Make sure we get an email address
		$this->mAccount = $wgRequest->getVal('account');
		if (!$this->mAccount) {
			header("Status: 400");
			header("Content-type: text/plain");
			print("Parameter 'account' required");

			wfProfileOut( __METHOD__ );
			exit;
		}

		# These two both have defaults
		$this->mText = $wgRequest->getVal('text', $this->mText);
		$this->mConfirmToken = $wgRequest->getVal('token', $this->mConfirmToken);

		# default to whatever mail backend is in config or wikifactory, allow override
		if ( $wgRequest->getVal('force') ) {
			$wgEnableWikiaDBEmail = ($wgRequest->getVal('force') == 'wikiadb');
			$wgEnablePostfixEmail = ($wgRequest->getVal('force') == 'postfix');
		}

		UserMailer::send( new MailAddress($this->mAccount),
						  new MailAddress('test@wikia-inc.com'),
						  "EmailTest - End to end test",
						  $this->mConfirmToken."\n".$this->mText,
						  null,
						  null,
						  "emailtest",
						  1
						);

		header("Status: 200");
		header("Content-type: text/plain");
		print($this->mConfirmToken);

		wfProfileOut( __METHOD__ );
		exit;
	}
}
