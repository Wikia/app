<?php

/**
 * A helper class for tallying a whole election (with multiple questions).
 * Most of the functionality is contained in the SecurePoll_Tallier subclasses
 * which operate on a single question at a time.
 *
 * A convenience function for accessing this class is 
 * SecurePoll_Election::tally().
 */
class SecurePoll_ElectionTallier {
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
	 * Do the tally. Returns a Status object. On success, the value property 
	 * of the status will be an array of SecurePoll_Tallier objects, which can
	 * be queried for results information.
	 */
	function execute() {
		$store = $this->context->getStore();
		$this->crypt = $this->election->getCrypt();
		$this->ballot = $this->election->getBallot();
		$questions = $this->election->getQuestions();
		$this->talliers = array();
		$tallyType = $this->election->getTallyType();
		foreach ( $questions as $question ) {
			$tallier = $this->context->newTallier( $tallyType, $this, $question );
			if ( !$tallier ) {
				throw new MWException( 'Invalid tally type' );
			}
			$this->talliers[$question->getId()] = $tallier;
		}

		$status = $store->callbackValidVotes( $this->election->getId(), array( $this, 'addRecord' ) );
		if ( !$status->isOK() ) {
			return $status;
		}

		foreach ( $this->talliers as $tallier ) {
			$tallier->finishTally();
		}
		return Status::newGood( $this->talliers );
	}

	/**
	 * Add a record. This is the callback function for SecurePoll_Store::callbackValidVotes(). 
	 * On error, the Status object returned here will be passed through back to 
	 * the caller of callbackValidVotes().
	 *
	 * @param $store SecurePoll_Store
	 * @param $record string Encrypted, packed record.
	 * @return Status
	 */
	function addRecord( $store, $record ) {
		# Decrypt and unpack
		if ( $this->crypt ) {
			$status = $this->crypt->decrypt( $record );
			if ( !$status->isOK() ) {
				return $status;
			}
			$record = $status->value;
		}
		$record = rtrim( $record );
		$scores = $this->ballot->unpackRecord( $record );

		# Add the record to the underlying question-specific tallier objects
		foreach ( $this->election->getQuestions() as $question ) {
			$qid = $question->getId();
			if ( !isset( $scores[$qid] ) ) {
				return Status::newFatal( 'securepoll-tally-error' );
			}
			if ( !$this->talliers[$qid]->addVote( $scores[$qid] ) ) {
				return Status::newFatal( 'securepoll-tally-error' );
			}
		}
		return Status::newGood();
	}

	/**
	 * Get HTML formatted results for this tally. Should only be called after 
	 * execute().
	 */
	function getHtmlResult() {
		$s = '';
		foreach ( $this->election->getQuestions() as $question ) {
			if ( $s !== '' ) {
				$s .= "<hr/>\n";
			}
			$tallier = $this->talliers[$question->getId()];
			$s .= $tallier->getHtmlResult();
		}
		return $s;
	}

	/**
	 * Get text formatted results for this tally. Should only be called after 
	 * execute().
	 */
	function getTextResult() {
		$s = '';
		foreach ( $this->election->getQuestions() as $question ) {
			if ( $s !== '' ) {
				$s .= "\n";
			}
			$tallier = $this->talliers[$question->getId()];
			$s .= $tallier->getTextResult();
		}
		return $s;
	}
}

