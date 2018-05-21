<?php

namespace DownloadYourData;

class DownloadUserData {

	private $exportingUser;

	/**
	 * @param \User $exportingUser User performing the export operation.
	 */
	public function __construct( \User $exportingUser ) {
		$this->exportingUser = $exportingUser;
	}

	/**
	 * Returns a 2-dimensional array of user data. Note that exportuserdata permission is needed in order to fetch
	 * someone's data. Otherwise $user should be the same user as $exportingUser passed to the constructor. In case
	 * of permission error exception is thrown.
	 *
	 * Attribute names and values are returned in language set for $user.
	 *
	 * @param \User $user user whos data is fetched
	 * @return array 2-dimesional array with user data. each row contains 2 values - attribute name and value.
	 * @throws \Exception in case of permission errors
	 */
	public function getDataForUser( \User $user ) {
		if ( $this->exportingUser->getId() !== $user->getId() &&
			!$this->exportingUser->isAllowed( 'exportuserdata' )
		) {
			throw new \Exception( 'Current user is not allowed to export data for other users.' );
		}

		$language = $user->getGlobalPreference( 'language' );
		$userLang = \Language::factory( $language );

		$userdata = [ [ wfMessage( 'downloadyourdata-username' )->inLanguage( $language )->text(), $user->getName() ],
			[ wfMessage( 'downloadyourdata-userid' )->inLanguage( $language )->text(), $user->getId() ] ];


		if ( !empty( $user->getEmail() ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-email' )->inLanguage( $language )->text(), $user->getEmail() ];
		}

		if ( !empty( $user->getRealName() ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-realname' )->inLanguage( $language )->text(),
				$user->getRealName() ];
		}

		if ( isset( $user->mBirthDate ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-birthdate' )->inLanguage( $language )->text(),
				$userLang->userDate( strtotime( $user->mBirthDate ), $user ) ];
		}

		if ( !empty( $user->getRegistration() ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-registration' )->inLanguage( $language )->text(),
				$userLang->userTimeAndDate( $user->getRegistration(), $user ) ];
		}

		$identityBox = new \UserIdentityBox( $user );
		$profileData = $identityBox->getFullData();

		if ( !empty( $profileData['birthday'] ) &&
			intval( $profileData['birthday']['month'] ) > 0 &&
			intval( $profileData['birthday']['month'] ) < 13
		) {
			$formattedBirthday = wfMessage( 'downloadyourdata-birthday-value' )->inLanguage( $language )
				->params( $userLang->getMonthName( intval( $profileData['birthday']['month'] ) ) )
				->numParams( htmlspecialchars( $profileData['birthday']['day'] ) )
				->parse();
			$userdata[] = [ wfMessage( 'downloadyourdata-birthday' )->inLanguage( $language )->text(),
				$formattedBirthday ];
		}

		$gender = $user->getGlobalAttribute( 'gender' );
		if ( !empty( $gender ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-gender' )->inLanguage( $language )->text(),
				wfMessage( 'gender-' . $gender )->inLanguage( $language )->text() ];
		}

		if ( !empty( $profileData['gender'] ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-profile-gender' )->inLanguage( $language )->text(),
				$profileData['gender'] ];
		}

		if ( !empty( $profileData['location'] ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-location' )->inLanguage( $language )->text(),
				$profileData['location'] ];
		}
		if ( !empty( $profileData['occupation'] ) ) {
			$userdata[] = [ wfMessage( 'downloadyourdata-occupation' )->inLanguage( $language )->text(),
				$profileData['occupation'] ];
		}

		$userdata[] = [ wfMessage( 'downloadyourdata-user-activity-link' )->inLanguage( $language )->text(),
			\GlobalTitle::newFromText('UserActivity', NS_SPECIAL, \Wikia::COMMUNITY_WIKI_ID)->getFullURL() ];

		return $userdata;

	}

	/**
	 * Takes a 2-dimensional array and formats it into a CSV file
	 * @param $data array of csv rows
	 * @return string csv content
	 */
	public function formatAsCsv( $data ) {
		$fp = fopen("php://temp", 'w+');
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
