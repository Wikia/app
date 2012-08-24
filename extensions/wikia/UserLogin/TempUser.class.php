<?php

/**
 * TempUser
 * @author Hyun
 * @author Saipetch
 *
 */
class TempUser extends WikiaModel {

	protected $user_id = 0;
	protected $user_name = '';
	protected $user_password = '';
	protected $user_email = '';
	protected $user_registration = '';
	protected $user_birthdate = '';
	protected $user_source = '';
	protected $user_wiki_id = 0;

	const DefaultPassword = '';
	const DefaultEmail = '';

	public function __construct( $data = array() ) {
		foreach ( $data as $key => $value ) {
			$this->$key = $value;
		}
		parent::__construct();
	}

	/**
	 * get temp user's id
	 * @return string $user_id
	 */
	public function getId() {
		return $this->user_id;
	}

	/**
	 * get temp user's name
	 * @return string user_name
	 */
	public function getName() {
		return $this->user_name;
	}

	/**
	 * get temp user's email
	 * @return string user_email
	 */
	public function getEmail() {
		return $this->user_email;
	}

	/**
	 * get temp user's password
	 * @return string user_password
	 */
	public function getPassword() {
		return $this->user_password;
	}

	/**
	 * get temp user's source page
	 * @return string user_source
	 */
	public function getSource() {
		return $this->user_source;
	}

	/**
	 * get temp user's wiki id
	 * @return integer user_wiki_id
	 */
	public function getWikiId() {
		return $this->user_wiki_id;
	}

	/**
	 * set temp user's id
	 */
	public function setId( $id ) {
		$this->user_id = $id;
	}

	/**
	 * set temp user's email
	 */
	public function setEmail( $email ) {
		$this->user_email = $email;
	}

	/**
	 * set temp user's password
	 */
	public function setPassword( $password ) {
		$this->user_password = $password;
	}

	/**
	 * get default name for temp user
	 */
	public static function getDefaultName( $userId ) {
		return 'TempUser'.$userId;
	}

	/**
	 * create TempUser object from User object
	 * @param User object $user
	 * @return TempUser object $tempUser
	 */
	public static function createNewFromUser( $user, $source='' ) {
		global $wgCityId;

		$class = __CLASS__;
		$wikiId = ( empty($wgCityId) ) ? 0 : $wgCityId;
		$params = array(
			'user_id' => $user->mId,
			'user_name' => $user->mName,
			'user_email' => $user->mEmail,
			'user_password' => $user->mPassword,
			'user_registration' => $user->mRegistration,
			'user_birthdate' => $user->mBirthDate,
			'user_source' => $source,
			'user_wiki_id' => $wikiId,
		);
		$tempUser = new $class( $params );
		return $tempUser;
	}

	/**
	 * get memcache key for temp user
	 * @param string $username
	 * @return string key
	 */
	protected static function getMemKeyTempUser( $username ) {
		return F::app()->wf->SharedMemcKey( 'userlogin', 'temp_user', md5($username) );
	}

	/**
	 * get temp user from name
	 * @param string $username
	 * @return tempUser object or false $tempUser
	 */
	public static function getTempUserFromName( $username ) {
		$app = F::app();
		$tempUser = false;

		$app->wf->ProfileIn( __METHOD__ );

		$username = User::getCanonicalName( $username, 'valid' );
		if ( $username != false ) {
			$memKey = self::getMemKeyTempUser( $username );
			$tempUser = $app->wg->Memc->get( $memKey );
			if ( empty($tempUser) ) {
				$db = $app->wf->GetDB( DB_MASTER, array(), $app->wg->ExternalSharedDB );
				$row = $db->selectRow(
					array( 'user_temp' ),
					array( '*' ),
					array( 'user_name' => $username ),
					__METHOD__
				);

				if ( $row ) {
					$rowArr = get_object_vars( $row );
					$tempUser = F::build( __CLASS__, array($rowArr) );

					$app->wg->Memc->set( $memKey, $tempUser, 60*60*24 );
				}
			}
		}

		$app->wf->ProfileOut( __METHOD__ );

		return $tempUser;
	}

