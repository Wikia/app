<?php

class ApiFeedbackDashboardResponse extends ApiBase {

	private $EnotifUserTalk;
	private $EnotifWatchlist;

	public function execute() {
		global $wgRequest, $wgUser;

		if ( $wgUser->isAnon() ) {
			$this->dieUsage( "You don't have permission to do that", 'permission-denied' );
		}
		if ( $wgUser->isBlocked( false ) ) {
			$this->dieUsageMsg( array( 'blockedtext' ) );
		}

		$params = $this->extractRequestParams();

		//Response Object
		$item = MBFeedbackResponseItem::create( array() );

		$setParams = array();
		foreach( $params as $key => $value ) {
			if ( $item->isValidKey( $key ) ) {
				$setParams[$key] = $value;
			}
		}

		$item->setProperties( $setParams );
		$item->save();

		$commenter = $item->getProperty('feedbackitem')->getProperty('user');

		if ( $commenter !== null && $commenter->isAnon() == false ) {
			$talkPage = $commenter->getTalkPage();

			$response = Parser::cleanSigInSig($params['response']);

			$feedback_link = wfMessage('moodbar-feedback-response-title')->inContentLanguage()->
				params( SpecialPage::getTitleFor( 'FeedbackDashboard', $item->getProperty('feedback') )->
				getPrefixedText() )->escaped();

			$summary = wfMessage('moodbar-feedback-edit-summary')->inContentLanguage()->
				rawParams( $item->getProperty('feedback'),  $response)->escaped();

			$this->disableUserTalkEmailNotification();

			$id = intval( $item->getProperty( 'id' ) );
			$api = new ApiMain( new DerivativeRequest(
				$wgRequest, 
				array(
					'action' => 'edit',
					'title'  => $talkPage->getFullText(),
					'appendtext' => ( $talkPage->exists() ? "\n\n" : '' ) . 
							$feedback_link . "\n" . 
							'<span id="feedback-dashboard-response-' . $id . '"></span>' . "\n\n" . 
							$response . "\n\n~~~~\n\n" .
							'<span class="markashelpful-mbresponse-' . $id . '">&#160;</span>',
					'token'  => $params['token'],
					'summary' => $summary,
					'notminor' => true,
				), true),
			true );

			$api->execute();

			$this->restoreUserTalkEmailNotification();

			global $wgLang;

			$EMailNotif = new MoodBarHTMLEmailNotification();
			$EMailNotif->notifyOnRespond( $wgUser, $talkPage, wfTimestampNow(), 
							$item->getProperty('feedback'), 
							$wgLang->truncate( $response, 250 ), 
							$item->getProperty('feedbackitem')->getProperty( 'type' ),
							$id );

		}

		$result = array( 'result' => 'success' );
		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	/**
	 * temporarily disable the talk page email notification
	 * for user and watchers
	 */
	private function disableUserTalkEmailNotification() {
		global $wgEnotifUserTalk, $wgEnotifWatchlist;

		$this->EnotifUserTalk  = $wgEnotifUserTalk;
		$this->EnotifWatchlist = $wgEnotifWatchlist;

			$wgEnotifUserTalk = $wgEnotifWatchlist = false;
	}

	/**
	 * restore the default state of talk page email notification
	 */
	private function restoreUserTalkEmailNotification() {
		global $wgEnotifUserTalk, $wgEnotifWatchlist;

		if ( !is_null( $this->EnotifUserTalk ) ) {
			$wgEnotifUserTalk = $this->EnotifUserTalk;
		}
		if ( !is_null( $this->EnotifWatchlist ) ) {
			$wgEnotifWatchlist = $this->EnotifWatchlist;
		}
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getAllowedParams() {
		return array(
			'feedback' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => 'integer'
			),
			'response' => array(
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
		return __CLASS__ . ': $Id: ApiMoodBar.php 93113 2011-07-25 21:03:33Z reedy $';
	}

	public function getParamDescription() {
		return array(
			'feedback' => 'The moodbar feedback unique identifier',
			'response' => 'The feedback text',
			'anonymize' => 'Whether to hide user information',
			'editmode' => 'Whether or not the feedback context is in edit mode',
			'useragent' => 'The User-Agent header of the browser',
			'system' => 'The operating system being used',
			'locale' => 'The locale in use',
			'token' => 'An edit token',
		);
	}

	public function getDescription() {
		return 'Allows users to submit response to a feedback about their experiences on the site';
	}

}
