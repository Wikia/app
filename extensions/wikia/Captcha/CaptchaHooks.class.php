<?php

namespace Captcha;

class Hooks {

	protected static $handler;

	/**
	 * Get the global Captcha instance
	 *
	 * @return Handler
	 */
	static function getInstance() {
		if ( !self::$handler ) {
			self::$handler = new Handler();
		}

		return self::$handler;
	}

	public static function confirmEditMerged( $editPage, $newtext ) {
		return self::getInstance()->confirmEditMerged( $editPage, $newtext );
	}

	public static function confirmEditAPI( $editPage, $newtext, &$resultArr ) {
		return self::getInstance()->confirmEditAPI( $editPage, $newtext, $resultArr );
	}

	public static function injectUserCreate( \QuickTemplate $template ): bool {
		return self::getInstance()->injectUserCreate( $template );
	}

	public static function confirmUserCreate( $u, &$message ) {
		return self::getInstance()->confirmUserCreate( $u, $message );
	}

	public static function triggerUserLogin( $user, $password, $retval ) {
		return self::getInstance()->triggerUserLogin( $user, $password, $retval );
	}

	public static function injectUserLogin( \QuickTemplate $template ): bool {
		return self::getInstance()->injectUserLogin( $template );
	}

	public static function injectEmailUser( \HTMLForm $form ): bool {
		return self::getInstance()->injectEmailUser( $form );
	}

	public static function confirmEmailUser( $from, $to, $subject, $text, &$error ) {
		return self::getInstance()->confirmEmailUser( $from, $to, $subject, $text, $error );
	}

	public static function APIGetAllowedParams( \ApiBase $module, &$params ): bool {
		return Factory\Module::getInstance()->APIGetAllowedParams( $module, $params );
	}

	public static function APIGetParamDescription( \ApiBase $module, &$desc ): bool {
		return Factory\Module::getInstance()->APIGetParamDescription( $module, $desc );
	}
}
