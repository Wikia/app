<?php

/**
 * Register when & where user is logged in and what was changed in
 * user preferences. Could be used for restoring wrongly saved preferences (undo).
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */

/**
 * static methods, wait for PHP with namespaces
 */
class UserChangesHistory {

	const LOGIN_AUTO = 0;
	const LOGIN_FORM = 1;
	const LOGIN_REGISTRATION = 2;

	/**
	 * LoginHistoryHook
	 *
	 * store information about when & where user logged in, for stats
	 * purposes, called by Hook UserLoginComplete and UserLoadFromSessionInfo
	 * Data is stored in external storage archive1
	 *
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
	 * @access public
	 * @static
	 *
	 * @param Integer $from -- which hook call this
	 * @param User    $user -- User class instance
	 * @param String  $type -- UserLoadFromSessionInfo set this to 'cookie' or 'session'
	 *
	 * @return bool true		process other hooks
	 */
	static public function LoginHistoryHook( $from, $user, $type = false ) {
		global $wgCityId; #--- private wikia identifier, you can use wgDBname
		global $wgEnableScribeReport, $wgSpecialsDB;

		if( wfReadOnly() ) { return true; }

		wfProfileIn( __METHOD__ );

		/**
		 * if user id is empty it means that user object is not loaded
		 * store information only for registered users
		 */
		if(!empty($user) && is_object($user)){
			$id = $user->getId();
			if ( $id ) {

				if( $from == self::LOGIN_AUTO && $type == "session" ) {
					# ignore
				}
				else {
					$params = array(
						"user_id"   		=> $id,
						"city_id"   		=> $wgCityId,
						"ulh_from"  		=> $from,
						"ulh_rememberme" 	=> $user->getGlobalPreference('rememberpassword')
					);
					if ( !empty($wgEnableScribeReport) ) {
						# use scribe
						try {
							$message = array(
								'method' => 'login',
								'params' => $params
							);
							$data = json_encode( $message );
							WScribeClient::singleton('trigger')->send($data);
						}
						catch( TException $e ) {
							Wikia\Logger\WikiaLogger::instance()->error( __METHOD__ . ' - scribeClient exception', [
								'exception' => $e
							] );
						}
					} else {
						// user_login_history_summary is used in joins with specials.events_local_users table
						// @see PLATFORM-1309
						$dbw_specials = wfGetDB( DB_MASTER, array(), $wgSpecialsDB ) ;

						$dbw_specials->insert(
							"user_login_history",
							$params,
							__METHOD__,
							array('IGNORE')
						);

						$dbw_specials->replace(
							"user_login_history_summary",
							array( 'user_id' ),
							array( 'ulh_timestamp' => wfTimestampOrNull(), 'user_id' => $id ),
							__METHOD__
						);

						$dbw_specials->commit(__METHOD__);
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}


	/**
	 * SavePreferencesHook
	 *
	 * Store row from user table before changes of preferences are saved.
	 * Called by Hook SavePreferences
	 * Data is stored in external storage archive1
	 *
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
	 * @access public
	 * @static
	 *
	 * @return bool true		process other hooks
	 */
	static public function SavePreferencesHook($formData, $error) {
		global $wgSpecialsDB, $wgEnableScribeReport, $wgUser;

		if( wfReadOnly() ) { return true; }

		wfProfileIn( __METHOD__ );

		$id = $wgUser->getId();
		if( $id ) {
			/**
			 * caanot use "insert from select" because we got two different db
			 * clusters. But we should have all user data already loaded.
			 */
			$options = $wgUser->getOptions();
			$a = array();
			if ( !empty($options) ) {
				foreach ( $options as $oname => $oval ) {
					array_push( $a, $oname.'='.$oval );
				}
			}
			$user_options = implode( "\n", $a );

			$params = array(
				"user_id"          => $id,
				"user_name"        => $wgUser->mName,
				"user_real_name"   => $wgUser->mRealName,
				"user_password"    => $wgUser->mPassword,
				"user_newpassword" => $wgUser->mNewpassword,
				"user_email"       => $wgUser->mEmail,
				"user_options"     => $user_options,
				"user_touched"     => $wgUser->mTouched,
				"user_token"       => $wgUser->mToken
			);

			if ( !empty($wgEnableScribeReport) ) {
				# use scribe
				try {
					$message = array(
						'method' => 'savepreferences',
						'params' => $params
					);
					$data = json_encode( $message );
					WScribeClient::singleton('trigger')->send($data);
				}
				catch( TException $e ) {
					Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
				}
			} else {
				$dbw = wfGetDB( DB_MASTER, array(), $wgSpecialsDB ) ;

				/**
				 * so far encodeOptions is public by default but could be
				 * private in future
				 */
				$dbw->insert(
					"user_history",
					$params,
					__METHOD__
				);

				$dbw->commit(__METHOD__);
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}
}
