<?php

class FlashMessages {
	const FLASH_MESSAGE_SESSION_KEY = 'flash_message';

	public static function pop() {
		global $wgRequest;
		$message = $wgRequest->getSessionData(self::FLASH_MESSAGE_SESSION_KEY);
		$wgRequest->setSessionData(self::FLASH_MESSAGE_SESSION_KEY, null);
		return $message;
	}

	public function put($message) {
		global $wgRequest;
		$wgRequest->setSessionData(self::FLASH_MESSAGE_SESSION_KEY, $message);
	}
}
