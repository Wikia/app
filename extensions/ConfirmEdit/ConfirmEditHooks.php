<?php

class ConfirmEditHooks {
	/**
	 * Get the global Captcha instance
	 *
	 * @return Captcha|SimpleCaptcha
	 */
	static function getInstance() {
		global $wgCaptcha, $wgCaptchaClass;

		static $done = false;

		if ( !$done ) {
			$done = true;
			$wgCaptcha = new $wgCaptchaClass;
		}

		return $wgCaptcha;
	}

	static function confirmEditMerged( $editPage, $newtext ) {
		return self::getInstance()->confirmEditMerged( $editPage, $newtext );
	}

	static function confirmEditAPI( $editPage, $newtext, &$resultArr ) {
		return self::getInstance()->confirmEditAPI( $editPage, $newtext, $resultArr );
	}

	static function injectUserCreate( &$template ) {
		return self::getInstance()->injectUserCreate( $template );
	}

	static function confirmUserCreate( $u, &$message ) {
		return self::getInstance()->confirmUserCreate( $u, $message );
	}

	static function triggerUserLogin( $user, $password, $retval ) {
		return self::getInstance()->triggerUserLogin( $user, $password, $retval );
	}

	static function injectUserLogin( &$template ) {
		return self::getInstance()->injectUserLogin( $template );
	}

	static function confirmUserLogin( $u, $pass, &$retval ) {
		return self::getInstance()->confirmUserLogin( $u, $pass, $retval );
	}

	static function injectEmailUser( &$form ) {
		return self::getInstance()->injectEmailUser( $form );
	}

	static function confirmEmailUser( $from, $to, $subject, $text, &$error ) {
		return self::getInstance()->confirmEmailUser( $from, $to, $subject, $text, $error );
	}

	public static function APIGetAllowedParams( &$module, &$params ) {
		return self::getInstance()->APIGetAllowedParams( $module, $params );
	}

	public static function APIGetParamDescription( &$module, &$desc ) {
		return self::getInstance()->APIGetParamDescription( $module, $desc );
	}
}

class CaptchaSpecialPage extends UnlistedSpecialPage {
	public function __construct() {
		parent::__construct( 'Captcha' );
	}

	function execute( $par ) {
		$this->setHeaders();

		$instance = ConfirmEditHooks::getInstance();

		switch( $par ) {
			case "image":
				if ( method_exists( $instance, 'showImage' ) ) {
					return $instance->showImage();
				}
			case "help":
			default:
				return $instance->showHelp();
		}
	}
}
