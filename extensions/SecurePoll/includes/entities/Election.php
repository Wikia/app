<?php

/**
 * Class representing an *election*. The term is intended to include straw polls, 
 * surveys, etc. An election has one or more *questions* which voters answer. 
 * The *voters* submit their *votes*, which are later tallied to provide a result.
 * An election runs only once and produces a single result.
 *
 * Each election has its own independent set of voters. Voters are created 
 * when the underlying user attempts to vote. A voter may vote more than once,
 * unless the election disallows this, but only one of their votes is counted.
 *
 * Elections have a list of key/value pairs called properties, which are defined 
 * and used by various modules in order to configure the election. The properties,
 * in order of the module that defines them, are as follows:
 *
 *      Election
 *          min-edits
 *              Minimum number of edits needed to be qualified
 *          max-registration
 *              Latest acceptable registration date
 *          not-blocked
 *              True if voters need to not be blocked
 *          not-bot
 *              True if voters need to not have the bot permission
 *          need-group
 *              The name of an MW group voters need to be in
 *          need-list
 *              The name of a SecurePoll list voters need to be in
 *          admins
 *              A list of admin names, pipe separated
 *          disallow-change
 *              True if a voter is not allowed to change their vote
 *          encrypt-type
 *              The encryption module name
 *          not-centrally-blocked
 *          	True if voters need to not be blocked on more than X projects
 *          central-block-threshold
 *          	Number of blocks across projects that disqualify a user from voting.
 *      
 *      See the other module for documentation of the following.
 *
 *      RemoteMWAuth
 *          remote-mw-script-path
 *
 *      Ballot
 *          shuffle-questions
 *          shuffle-options
 *
 *      GpgCrypt
 *          gpg-encrypt-key
 *          gpg-sign-key
 *          gpg-decrypt-key
 *
 *      VotePage
 *          jump-url
 *          jump-id
 *          return-url
 */
class SecurePoll_Election extends SecurePoll_Entity {
	var $questions, $auth, $ballot;
	var $id, $title, $ballotType, $tallyType, $primaryLang;
	var $startDate, $endDate, $authType;

	/**
	 * Constructor. 
	 *
	 * Do not use this constructor directly, instead use 
	 * SecurePoll_Context::getElection(). 
	 *
	 * @param $id integer
	 */
	function __construct( $context, $info ) {
		parent::__construct( $context, 'election', $info );
		$this->id = $info['id'];
		$this->title = $info['title'];
		$this->ballotType = $info['ballot'];
		$this->tallyType = $info['tally'];
		$this->primaryLang = $info['primaryLang'];
		$this->startDate = $info['startDate'];
		$this->endDate = $info['endDate'];
		$this->authType = $info['auth'];
	}

	/**
	 * Get a list of localisable message names. See SecurePoll_Entity.
	 */
	function getMessageNames() {
		return array(
			'title',
			'intro',
			'jump-text',
			'return-text',
			'unqualified-error',
		);
	}
	
	/**
	 * Get the election's parent election... hmm...
	 */
	function getElection() {
		return $this;
	}

	/**
	 * Get a list of child entity objects. See SecurePoll_Entity.
	 */
	function getChildren() {
		return $this->getQuestions();
	}

	/**
	 * Get the start date in MW internal form.
	 */
	function getStartDate() { return $this->startDate; }

	/**
	 * Get the end date in MW internal form.
	 */
	function getEndDate() { return $this->endDate; }

	/**
	 * Returns true if the election has started.
	 * @param $ts The reference timestamp, or false for now.
	 */
	function isStarted( $ts = false ) {
		if ( $ts === false ) {
			$ts = wfTimestampNow();
		}
		return !$this->startDate || $ts >= $this->startDate;
	}

	/**
	 * Returns true if the election has finished.
	 * @param $ts The reference timestamp, or false for now.
	 */
	function isFinished( $ts = false ) {
		if ( $ts === false ) {
			$ts = wfTimestampNow();
		}
		return $this->endDate && $ts >= $this->endDate;
	}

	/**
	 * Get the ballot object for this election.
	 * @return SecurePoll_Ballot
	 */
	function getBallot() {
		if ( !$this->ballot ) {
			$this->ballot = $this->context->newBallot( $this->ballotType, $this );
		}
		return $this->ballot;
	}

