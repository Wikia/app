<?php
class ApiWikiLove extends ApiBase {
	public function execute() {
		global $wgRequest, $wgWikiLoveLogging, $wgParser;

		$params = $this->extractRequestParams();

		$title = Title::newFromText( $params['title'] );
		if ( is_null( $title ) ) {
			$this->dieUsageMsg( array( 'invaliduser', $params['title'] ) );
		}

		$talk = WikiLoveHooks::getUserTalkPage( $title );
		if ( is_null( $talk ) ) {
			$this->dieUsageMsg( array( 'invaliduser', $params['title'] ) );
		}

		if ( $wgWikiLoveLogging ) {
			$this->saveInDb( $talk, $params['subject'], $params['message'], $params['type'], isset( $params['email'] ) ? 1 : 0 );
		}

		// not using section => 'new' here, as we like to give our own edit summary
		$api = new ApiMain(
			new DerivativeRequest(
				$wgRequest,
				array(
					'action'     => 'edit',
					'title'      => $talk->getFullText(),
					// need to do this, as Article::replaceSection fails for non-existing pages
					'appendtext' => ( $talk->exists() ? "\n\n" : '' ) . 
						wfMsgForContent( 'newsectionheaderdefaultlevel', $params['subject'] )
						. "\n\n" . $params['text'],
					'token'      => $params['token'],
					'summary'    => wfMsgForContent( 'wikilove-summary', 
						$wgParser->stripSectionName( $params['subject'] ) ),
					'notminor'   => true
				),
				false // was posted?
			),
			true // enable write?
		);

		$api->execute();

		if ( isset( $params['email'] ) ) {
			$this->emailUser( $talk, $params['subject'], $params['email'], $params['token'] );
		}

		$this->getResult()->addValue( 'redirect', 'pageName', $talk->getPrefixedDBkey() );
		$this->getResult()->addValue( 'redirect', 'fragment', Title::escapeFragmentForURL( $params['subject'] ) );
		// note that we cannot use Title::makeTitle here as it doesn't sanitize the fragment
	}

	/**
	 * @param $talk Title
	 * @param $subject
	 * @param $message
	 * @param $type
	 * @param $email
	 * @return void
	 */
	private function saveInDb( $talk, $subject, $message, $type, $email ) {
		global $wgUser;
		$dbw = wfGetDB( DB_MASTER );
		$receiver = User::newFromName( $talk->getSubjectPage()->getBaseText() );
		if ( $receiver === false || $receiver->isAnon() ) {
			$this->setWarning( 'Not logging unregistered recipients' );
			return;
		}

		$values = array(
			'wll_timestamp' => $dbw->timestamp(),
			'wll_sender' => $wgUser->getId(),
			'wll_sender_editcount' => $wgUser->getEditCount(),
			'wll_sender_registration' => $wgUser->getRegistration(),
			'wll_receiver' => $receiver->getId(),
			'wll_receiver_editcount' => $receiver->getEditCount(),
			'wll_receiver_registration' => $receiver->getRegistration(),
			'wll_type' => $type,
			'wll_subject' => $subject,
			'wll_message' => $message,
			'wll_email' => $email,
		);

		try{
			$dbw->insert( 'wikilove_log', $values, __METHOD__ );
		} catch( DBQueryError $dbqe ) {
			$this->setWarning( 'Action was not logged' );
		}
	}

	/**
	 * @param $talk Title
	 * @param $subject string
	 * @param $text string
	 * @param $token string
	 */
	private function emailUser( $talk, $subject, $text, $token ) {
		global $wgRequest;

		$api = new ApiMain( new FauxRequest( array(
			'action' => 'emailuser',
			'target' => User::newFromName( $talk->getSubjectPage()->getBaseText() )->getName(),
			'subject' => $subject,
			'text' => $text,
			'token' => $token,
		), false, array( 'wsEditToken' => $wgRequest->getSessionData( 'wsEditToken' ) ) ), true );

		try {
			$api->execute();
		} catch( DBQueryError $dbqe ) {
			$this->setWarning( 'E-mail was not sent' );
		}
	}

	public function getAllowedParams() {
		return array(
			'title' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'text' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'message' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'token' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'subject' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'type' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'email' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
		);
	}

	public function getParamDescription() {
		return array(
			'title' => 'Full pagename of the user page or user talk page of the user to send WikiLove to',
			'text' => 'Raw wikitext to add in the new section',
			'message' => 'Actual message the user has entered, for logging purposes',
			'token' => array( 'Edit token. You can get one of these through the API with prop=info,',
				'or when on a MediaWiki page through mw.user.tokens',
			),
			'subject' => 'Subject header of the new section',
			'email' => array( 'Content of the optional e-mail message to send to the user.',
				'A warning will be returned if the user cannot be e-mailed. WikiLove will be sent to user talk page either way.',
			),
			'type' => array( 'Type of WikiLove (for statistics); this corresponds with a type',
				'selected in the left menu, and optionally a subtype after that',
				'(e.g. "barnstar-normal" or "kitten")',
			),
		);
	}

	public function getDescription() {
		return array(
			'Give WikiLove to another user.',
			"WikiLove is a positive message posted to a user's talk page through a",
			'convenient interface with preset or locally defined templates. This action',
			'adds the specified wikitext to a certain talk page. For statistical purposes,',
			'the type and other data are logged.',
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'invalidtitle', 'title' ),
			array(
				'code' => 'nologging',
				'info' => 'Warning: action was not logged!'
			),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=wikilove&title=User:Dummy&text=Love&subject=Hi&token=%2B\\',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiWikiLove.php 113049 2012-03-05 17:46:47Z reedy $';
	}
}
