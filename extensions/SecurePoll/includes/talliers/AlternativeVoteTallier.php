<?php

/**
 * Tallier for AlternativeVote system.
 */
class SecurePoll_AlternativeVoteTallier extends SecurePoll_Tallier {

	/**
	 * Array of ballot bins for each candidate
	 * @var array
	 */
	var $ballots = array();

	/**
	 * Votes which give the same preference to more than one candidate are considered
	 * spoilt; keep a count of these so scrutineers can check that the numbers add up
	 * array( <round number> => <number>
	 */
	var $spoilt = array( 1 => 0);
	var $exhausted = array( 1 => 0 );

	// Total number of counting rounds
	var $rounds = 0;

	// Total number of candidates who received any votes at all
	var $numCandidates = 0;

	/**
	 * The results of the counting process
	 * array( <option id> => array( <round number> => <votes> ) )
	 */
	var $results = array();


	/**
	 * @param  $context SecurePoll_Context
	 * @param  $electionTallier SecurePoll_ElectionTallier
	 * @param  $question SecurePoll_Question
	 */
	function __construct( $context, $electionTallier, $question ) {
		parent::__construct( $context, $electionTallier, $question );

		foreach ( $question->getOptions() as $option ) {
			$this->results[$option->getId()] = array();
		}
	}

	/**
	 * Add a voter's preferences to the ballot bin
	 *
	 * @param  $scores array of <option_id> => <preference>
	 * @return bool Whether the vote was parsed correctly
	 */
	function addVote( $scores ) {

		foreach ( $scores as $oid => $score ) {
			if ( !isset( $this->results[$oid] ) ) {
				wfDebug( __METHOD__.": unknown OID $oid\n" );
				return false;
			}
			// Score of zero = no preference
			if( $score == 0 ){
				unset( $scores[$oid] );
			}
		}

		$this->numCandidates = max( $this->numCandidates, count( $scores ) );

		// Simple way to check for duplicate preferences: flip the array, and the
		// preferences will become duplicate keys.
		$rscores = array_flip( $scores );
		if( count( $rscores ) < count( $scores ) ){
			wfDebug( __METHOD__.": vote has duplicate preferences, spoilt\n" );
			$this->spoilt[1] ++;
			return true;
		} elseif ( count( $rscores ) == 0 ) {
			wfDebug( __METHOD__.": vote is empty\n" );
			$this->exhausted[1]++;
			return true;
		}

		// Sorting also avoids any problem with voters skipping preferences (1, 2, 4, etc)
		ksort( $rscores );

		// Slightly ugly way to get the first element of the array when that might not
		// have index zero
		$this->ballots[reset($rscores)][] = $rscores;

		return true;
	}

	function finishTally(){
		while ( $this->rounds++ < $this->numCandidates ){
			// Record the number of ballots in each bin
			foreach( $this->ballots as $oid => $bin ){
				$this->results[$oid][$this->rounds] = count( $bin );
			}

			// Carry over exhausted ballot count from previous round
			$this->exhausted[$this->rounds + 1] = $this->exhausted[$this->rounds];
			$this->spoilt[$this->rounds + 1] = $this->spoilt[$this->rounds];

			// Sort the ballot bins by the number of ballots they contain
			uasort( $this->ballots, array( __CLASS__, 'sortByArraySize' ) );

			// The smallest bin is now at the end of the list; kill it
			$loser = array_pop( $this->ballots );

			// And redistribute its ballots to the other bins
			foreach( $loser as &$ballot ){
				$reused = false;
				foreach( $ballot as $pref => $oid ){
					if( !array_key_exists( $oid, $this->ballots ) ){
						unset( $ballot[$pref] );
					} else {
						$this->ballots[$oid][] = $ballot;
						$reused = true;
						break;
					}
				}
				if( !$reused ){
					$this->exhausted[$this->rounds + 1] ++;
				}
			}
		}

		// We marked every ballot as exhausted after the final round, which is a bit silly
		array_pop( $this->exhausted );
		array_pop( $this->spoilt );

		// Sort the results so the winner is on top
		uasort( $this->results, array( __CLASS__, 'sortByArraySize' ) );
	}

	public static function sortByArraySize( $a, $b ){
		if( !is_array( $a ) || !is_array( $b ) || count( $a ) == count( $b ) ){
			return 0;
		} else {
			return count( $a ) < count( $b );
		}
	}

	function getHtmlResult() {
		global $wgLang;

		$s = "<table class=\"securepoll-results\">\n";

		$lines = array();
		foreach( $this->results as $oid => $data ){
			$option = $this->optionsById[$oid];
			$res = implode( $data, '</td><td>' );
			$name = $option->parseMessageInline( 'text' );
			$lines[] = "<tr><th>$name</th><td>$res</td></tr>";
		}

		$t = '<th></th>';
		for( $i = 1; $i < $this->rounds; $i++ ){
			$ordinal = wfMsg( 'securepoll-round', $wgLang->romanNumeral( $i ) );
			$t .= "<th>$ordinal</th>";
		}

		$s .= "<tr>$t</tr>\n<tr>" . implode( $lines, "\n" ) . "</tr>\n";

		$exhausted = wfMsg( 'securepoll-exhausted' );
		$s .= "<tr class='securepoll-exhausted'><th>$exhausted</th>";
		$s .= "<td>" . implode( array_values( $this->exhausted ), "</td><td>" ) . "</td></tr>\n";

		$spoilt = wfMsg( 'securepoll-spoilt' );
		$s .= "<tr class='securepoll-spoilt'><th>$spoilt</th>";
		$s .= "<td>" . implode( array_values( $this->spoilt ), "</td><td>" ) . "</td></tr>\n";

		$s .= "</table>\n";
		return $s;
	}

	function getTextResult() {
		// Calculate column width
		$width = 10;
		foreach ( $this->results as $oid => $rank ) {
			$option = $this->optionsById[$oid];
			$width = min( 57, max( $width, strlen( $option->getMessage( 'text' ) ) ) );
		}

		// Show the results
		$qtext = $this->question->getMessage( 'text' );
		$s = '';
		if ( $qtext !== '' ) {
			$s .= wordwrap( $qtext ) . "\n";
		}

		foreach ( $this->results as $oid => $data ) {
			$option = $this->optionsById[$oid];
			$otext = $option->getMessage( 'text' );
			if ( strlen( $otext ) > $width ) {
				$otext = substr( $otext, 0, $width - 3 ) . '...';
			} else {
				$otext = str_pad( $otext, $width );
			}
			$s .= $otext . ' | ';
			$s .= implode( array_values( $data ), ' | ' ) . "\n";
		}
		return $s;
	}
}