	/**
	 * Determine whether a voter would be qualified to vote in this election, 
	 * based on the given associative array of parameters.
	 * @param $params Associative array
	 * @return Status
	 */
	function getQualifiedStatus( $params ) {
		global $wgLang;
		$props = $params['properties'];
		$status = Status::newGood();

		# Edits
		$minEdits = $this->getProperty( 'min-edits' );
		$edits = isset( $props['edit-count'] ) ? $props['edit-count'] : 0;
		if ( $minEdits && $edits < $minEdits ) {
			$status->fatal( 'securepoll-too-few-edits', $wgLang->formatNum( $minEdits), $wgLang->formatNum( $edits ) );
		}

		# Registration date
		$maxDate = $this->getProperty( 'max-registration' );
		$date = isset( $props['registration'] ) ? $props['registration'] : 0;
		if ( $maxDate && $date > $maxDate ) {
			$status->fatal( 
				'securepoll-too-new', 
				$wgLang->date( $maxDate ), 
				$wgLang->date( $date ),
				$wgLang->time( $maxDate ), 
				$wgLang->time( $date )
			);
		}

		# Blocked
		$notBlocked = $this->getProperty( 'not-blocked' );
		$isBlocked = !empty( $props['blocked'] );
		if ( $notBlocked && $isBlocked ) {
			$status->fatal( 'securepoll-blocked' );
		}
		
		# Centrally blocked on more than X projects
		$notCentrallyBlocked = $this->getProperty( 'not-centrally-blocked' );
		$centralBlockCount = isset( $props['central-block-count'] ) ? $props['central-block-count'] : 0;
		$centralBlockThreshold = $this->getProperty( 'central-block-threshold', 1 );
		if ( $notCentrallyBlocked && $centralBlockCount >= $centralBlockThreshold ) {
			$status->fatal( 'securepoll-blocked-centrally', $wgLang->formatNum( $centralBlockThreshold ) );
		}

		# Bot
		$notBot = $this->getProperty( 'not-bot' );
		$isBot = !empty( $props['bot'] );
		if ( $notBot && $isBot ) {
			$status->fatal( 'securepoll-bot' );
		}

		# Groups
		$needGroup = $this->getProperty( 'need-group' );
		$groups = isset( $props['groups'] ) ? $props['groups'] : array();
		if ( $needGroup && !in_array( $needGroup, $groups ) ) {
			$status->fatal( 'securepoll-not-in-group', $needGroup );
		}

		# Lists
		$needList = $this->getProperty( 'need-list' );
		$lists = isset( $props['lists'] ) ? $props['lists'] : array();
		if ( $needList && !in_array( $needList, $lists ) ) {
			$status->fatal( 'securepoll-not-in-list' );
		}

		# Get custom error message
		if ( !$status->isOK() ) {
			$errorMsg = $this->getMessage( 'unqualified-error' );
			if ( $errorMsg !== '[unqualified-error]' && $errorMsg !== '' ) {
				$status = Status::newFatal( 'securepoll-custom-unqualified', $errorMsg );
			}
		}

		return $status;
	}

	/**
	 * Returns true if the user is an admin of the current election.
	 * @param $user User
	 */
	function isAdmin( $user ) {
		$admins = array_map( 'trim', explode( '|', $this->getProperty( 'admins' ) ) );
		return in_array( $user->getName(), $admins );
	}

	/**
	 * Returns true if the voter has voted already.
	 * @param $voter SecurePoll_Voter
	 */
	function hasVoted( $voter ) {
		$db = $this->context->getDB();
		$row = $db->selectRow(
			'securepoll_votes',
			array( "1" ),
			array(
				'vote_election' => $this->getId(),
				'vote_voter' => $voter->getId(),
			),
			__METHOD__ );
		return $row !== false;
	}

	/**
	 * Returns true if the election allows voters to change their vote after it
	 * is initially cast.
	 * @return bool
	 */
	function allowChange() {
		return !$this->getProperty( 'disallow-change' );
	}

	/**
	 * Get the questions in this election
	 * @return array of SecurePoll_Question objects.
	 */
	function getQuestions() {
		if ( $this->questions === null ) {
			$info = $this->context->getStore()->getQuestionInfo( $this->getId() );
			$this->questions = array();
			foreach ( $info as $questionInfo ) {
				$this->questions[] = $this->context->newQuestion( $questionInfo );
			}
		}
		return $this->questions;
	}

