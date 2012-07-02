<?php
class ConfirmAccount {
	/**
	 * Move old stale requests to rejected list. Delete old rejected requests.
	 */
	public static function runAutoMaintenance() {
		global $wgRejectedAccountMaxAge, $wgConfirmAccountRejectAge, $wgConfirmAccountFSRepos;

		$dbw = wfGetDB( DB_MASTER );
		$repo = new FSRepo( $wgConfirmAccountFSRepos['accountreqs'] );

		# Select all items older than time $encCutoff
		$encCutoff = $dbw->addQuotes( $dbw->timestamp( time() - $wgRejectedAccountMaxAge ) );
		$res = $dbw->select( 'account_requests',
			array( 'acr_id', 'acr_storage_key' ),
			array( "acr_rejected < {$encCutoff}" ),
			__METHOD__
		);

		# Clear out any associated attachments and delete those rows
		foreach ( $res as $row ) {
			$key = $row->acr_storage_key;
			if ( $key ) {
				$path = $repo->getZonePath( 'public' ) . '/' .
					UserAccountRequest::relPathFromKey( $key );
				if ( $path && file_exists($path) ) {
					unlink($path);
				}
			}
			$dbw->delete( 'account_requests', array( 'acr_id' => $row->acr_id ), __METHOD__ );
		}

		# Select all items older than time $encCutoff
		$encCutoff = $dbw->addQuotes( $dbw->timestamp( time() - $wgConfirmAccountRejectAge ) );
		# Old stale accounts will count as rejected. If the request was held, give it more time.
		$dbw->update( 'account_requests',
			array( 'acr_rejected' => $dbw->timestamp(),
				'acr_user' => 0, // dummy
				'acr_comment' => wfMsgForContent('confirmaccount-autorej'),
				'acr_deleted' => 1 ),
			array( "acr_rejected IS NULL",
				"acr_registration < {$encCutoff}",
				"acr_held < {$encCutoff} OR acr_held IS NULL" ),
			__METHOD__
		);

		# Clear cache for notice of how many account requests there are
		self::clearAccountRequestCountCache();
	}

