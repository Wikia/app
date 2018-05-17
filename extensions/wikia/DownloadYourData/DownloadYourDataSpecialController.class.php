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
				if ( !$exportedUser || !$exportedUser->getId() ) {
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

				$output->addHTML( $this->formatAsCsv( $this->prepareUserData( $exportedUser ) ) );

				wfProfileOut( __METHOD__ );

				return false;
			}

		}

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->introText = $this->msg( 'downloadyourdata-intro' )->text();
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

		wfProfileOut( __METHOD__ );
	}

	private function prepareUserData( User $user ) {
		$language = $user->getGlobalPreference( 'language' );

		$userdata = [ [ $this->msg( 'downloadyourdata-username' )->inLanguage( $language )->text(), $user->getName() ] ];

		if ( !empty( $user->getEmail() ) ) {
			$userdata[] = [ $this->msg( 'downloadyourdata-email' )->inLanguage( $language )->text(), $user->getEmail() ];
		}

		if ( !empty( $user->getRealName() ) ) {
			$userdata[] = [ $this->msg( 'downloadyourdata-realname' )->inLanguage( $language )->text(), $user->getRealName() ];
		}

		if ( isset( $user->mBirthDate ) ) {
			$userdata[] = [ $this->msg( 'downloadyourdata-birthdate' )->inLanguage( $language )->text(),
				Language::factory( $language )->userDate( date( 'Y-m-d H:i:s', strtotime( $user->mBirthDate ) ), $user ) ];
		}

		$gender = $user->getGlobalAttribute( 'gender' );
		if ( !empty( $gender ) ) {
			$userdata[] = [ $this->msg( 'downloadyourdata-gender' )->inLanguage( $language )->text(),
				$this->msg( 'gender-' . $gender )->inLanguage( $language )->text() ];
		}

		return $userdata;
	}

	private function formatAsCsv( $data ) {
		$fp = fopen("php://temp/maxmemory:65536", 'r+');
		foreach($data as $row ) {
			fputcsv( $fp, $row );
		}
		fflush( $fp );
		rewind( $fp );
		$result = stream_get_contents( $fp );
		fclose($fp);
		return $result;
	}

}
