<?php

class ApiMoodBar extends ApiBase {
	public function execute() {
		global $wgUser;

		if ( $wgUser->isBlocked( false ) ) {
			$this->dieUsageMsg( array( 'blockedtext' ) );
		}

		$params = $this->extractRequestParams();

		$params['page'] = Title::newFromText( $params['page'] );

		// Params are deliberately named the same as the properties,
		//  just slurp them through.
		$item = MBFeedbackItem::create( array() );

		$setParams = array();
		foreach( $params as $key => $value ) {
			if ( $item->isValidKey( $key ) ) {
				$setParams[$key] = $value;
			}
		}

		$item->setProperties( $setParams );

		$item->save();

		$result = array( 'result' => 'success' );
		$this->getResult()->addValue( null, $this->getModuleName(), $result );

		//add feedback log in recent changes
		$this->logFeedback($params, $item->getProperty( 'id' ));
	}

	public function logFeedback( $params, $itemId ) {
		$title = SpecialPage::getTitleFor( 'FeedbackDashboard', $itemId );
		$reason = wfMessage( 'moodbar-log-reason' )->params( $params['type'], $params['comment'] )->text();
		$log = new LogPage( 'moodbar' );
		$log->addEntry( 'feedback', $title, $reason );
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getAllowedParams() {
		return array(
			'page' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
			'type' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => MBFeedbackItem::getValidTypes(),
			),
			'comment' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
			'anonymize' => array(
				ApiBase::PARAM_TYPE => 'boolean',
			),
			'editmode' => array(
				ApiBase::PARAM_TYPE => 'boolean',
			),
			'useragent' => null,
			'system' => null,
			'locale' => null,
			'bucket' => null,
			'token' => null,
		);
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiMoodBar.php 108576 2012-01-11 00:30:07Z rmoen $';
	}

	public function getParamDescription() {
		return array(
			'page' => 'The page the feedback is on',
			'type' => 'The type of feedback being provided',
			'comment' => 'The feedback text',
			'anonymize' => 'Whether to hide user information',
			'editmode' => 'Whether or not the feedback context is in edit mode',
			'bucket' => 'The testing bucket, if any',
			'useragent' => 'The User-Agent header of the browser',
			'system' => 'The operating system being used',
			'locale' => 'The locale in use',
			'token' => 'An edit token',
		);
	}

	public function getDescription() {
		return 'Allows users to submit feedback about their experiences on the site';
	}
}
