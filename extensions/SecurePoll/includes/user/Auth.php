<?php

/**
 * Class for handling guest logins and sessions. Creates SecurePoll_Voter objects.
 */
class SecurePoll_Auth {
	var $context;

	/**
	 * List of available authorisation modules (subclasses)
	 */
	static $authTypes = array(
		'local' => 'SecurePoll_LocalAuth',
		'remote-mw' => 'SecurePoll_RemoteMWAuth',
	);

	/**
	 * Create an auth object of the given type
	 * @param $type string
	 */
	static function factory( $context, $type ) {
		if ( !isset( self::$authTypes[$type] ) ) {
			throw new MWException( "Invalid authentication type: $type" );
		}
		$class = self::$authTypes[$type];
		return new $class( $context );
	}

	function __construct( $context ) {
		$this->context = $context;
	}

	/**
	 * Create a voter transparently, without user interaction.
	 * Sessions authorised against local accounts are created this way.
	 * @param $election SecurePoll_Election
	 * @return Status
	 */
	function autoLogin( $election ) {
		return Status::newFatal( 'securepoll-not-logged-in' );
	}

	/**
	 * Create a voter on a direct request from a remote site.
	 * @param $election SecurePoll_Election
	 * @return Status
	 */
	function requestLogin( $election ) {
		return $this->autoLogin( $election );
	}

	/**
	 * Get the voter associated with the current session. Returns false if 
	 * there is no session.
	 * @param $election SecurePoll_Election
	 * @return SecurePoll_Election
	 */
	function getVoterFromSession( $election ) {
		if ( session_id() == '' ) {
			wfSetupSession();
		}
		if ( isset( $_SESSION['securepoll_voter'][$election->getId()] ) ) {
			$voterId = $_SESSION['securepoll_voter'][$election->getId()];
			
			# Perform cookie fraud check
			$status = $this->autoLogin( $election );
			if ( $status->isOK() ) {
				$otherVoter = $status->value;
				if ( $otherVoter->getId() != $voterId ) {
					$otherVoter->addCookieDup( $voterId );
					$_SESSION['securepoll_voter'][$election->getId()] = $otherVoter->getId();
					return $otherVoter;
				}
			}

			# Sanity check election ID
			$voter = $this->context->getVoter( $voterId );
			if ( !$voter || $voter->getElectionId() != $election->getId() ) {
				return false;
			} else {
				return $voter;
			}
		} else {
			return false;
		}
	}

	/**
	 * Get a voter object with the relevant parameters.
	 * If no voter exists with those parameters, a new one is created. If one
	 * does exist already, it is returned.
	 * @param $params array
	 * @return SecurePoll_Voter
	 */
	function getVoter( $params ) {
		$dbw = $this->context->getDB();

		# This needs to be protected by FOR UPDATE
		# Otherwise a race condition could lead to duplicate users for a single remote user, 
		# and thus to duplicate votes.
		$dbw->begin();
		$row = $dbw->selectRow( 
			'securepoll_voters', '*', 
			array( 
				'voter_name' => $params['name'],
				'voter_election' => $params['electionId'],
				'voter_domain' => $params['domain'],
				'voter_url' => $params['url']
			),
			__METHOD__,
			array( 'FOR UPDATE' )
		);
		if ( $row ) {
			# No need to hold the lock longer
			$dbw->commit();
			$user = $this->context->newVoterFromRow( $row );
		} else {
			# Lock needs to be held until the row is inserted
			$user = $this->context->createVoter( $params );
			$dbw->commit();
		}
		return $user;
	}

	/**
	 * Create a voter without user interaction, and create a session for it.
	 * @param $election SecurePoll_Election
	 * @return Status
	 */
	function newAutoSession( $election ) {
		$status = $this->autoLogin( $election );
		if ( $status->isGood() ) {
			$voter = $status->value;
			$_SESSION['securepoll_voter'][$election->getId()] = $voter->getId();
			$voter->doCookieCheck();
		}
		return $status;
	}

	/**
	 * Create a voter on an explicit request, and create a session for it.
	 * @param $election SecurePoll_Election
	 * @return Status
	 */
	function newRequestedSession( $election ) {
		if ( session_id() == '' ) {
			wfSetupSession();
		}
		$status = $this->requestLogin( $election );
		if ( !$status->isOK() ) {
			return $status;
		}

		# Do cookie dup flagging
		$voter = $status->value;
		if ( isset( $_SESSION['securepoll_voter'][$election->getId()] ) ) {
			$otherVoterId = $_SESSION['securepoll_voter'][$election->getId()];
			if ( $voter->getId() != $otherVoterId ) {
				$voter->addCookieDup( $otherVoterId );
			}
		} else {
			$voter->doCookieCheck();
		}

		$_SESSION['securepoll_voter'][$election->getId()] = $voter->getId();
		return $status;
	}
}

