<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of QPoll.
 * Uses parts of code from Quiz extension (c) 2007 Louis-Rémi BABE. All rights reserved.
 *
 * QPoll is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * QPoll is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with QPoll; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * QPoll is a poll tool for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named QPoll into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/QPoll/qp_user.php";
 *
 * @version 0.8.0a
 * @link http://www.mediawiki.org/wiki/Extension:QPoll
 * @author QuestPC <questpc@rambler.ru>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * PEAR Excel helper / wrapper
 *
 */
class qp_XlsPoll extends qp_XlsWriter {

	var $tabular_writer;
	var $text_writer;

	function __construct( $xls_fname = null ) {
		parent::__construct( $xls_fname );
		# Create question writers; Single instances will be re-used in the top loop.
		# They are sharing the same instance of Spreadsheet_Excel_Writer_Worksheet.
		# We do not use class with static properties and methods only because
		# such class names cannot be accessed by reference in PHP < 5.3.0:
		# http://php.net/manual/en/language.oop5.static.php
		# "As of PHP 5.3.0, it's possible to reference the class using a variable.
		# The variable's value can not be a keyword (e.g. self, parent and static)."
		$this->tabular_writer = new qp_XlsTabularQuestion();
		$this->text_writer = new qp_XlsTextQuestion();
	}

	function writeHeader( $totalUsersAnsweredQuestion ) {
		$this->write( 0, $totalUsersAnsweredQuestion, 'heading' );
		$this->writeLn( 1, wfMsgExt( 'qp_users_answered_questions', array( 'parsemag' ), $totalUsersAnsweredQuestion ), 'heading' );
		$this->nextRow();
	}

	function voicesToXls( qp_PollStore $pollStore ) {
		$pollStore->loadQuestions();
		$first_question = true;
		foreach ( $pollStore->Questions as $qkey => $qdata ) {
			$xlsq = ( $qdata->type === 'textQuestion' ) ? $this->text_writer : $this->tabular_writer;
			$xlsq->setQuestionData( $qdata );
			if ( $first_question ) {
				$this->writeHeader( $pollStore->totalUsersAnsweredQuestion( $qdata ) );
			} else {
				# get maximum count of voters of the first question
				$total_voters = $first_question_voters;
			}
			$xlsq->writeHeader();
			$voters = array();
			$offset = 0;
			# iterate through the voters of the current poll (there might be many)
			while ( ( $limit = count( $voters = $pollStore->pollVotersPager( $offset ) ) ) > 0 ) {
				if ( !$first_question ) {
					# do not export more user voices than first question has
					for ( $total_voters -= $limit; $total_voters < 0 && $limit > 0; $total_voters++, $limit-- ) {
						array_pop( $voters );
					}
					if ( count( $voters ) === 0 ) {
						break;
					}
				}
				$uvoices = $pollStore->questionVoicesRange( $qdata->question_id, array_keys( $voters ) );
				# get each of proposal votes for current uid
				foreach ( $uvoices as $uid => &$pvoices ) {
					$xlsq->writeQuestionVoice( $pvoices );
				}
				if ( !$first_question && $total_voters < 1 ) {
					# break on reaching the count of first question user voices
					break;
				}
				$offset += $limit;
			}
			if ( $first_question ) {
				# store maximum count of voters of the first question
				$first_question_voters = $offset;
				$first_question = false;
			}
		}
	}

	function statsToXls( qp_PollStore $pollStore ) {
		$pollStore->loadQuestions();
		$pollStore->loadTotals();
		$pollStore->calculateStatistics();
		$first_question = true;
		foreach ( $pollStore->Questions as $qkey => $qdata ) {
			$xlsq = ( $qdata->type === 'textQuestion' ) ? $this->text_writer : $this->tabular_writer;
			$xlsq->setQuestionData( $qdata );
			if ( $first_question ) {
				$this->writeHeader( $pollStore->totalUsersAnsweredQuestion( $qdata ) );
				$first_question = false;
			}
			$xlsq->writeHeader();
			$percentsTable = array();
			$spansUsed = count( $qdata->CategorySpans ) > 0 || $qdata->type == "multipleChoice";
			$xlsq->writeQuestionStats();
		}
	}

	function interpretationToXLS( qp_PollStore $pollStore ) {
		$offset = 0;
		# iterate through the voters of the current poll (there might be many)
		while ( ( $limit = count( $voters = $pollStore->pollVotersPager( $offset ) ) ) > 0 ) {
			foreach ( $voters as &$voter ) {
				if ( $voter['interpretation']->short != '' ) {
					$this->writeLn( 0, wfMsg( 'qp_results_short_interpretation' ), 'heading' );
					$this->writeLn( 0, $voter['interpretation']->short );
				}
				if ( $voter['interpretation']->structured != '' ) {
					$this->writeLn( 0, wfMsg( 'qp_results_structured_interpretation' ), 'heading' );
					$strucTable = $voter['interpretation']->getStructuredAnswerTable();
					foreach ( $strucTable as &$line ) {
						if ( isset( $line['keys'] ) ) {
							# current node is associative array
							$this->writeRowLn( 0, $line['keys'], 'odd' );
							$this->writeRowLn( 0, $line['vals'] );
						} else {
							$this->writeLn( 0, $line['vals'] );
						}
					}
					$this->nextRow();
				}
			}
			$offset += $limit;
		}
	}

} /* end of qp_XlsPoll class */