	/**
	 * Flag a user's email as confirmed in the db
	 *
	 * @param sring $name
	 */
	public static function confirmEmail( $name ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'account_requests',
			array( 'acr_email_authenticated' => $dbw->timestamp() ),
			array( 'acr_name' => $name ),
			__METHOD__ );
		# Clear cache for notice of how many account requests there are
		self::clearAccountRequestCountCache();
	}

	/**
	 * Generate and store a new e-mail confirmation token, and return
	 * the URL the user can use to confirm.
	 * @param string $token
	 * @return string
	 */
	public static function confirmationTokenUrl( $token ) {
		$title = SpecialPage::getTitleFor( 'RequestAccount' );
		return $title->getFullUrl( array(
			'action' => 'confirmemail',
			'wpEmailToken' => $token
		) );
	}

	/**
	 * Generate, store, and return a new e-mail confirmation code.
	 * A hash (unsalted since it's used as a key) is stored.
	 * @param User $user
	 * @param string $expiration
	 * @return string
	 */
	public static function getConfirmationToken( $user, &$expiration ) {
		global $wgConfirmAccountRejectAge;

		$expires = time() + $wgConfirmAccountRejectAge;
		$expiration = wfTimestamp( TS_MW, $expires );
		$token = $user->generateToken( $user->getName() . $user->getEmail() . $expires );
		return $token;
	}

	/**
	 * Generate a new e-mail confirmation token and send a confirmation
	 * mail to the user's given address.
	 *
	 * @param User $user
	 * @param string $ip User IP address
	 * @param string $token
	 * @param string $expiration
	 * @return true|Status True on success, a Status object on failure.
	 */
	public static function sendConfirmationMail( User $user, $ip, $token, $expiration ) {
		global $wgContLang;

		$url = self::confirmationTokenUrl( $token );
		$lang = $user->getOption( 'language' );
		return $user->sendMail(
			wfMessage( 'requestaccount-email-subj' )->inLanguage( $lang )->text(),
			wfMessage( 'requestaccount-email-body',
				$ip,
				$user->getName(),
				$url,
				$wgContLang->timeanddate( $expiration, false ) ,
				$wgContLang->date( $expiration, false ) ,
				$wgContLang->time( $expiration, false )
			)->inLanguage( $lang )->text()
		);
	}

	/**
	 * Get a request name from an email confirmation token
	 *
	 * @param $code string
	 * @return string|false
	 */
	public static function requestNameFromEmailToken( $code ) {
		$dbr = wfGetDB( DB_SLAVE );
		return $dbr->selectField( 'account_requests',
			'acr_name',
			array(
				'acr_email_token' => md5( $code ),
				'acr_email_token_expires > ' . $dbr->addQuotes( $dbr->timestamp() ),
			)
		);
	}

	/**
	 * Get the number of account requests for a request type
	 * @param $type int
	 * @return Array Assosiative array with 'open', 'held', 'type' keys mapping to integers
	 */
	public static function getOpenRequestCount( $type ) {
		$dbr = wfGetDB( DB_SLAVE );
		$open = (int)$dbr->selectField( 'account_requests', 'COUNT(*)',
			array( 'acr_type' => $type, 'acr_deleted' => 0, 'acr_held IS NULL' ),
			__METHOD__
		);
		$held = (int)$dbr->selectField( 'account_requests', 'COUNT(*)',
			array( 'acr_type' => $type, 'acr_deleted' => 0, 'acr_held IS NOT NULL' ),
			__METHOD__
		);
		$rej = (int)$dbr->selectField( 'account_requests', 'COUNT(*)',
			array( 'acr_type' => $type, 'acr_deleted' => 1, 'acr_user != 0' ),
			__METHOD__
		);
		return array( 'open' => $open, 'held' => $held, 'rejected' => $rej );
	}

	/**
	 * Get the number of open email-confirmed account requests for a request type
	 * @param $type int|string A request type or '*' for all
	 * @return int
	 */
	public static function getOpenEmailConfirmedCount( $type = '*' ) {
		global $wgMemc;

		# Check cached results
		$key = wfMemcKey( 'confirmaccount', 'econfopencount', $type );
		$count = $wgMemc->get( $key );
		# Only show message if there are any such requests
		if ( $count === false ) {
			$conds = array(
				'acr_deleted' => 0, // not rejected
				'acr_held IS NULL', // nor held
				'acr_email_authenticated IS NOT NULL' ); // email confirmed
			if ( $type !== '*' ) {
				$conds['acr_type'] = (int)$type;
			}
			$dbw = wfGetDB( DB_MASTER );
			$count = (int)$dbw->selectField( 'account_requests', 'COUNT(*)', $conds, __METHOD__ );
			# Cache results (invalidated on change )
			$wgMemc->set( $key, $count, 3600 * 24 * 7 );
		}
		return $count;
	}

	/**
	 * Clear account request cache
	 * @return void
	 */
	public static function clearAccountRequestCountCache() {
		global $wgAccountRequestTypes, $wgMemc;

		$types = array_keys( $wgAccountRequestTypes );
		$types[] = '*'; // "all" types count
		foreach( $types as $type ) {
			$key = wfMemcKey( 'confirmaccount', 'econfopencount', $type );
			$wgMemc->delete( $key );
		}
	}

	/**
	 * Verifies that it's ok to include the uploaded file
	 *
	 * @param string $tmpfile the full path of the temporary file to verify
	 * @param string $extension The filename extension that the file is to be served with
	 * @return Status object
	 */
	public static function verifyAttachment( $tmpfile, $extension ) {
		global $wgVerifyMimeType, $wgMimeTypeBlacklist;

		$magic =& MimeMagic::singleton(); // magically determine mime type
		$mime = $magic->guessMimeType( $tmpfile, false );
		# check mime type, if desired
		if ( $wgVerifyMimeType ) {
			wfDebug ( "\n\nmime: <$mime> extension: <$extension>\n\n" );
			# Check mime type against file extension
			if ( !UploadBase::verifyExtension( $mime, $extension ) ) {
				return Status::newFatal( 'uploadcorrupt' );
			}
			# Check mime type blacklist
			if ( isset( $wgMimeTypeBlacklist ) && !is_null( $wgMimeTypeBlacklist )
				&& self::checkFileExtension( $mime, $wgMimeTypeBlacklist ) ) {
				return Status::newFatal( 'filetype-badmime', $mime );
			}
		}
		wfDebug( __METHOD__ . ": all clear; passing.\n" );
		return Status::newGood();
	}

	/**
	 * Perform case-insensitive match against a list of file extensions.
	 * Returns true if the extension is in the list.
	 *
	 * @param string $ext
	 * @param array $list
	 * @return bool
	 */
	protected static function checkFileExtension( $ext, $list ) {
		return in_array( strtolower( $ext ), $list );
	}

	/**
	 * Get the text to add to this users page for describing editing topics
	 * for each "area" a user can be in, as defined in MediaWiki:requestaccount-areas.
	 *
	 * @return Array Associative mapping of the format:
	 *    (name => ('project' => x, 'userText' => y, 'grpUserText' => (request type => z)))
	 * Any of the ultimate values can be the empty string
	 */
	public static function getUserAreaConfig() {
		static $res; // process cache
		if ( $res !== null ) {
			return $res;
		}
		$res = array();
		// Message describing the areas a user can be interested in, the corresponding wiki page,
		// and any text that is automatically appended to the userpage on account acceptance.
		// Format is <name> | <wikipage> [| <text for all>] [| <text group0>] [| <text group1>] ...
		$msg = wfMessage( 'requestaccount-areas' )->inContentLanguage();
		if ( $msg->exists() ) {
			$areas = explode( "\n*", "\n" . $msg->text() );
			foreach ( $areas as $n => $area ) {
				$set = explode( "|", $area );
				if ( count( $set ) >= 2 ) {
					$name = trim( str_replace( '_', ' ', $set[0] ) );
					$res[$name] = array();

					$res[$name]['project'] = trim( $set[1] ); // name => WikiProject mapping
					if ( isset( $set[2] ) ) {
						$res[$name]['userText'] = trim( $set[2] ); // userpage text for all
					} else {
						$res[$name]['userText'] = '';
					}

					$res[$name]['grpUserText'] = array(); // userpage text for certain request types
					$categories = array_slice( $set, 3 ); // keys start from 0 now in $categories
					foreach ( $categories as $i => $cat ) {
						$res[$name]['grpUserText'][$i] = trim( $cat ); // category for group $i
					}
				}
			}
		}
		return $res;
	}

	/**
	 * Get a block for this user if they are blocked from requesting accounts
	 * @param User $user
	 * @return Block|null 
	 */
	public static function getAccountRequestBlock( User $user ) {
		global $wgAccountRequestWhileBlocked;

		$block = false;
		# If a user cannot make accounts, don't let them request them either
		if ( !$wgAccountRequestWhileBlocked ) {
			$block = $user->isBlockedFromCreateAccount();
		}

		return $block;
	}
}
