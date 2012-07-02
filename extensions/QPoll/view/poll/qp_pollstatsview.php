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

class qp_PollStatsView extends qp_AbstractPollView {

	function isCompatibleController( $ctrl ) {
		return method_exists( $ctrl, 'parseStats' );
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
			# render the question statistics only when showResuls is available (suppress stats)
			if ( $question->view->hasShowResults() ) {
				if ( $this->perRow > 1 ) {
					$write_col[] = array( '__tag' => 'td', 'valign' => 'top', 0 => $question->view->renderQuestion(), '__end' => "\n" );
					if ( $this->currCol == 1 ) {
						$write_row[] = array( '__tag' => 'tr', 0 => $write_col, '__end' => "\n" );
						$write_col = Array();
					}
					if ( --$this->currCol < 1 ) {
						$this->currCol = $this->perRow;
					}
				} else {
					$write_row[] = $question->view->renderQuestion();
				}
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
		# Generates the output.
		$qpoll_div = array( '__tag' => 'div', 'class' => 'qpoll', 0 => $this->renderQuestionViews() );
		return qp_Renderer::renderTagArray( $qpoll_div );
	}

} /* end of qp_PollStatsView class */
