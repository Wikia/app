<?php

class SecurePoll_HistogramRangeTallier extends SecurePoll_Tallier {
	var $histogram = array();
	var $sums = array();
	var $counts = array();
	var $averages;
	var $minScore, $maxScore;

	function __construct( $context, $electionTallier, $question ) {
		parent::__construct( $context, $electionTallier, $question );
		$this->minScore = intval( $question->getProperty( 'min-score' ) );
		$this->maxScore = intval( $question->getProperty( 'max-score' ) );
		if ( $this->minScore >= $this->maxScore ) {
			throw new MWException( __METHOD__.': min-score/max-score configured incorrectly' );
		}

		foreach ( $question->getOptions() as $option ) {
			$this->histogram[$option->getId()] = 
				array_fill( $this->minScore, $this->maxScore - $this->minScore + 1, 0 );
			$this->sums[$option->getId()] = 0;
			$this->counts[$option->getId()] = 0;
		}
	}

	function addVote( $scores ) {
		foreach ( $scores as $oid => $score ) {
			$this->histogram[$oid][$score] ++;
			$this->sums[$oid] += $score;
			$this->counts[$oid] ++;
		}
		return true;
	}

	function finishTally() {
		$this->averages = array();
		foreach ( $this->sums as $oid => $sum ) {
			if ( $this->counts[$oid] === 0 ) {
				$this->averages[$oid] = 'N/A';
				break;
			}
			$this->averages[$oid] = $sum / $this->counts[$oid];
		}
		arsort( $this->averages );
	}

	function getHtmlResult() {
		$ballot = $this->election->getBallot();
		if ( !is_callable( array( $ballot, 'getColumnLabels' ) ) ) {
			throw new MWException( __METHOD__.': ballot type not supported by this tallier' );
		}
		$optionLabels = array();
		foreach ( $this->question->getOptions() as $option ) {
			$optionLabels[$option->getId()] = $option->parseMessageInline( 'text' );
		}

		$labels = $ballot->getColumnLabels( $this->question );
		$s = "<table class=\"securepoll-table\">\n" .
			"<tr>\n" .
			"<th>&#160;</th>\n";
		foreach ( $labels as $label ) {
			$s .= Xml::element( 'th', array(), $label ) . "\n";
		}
		$s .= Xml::element( 'th', array(), wfMsg( 'securepoll-average-score' ) );
		$s .= "</tr>\n";
		
		foreach ( $this->averages as $oid => $average ) {
			$s .= "<tr>\n" . 
				Xml::tags( 'td', array( 'class' => 'securepoll-results-row-heading' ),
					$optionLabels[$oid] ) .
				"\n";
			foreach ( $labels as $score => $label ) {
				$s .= Xml::element( 'td', array(), $this->histogram[$oid][$score] ) . "\n";
			}
			$s .= Xml::element( 'td', array(), $average ) . "\n";
			$s .= "</tr>\n";
		}
		$s .= "</table>\n";
		return $s;
	}

	function getTextResult() {
		return $this->getHtmlResult();
	}
}

