<?php

/**
 * API module for serving debug console requests on the edit page
 */

class ApiScribuntoConsole extends ApiBase {
	const SC_MAX_SIZE = 500000;
	const SC_SESSION_EXPIRY = 3600;

	public function execute() {
		$params = $this->extractRequestParams();

		$title = Title::newFromText( $params['title'] );
		if ( !$title ) {
			$this->dieUsageMsg( array( 'invalidtitle', $params['title'] ) );
		}

		if ( $params['session'] ) {
			$sessionId = $params['session'];
		} else {
			$sessionId = mt_rand( 0, 0x7fffffff );
		}

		global $wgUser;
		$sessionKey = wfMemcKey( 'scribunto-console', $wgUser->getId(), $sessionId );
		$cache = ObjectCache::getInstance( CACHE_ANYTHING );
		$session = null;
		$sessionIsNew = false;
		if ( $params['session'] ) {
			$session = $cache->get( $sessionKey );
		}
		if ( !isset( $session['version'] ) ) {
			$session = $this->newSession();
			$sessionIsNew = true;
		}

		// Create a variable holding the session which will be stored if there 
		// are no errors. If there are errors, we don't want to store the current
		// question to the state builder array, since that will cause subsequent
		// requests to fail.
		$newSession = $session;

		if ( !empty( $params['clear'] ) ) {
			$newSession['size'] -= strlen( implode( '', $newSession['questions'] ) );
			$newSession['questions'] = array();
			$session['questions'] = array();
		}
		if ( strlen( $params['question'] ) ) {
			$newSession['size'] += strlen( $params['question'] );
			$newSession['questions'][] = $params['question'];
		}
		if ( $params['content'] ) {
			$newSession['size'] += strlen( $params['content'] ) - strlen( $newSession['content'] );
			$newSession['content'] = $params['content'];
		}

		if ( $newSession['size'] > self::SC_MAX_SIZE ) {
			$this->dieUsage(
				$this->msg( 'scribunto-console-too-large' )->text(),
				'scribunto-console-too-large'
			);
		}
		$result = $this->runConsole( array(
			'title' => $title,
			'content' => $newSession['content'],
			'prevQuestions' => $session['questions'],
			'question' => $params['question'] ) );

		if ( $result['type'] === 'error' ) {
			// Restore the questions array
			$newSession['questions'] = $session['questions'];
		}
		$cache->set( $sessionKey, $newSession, self::SC_SESSION_EXPIRY );
		$result['session'] = $sessionId;
		$result['sessionSize'] = $newSession['size'];
		$result['sessionMaxSize'] = self::SC_MAX_SIZE;
		if ( $sessionIsNew ) {
			$result['sessionIsNew'] = '';
		}
		foreach ( $result as $key => $value ) {
			$this->getResult()->addValue( null, $key, $value );
		}
	}

	protected function runConsole( $params ) {
		global $wgParser;
		$options = new ParserOptions;
		$wgParser->startExternalParse( $params['title'], $options, Parser::OT_HTML, true );
		$engine = Scribunto::getParserEngine( $wgParser );
		try {
			$result = $engine->runConsole( $params );
		} catch ( ScribuntoException $e ) {
			$trace = $e->getScriptTraceHtml();
			$message = $e->getMessage();
			$html = Html::element( 'p', array(), $message );
			if ( $trace !== false ) {
				$html .= Html::element( 'p',
					array(),
					$this->msg( 'scribunto-common-backtrace' )->inContentLanguage()->text()
				) . $trace;
			}
			
			return array(
				'type' => 'error',
				'html' => $html,
				'message' => $message,
				'messagename' => $e->getMessageName() );
		}
		return array(
			'type' => 'normal',
			'print' => strval( $result['print'] ),
			'return' => strval( $result['return'] )
		);
	}

	protected function newSession() {
		return array(
			'content' => '',
			'questions' => array(),
			'size' => 0,
			'version' => 1,
		);
	}

	public function getAllowedParams() {
		return array(
			'title' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'content' => array(
				ApiBase::PARAM_TYPE => 'string'
			),
			'session' => array(
				ApiBase::PARAM_TYPE => 'integer',
			),
			'question' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'clear' => array(
				ApiBase::PARAM_TYPE => 'boolean',
			),
		);
	}

	public function getParamDescription() {
		return array(
			'title' => 'The module title to test',
			'content' => 'The new content of the module',
			'question' => 'The next line to evaluate as a script',
			'clear' => 'Set this to true to clear the current session state',
		);
	}

	public function getDescription() {
		return 'Internal module for servicing XHR requests from the Scribunto console';
	}

	public function getVersion() {
		return __CLASS__.': 1';
	}
}
