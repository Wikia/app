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

class qp_FunctionsHook {

	var $frame;
	var $args;

	var $pollAddr;
	var $pollStore;
	var $question_id = '';
	var $proposal_id = '';
	var $defaultProposalText;

	var $error_message = 'no_such_poll';

	function qpuserchoice( Parser &$parser, PPFrame $frame, array $args ) {
		$this->frame = $frame;
		$this->args = &$args;
		if ( isset( $args[ 0 ] ) ) {
			# args[0] is a poll address
			$this->pollAddr = trim( $this->frame->expand( $this->args[ 0 ] ) );
			$this->pollStore = qp_PollStore::newFromAddr( $this->pollAddr );
			if ( $this->pollStore instanceof qp_PollStore && $this->pollStore->pid !== null ) {
				$this->error_message = 'missing_question_id';
				if ( isset( $args[ 1 ] ) ) {
					# args[1] is question_id
					$qdata = $this->getQuestionData( trim( $frame->expand( $args[ 1 ] ) ) );
					if ( $qdata instanceof qp_QuestionData ) {
						$this->error_message = 'missing_proposal_id';
						if ( isset( $args[ 2 ] ) ) {
							# get poll's proposal choice
							$this->proposal_id = trim( $frame->expand( $args[ 2 ] ) );
							$this->error_message = 'invalid_proposal_id';
							if ( preg_match( qp_Setup::PREG_NON_NEGATIVE_INT4_MATCH, $this->proposal_id ) ) {
								$this->defaultProposalText = isset( $args[ 3 ] ) ? trim( $frame->expand( $args[ 3 ] ) ) : '';
								$this->proposal_id = intval( $this->proposal_id );
								$this->error_message = 'missing_proposal_id';
								if ( array_key_exists( $this->proposal_id, $qdata->ProposalText ) ) {
									return $this->qpuserchoiceValidResult( $qdata );
								}
							}
						}
					}
				}
			}
		}
		return '<strong class="error">qpuserchoice: ' . wfMsgHTML( 'qp_func_' . $this->error_message, qp_Setup::specialchars( $this->pollAddr ), qp_Setup::specialchars( $this->question_id ), qp_Setup::specialchars( $this->proposal_id ) ) . '</strong>';
	}

	function getQuestionData( $qid ) {
		$this->question_id = $qid;
		$this->error_message = 'invalid_question_id';
		if ( preg_match( qp_Setup::PREG_POSITIVE_INT4_MATCH, $this->question_id ) ) {
			$this->question_id = intval( $this->question_id );
			$this->pollStore->loadQuestions();
			$this->pollStore->setLastUser( qp_Setup::getCurrUserName() );
			$this->pollStore->loadUserVote();
			$this->error_message = 'missing_question_id';
			if ( array_key_exists( $this->question_id, $this->pollStore->Questions ) ) {
				return $this->pollStore->Questions[ $this->question_id ];
			}
		}
		return false;
	}

	function qpuserchoiceValidResult( qp_QuestionData $qdata ) {
		$result = '';
		if ( array_key_exists( $this->proposal_id, $qdata->ProposalCategoryId ) ) {
			foreach ( $qdata->ProposalCategoryId[ $this->proposal_id ] as $id_key => $cat_id ) {
				if ( $result != '' ) {
					$result .= '~';
				}
				if ( $this->defaultProposalText == '$' ) {
					$result .= $cat_id;
				} else {
					$text_answer = $qdata->ProposalCategoryText[ $this->proposal_id ][ $id_key ];
					if ( $text_answer != '' ) {
						$result .= $text_answer;
					} else {
						$cat_name = isset( $this->args[ $cat_id + 4 ] ) ? trim( $this->frame->expand( $this->args[ $cat_id + 4 ] ) ) : '';
						if ( $cat_name != '' ) {
							$result .= $cat_name;
						} else {
							if ( $this->defaultProposalText != '' ) {
								$result .= $this->defaultProposalText;
							} else {
								$result .= $qdata->Categories[$cat_id]['name'];
								if ( isset( $qdata->Categories[$cat_id]['spanId'] ) ) {
									$spanId = $qdata->Categories[$cat_id]['spanId'];
									$result .= '(' . $qdata->CategorySpans[$spanId]['name'] . ')';
								}
							}
						}
					}
				}
			}
		}
		# do not need to wrap the result into qp_Setup::entities()
		# because the result is a wikitext (will be escaped by parser)
		return $result;
	}

}