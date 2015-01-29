<?php

namespace Captcha;

class Hooks {
	static function confirmEditMerged( $editPage, $newtext ) {
		return Factory::getInstance()->confirmEditMerged( $editPage, $newtext );
	}

	static function confirmEditAPI( $editPage, $newtext, &$resultArr ) {
		return Factory::getInstance()->confirmEditAPI( $editPage, $newtext, $resultArr );
	}

	static function injectUserCreate( &$template ) {
gmark();
		return Factory::getInstance()->injectUserCreate( $template );
	}

	static function confirmUserCreate( $u, &$message ) {
gmark();
		return Factory::getInstance()->confirmUserCreate( $u, $message );
	}

	static function triggerUserLogin( $user, $password, $retval ) {
		return Factory::getInstance()->triggerUserLogin( $user, $password, $retval );
	}

	static function injectUserLogin( &$template ) {
		return Factory::getInstance()->injectUserLogin( $template );
	}

	static function confirmUserLogin( $u, $pass, &$retval ) {
		return Factory::getInstance()->confirmUserLogin( $u, $pass, $retval );
	}

	static function injectEmailUser( &$form ) {
		return Factory::getInstance()->injectEmailUser( $form );
	}

	static function confirmEmailUser( $from, $to, $subject, $text, &$error ) {
		return Factory::getInstance()->confirmEmailUser( $from, $to, $subject, $text, $error );
	}

	public static function APIGetAllowedParams( &$module, &$params ) {
		return Factory::getInstance()->APIGetAllowedParams( $module, $params );
	}

	public static function APIGetParamDescription( &$module, &$desc ) {
		return Factory::getInstance()->APIGetParamDescription( $module, $desc );
	}
}
