<?php

/**
 * A ballot class which asks the user to choose one answer only from the 
 * given options, for each question.
 */
class SecurePoll_ChooseBallot extends SecurePoll_Ballot {
	/**
	 * Get a list of names of tallying methods, which may be used to produce a 
	 * result from this ballot type.
	 * @return array
	 */
	function getTallyTypes() {
		return array( 'plurality' );
	}

	/**
	 * Get the HTML form segment for a single question
	 * @param $question SecurePoll_Question
	 * @param $options Array of options, in the order they should be displayed
	 * @return string
	 */
	function getQuestionForm( $question, $options ) {
		$name = 'securepoll_q' . $question->getId();
		$s = '';
		foreach ( $options as $option ) {
			$optionHTML = $option->parseMessageInline( 'text' );
			$optionId = $option->getId();
			$radioId = "{$name}_opt{$optionId}";
			$s .= 
				'<div class="securepoll-option-choose">' .
				Xml::radio( $name, $optionId, false, array( 'id' => $radioId ) ) .
				'&#160;' .
				Xml::tags( 'label', array( 'for' => $radioId ), $optionHTML ) .
				"</div>\n";
		}
		return $s;
	}

	function submitQuestion( $question, $status ) {
		global $wgRequest;
		$result = $wgRequest->getInt( 'securepoll_q' . $question->getId() );
		if ( !$result ) {
			$status->fatal( 'securepoll-unanswered-questions' );
		} else {
			return $this->packRecord( $question->getId(), $result );
		}
	}

	function packRecord( $qid, $oid ) {
		return sprintf( 'Q%08XA%08X', $qid, $oid );
	}

	function unpackRecord( $record ) {
		$result = array();
		$record = trim( $record );
		for ( $offset = 0; $offset < strlen( $record ); $offset += 18 ) {
			if ( !preg_match( '/Q([0-9A-F]{8})A([0-9A-F]{8})/A', $record, $m, 0, $offset ) ) {
				wfDebug( __METHOD__.": regex doesn't match\n" );
				return false;
			}
			$qid = intval( base_convert( $m[1], 16, 10 ) );
			$oid = intval( base_convert( $m[2], 16, 10 ) );
			$result[$qid] = array( $oid => 1 );
		}
		return $result;
	}

	function convertScores( $scores, $params = array() ) {
		$s = '';
		foreach ( $this->election->getQuestions() as $question ) {
			$qid = $question->getId();
			if ( !isset( $scores[$qid] ) ) {
				return false;
			}
			if ( $s !== '' ) {
				$s .= '; ';
			}
			$oid = key( $scores );
			$option = $this->election->getOption( $oid );
			$s .= $option->getMessage( 'name' );
		}
		return $s;
	}
}

