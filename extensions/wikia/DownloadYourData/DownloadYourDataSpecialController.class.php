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
		$userLang = Language::factory( $language );

		$userdata = [ [ $this->msg( 'downloadyourdata-username' )->inLanguage( $language )->text(), $user->getName() ],
			[ $this->msg( 'downloadyourdata-userid' )->inLanguage( $language )->text(), $user->getId() ] ];


		if ( !empty( $user->getEmail() ) ) {
			$userdata[] = [ $this->msg( 'downloadyourdata-email' )->inLanguage( $language )->text(), $user->getEmail() ];
		}

		if ( !empty( $user->getRealName() ) ) {
			$userdata[] = [ $this->msg( 'downloadyourdata-realname' )->inLanguage( $language )->text(), $user->getRealName() ];
		}

		if ( isset( $user->mBirthDate ) ) {
			$userdata[] = [ $this->msg( 'downloadyourdata-birthdate' )->inLanguage( $language )->text(),
				$userLang->userDate( strtotime( $user->mBirthDate ), $user ) ];
		}

		$identityBox = new UserIdentityBox( $user );
		$profileData = $identityBox->getFullData();
		//$userdata[] = ['ibox', json_encode($profileData)];

		if ( !empty( $profileData['registration'] ) ) {
			$userdata[] = [ $this->msg( 'downloadyourdata-registration' )->inLanguage( $language )->text(), $profileData['registration'] ];
		}

		if ( !empty( $profileData['birthday'] ) && intval( $profileData['birthday']['month'] ) > 0 && intval( $profileData['birthday']['month'] ) < 13 ) {
			$userdata[] = [ $this->msg( 'downloadyourdata-profile-birthday' )->inLanguage( $language )->text(),
				$this->msg( 'downloadyourdata-birthday-value' )->inLanguage( $language )->params( $userLang->getMonthName( intval( $profileData['birthday']['month'] ) ) )->numParams( htmlspecialchars( $profileData['birthday']['day'] ) )->parse() ];
		}

		$gender = $user->getGlobalAttribute( 'gender' );
		if ( !empty( $gender ) ) {
			$userdata[] = [ $this->msg( 'downloadyourdata-gender' )->inLanguage( $language )->text(),
				$this->msg( 'gender-' . $gender )->inLanguage( $language )->text() ];
		}

		if ( !empty( $profileData['gender'] ) ) {
			$userdata[] = [ $this->msg( 'downloadyourdata-profile-gender' )->inLanguage( $language )->text(), $profileData['gender'] ];
		}

		if ( !empty( $profileData['location'] ) ) {
			$userdata[] = [ $this->msg( 'downloadyourdata-location' )->inLanguage( $language )->text(), $profileData['location'] ];
		}
		if ( !empty( $profileData['occupation'] ) ) {
			$userdata[] = [ $this->msg( 'downloadyourdata-occupation' )->inLanguage( $language )->text(), $profileData['occupation'] ];
		}

		$userdata[] = [ $this->msg( 'downloadyourdata-user-activity-link' )->inLanguage( $language )->text(), GlobalTitle::newFromText('UserActivity', NS_SPECIAL, Wikia::COMMUNITY_WIKI_ID)->getFullURL() ];


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
