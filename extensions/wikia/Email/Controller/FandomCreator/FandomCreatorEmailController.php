<?php

namespace Email\Controller\FandomCreator;

use Email\EmailController;

abstract class FandomCreatorEmailController extends EmailController {
	/** @var MagicWordWrapper */
	protected $magicWordWrapper;

	public function initEmail() {
		$sitename = $this->getVal('siteName');
		$domain = $this->getVal('domain');
		$this->magicWordWrapper = new MagicWordWrapper($sitename, $domain);
	}

	protected function getFooterMessages() {
		return [
				$this->getMessage( 'emailext-recipient-notice', $this->getTargetUserEmail() )->parse(),
				$this->getMessage( 'emailext-unsubscribe', $this->getUnsubscribeLink() )->parse(),
		];
	}
}
