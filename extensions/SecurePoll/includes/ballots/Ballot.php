<?php

/**
 * Parent class for ballot forms. This is the UI component of a voting method.
 */
abstract class SecurePoll_Ballot {
	var $election, $context;

	/**
	 * Get a list of names of tallying methods, which may be used to produce a 
	 * result from this ballot type.
	 * @return array
	 */
	abstract function getTallyTypes();

	/**
	 * Get the HTML form segment for a single question
	 * @param $question SecurePoll_Question
	 * @param $options Array of options, in the order they should be displayed
	 * @param $prevStatus Status of previous form submission
	 * @return string
	 */
	abstract function getQuestionForm( $question, $options );
	
	/**
	 * Get any extra messages that this ballot type uses to render questions.
	 * Used to get the list of translatable messages for TranslatePage.
	 * @return Array
	 * @see SecurePoll_Election::getMessageNames()
	 */
	function getMessageNames() {
		return array();
	}

	/**
	 * Called when the form is submitted. This returns a Status object which, 
	 * when successful, contains a voting record in the value member. To 
	 * preserve voter privacy, voting records should be the same length 
	 * regardless of voter choices.
	 */
	function submitForm() {
		$questions = $this->election->getQuestions();
		$record = '';
		$status = new SecurePoll_BallotStatus( $this->context );

		foreach ( $questions as $question ) {
			$record .= $this->submitQuestion( $question, $status );
		}
		if ( $status->isOK() ) {
			$status->value = $record . "\n";
		}
		return $status;
	}

	/**
	 * Construct a string record for a given question, during form submission.
	 *
	 * If there is a problem with the form data, the function should set a 
	 * fatal error in the $status object and return null.
	 *
	 * @param Status
	 * @return string
	 */
	abstract function submitQuestion( $question, $status );

	/**
	 * Unpack a string record into an array format suitable for the tally type
	 */
	abstract function unpackRecord( $record );

	/**
	 * Convert a record to a string of some kind
	 */
	function convertRecord( $record, $options = array() ) {
		$scores = $this->unpackRecord( $record );
		return $this->convertScores( $scores );
	}

	/**
	 * Convert a score array to a string of some kind
	 */
	abstract function convertScores( $scores, $options = array() );

	/**
	 * Create a ballot of the given type
	 * @param $context SecurePoll_Context
	 * @param $type string
	 * @param $election SecurePoll_Election
	 */
	static function factory( $context, $type, $election ) {
		switch ( $type ) {
		case 'approval':
			return new SecurePoll_ApprovalBallot( $context, $election );
		case 'preferential':
			return new SecurePoll_PreferentialBallot( $context, $election );
		case 'choose':
			return new SecurePoll_ChooseBallot( $context, $election );
		case 'radio-range':
			return new SecurePoll_RadioRangeBallot( $context, $election );
		case 'radio-range-comment':
			return new SecurePoll_RadioRangeCommentBallot( $context, $election );
		default:
			throw new MWException( "Invalid ballot type: $type" );
		}
	}

	/**
	 * Constructor.
	 * @param $context SecurePoll_Context
	 * @param $election SecurePoll_Election
	 */
	function __construct( $context, $election ) {
		$this->context = $context;
		$this->election = $election;
	}

	/**
	 * Get the HTML for this ballot. <form> tags should not be included,
	 * they will be added by the VotePage.
	 * @return string
	 */
	function getForm( $prevStatus = false ) {
		$questions = $this->election->getQuestions();
		if ( $this->election->getProperty( 'shuffle-questions' ) ) {
			shuffle( $questions );
		}
		$shuffleOptions = $this->election->getProperty( 'shuffle-options' );
		$this->setErrorStatus( $prevStatus );

		$s = '';
		foreach ( $questions as $question ) {
			$options = $question->getOptions();
			if ( $shuffleOptions ) {
				shuffle( $options );
			}
			$s .= "<hr/>\n" .
				$question->parseMessage( 'text' ) .
				$this->getQuestionForm( $question, $options ) .
				"\n";
		}
		if ( $prevStatus ) {
			$s = $this->formatStatus( $prevStatus ) . $s;
		}
		return $s;
	}

