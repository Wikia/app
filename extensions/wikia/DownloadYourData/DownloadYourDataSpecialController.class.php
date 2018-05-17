<?php

namespace DownloadYourData;

class DownloadYourDataSpecialController extends \WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'DownloadYourData' );
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		$user = $this->getUser();
		if ( !$user->isLoggedIn() ) {
			$this->getOutput()->redirect( \SpecialPage::getTitleFor( 'Contact/data-portability' )->getFullURL() );
			return false;
		}

		if ( $this->request->wasPosted() && $user->matchEditToken( $this->getVal( 'token' ) ) ) {

			$model = new DownloadUserData( $user );
			$username = $this->request->getVal( 'username' );

			if ( $user->isAllowed( 'exportuserdata' ) && !empty( $username ) ) {
				$exportedUser = \User::newFromName( $username );
				if ( !$exportedUser || !$exportedUser->getId() ) {
					$this->error = $this->msg( 'downloadyourdata-user-not-found', $username )->parse();
				}
			} else {
				$exportedUser = $user;
			}

			if ( empty( $this->error ) ) {
				$output = \RequestContext::getMain()->getOutput();

				$output->getRequest()->response()->header('Content-disposition: attachment;filename=wikia_account_data.csv');
				$output->getRequest()->response()->header('Content-type: text/csv');

				$output->setArticleBodyOnly( true );

				$output->addHTML( $model->formatAsCsv( $model->getDataForUser( $exportedUser ) ) );

				wfProfileOut( __METHOD__ );

				return false;
			}

		}

		$this->specialPage->setHeaders();

		$this->response->setTemplateEngine( \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->introText = $this->msg( 'downloadyourdata-intro' )->text();
		$this->showUsernameField = $user->isAllowed( 'exportuserdata' );
		$this->usernamePlaceholder = $this->msg( 'downloadyourdata-username-placeholder' )->text();
		$this->editToken = $user->getEditToken();

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

		wfProfileOut( __METHOD__ );
	}

}
