<?php

namespace Email\Controller;

use Email\EmailController;

class MonobookNotificationController extends EmailController {

	public function getSubject() {
		return "will be ignored anyway";
	}

	public function body() {
		$this->overrideTemplate( 'monobook' );
	}
}
