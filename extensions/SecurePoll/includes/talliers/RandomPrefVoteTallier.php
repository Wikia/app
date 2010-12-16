<?php

/**
 * A tallier which gives a tie-breaking ranking of candidates (TBRC) by 
 * selecting random preferential votes. Untested.
 */
abstract class SecurePoll_RandomPrefVoteTallier {
	var $records, $random;

	function addVote( $vote ) {
		$this->records[] = $vote;
	}

	function getTBRCMatrix() {
		$tbrc = array();
		$marked = array();

		$random = $this->context->getRandom();
		$status = $random->open();
		if ( !$status->isOK() ) {
			throw new MWException( "Unable to open random device for TBRC ranking" );
		}

		# Random ballot round
		$numCands = count( $this->optionIds );
		$numPairsRanked = 0;
		$numRecordsUsed = 0;
		while ( $numRecordsUsed < count( $this->records )
			&& $numPairsRanked < $numCands * $numCands ) 
		{
			# Pick the record
			$recordIndex = $random->getInt( $numCands - $numRecordsUsed );
			$ranks = $this->records[$recordIndex];
			$numRecordsUsed++;

			# Swap it to the end
			$destIndex = $numCands - $numRecordsUsed;
			$this->records[$recordIndex] = $this->records[$destIndex];
			$this->records[$destIndex] = $ranks;

			# Apply its rankings
			foreach ( $this->optionIds as $oid1 ) {
				if ( !isset( $ranks[$oid1] ) ) {
					throw new MWException( "Invalid vote record, missing option $oid1" );
				}
				foreach ( $this->optionIds as $oid2 ) {
					if ( isset( $marked[$oid1][$oid2] ) ) {
						// Already ranked
						continue;
					}

					if ( $oid1 == $oid2 ) {
						# Same candidate, no win
						$tbrc[$oid1][$oid2] = false;
					} elseif ( $ranks[$oid1] < $ranks[$oid2] ) {
						# oid1 win
						$tbrc[$oid1][$oid2] = true;
					} elseif ( $ranks[$oid2] < $ranks[$oid1] ) {
						# oid2 win
						$tbrc[$oid1][$oid2] = false;
					} else {
						# Tie, don't mark
						continue;
					}
					$marked[$oid1][$oid2] = true;
					$numPairsRanked++;
				}
			}
		}

		# Random win round
		if ( $numPairsRanked < $numCands * $numCands ) {
			$randomRanks = $random->shuffle( $this->optionIds );
			foreach ( $randomRanks as $oidWin ) {
				if ( $numPairsRanked >= $numCands * $numCands ) {
					# Done
					break;
				}
				foreach ( $this->optionIds as $oidOther ) {
					if ( !isset( $marked[$oidWin][$oidOther] ) ) {
						$tbrc[$oidWin][$oidOther] = true;
						$marked[$oidWin][$oidOther] = true;
						$numPairsRanked++;
					}
					if ( !isset( $marked[$oidOther][$oidWin] ) ) {
						$tbrc[$oidOther][$oidWin] = false;
						$marked[$oidOther][$oidWin] = true;
						$numPairsRanked++;
					}
				}
			}
		}

		return $tbrc;
	}
}

