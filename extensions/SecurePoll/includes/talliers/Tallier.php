<?php

/**
 * Base class for objects which tally individual questions.
 * See SecurePoll_ElectionTallier for an object which can tally multiple 
 * questions.
 */
abstract class SecurePoll_Tallier {
	var $context, $question, $electionTallier, $election, $optionsById;

	abstract function addVote( $scores );
	abstract function getHtmlResult();
	abstract function getTextResult();

	abstract function finishTally();

	static function factory( $context, $type, $electionTallier, $question ) {
		switch ( $type ) {
		case 'plurality':
			return new SecurePoll_PluralityTallier( $context, $electionTallier, $question );
		case 'schulze':
			return new SecurePoll_SchulzeTallier( $context, $electionTallier, $question );
		case 'histogram-range':
			return new SecurePoll_HistogramRangeTallier( $context, $electionTallier, $question );
		case 'alternative-vote':
			return new SecurePoll_AlternativeVoteTallier( $context, $electionTallier, $question );
		default:
			throw new MWException( "Invalid tallier type: $type" );
		}
	}

	/**
	 * @param  $context SecurePoll_Context
	 * @param  $electionTallier SecurePoll_ElectionTallier
	 * @param  $question SecurePoll_Question
	 */
	function __construct( $context, $electionTallier, $question ) {
		$this->context = $context;
		$this->question = $question;
		$this->electionTallier = $electionTallier;
		$this->election = $electionTallier->election;
		foreach ( $this->question->getOptions() as $option ) {
			$this->optionsById[$option->getId()] = $option;
		}
	}

	function convertRanksToHtml( $ranks ) {
		$s = "<table class=\"securepoll-table\">";
		$ids = array_keys( $ranks );
		foreach ( $ids as $i => $oid ) {
			$rank = $ranks[$oid];
			$prevRank = isset( $ids[$i-1] ) ? $ranks[$ids[$i-1]] : false;
			$nextRank = isset( $ids[$i+1] ) ? $ranks[$ids[$i+1]] : false;
			if ( $rank === $prevRank || $rank === $nextRank ) {
				$rank .= '*';
			}

			$option = $this->optionsById[$oid];
			$s .= "<tr>" .
				Xml::element( 'td', array(), $rank ) .
				Xml::element( 'td', array(), $option->parseMessage( 'text' ) ) .
				"</tr>\n";
		}
		$s .= "</table>";
		return $s;
	}

	function convertRanksToText( $ranks ) {
		$s = '';
		$ids = array_keys( $ranks );
		$colWidth = 6;
		foreach ( $this->optionsById as $option ) {
			$colWidth = max( $colWidth, $option->getMessage( 'text' ) );
		}

		foreach ( $ids as $i => $oid ) {
			$rank = $ranks[$oid];
			$prevRank = isset( $ids[$i-1] ) ? $ranks[$ids[$i-1]] : false;
			$nextRank = isset( $ids[$i+1] ) ? $ranks[$ids[$i+1]] : false;
			if ( $rank === $prevRank || $rank === $nextRank ) {
				$rank .= '*';
			}

			$option = $this->optionsById[$oid];
			$s .= str_pad( $rank, 6 ) . ' | ' . 
				$option->getMessage( 'text' ) . "\n";
		}
		return $s;
	}
}



