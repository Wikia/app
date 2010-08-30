<?php
class FeedbackModule extends Module {

	var $siteCode;
	var $userData;

	public function executeIndex() {
		wfProfileIn(__METHOD__);
		global $wgUser, $wgKampyleSecretKey;

		// config for feedback account
		$this->siteCode = 7376518;

		// send user data (for logged in only)
		// @see http://forums.kampyle.com/viewtopic.php?f=2&t=6723
		if ($wgUser->isLoggedIn()) {
			// calculate hash
			$u_id = 'wikia_user_' . $wgUser->getId();
			$u_code = hash('sha256', $wgKampyleSecretKey . $u_id);

			$this->userData = array(
				'u_code' => $u_code,
				'u_id' => $u_id,
				'u_disp' => $wgUser->getName(),
				'u_email' => str_replace('@', 'KAMP_SPEC40', $wgUser->getEmail()),
				'u_notify_email' => 0,
			);
		}

		// load CSS for Feedback feature
		global $wgOut;
		$wgOut->addStyle('http://cf.kampyle.com/k_button.css', 'screen');

		wfProfileOut(__METHOD__);
	}
}