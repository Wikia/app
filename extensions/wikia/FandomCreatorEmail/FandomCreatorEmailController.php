<?php

namespace FandomCreatorEmail;

use Email\EmailController;

abstract class FandomCreatorEmailController extends EmailController {
	/** @var MagicWordWrapper */
	protected $magicWordWrapper;

	public function initEmail() {
		$siteName = $this->getVal( 'siteName' );
		$siteUrl = $this->getVal( 'siteUrl' );
		$this->magicWordWrapper = new MagicWordWrapper( $siteName, $siteUrl );
	}

	protected function getFooterMessages() {
		return [
				$this->getMessage( 'emailext-recipient-notice', $this->getTargetUserEmail() )->parse(),
				$this->getMessage( 'emailext-unsubscribe', $this->getUnsubscribeLink() )->parse(),
		];
	}
}