	/**
	 * map temp user to user
	 * @param boolean $resetUserId
	 * @param object $user
	 * @return object $user
	 */
	public function mapTempUserToUser( $resetUserId=true, $user=null ) {
		if ( !$user ) {
			$user = F::build( 'User' , array(self::getDefaultName($this->getId())), 'newFromName' ); /** @var User $user */
			if ( $user->getId() == 0 ) {
				$user = F::build( 'User' , array($this->getId()), 'newFromId' );
				$user->loadFromDatabase();
			}
		}

		if ( $resetUserId ) {
			$user->mId = 0;
		}

		$user->mName = $this->user_name;
		$user->mPassword = $this->user_password;
		$user->mEmail = $this->user_email;
		$user->mRegistration = wfTimestampOrNull( TS_MW, $this->user_registration );
		$user->mBirthDate = $this->user_birthdate;

		return $user;
	}

	/**
	 * save settings for temp user - update username, passwordm email for temp user before saving
	 * @param User object $user
	 */
	public function saveSettingsTempUserToUser( User &$user ) {
		if ( $user->mId == 0 ) {
			$user->mId = $this->getId();
		}
		$user->mName = self::getDefaultName( $user->mId );
		$user->mPassword = self::DefaultPassword;
		$user->mEmail = self::DefaultEmail;
		$user->saveSettings();
	}

	/**
	 * add temp user to database
	 */
	public function addToDatabase() {
		$this->wf->ProfileIn( __METHOD__ );

		if ( !$this->wf->ReadOnly() ) {
			$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalSharedDB );
			$db->insert(
				'user_temp',
				array(
					'user_id' => $this->user_id,
					'user_name' => $this->user_name,
					'user_password' => $this->user_password,
					'user_email' => $this->user_email,
					'user_registration' => $this->user_registration,
					'user_birthdate' => $this->user_birthdate,
					'user_source' => $this->user_source,
					'user_wiki_id' => $this->user_wiki_id,
				),
				__METHOD__
			);
			$db->commit(__METHOD__);
		}
		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * remove temp user from database by user id
	 */
	public function removeFromDatabase() {
		$this->wf->ProfileIn( __METHOD__ );

		if ( !$this->wf->ReadOnly() && !empty($this->user_id) ) {
			$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalSharedDB );
			$db->delete(
				'user_temp',
				array( 'user_id' => $this->user_id),
				__METHOD__
			);
			$db->commit(__METHOD__);

			// clear temp user cache
			$memKey = self::getMemKeyTempUser( $this->getName() );
			$this->wg->Memc->delete( $memKey );
		}

		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * update temp user by user id
	 */
	public function updateData() {
		$this->wf->ProfileIn( __METHOD__ );

		if ( !$this->wf->ReadOnly() && !empty($this->user_id) && !empty($this->user_email) ) {
			$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalSharedDB );
			$db->update(
				'user_temp',
				array(
					'user_email' => $this->user_email,
					'user_password' => $this->user_password,
				),
				array( 'user_id' => $this->user_id ),
				__METHOD__
			);
			$db->commit(__METHOD__);
		}

		// clear temp user cache
		$memKey = self::getMemKeyTempUser( $this->getName() );
		$this->wg->Memc->delete( $memKey );

		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * activate user
	 * @param User object $user
	 * @return User object $user
	 */
	public function activateUser( User $user ) {
		$this->wf->ProfileIn( __METHOD__ );

		// confirm email
		$user = $this->mapTempUserToUser( false, $user );
		$user->confirmEmail();
		$user->saveSettings();

		// send welcome email
		$emailParams = array(
			'$USERNAME' => $user->getName(),
			'$EDITPROFILEURL' => $user->getUserPage()->getFullURL(),
			'$LEARNBASICURL' => 'http://community.wikia.com/wiki/Help:Wikia_Basics',
			'$EXPLOREWIKISURL' => 'http://www.wikia.com',
		);

		$userLoginHelper = F::build( 'UserLoginHelper' ); /** @var UserLoginHelper $userLoginHelper */
		$userLoginHelper->sendEmail( $user, 'WelcomeMail', 'usersignup-welcome-email-subject', 'usersignup-welcome-email-body', $emailParams, 'welcome-email', 'WelcomeMail' );

		// remove temp user
		$this->removeFromDatabase();

		// Update user count
		$ssUpdate = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
		$ssUpdate->doUpdate();

		$this->wf->RunHooks( 'AddNewAccount', array( $user, false ) );
		$userLoginHelper->addNewUserLogEntry( $user );

		$this->wf->RunHooks( 'ConfirmEmailComplete', array( &$user ) );

		$this->wf->ProfileOut( __METHOD__ );

		return $user;
	}

	public static function clearTempUserSession() {
		unset($_SESSION['tempUserId']);
	}

	public function setTempUserSession() {
		$_SESSION['tempUserId'] = $this->getId();
	}

}
