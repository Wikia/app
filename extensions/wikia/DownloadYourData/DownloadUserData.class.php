<?php

class DownloadUserData {

	private $exportingUser;

	public function __construct( User $exportingUser ) {
		$this->exportingUser = $exportingUser;
	}

	public function getDataForUser( User $user ) {
		if ( $this->exportingUser->getId() !== $user->getId() && !$this->exportingUser->isAllowed( 'exportuserdata' ) ) {
			throw new Exception( 'Current user is not allowed to export data for other users.' );
		}

		$language = $user->getGlobalPreference( 'language' );
		$userLang = Language::factory( $language );

		$userdata = [ [ wfMessage( 'downloadyourdata-username' )->inLanguage( $language )->text(), $user->getName() ],
			[ wfMessage( 'downloadyourdata-userid' )->inLanguage( $language )->text(), $user->getId() ] ];


		if ( !empty( $user->getEmail() ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-email' )->inLanguage( $language )->text(), $user->getEmail() ];
		}

		if ( !empty( $user->getRealName() ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-realname' )->inLanguage( $language )->text(), $user->getRealName() ];
		}

		if ( isset( $user->mBirthDate ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-birthdate' )->inLanguage( $language )->text(),
				$userLang->userDate( strtotime( $user->mBirthDate ), $user ) ];
		}

		$identityBox = new UserIdentityBox( $user );
		$profileData = $identityBox->getFullData();
		//$userdata[] = ['ibox', json_encode($profileData)];

		if ( !empty( $profileData['registration'] ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-registration' )->inLanguage( $language )->text(), $profileData['registration'] ];
		}

		if ( !empty( $profileData['birthday'] ) && intval( $profileData['birthday']['month'] ) > 0 && intval( $profileData['birthday']['month'] ) < 13 ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-profile-birthday' )->inLanguage( $language )->text(),
				wfMessage( 'downloadyourdata-birthday-value' )->inLanguage( $language )->params( $userLang->getMonthName( intval( $profileData['birthday']['month'] ) ) )->numParams( htmlspecialchars( $profileData['birthday']['day'] ) )->parse() ];
		}

		$gender = $user->getGlobalAttribute( 'gender' );
		if ( !empty( $gender ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-gender' )->inLanguage( $language )->text(),
				wfMessage( 'gender-' . $gender )->inLanguage( $language )->text() ];
		}

		if ( !empty( $profileData['gender'] ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-profile-gender' )->inLanguage( $language )->text(), $profileData['gender'] ];
		}

		if ( !empty( $profileData['location'] ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-location' )->inLanguage( $language )->text(), $profileData['location'] ];
		}
		if ( !empty( $profileData['occupation'] ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-occupation' )->inLanguage( $language )->text(), $profileData['occupation'] ];
		}

		$userdata[] = [ wfMessage( 'downloadyourdata-user-activity-link' )->inLanguage( $language )->text(), GlobalTitle::newFromText('UserActivity', NS_SPECIAL, Wikia::COMMUNITY_WIKI_ID)->getFullURL() ];


		return $userdata;

	}

	public function formatAsCsv( $data ) {
		$fp = fopen("php://temp", 'r+');
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