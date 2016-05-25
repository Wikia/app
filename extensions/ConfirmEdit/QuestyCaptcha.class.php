<?php

/**
 * QuestyCaptcha class
 *
 * @file
 * @author Benjamin Lees <emufarmers@gmail.com>
 * @ingroup Extensions
 */

class QuestyCaptcha extends SimpleCaptcha {

	/** Validate a captcha response */
	function keyMatch( $answer, $info ) {
		if ( is_array( $info['answer'] ) ) {
			return in_array( strtolower( $answer ), $info['answer'] );
		} else {
			return strtolower( $answer ) == strtolower( $info['answer'] );
		}
	}

	function addCaptchaAPI( &$resultArr ) {
		$captcha = $this->getCaptcha();
		$index = $this->storeCaptcha( $captcha );
		$resultArr['captcha']['type'] = 'question';
		$resultArr['captcha']['mime'] = 'text/plain';
		$resultArr['captcha']['id'] = $index;
		$resultArr['captcha']['question'] = $captcha['question'];
	}

	function getCaptcha() {
		global $wgCaptchaQuestions;
		return $wgCaptchaQuestions[mt_rand( 0, count( $wgCaptchaQuestions ) - 1 )]; // pick a question, any question
	}

	function getForm() {
		$captcha = $this->getCaptcha();
		if ( !$captcha ) {
			die( "No questions found; set some in LocalSettings.php using the format from QuestyCaptcha.php." );
		}
		$index = $this->storeCaptcha( $captcha );
		return "<p><label for=\"wpCaptchaWord\">{$captcha['question']}</label> " .
			Html::element( 'input', array(
				'name' => 'wpCaptchaWord',
				'id'   => 'wpCaptchaWord',
				'required',
				'tabindex' => 1 ) ) . // tab in before the edit textarea
			"</p>\n" .
			Xml::element( 'input', array(
				'type'  => 'hidden',
				'name'  => 'wpCaptchaId',
				'id'    => 'wpCaptchaId',
				'value' => $index ) );
	}

	function getMessage( $action ) {
		$name = 'questycaptcha-' . $action;
		$text = wfMsg( $name );
		# Obtain a more tailored message, if possible, otherwise, fall back to
		# the default for edits
		return wfEmptyMsg( $name, $text ) ? wfMsg( 'questycaptcha-edit' ) : $text;
	}

	function showHelp() {
		global $wgOut;
		$wgOut->setPageTitle( wfMsg( 'captchahelp-title' ) );
		$wgOut->addWikiText( wfMsg( 'questycaptchahelp-text' ) );
		if ( CaptchaStore::get()->cookiesNeeded() ) {
			$wgOut->addWikiText( wfMsg( 'captchahelp-cookies-needed-confirm-edit' ) );
		}
	}
}