	function setErrorStatus( $status ) {
		if ( $status ) {
			$this->prevErrorIds = $status->sp_getIds();
			$this->prevStatus = $status;
		} else {
			$this->prevErrorIds = array();
		}
		$this->usedErrorIds = array();
	}

	function errorLocationIndicator( $id ) {
		if ( !isset( $this->prevErrorIds[$id] ) ) {
			return '';
		}
		$this->usedErrorIds[$id] = true;
		return 
			Xml::element( 'img', array(
				'src' => $this->context->getResourceUrl( 'warning-22.png' ),
				'width' => 22,
				'height' => 22,
				'id' => "$id-location",
				'class' => 'securepoll-error-location',
				'alt' => '',
				'title' => $this->prevStatus->sp_getMessageText( $id )
			) );
	}

	/**
	 * Convert a SecurePoll_BallotStatus object to HTML
	 */
	function formatStatus( $status ) {
		return $status->sp_getHTML( $this->usedErrorIds );
	}
	
	/**
	 * Get the way the voter cast their vote previously, if we're allowed
	 * to show that information.
	 * @return false on failure or if cast ballots are hidden, or the output
	 *     of unpackRecord().
	 */
	function getCurrentVote(){
		
		if( !$this->election->getOption( 'show-change' ) ){
			return false;
		}
			
		$auth = $this->election->getAuth();

		# Get voter from session
		$voter = $auth->getVoterFromSession( $this->election );
		# If there's no session, try creating one.
		# This will fail if the user is not authorised to vote in the election
		if ( !$voter ) {
			$status = $auth->newAutoSession( $this->election );
			if ( $status->isOK() ) {
				$voter = $status->value;
			} else {
				return false;
			}
		}
		
		$store = $this->context->getStore();
		$status = $store->callbackValidVotes(
			$this->election->info['id'],
			array( $this, 'getCurrentVoteCallback' ),
			$voter->getId()
		);
		if( !$status->isOK() ){
			return false;
		}
		
		return isset( $this->currentVote )
			? $this->unpackRecord( $this->currentVote )
			: false;
	}
	
	function getCurrentVoteCallback( $store, $record ){
		$this->currentVote = $record;
		return Status::newGood();
	}
}

class SecurePoll_BallotStatus extends Status {
	var $sp_context;
	var $sp_ids = array();

	function __construct( $context ) {
		$this->sp_context = $context;
	}

	function sp_fatal( $message, $id /*, parameters... */ ) {
		$params = array_slice( func_get_args(), 2 );
		$this->errors[] = array(
			'type' => 'error',
			'securepoll-id' => $id,
			'message' => $message,
			'params' => $params );
		$this->sp_ids[$id] = true;
		$this->ok = false;
	}

	function sp_getIds() {
		return $this->sp_ids;
	}

	function sp_getHTML( $usedIds ) {
		if ( !$this->errors ) {
			return '';
		}
		$s = '<ul class="securepoll-error-box">';
		foreach ( $this->errors as $error ) {
			$text = wfMsgReal( $error['message'], $error['params'] );
			if ( isset( $error['securepoll-id'] ) ) {
				$id = $error['securepoll-id'];
				if ( isset( $usedIds[$id] ) ) {
					$s .= '<li>' . 
						Xml::openElement( 'a', array(
							'href' => '#' . urlencode( "$id-location" ),
							'class' => 'securepoll-error-jump'
						) ) .
						Xml::element( 'img', array(
							'alt' => '',
							'src' => $this->sp_context->getResourceUrl( 'down-16.png' ),
						) ) .
						'</a>' . 
						htmlspecialchars( $text ) .
						"</li>\n";
					continue;
				}
			}
			$s .= '<li>' . htmlspecialchars( $text ) . "</li>\n";
		}
		$s .= "</ul>\n";
		$s .= '<script type="text/javascript"> securepoll_ballot_setup(); </script>';
		return $s;
	}

	function sp_getMessageText( $id ) {
		foreach ( $this->errors as $error ) {
			if ( $error['securepoll-id'] !== $id ) {
				continue;
			}
			return wfMsgReal( $error['message'], $error['params'] );
		}
	}
}
