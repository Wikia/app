<?php

class qp_XlsTabularQuestion extends qp_XlsWriter {

	var $qdata;

	var $spansUsed;

	function setQuestionData( qp_QuestionData $qdata ) {
		$this->qdata = $qdata;
		$this->spansUsed = count( $qdata->CategorySpans ) > 0 || $qdata->type == 'multipleChoice';
	}

	function writeHeader() {
		$col = 0;
		$this->write( $col++, $this->qdata->question_id, 'heading' );
		if ( $this->qdata->name !== null ) {
			$this->write( $col, $this->qdata->name, 'heading' );
		}
		$this->writeLn( ++$col, $this->qdata->CommonQuestion, 'heading' );
		if ( count( $this->qdata->CategorySpans ) > 0 ) {
			$row = array();
			foreach ( $this->qdata->CategorySpans as &$span ) {
				$row[] = $span['name'];
				for ( $i = 1; $i < $span['count']; $i++ ) {
					$row[] = '';
				}
			}
			$this->writeRowLn( 0, $row );
		}
		$row = array();
		foreach ( $this->qdata->Categories as &$categ ) {
			$row[] = $categ['name'];
		}
		$this->writeRowLn( 0, $row );
	}

	function writeQuestionVoice( array $pvoices ) {
		$qdata = $this->qdata;
		# create square table of proposal / category answers for each uid in uvoices array
		$voicesTable = array();
		foreach ( $qdata->ProposalText as $propkey => &$proposal_text ) {
			$row = array_fill( 0, count( $qdata->Categories ), '' );
			if ( isset( $pvoices[$propkey] ) ) {
				foreach ( $pvoices[$propkey] as $catkey => $text_answer ) {
					$row[$catkey] = $text_answer;
				}
				if ( $this->spansUsed ) {
					foreach ( $row as $catkey => &$cell ) {
						$cell = array( 0 => $cell );
						if ( $qdata->type == 'multipleChoice' ) {
							$cell['format'] = ( ( $catkey & 1 ) === 0 ) ? 'even' : 'odd';
						} else {
							$cell['format'] = ( ( $qdata->Categories[ $catkey ][ "spanId" ] & 1 ) === 0 ) ? 'even' : 'odd';
						}
					}
				}
			}
			$voicesTable[] = $row;
		}
		$this->writeFormattedTable( 0, $voicesTable, 'answer' );
		$row = array();
		foreach ( $qdata->ProposalText as $ptext ) {
			$row[] = $ptext;
		}
		$this->writeCol( count( $qdata->Categories ), $row );
		$this->relRow( count( $qdata->ProposalText ) + 1 );
	}

	function writeQuestionStats() {
		$qdata = $this->qdata;
		foreach ( $qdata->ProposalText as $propkey => &$proposal_text ) {
			if ( isset( $qdata->Percents[ $propkey ] ) ) {
				$row = $qdata->Percents[ $propkey ];
				foreach ( $row as $catkey => &$cell ) {
					$cell = array( 0 => $cell );
					if ( $this->spansUsed ) {
						if ( $qdata->type == 'multipleChoice' ) {
							$cell['format'] = ( ( $catkey & 1 ) === 0 ) ? 'even' : 'odd';
						} else {
							$cell['format'] = ( ( $qdata->Categories[ $catkey ][ "spanId" ] & 1 ) === 0 ) ? 'even' : 'odd';
						}
					}
				}
			} else {
				$row = array_fill( 0, count( $qdata->Categories ), '' );
			}
			$percentsTable[] = $row;
		}
		$this->writeFormattedTable( 0, $percentsTable, 'percent' );
		$row = array();
		foreach ( $qdata->ProposalText as $ptext ) {
			$row[] = $ptext;
		}
		$this->writeCol( count( $qdata->Categories ), $row );
		$this->relRow( count( $qdata->ProposalText ) + 1 );
	}

} /* end of qp_XlsTabularQuestion class */
