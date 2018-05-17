<?php

class DownloadYourDataSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'DownloadYourData' );
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		$this->specialPage->setHeaders();

		$user = $this->getUser();
		$this->canPickUsername = $user->isAllowed( 'exportuserdata' );
		$this->isLoggedIn = $user->isLoggedIn();

		if ( $this->isLoggedIn && $this->request->wasPosted() && $user->matchEditToken( $this->getVal( 'token' ) ) ) {

			$username = $this->request->getVal( 'username' );
			if ( $this->canPickUsername && !empty( $username ) ) {
				$exportedUser = User::newFromName( $username );
				if ( !$exportedUser ) {
					$this->error = $this->msg( 'downloadyourdata-user-not-found', $username )->parse();
				}
			} else {
				$exportedUser = $user;
			}

			if ( empty( $this->error ) ) {
				$output = RequestContext::getMain()->getOutput();

				// todo - include user name or user id in file name?
				$output->getRequest()->response()->header('Content-disposition: attachment;filename=wikia_account_data.csv');
				$output->getRequest()->response()->header('Content-type: text/csv');

				$output->setArticleBodyOnly( true );

				// use $exportedUser object to fetch the csv data

				$output->addHTML( 'works like a charm!' );

				wfProfileOut( __METHOD__ );

				return false;
			}

		}

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );


		$this->notLoggedInMessage = $this->msg( 'downloadyourdata-not-logged-in' )->parse();
		$this->usernamePlaceholder = $this->msg( 'downloadyourdata-username-placeholder' )->text();
		$this->editToken = $user->getEditToken();
		$this->showForm = true;

		$buttonParams = [
			'type' => 'button',
			'vars' => [
				'type' => 'submit',
				'classes' => [ 'wikia-button' ],
				'value' => $this->msg( 'downloadyourdata-button-text' )->text(),
				'data' => [],
			]
		];

		$this->submitButton = \Wikia\UI\Factory::getInstance()->init( 'button' )->render( $buttonParams );

		$this->introText = $this->msg( 'downloadyourdata-intro' )->escaped();

		wfProfileOut( __METHOD__ );
	}

}
