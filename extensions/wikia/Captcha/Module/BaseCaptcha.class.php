<?php

namespace Captcha\Module;

use Captcha\Factory;
use Wikia\Logger\WikiaLogger;

/**
 * Class BaseCaptcha
 *
 * @package Captcha\Module
 */
abstract class BaseCaptcha extends \WikiaObject {

	public $action;

	public $actionDetail;

	/**
	 * Called to determine what field to look for when validating if the captcha has loaded
	 *
	 * @return string
	 */
	abstract function checkCaptchaField();

	public function getCaptcha() {
		$a = mt_rand( 0, 100 );
		$b = mt_rand( 0, 10 );

		/* Minus sign is used in the question. UTF-8,
		   since the api uses text/plain, not text/html */
		$op = mt_rand( 0, 1 ) ? '+' : '−';

		// No space before and after $op, to ensure correct
		// directionality.
		$test = "$a$op$b";
		$answer = ( $op == '+' ) ? ( $a + $b ) : ( $a - $b );
		return [
			'question' => $test,
			'answer' => $answer
		];
	}

	public function addCaptchaAPI( &$resultArr ) {
		$captcha = $this->getCaptcha();
		$index = $this->storeCaptcha( $captcha );
		$resultArr['captcha']['type'] = 'simple';
		$resultArr['captcha']['mime'] = 'text/plain';
		$resultArr['captcha']['id'] = $index;
		$resultArr['captcha']['question'] = $captcha['question'];
	}

	/**
	 * Insert a captcha prompt into the edit form.
	 * This sample implementation generates a simple arithmetic operation;
	 * it would be easy to defeat by machine.
	 *
	 * Override this!
	 *
	 * @return string HTML
	 */
	public function getForm() {
		$captcha = $this->getCaptcha();
		$index = $this->storeCaptcha( $captcha );

		return "<p><label for=\"wpCaptchaWord\">{$captcha['question']}</label> = " .
		\Xml::element( 'input', [
			'name' => 'wpCaptchaWord',
			'id'   => 'wpCaptchaWord',
			'tabindex' => 1,
		] ) . // tab in before the edit textarea
		"</p>\n" .
		\Xml::element( 'input', [
			'type'  => 'hidden',
			'name'  => 'wpCaptchaId',
			'id'    => 'wpCaptchaId',
			'value' => $index,
		] );
	}

	/**
	 * Show a message asking the user to enter a captcha on edit
	 * The result will be treated as wiki text
	 *
	 * @param string $action Action being performed
	 *
	 * @return string
	 */
	public function getMessage( $action ) {
		// Possible keys for easy grepping: captcha-edit, captcha-addurl, captcha-createaccount, captcha-create
		$name = 'captcha-' . $action;
		$text = wfMessage( $name )->escaped();
		# Obtain a more tailored message, if possible, otherwise, fall back to
		# the default for edits
		return wfEmptyMsg( $name, $text ) ? wfMessage( 'captcha-edit' )->escaped() : $text;
	}

	/**
	 * Check if the submitted form matches the captcha session data provided
	 * by the plugin when the form was generated.
	 *
	 * Override this!
	 *
	 * @param string $answer
	 * @param array $info
	 *
	 * @return bool
	 */
	public function keyMatch( $answer, $info ) {
		return $answer == $info['answer'];
	}

	/**
	 * @param \ApiBase $module
	 * @param array $params
	 *
	 * @return bool
	 */
	public function APIGetAllowedParams( &$module, &$params ) {
		if ( $module instanceof \ApiEditPage ) {
			$params['captchaword'] = null;
			$params['captchaid'] = null;
		}
		return true;
	}

	/**
	 * @param \ApiBase $module
	 * @param array $desc
	 * @return bool
	 */
	public function APIGetParamDescription( &$module, &$desc ) {
		if ( $module instanceof \ApiEditPage ) {
			$desc['captchaid'] = 'CAPTCHA ID from previous request';
			$desc['captchaword'] = 'Answer to the CAPTCHA';
		}

		return true;
	}

	/**
	 * Given a required captcha run, test form input for correct
	 * input on the open session.
	 *
	 * @return bool if passed, false if failed or new session
	 */
	public function passCaptcha() {
		$info = $this->retrieveCaptcha();
		if ( $info ) {
			if ( $this->keyMatch( $this->wg->Request->getVal( 'wpCaptchaWord' ), $info ) ) {
				$this->log( "verification passed" );
				$this->clearCaptcha( $info );
				return true;
			} else {
				$this->clearCaptcha( $info );
				$this->log( "verification failed" );
				return false;
			}
		} else {
			$this->log( "verification failed - stored captcha not found" );
			return false;
		}
	}

	/**
	 * Log the status and any triggering info for debugging or statistics
	 *
	 * @param string $message
	 */
	public function log( $message ) {
		$log = WikiaLogger::instance();
		$log->info( 'Captcha: ' . $message, [
			'type' => __CLASS__,
		] );
	}

	/**
	 * Generate a captcha session ID and save the info in PHP's session storage.
	 * (Requires the user to have cookies enabled to get through the captcha.)
	 *
	 * A random ID is used so legit users can make edits in multiple tabs or
	 * windows without being unnecessarily hobbled by a serial order requirement.
	 * Pass the returned id value into the edit form as wpCaptchaId.
	 *
	 * @param array $info data to store
	 *
	 * @return string captcha ID key
	 */
	public function storeCaptcha( $info ) {
		if ( !isset( $info['index'] ) ) {
			// Assign random index if we're not udpating
			$info['index'] = strval( mt_rand() );
		}
		Factory\Store::getInstance()->store( $info['index'], $info );
		return $info['index'];
	}

	/**
	 * Fetch this session's captcha info.
	 *
	 * @return mixed array of info, or false if missing
	 */
	public function retrieveCaptcha() {
		$index = $this->wg->Request->getVal( 'wpCaptchaId' );
		return Factory\Store::getInstance()->retrieve( $index );
	}

	/**
	 * Clear out existing captcha info from the session, to ensure
	 * it can't be reused.
	 *
	 * @param array $info
	 */
	public function clearCaptcha( Array $info ) {
		Factory\Store::getInstance()->clear( $info['index'] );
	}

	/**
	 * Show a page explaining what this wacky thing is.
	 */
	public function showHelp() {
		$this->wg->Out->setPageTitle( wfMessage( 'captchahelp-title' )->escaped() );
		$this->wg->Out->addWikiText( wfMessage( 'captchahelp-text' )->text() );
		if ( Factory\Store::getInstance()->cookiesNeeded() ) {
			$this->wg->Out->addWikiText( wfMessage( 'captchahelp-cookies-needed' )->text() );
		}
	}
}