	/**
	 * Get the authorisation object.
	 * @return SecurePoll_Auth
	 */
	function getAuth() {
		if ( !$this->auth ) {
			$this->auth = $this->context->newAuth( $this->authType );
		}
		return $this->auth;
	}

	/**
	 * Get the primary language for this election. This language will be used as
	 * a default in the relevant places.
	 * @return string
	 */
	function getLanguage() {
		return $this->primaryLang;
	}

	/**
	 * Get the cryptography module for this election, or false if none is
	 * defined.
	 * @return SecurePoll_Crypt or false
	 */
	function getCrypt() {
		$type = $this->getProperty( 'encrypt-type' );
		if ( $type === false || $type === 'none' ) {
			return false;
		}
		$crypt = $this->context->newCrypt( $type, $this );
		if ( !$crypt ) {
			throw new MWException( 'Invalid encryption type' );
		}
		return $crypt;
	}

	/**
	 * Get the tally type
	 */
	function getTallyType() {
		return $this->tallyType;
	}

	/**
	 * Call a callback function for each valid vote record, in random order.
	 */
	function dumpVotesToCallback( $callback ) {
		if ( !$this->getCrypt() ) {
			return Status::newFatal( 'securepoll-dump-no-crypt' );
		}

		$random = $this->context->getRandom();
		$status = $random->open();
		if ( !$status->isOK() ) {
			return $status;
		}
		$db = $this->context->getDB();
		$res = $db->select(
			'securepoll_votes',
			array( '*' ),
			array(
				'vote_election' => $this->getId(),
				'vote_current' => 1,
				'vote_struck' => 0
			),
			__METHOD__
		);
		if ( $res->numRows() ) {
			$order = $random->shuffle( range( 0, $res->numRows() - 1 ) );
			foreach ( $order as $i ) {
				$res->seek( $i );
				call_user_func( $callback, $this, $res->fetchObject() );
			}
		}
		$random->close();
		return Status::newGood();
	}

	/**
	 * Get an XML snippet describing the configuration of this object
	 */
	function getConfXml( $params = array() ) {
		$s = "<configuration>\n" .
			Xml::element( 'title', array(), $this->title ) . "\n" .
			Xml::element( 'ballot', array(), $this->ballotType ) . "\n" .
			Xml::element( 'tally', array(), $this->tallyType ) . "\n" .
			Xml::element( 'primaryLang', array(), $this->primaryLang ) . "\n" .
			Xml::element( 'startDate', array(), wfTimestamp( TS_ISO_8601, $this->startDate ) ) . "\n" .
			Xml::element( 'endDate', array(), wfTimestamp( TS_ISO_8601, $this->endDate ) ) . "\n" .
			$this->getConfXmlEntityStuff( $params );

		# If we're making a jump dump, we need to add some extra properties, and 
		# override the auth type
		if ( !empty( $params['jump'] ) ) {
			$s .= 
				Xml::element( 'auth', array(), 'local' ) . "\n" .
				Xml::element( 'property', 
					array( 'name' => 'jump-url' ), 
					$this->context->getSpecialTitle()->getCanonicalUrl()
				) . "\n" .
				Xml::element( 'property',
					array( 'name' => 'jump-id' ),
					$this->getId() 
				) . "\n";
		} else {
			$s .= Xml::element( 'auth', array(), $this->authType ) . "\n";
		}

		foreach ( $this->getQuestions() as $question ) {
			$s .= $question->getConfXml( $params );
		}
		$s .= "</configuration>\n";
		return $s;
	}

	/**
	 * Get property names which aren't included in an XML dump
	 */
	function getPropertyDumpBlacklist( $params = array() ) {
		if ( !empty( $params['jump'] ) ) {
			return array(
				'gpg-encrypt-key',
				'gpg-sign-key',
				'gpg-decrypt-key'
			);
		} else {
			return array();
		}
	}

	/**
	 * Tally the valid votes for this election.
	 * Returns a Status object. On success, the value property will contain a
	 * SecurePoll_ElectionTallier object.
	 */
	function tally() {
		$tallier = $this->context->newElectionTallier( $this );
		$status = $tallier->execute();
		if ( $status->isOK() ) {
			return Status::newGood( $tallier );
		} else {
			return $status;
		}
	}
}

