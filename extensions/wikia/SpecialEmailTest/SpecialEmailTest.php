<?php

/**
 * Send a test email to the address provided.  Require a challenge token to
 * make sure this tool can't be abused.  Allow for a confirmation token so
 * the script reading the mail accounts at the other end can verify which
 * email is which.
 *
 */

$wgSpecialPages['EmailTest'] = 'SpecialEmailTest';
$wgGroupPermissions['*']['emailtest'] = false;
$wgGroupPermissions['staff']['emailtest'] = true;

class SpecialEmailTest extends UnlistedSpecialPage {

	private	$mAccount;
	private $mChallengeToken;
	private $mConfirmToken;
	private $mText;

	public function __construct() {
		global $wgEmailTestSecretToken;

		parent::__construct( 'EmailTest', 'emailtest' );

		$this->mChallengeToken = $wgEmailTestSecretToken;
		$this->mConfirmToken = time()."_emailtest"
		$this->mText = "The quick brown fox jumps over the lazy dog";
	}

	public function execute( $subpage ) {
		global $wgOut, $wgUser, $wgMessageCache;

		$wgMessageCache->addMessages( array( 'emailtest' => 'EmailTest' ), 'en' );

		wfProfileIn( __METHOD__ );

		$this->setHeaders();

		if ($this->isRestricted() && !$this->userCanExecute( $wgUser )) {
			$this->displayRestrictionError();
			return;
		}
		
		// Keep this separate from the above check in the event we want ever want
		// to handle this differently
		if ($this->mChallengeToken != $wgRequest->getVal('challenge')) {
			$this->displayRestrictionError();
			return;
		}
		
		// Make sure we get an email address
		$this->mAccount = $wgRequest->getVal('account');
		if (!$this->mAccount) {
			$wgOut->setStatusCode(400);
			$wgOut->addHTML("Parameter 'account' required");
			return;
		}
		
		# These two both have defaults
		$this->mText = $wgRequest->getVal('text', $this->mText);
		$this->mConfirmToken = $wgRequest->getVal('token', $this->mConfirmToken);
		
		UserMailer::send( new MailAddress($this->mAccount),
						  new MailAddress('test@wikia-inc.com'),
						  "EmailTest - End to end test",
						  $this->mText,
						  null,
						  null,
						  $this->mConfirmToken
						);

		$wgOut->setStatusCode(200);
		$wgOut->addHTML($this->mConfirmToken);

		wfProfileOut( __METHOD__ );
	}
}
