<?php

/**
 * Tallier that supports choose-one, approval and range voting
 */
class SecurePoll_PluralityTallier extends SecurePoll_Tallier {
	var $tally = array();

	/**
	 * @param  $context SecurePoll_Context
	 * @param  $electionTallier SecurePoll_ElectionTallier
	 * @param  $question SecurePoll_Question
	 */
	function __construct( $context, $electionTallier, $question ) {
		parent::__construct( $context, $electionTallier, $question );
		foreach ( $question->getOptions() as $option ) {
			$this->tally[$option->getId()] = 0;
		}
	}

	function addVote( $scores ) {
		foreach ( $scores as $oid => $score ) {
			if ( !isset( $this->tally[$oid] ) ) {
				wfDebug( __METHOD__.": unknown OID $oid\n" );
				return false;
			}
			$this->tally[$oid] += $score;
		}
		return true;
	}

	function finishTally() {
		// Sort the scores
		arsort( $this->tally );
	}

	function getHtmlResult() {
		// Show the results
		$s = "<table class=\"securepoll-results\">\n";

		foreach ( $this->tally as $oid => $rank ) {
			$option = $this->optionsById[$oid];
			$s .= '<tr><td>' . $option->parseMessageInline( 'text' ) . "</td>\n" .
				'<td>' . $this->tally[$oid] . "</td>\n" .
				"</tr>\n";
		}
		$s .= "</table>\n";
		return $s;
	}

	function getTextResult() {
		// Calculate column width
		$width = 10;
		foreach ( $this->tally as $oid => $rank ) {
			$option = $this->optionsById[$oid];
			$width = max( $width, strlen( $option->getMessage( 'text' ) ) );
		}
		if ( $width > 57 ) {
			$width = 57;
		}

		// Show the results
		$qtext = $this->question->getMessage( 'text' );
		$s = '';
		if ( $qtext !== '' ) {
			$s .= wordwrap( $qtext ) . "\n";
		}
		foreach ( $this->tally as $oid => $rank ) {
			$option = $this->optionsById[$oid];
			$otext = $option->getMessage( 'text' );
			if ( strlen( $otext ) > $width ) {
				$otext = substr( $otext, 0, $width - 3 ) . '...';
			} else {
				$otext = str_pad( $otext, $width );
			}
			$s .= $otext . ' | ' . 
				$this->tally[$option->getId()] . "\n";
		}
		return $s;
	}

	function getRanks() {
		$ranks = array();
		$currentRank = 1;
		$oids = array_keys( $this->tally );
		$scores = array_values( $this->tally );
		foreach ( $oids as $i => $oid ) {
			if ( $i > 0 && $scores[$i-1] !== $scores[$i] ) {
				$currentRank = $i + 1;
			}
			$ranks[$oid] = $currentRank;
		}
		return $ranks;
	}
}

