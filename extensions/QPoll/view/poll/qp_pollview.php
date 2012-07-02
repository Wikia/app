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

/**
 * Stores poll views and renders these
 * todo: transfer view logic completely from controllers
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

class qp_PollView extends qp_AbstractPollView {

	function isCompatibleController( $ctrl ) {
		return method_exists( $ctrl, 'parsePoll' );
	}

	/**
	 * Renders question views
	 * todo: move this code into separate poll view
	 */
	function renderQuestionViews() {
		$write_row = array();
		$write_col = array();
		# render the body
		$this->ctrl->questions->reset();
		while ( is_object( $question = $this->ctrl->questions->iterate() ) ) {
			$question->view->renderInterpErrors();
			if ( $this->perRow > 1 ) {
				$write_col[] = array( '__tag' => 'td', 'valign' => 'top', 0 => $question->view->renderQuestion(), '__end' => "\n" );
				if ( $this->currCol == 1 ) {
					$write_row[] = array( '__tag' => 'tr', 0 => $write_col, '__end' => "\n" );
					$write_col = array();
				}
				if ( --$this->currCol < 1 ) {
					$this->currCol = $this->perRow;
				}
			} else {
				$write_row[] = $question->view->renderQuestion();
			}
			# question object is not needed anymore
			unset( $question );
		}
		if ( $this->perRow > 1 && $this->currCol != $this->perRow ) {
			# add last incomplete row
			$write_row[] = array( '__tag' => 'tr', '__end' => "\n", 0 => $write_col );
		}
		if ( $this->perRow > 1 ) {
			$question_table = array( '__tag' => 'table', 0 => array( '__tag' => 'tbody', 0 => &$write_row, '__end' => "\n" ), '__end' => "\n" );
			return qp_Renderer::renderTagArray( $question_table );
		} else {
			return qp_Renderer::renderTagArray( $write_row );
		}
	}

	/**
	 * Encloses the output of $this->renderQuestionViews() into the output tag wrappers
	 * @return  rendered "final" html
	 */
	function renderPoll() {
		$pollStore = $this->ctrl->pollStore;
		# Generates the output.
		$qpoll_div = array( '__tag' => 'div', 'class' => 'qpoll' );
		$qpoll_div[] = array( '__tag' => 'a', 'name' => $this->ctrl->getPollTitleFragment( null, '' ), 0 => '' );
		# output script-generated error, when available
		# render short/long/structured result, when permitted and available
		$interpResultView = qp_InterpResultView::newFromBaseView( $this );
		$interpResultView->showInterpResults( $qpoll_div, $pollStore->interpResult );
		# unused anymore
		unset( $interpResultView );
		# create voting form and fill it with messages and inputs
		$qpoll_form = array( '__tag' => 'form', 'method' => 'post', 'action' => $this->ctrl->getPollTitleFragment(), 'autocomplete' => 'off', '__end' => "\n" );
		$qpoll_div[] = &$qpoll_form;
		# Determine the content of the settings table.
		$settings = Array();
		if ( $this->ctrl->mState != '' ) {
			$settings[0][] = array( '__tag' => 'td', 'class' => 'margin object_error' );
			$settings[0][] = array( '__tag' => 'td', 0 => wfMsgHtml( 'qp_result_' . $this->ctrl->mState ) );
		}
		# Build the settings table.
		if ( count( $settings ) > 0 ) {
			$settingsTable = array( '__tag' => 'table', 'class' => 'settings', '__end' => "\n" );
			foreach ( $settings as $settingsTr ) {
				$settingsTable[] = array( '__tag' => 'tr', 0 => $settingsTr, '__end' => "\n" );
			}
			$qpoll_form[] = &$settingsTable;
		}
		$qpoll_form[] = array( '__tag' => 'input', 'type' => 'hidden', 'name' => 'pollId', 'value' => $this->ctrl->mPollId );
		$qpoll_form[] = array( '__tag' => 'div', 'class' => 'pollQuestions', 0 => $this->renderQuestionViews() );
		$submitBtn = array( '__tag' => 'input', 'type' => 'submit' );
		$submitMsg = 'qp_vote_button';
		if ( $pollStore->isAlreadyVoted() ) {
			$submitMsg = 'qp_vote_again_button';
		}
		if ( $this->ctrl->mBeingCorrected ) {
			if ( $pollStore->getState() == "complete" ) {
				$submitMsg = 'qp_vote_again_button';
			}
		} else {
			if ( $pollStore->getState() == "error" ) {
				$submitBtn['disabled'] = 'disabled';
			}
		}
		$atLeft = $this->ctrl->attemptsLeft();
		if ( $atLeft === false ) {
			$submitBtn['disabled'] = 'disabled';
		}
		# disable submit button in preview mode & printable version
		if ( qp_Setup::$request->getVal( 'action' ) == 'parse' ||
				qp_Setup::$output->isPrintable() ) {
			$submitBtn['disabled'] = 'disabled';
		}
		$submitBtn['value'] = wfMsgHtml( $submitMsg );
		$p = array( '__tag' => 'p' );
		$p[] = $submitBtn;
		# output "no more attempts" message, when applicable
		if ( $atLeft === false ) {
			$p[] = array( '__tag' => 'span', 'class' => 'attempts_counter', qp_Setup::specialchars( wfMsg( 'qp_error_no_more_attempts' ) ) );
		} elseif ( $atLeft !== true ) {
			$p[] = array( '__tag' => 'span', 'class' => 'attempts_counter', qp_Setup::specialchars( wfMsgExt( 'qp_submit_attempts_left', array( 'parsemag' ), intval( $atLeft ) ) ) );
		}

		$qpoll_form[] = &$p;
		return qp_Renderer::renderTagArray( $qpoll_div );
	}

} /* end of qp_PollView class */
