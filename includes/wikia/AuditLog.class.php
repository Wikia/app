<?php

class AuditLog {

	static public function init() {
		global $wgHooks;

		// recent changes
		$wgHooks['RecentChange_save'][] = 'AuditLog::onRecentChangeSave';
		// user login
		$wgHooks["UserLoginComplete"][] = 'AuditLog::onUserLoginComplete';
		$wgHooks["UserLoadFromHeliosToken"][] = 'AuditLog::onUserLoadFromHeliosToken';
		$wgHooks['LoginAuthenticateAudit'][] = 'AuditLog::onLoginAuthenticateAudit';
		// user password reset
		$wgHooks['User::mailPasswordInternal'][] = 'AuditLog::onUserMailPasswordInternal';
		// user password change
		$wgHooks['PrefsPasswordAudit'][] = 'AuditLog::onPrefsPasswordAudit';
		// user preferences change
		$wgHooks["BeforeUserSaveSettings"][] = 'AuditLog::onBeforeUserSaveSettings';

		return true;
	}

	static public function onRecentChangeSave( RecentChange $rc ) {
		global $wgUser;
		/** @var $rc_type */
		/** @var $rc_namespace */
		/** @var $rc_title */
		/** @var $rc_log_type */
		/** @var $rc_log_action */
		/** @var $rc_cur_id */
		/** @var $rc_this_oldid */
		/** @var $rc_comment */
		// Extract params
		extract( $rc->mAttribs );

		// Store the log action text for log events
		// $rc_comment should just be the log_comment
		// BC: check if log_type and log_action exists
		// If not, then $rc_comment is the actiontext and comment
		if ( isset( $rc_log_type ) && $rc_type == RC_LOG ) {
			$actionText = "{$rc_log_type}.{$rc_log_action}";
		} else {
			$actionText = '';
		}

		$target = null;
		$targetText = '';
		if ( !$target && !empty( $rc_namespace ) && !empty( $rc_title ) ) {
			$target = Title::newFromText( $rc_title, $rc_namespace );
		}
		if ( !$target && !empty( $rc_cur_id ) ) {
			$target = Title::newFromID( $rc_cur_id );
		}
		if ( $target ) {
			$targetText = $target->getPrefixedText();
		}

		$userText = ( !empty( $wgUser ) && $wgUser->getId() !== 0 ) ? sprintf( ' by "%s"', $wgUser->getName() ) : '';
		$actionText = $actionText ? " action = {$actionText}:" : '';
		$text = sprintf( 'Recentchange%s%s: %s', $userText, $actionText, $targetText );

		self::log( $text, [ 'recentchange' ], [
			'target_page' => $targetText,
			'target_page_id' => !empty( $rc_cur_id ) ? intval( $rc_cur_id ) : 0,
			'target_rev_id' => intval( $rc_this_oldid ),
		] );

		return true;
	}

	static public function onUserLoginComplete( User $user ) {
		self::log( sprintf( 'User login using password: "%s"', $user->getName() ),
			[ 'user_login', 'user_login_password' ], [
				'target_user' => $user->getName(),
				'target_user_id' => $user->getId(),
				'login_type' => 'password',
				'success' => true,
			] );

		return true;
	}

	static public function onUserLoadFromHeliosToken( User $user ) {
		self::log( sprintf( 'User login using access_token: "%s"', $user->getName() ),
			[ 'user_login', 'user_login_access_token' ], [
				'target_user' => $user->getName(),
				'target_user_id' => $user->getId(),
				'login_type' => 'access_token',
				'success' => true,
			] );

		return true;
	}

	static public function onLoginAuthenticateAudit( User $user, $password, $retval ) {
		$retvalMap = [
			LoginForm::WRONG_PASS => 'wrong_pass',
			LoginForm::ABORTED => 'aborted',
		];
		if ( isset( $retvalMap[$retval] ) ) {
			$errorType = $retvalMap[$retval];
			self::log( sprintf( 'Failed attempt to login using password: "%s"', $user->getName() ),
				[ 'user_login', 'user_login_password' ], [
					'target_user' => $user->getName(),
					'target_user_id' => $user->getId(),
					'login_type' => 'password',
					'error' => $errorType,
					'success' => false,
				] );
		}
		return true;
	}

	static public function onUserMailPasswordInternal( User $user, $ip, User $account ) {
		self::log( sprintf( 'Password reset for: "%s"', $account->getName() ),
			[ 'user_change', 'user_password_reset' ], [
				'target_user' => $account->getName(),
				'target_user_id' => $account->getId(),
			] );

		return true;
	}

	static public function onPrefsPasswordAudit( User $user, $password, $error ) {
		$tags = [ 'user_password_change_attempt' ];
		if ( $error === 'success' ) {
			$tags = array_merge( $tags, [ 'user_change', 'user_password_change' ] );
		}

		self::log( sprintf( 'User password changed for: "%s"', $user->getName() ), $tags, [
			'target_user' => $user->getName(),
			'target_user_id' => $user->getId(),
			'error' => $error,
		] );

		return true;
	}

	static public function onBeforeUserSaveSettings( User $user ) {
		$oldUser = User::newFromId( $user->getId() );
		$oldUser->load(); // resets ID to 0 if user does not exist in database
		if ( $oldUser->getId() === 0 ) {
			return true;
		}

		if ( $oldUser->getEmail() !== $user->getEmail() ) {
			self::log( sprintf( 'User email changed for: "%s"', $user->getName() ),
				[ 'user_change', 'user_email_change' ], [
					'target_user' => $user->getName(),
					'target_user_id' => $user->getId(),
					'email_old' => $oldUser->getEmail(),
					'email_new' => $user->getEmail(),
				] );
		}

		if ( $oldUser->getNewEmail() !== $user->getNewEmail() ) {
			self::log( sprintf( 'User new email changed for: "%s"', $user->getName() ),
				[ 'user_change', 'user_new_email_change' ], [
					'target_user' => $user->getName(),
					'target_user_id' => $user->getId(),
					'new_email_old' => $oldUser->getNewEmail(),
					'new_email_new' => $user->getNewEmail(),
				] );
		}

		return true;
	}

	static public function log( $text, $tags, $object ) {
		global $wgRequest, $wgUser, $wgCityId, $wgDBname;
		$ip = $wgRequest->getIP();
		$beacon = wfGetBeaconId();
		$userId = is_object( $wgUser ) ? intval( $wgUser->getId() ) : 0;
		$user = $userId !== 0 ? strval( $wgUser->getName() ) : '';

		$root = [
			'tags' => [ 'audit' ]
		];
		if ( $ip ) {
			$root['ip'] = $ip;
		}
		if ( $beacon !== '' ) {
			$root['beacon'] = $beacon;
		}
		if ( $userId !== 0 ) {
			$root['userid'] = $userId;
		}
		if ( $user !== '' ) {
			$root['user'] = $user;
		}
		if ( !empty( $wgDBname ) ) {
			$root['wikidbname'] = strval( $wgDBname );
		}
		if ( !empty( $wgCityId ) ) {
			$root['wikiid'] = intval( $wgCityId );
		}

		$context = $object;
		$context['action_tags'] = (array)$tags;
		if ( $root ) {
			$context['@root'] = $root;
		}

		$logger = \Wikia\Logger\WikiaLogger::instance();
		$logger->info( $text, $context );
	}

}

