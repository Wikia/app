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
 * Processes poll markup in statistical mode (only to show the results)
 */
class qp_PollStats extends qp_AbstractPoll {

	function __construct( array $argv, qp_PollStatsView $view ) {
		parent::__construct( $argv, $view );
		$this->pollAddr = trim( $argv['address'] );
	}

	/**
	 * Set poll headers; checks poll headers for errors
	 * @return  string  error message to display;
	 *          boolean  true when no errors
	 */
	function setHeaders() {
		if ( $this->mPollId !== null ) {
			$this->mState = "error";
			return self::fatalErrorNoQuote( 'qp_error_id_in_stats_mode' );
		}
		if ( isset( $this->dependsOn ) && $this->dependsOn !== '' ) {
			$this->mState = "error";
			return self::fatalErrorNoQuote( 'qp_error_dependance_in_stats_mode' );
		}
		return true;
	}

	/**
	 * Prepares qp_PollStore object
	 * @return  boolean  true on success ($this->pollStore has been created successfully)
	 *          string  error message on failure
	 */
	function getPollStore() {
		$this->pollStore = qp_PollStore::newFromAddr( $this->pollAddr );
		if ( !( $this->pollStore instanceof qp_PollStore ) || $this->pollStore->pid === null ) {
			return self::fatalErrorQuote( 'qp_error_no_such_poll', $this->pollAddr );
		}
		if ( !$this->pollStore->loadQuestions() ) {
			$this->mState = "error";
			return self::fatalErrorQuote( 'qp_error_no_stats', $this->pollAddr );
		}
		$this->pollStore->setLastUser( $this->username );
		# do not check the result, because we may show results even if the user hasn't voted
		$this->pollStore->loadUserAlreadyVoted();
		return true;
	}

	/**
	 * Parses the text enclosed in poll tag
	 * @param    $input - text enclosed in poll tag
	 * @return   boolean true - stop further processing, false - continue processing
	 */
	function parseInput( $input ) {
		$this->questions = new qp_QuestionCollection();
		# match questions in statistical mode
		$unparsedAttributes = array();
		if ( preg_match_all( '/^\s*\{(.*?)\}\s*$/msu', $input, $matches ) ) {
			$unparsedAttributes = $matches[1];
			# increase key values of $unparsedAttributes by one,
			# because questions are numbered from one, not zero
			array_unshift( $unparsedAttributes, null );
			unset( $unparsedAttributes[0] );
		}
		# first pass: parse the headers
		foreach ( $this->pollStore->Questions as $qdata ) {
			$question = new qp_QuestionStats(
				$this,
				qp_QuestionStatsView::newFromBaseView( $this->view ),
				$qdata->type,
				$qdata->question_id
			);
			$attr_str = isset( $unparsedAttributes[$qdata->question_id] ) ?
				$unparsedAttributes[$qdata->question_id] :
				'';
			$paramkeys = array();
			$type = $this->getQuestionAttributes( $attr_str, $paramkeys );
			$question->applyAttributes( $paramkeys );
			if ( $type != '' ) {
				# there cannot be type attribute of question in statistical display mode
				$question->setState( 'error', wfMsg( 'qp_error_type_in_stats_mode', $type ) );
			}
			$this->questions->add( $question );
		}
		# analyze question headers
		# check for showresults attribute
		$questions_set = array();
		$this->questions->reset();
		while ( is_object( $question = $this->questions->iterate() ) ) {
			if ( $question->view->hasShowResults() ) {
				$questions_set[] = $question->mQuestionId;
			}
		}
		# load the statistics for all/selective/none of questions
		if ( count( $questions_set ) > 0 ) {
			if ( count( $questions_set ) == $this->questions->totalCount() ) {
				$this->pollStore->loadTotals();
			} else {
				$this->pollStore->loadTotals( $questions_set );
			}
			$this->pollStore->calculateStatistics();
		}
		# second pass: generate views
		$this->questions->reset();
		while ( is_object( $question = $this->questions->iterate() ) ) {
			$this->parseStats( $question );
		}
		return false;
	}

	# populate the question with data and build it's HTML representation
	# returns HTML representation of the question
	function parseStats( qp_QuestionStats $question ) {
		# parse the question body
		if ( $question->getQuestionAnswer( $this->pollStore ) ) {
			$question->statsParseBody();
		}
	}

} /* end of qp_PollStats class */

