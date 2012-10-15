<?php

/**
 * Checkbox approval voting.
 */
class SecurePoll_ApprovalBallot extends SecurePoll_Ballot {
	function getTallyTypes() {
		return array( 'plurality' );
	}
	
	function getQuestionForm( $question, $options ) {
		global $wgRequest;
		$name = 'securepoll_q' . $question->getId();
		$s = '';
		foreach ( $options as $option ) {
			$optionHTML = $option->parseMessageInline( 'text' );
			$optionId = $option->getId();
			$inputId = "{$name}_opt{$optionId}";
			$oldValue = $wgRequest->getBool( $inputId );
			$s .= 
				'<div class="securepoll-option-approval">' .
				Xml::check( $inputId, $oldValue, array( 'id' => $inputId ) ) .
				'&#160;' .
				Xml::tags( 'label', array( 'for' => $inputId ), $optionHTML ) .
				'&#160;' .
				"</div>\n";
		}
		return $s;
	}

	function submitQuestion( $question, $status ) {
		global $wgRequest;

		$options = $question->getOptions();
		$record = '';
		foreach ( $options as $option ) {
			$id = 'securepoll_q' . $question->getId() . '_opt' . $option->getId();
			$checked = $wgRequest->getBool( $id );
			$record .= sprintf( 'Q%08X-A%08X-%s--',
				$question->getId(), $option->getId(), $checked ? 'y' : 'n' );
		}
		return $record;
	}

	function unpackRecord( $record ) {
		$scores = array();
		$itemLength = 2*8 + 7;
		for ( $offset = 0; $offset < strlen( $record ); $offset += $itemLength ) {
			if ( !preg_match( '/Q([0-9A-F]{8})-A([0-9A-F]{8})-([yn])--/A', 
				$record, $m, 0, $offset ) ) 
			{
				wfDebug( __METHOD__.": regex doesn't match\n" );
				return false;
			}
			$qid = intval( base_convert( $m[1], 16, 10 ) );
			$oid = intval( base_convert( $m[2], 16, 10 ) );
			$score = ( $m[3] === 'y' ) ? 1 : 0;
			$scores[$qid][$oid] = $score;
		}
		return $scores;
	}

	function convertScores( $scores, $params = array() ) {
		$result = array();
		foreach ( $this->election->getQuestions() as $question ) {
			$qid = $question->getId();
			if ( !isset( $scores[$qid] ) ) {
				return false;
			}
			$s = '';
			$qscores = $scores[$qid];
			ksort( $qscores );
			$first = true;
			foreach ( $qscores as $score ) {
				if ( $first ) {
					$first = false;
				} else {
					$s .= ', ';
				}
				$s .= $score ? 'y' : 'n';
			}
			$result[$qid] = $s;
		}
		return $result;
	}
		
}

