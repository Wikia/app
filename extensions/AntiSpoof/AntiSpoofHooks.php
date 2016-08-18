<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

class AntiSpoofHooks {
	/**
	 * @param $updater DatabaseUpdater
	 * @return bool
	 */
	public static function asUpdateSchema( $updater = null ) {
		if ( $updater === null ) {
			global $wgExtNewTables, $wgDBtype;
			$wgExtNewTables[] = array(
				'spoofuser',
				dirname( __FILE__ ) . '/sql/patch-antispoof.' . $wgDBtype . '.sql', true );
		} else {
			$updater->addExtensionUpdate( array( 'addTable', 'spoofuser',
				dirname( __FILE__ ) . '/sql/patch-antispoof.' . $updater->getDB()->getType() . '.sql', true ) );
		}
		return true;
	}

	/**
	 * @param $name string Username
	 * @return SpoofUser
	 */
	protected static function makeSpoofUser( $name ) {
		return new SpoofUser( $name );
	}

	/**
	 * Can be used to cancel user account creation
	 *
	 * @param $user User
	 * @param $message string
	 * @return bool true to continue, false to abort user creation
	 */
	public static function asAbortNewAccountHook( $user, &$message ) {
		global $wgAntiSpoofAccounts, $wgUser, $wgRequest;

		if ( !$wgAntiSpoofAccounts ) {
			$mode = 'LOGGING ';
			$active = false;
		} elseif ( $wgRequest->getCheck( 'wpIgnoreAntiSpoof' ) &&
				$wgUser->isAllowed( 'override-antispoof' ) ) {
			$mode = 'OVERRIDE ';
			$active = false;
		} else {
			$mode = '';
			$active = true;
		}

		$name = $user->getName();
		$spoof = self::makeSpoofUser( $name );
		if ( $spoof->isLegal() ) {
			$normalized = $spoof->getNormalized();
			$conflicts = $spoof->getConflicts();
			if ( empty( $conflicts ) ) {
				wfDebugLog( 'antispoof', "{$mode}PASS new account '$name' [$normalized]" );
			} else {
				wfDebugLog( 'antispoof', "{$mode}CONFLICT new account '$name' [$normalized] spoofs " . implode( ',', $conflicts ) );
				if ( $active ) {
					/* Wikia change - begin */
					$message = wfMsg( 'userexists' );
					/* Wikia change - end */
					return false;
				}
			}
		} else {
			$error = $spoof->getError();
			wfDebugLog( 'antispoof', "{$mode}ILLEGAL new account '$name' $error" );
			if ( $active ) {
				$message = wfMsg( 'antispoof-name-illegal', $name, $error );
				return false;
			}
		}
		return true;
	}

	/**
	 * Set the ignore spoof thingie
	 * (Manipulate the user create form)
	 *
	 * @param $template UsercreateTemplate
	 * @return bool
	 */
	public static function asUserCreateFormHook( &$template ) {
		global $wgRequest, $wgAntiSpoofAccounts, $wgUser;

		if ( $wgAntiSpoofAccounts && $wgUser->isAllowed( 'override-antispoof' ) ) {
			$template->addInputItem( 'wpIgnoreAntiSpoof',
				$wgRequest->getCheck( 'wpIgnoreAntiSpoof' ),
				'checkbox', 'antispoof-ignore' );
		}
		return true;
	}

	/**
	 * On new account creation, record the username's thing-bob.
	 * (Called after a user account is created)
	 *
	 * @param $user User
	 * @return bool
	 */
	public static function asAddNewAccountHook( $user ) {
		$spoof = self::makeSpoofUser( $user->getName() );
		$spoof->record();
		return true;
	}

	/**
	 * On rename, remove the old entry and add the new
	 * (After a sucessful user rename)
	 *
	 * @param $uid
	 * @param $oldName string
	 * @param $newName string
	 * @return bool
	 */
	public static function asAddRenameUserHook( $uid, $oldName, $newName ) {
		$spoof = self::makeSpoofUser( $newName );
		$spoof->update( $oldName );
		return true;
	}

	/**
	 * Wikia Addition
	 * (After a successful user rename using Wikia Tool)
	 *
	 * @param $dbw DatabaseBase
	 * @param $uid
	 * @param $oldusername string
	 * @param $newusername string
	 * @param $process
	 * @param $tasks
	 */
	public static function asAfterWikiaRenameUserHook( $dbw, $uid, $oldusername, $newusername, $process, &$tasks ) {
		$spoof = self::makeSpoofUser( $newusername );
		$spoof->record();
		return true;
	}
}
