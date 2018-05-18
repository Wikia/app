<?php

namespace Email\Controller;

use Email\EmailController;

class GdprNotificationController extends EmailController {

	public function getSubject() {
		return "will be ignored anyway";
	}

	/**
	 * @template passwordResetLink
	 */
	public function body() {
		$this->overrideTemplate( 'gdprNotification-' . $this->targetLang  );
	}
}
