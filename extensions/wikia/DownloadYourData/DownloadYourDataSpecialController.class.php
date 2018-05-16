<?php

class DownloadYourDataSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'DownloadYourData' );
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		$this->specialPage->setHeaders();

		$user = $this->getUser();

		if ( $user->isLoggedIn() && $this->request->wasPosted() && $user->matchEditToken( $this->getVal( 'token' ) ) ) {
			$output = RequestContext::getMain()->getOutput();

			$output->getRequest()->response()->header('Content-disposition: attachment;filename=wikia_account_data.csv');
			$output->getRequest()->response()->header('Content-type: text/csv');

			$output->setArticleBodyOnly( true );

			$output->addHTML( 'works like a charm!' );

			wfProfileOut( __METHOD__ );

			return false;
		}

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->isLoggedIn = $user->isLoggedIn();

		$this->notLoggedInMessage = $this->msg( 'downloadyourdata-not-logged-in' )->escaped();
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
