<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */
class SpecialForceDownloadIndex extends UnlistedSpecialPage {
	var $mName, $mPassword, $mRetype, $mReturnto, $mCookieCheck, $mPosted;
	var $mAction, $mCreateaccount, $mCreateaccountMail, $mMailmypassword;
	var $mLoginattempt, $mRemember, $mEmail, $mBrowser;
	var $err, $errInputs;

	function  __construct() {
		parent::__construct( 'ForceDownloadIndex' , ''/*'forcedownloadindex'*/ /*restriction*/);
	}

	function execute() {
		global $wgOut, $wgUser, $wgRequest, $wgCityId;

		if(!$this->userCanExecute($wgUser)) {
			$this->displayRestrictionError();
			return;
		}
		
		$wgOut->setPageTitle( 'Test' );
		$wgOut->addStyle( F::app()->getAssetsManager()->getSassCommonURL('extensions/wikia/SpecialContact/SpecialContact.scss'));
		
		if( $wgRequest->wasPosted() ) {
			//do some random DB stuff
			$tmp = WikiFactory::IDtoDB($wgCityId);
			
			sleep(10);
			//$wgOut->disable();
			$wgOut->addHTML("<strong>result: $tmp - " . $wgRequest->getText('input_value', 'No value posted') . "</strong>");
		} else {
			$wgOut->addHTML('<em>Input requested!</em>');
		}
	}
}