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

	public static function injectUserCreate( &$template ) {
		return self::getInstance()->injectUserCreate( $template );
	}

	public static function confirmUserCreate( $u, &$message ) {
		return self::getInstance()->confirmUserCreate( $u, $message );
	}

	public static function triggerUserLogin( $user, $password, $retval ) {
		return self::getInstance()->triggerUserLogin( $user, $password, $retval );
	}

	public static function injectUserLogin( &$template ) {
		return self::getInstance()->injectUserLogin( $template );
	}

	public static function injectEmailUser( &$form ) {
		return self::getInstance()->injectEmailUser( $form );
	}

	public static function confirmEmailUser( $from, $to, $subject, $text, &$error ) {
		return self::getInstance()->confirmEmailUser( $from, $to, $subject, $text, $error );
	}

	public static function APIGetAllowedParams( &$module, &$params ) {
		return Factory\Module::getInstance()->APIGetAllowedParams( $module, $params );
	}

	public static function APIGetParamDescription( &$module, &$desc ) {
		return Factory\Module::getInstance()->APIGetParamDescription( $module, $desc );
	}

	// Temporarily load captcha library on every page until we have on demand loading set up.
	// Remove with https://wikia-inc.atlassian.net/browse/SOC-288
	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		$script = \AssetsManager::getInstance()->getURL( 'captcha_js' );
		$text .= \Html::linkedScript( $script[0] );
		return true;
	}
}
