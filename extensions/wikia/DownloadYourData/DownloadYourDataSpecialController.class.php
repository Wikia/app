<?php

class DownloadYourDataSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'DownloadYourData' );
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		$this->specialPage->setHeaders();

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->isLoggedIn = $this->getUser()->isLoggedIn();

		$this->introText = $this->msg( 'downloadyourdata-intro' )->escaped();
		$this->notLoggedInMessage = $this->msg( 'downloadyourdata-not-logged-in' )->escaped();


		wfProfileOut( __METHOD__ );
	}

}