/**
 * Authorisation class for locally created accounts.
 * Certain functions in this class are also used for sending local voter 
 * parameters to a remote SecurePoll installation.
 */
class SecurePoll_LocalAuth extends SecurePoll_Auth {
	/**
	 * Create a voter transparently, without user interaction.
	 * Sessions authorised against local accounts are created this way.
	 * @param $election SecurePoll_Election
	 * @return Status
	 */
	function autoLogin( $election ) {
		global $wgUser, $wgServer, $wgLang;
		if ( $wgUser->isAnon() ) {
			return Status::newFatal( 'securepoll-not-logged-in' );
		}
		$params = $this->getUserParams( $wgUser );
		$params['electionId'] = $election->getId();
		$qualStatus = $election->getQualifiedStatus( $params );
		if ( !$qualStatus->isOK() ) {
			return $qualStatus;
		}
		$voter = $this->getVoter( $params );
		return Status::newGood( $voter );
	}

	/**
	 * Get voter parameters for a local User object.
	 * @param $user User
	 * @return array
	 */
	function getUserParams( $user ) {
		global $wgServer;
		$params = array(
			'name' => $user->getName(),
			'type' => 'local',
			'domain' => preg_replace( '!.*/(.*)$!', '$1', $wgServer ),
			'url' => $user->getUserPage()->getFullURL(),
			'properties' => array(
				'wiki' => wfWikiID(),
				'blocked' => $user->isBlocked(),
				'edit-count' => $user->getEditCount(),
				'bot' => $user->isBot(),
				'language' => $user->getOption( 'language' ),
				'groups' => $user->getGroups(),
				'lists' => $this->getLists( $user )
			)
		);
		wfRunHooks( 'SecurePoll_GetUserParams', array( $this, $user, &$params ) );
		return $params;
	}

	/**
	 * Get the lists a given local user belongs to
	 * @param $user User
	 * @return array
	 */
	function getLists( $user ) {
		$dbr = $this->context->getDB();
		$res = $dbr->select( 
			'securepoll_lists',
			array( 'li_name' ),
			array( 'li_member' => $user->getId() ),
			__METHOD__
		);
		$lists = array();
		foreach ( $res as $row ) {
			$lists[] = $row->li_name;
		}
		return $lists;
	}
}

/**
 * Class for guest login from one MW instance running SecurePoll to another.
 */
class SecurePoll_RemoteMWAuth extends SecurePoll_Auth {
	/**
	 * Create a voter on a direct request from a remote site.
	 * @param $election SecurePoll_Election
	 * @return Status
	 */
	function requestLogin( $election ) {
		global $wgRequest;

		$urlParamNames = array( 'id', 'token', 'wiki', 'site', 'lang', 'domain' );
		$vars = array();
		foreach ( $urlParamNames as $name ) {
			$value = $wgRequest->getVal( $name );
			if ( !preg_match( '/^[\w.-]*$/', $value ) ) {
				wfDebug( __METHOD__ . " Invalid parameter: $name\n" );
				return false;
			}
			$params[$name] = $value;
			$vars["\$$name"] = $value;
		}

		$url = $election->getProperty( 'remote-mw-script-path' );
		$url = strtr( $url, $vars );
		if ( substr( $url, -1 ) != '/' ) {
			$url .= '/';
		}
		$url .= 'extensions/SecurePoll/auth-api.php?' . 
			wfArrayToCGI( array(
				'token' => $params['token'],
				'id' => $params['id']
			) );

		// Use the default SSL certificate file
		// Necessary on some versions of cURL, others do this by default
		$curlParams = array( CURLOPT_CAINFO => '/etc/ssl/certs/ca-certificates.crt' );

		$value = Http::get( $url, 20, $curlParams );

		if ( !$value ) {
			return Status::newFatal( 'securepoll-remote-auth-error' );
		}

		$status = unserialize( $value );
		$status->cleanCallback = false;

		if ( !$status || !( $status instanceof Status ) ) {
			return Status::newFatal( 'securepoll-remote-parse-error' );
		}
		if ( !$status->isOK() ) {
			return $status;
		}
		$params = $status->value;
		$params['type'] = 'remote-mw';
		$params['electionId'] = $election->getId();

		$qualStatus = $election->getQualifiedStatus( $params );
		if ( !$qualStatus->isOK() ) {
			return $qualStatus;
		}

		return Status::newGood( $this->getVoter( $params ) );
	}

	/**
	 * Apply a one-way hash function to a string.
	 *
	 * The aim is to encode a user's login token so that it can be transmitted to the
	 * voting server without giving the voting server any special rights on the wiki 
	 * (apart from the ability to verify the user). We truncate the hash at 26 
	 * hexadecimal digits, to provide 24 bits less information than original token. 
	 * This makes discovery of the token difficult even if the hash function is 
	 * completely broken.
	 */
	static function encodeToken( $token ) {
		return substr( sha1( __CLASS__ . '-' . $token ), 0, 26 );
	}
}
