<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Render question data in Special:Pollresults
 *
 * *** Usually a singleton instantiated via $qdata->getView() ***
 *
 */
class qp_QuestionDataResults {

	var $ctrl;

	function __construct( qp_QuestionData $ctrl ) {
		$this->setController( $ctrl );
	}

	function setController( qp_QuestionData $ctrl ) {
		$this->ctrl = $ctrl;
	}

	protected function categoryentities( array $cat ) {
		$cat['name'] = qp_Setup::entities( $cat['name'] );
		return $cat;
	}

	/**
	 * @return  string  html representation of question header
	 */
	public function displayHeader() {
		$ctrl = $this->ctrl;
		return "<div class=\"question_header\">\n" .
			"<span class=\"question_id\">{$ctrl->question_id}</span> " .
			( ( $ctrl->name === null ) ?
					'' :
					' <span class="question_name">' . qp_Setup::entities( $ctrl->name ) . '</span>'
			) .
			' <span class="common_question">' . qp_Setup::entities( $ctrl->CommonQuestion ) .
			"</span></div>\n";
	}

	/**
	 * @return  string  html representation of user vote
	 */
	public function displayUserVote() {
		$ctrl = $this->ctrl;
		$output = $this->displayHeader() .
			"<div class=\"qpoll\">\n" . "<table class=\"qdata\">\n" .
			qp_Renderer::displayRow(
				array_map( array( $this, 'categoryentities' ), $ctrl->CategorySpans ),
				array( 'class' => 'spans' ),
				'th',
				array( 'count' => 'colspan', 'name' => 0 )
			) .
			qp_Renderer::displayRow(
				array_map( array( $this, 'categoryentities' ), $ctrl->Categories ),
				array(),
				'th',
				array( 'name' => 0 )
			);
		# multiple choice polls doesn't use real spans, instead, every column is like "span"
		$spansUsed = count( $ctrl->CategorySpans ) > 0 || $ctrl->type == "multipleChoice";
		foreach ( $ctrl->ProposalText as $propkey => &$proposal_text ) {
			$row = array();
			foreach ( $ctrl->Categories as $catkey => &$cat_name ) {
				$cell = array( 0 => "" );
				if ( array_key_exists( $propkey, $ctrl->ProposalCategoryId ) &&
							( $id_key = array_search( $catkey, $ctrl->ProposalCategoryId[ $propkey ] ) ) !== false ) {
					$text_answer = $ctrl->ProposalCategoryText[ $propkey ][ $id_key ];
					if ( $text_answer != '' ) {
						if ( strlen( $text_answer ) > 20 ) {
							$cell[ 0 ] = array( '__tag' => 'div', 'style' => 'width:10em; height:5em; overflow:auto', 0 => qp_Setup::entities( $text_answer ) );
						} else {
							$cell[ 0 ] = qp_Setup::entities( $text_answer );
						}
					} else {
						$cell[ 0 ] = qp_Setup::RESULTS_CHECK_SIGN;
					}
				}
				if ( $spansUsed ) {
					if ( $ctrl->type == "multipleChoice" ) {
						$cell[ "class" ] = ( ( $catkey & 1 ) === 0 ) ? "spaneven" : "spanodd";
					} else {
						$cell[ "class" ] = ( ( $ctrl->Categories[ $catkey ][ "spanId" ] & 1 ) === 0 ) ? "spaneven" : "spanodd";
					}
				} else {
					$cell[ "class" ] = "stats";
				}
				$row[] = $cell;
			}
			$row[] = array( 0 => qp_Setup::entities( $proposal_text ), "style" => "text-align:left;" );
			$output .= qp_Renderer::displayRow( $row );
		}
		$output .= "</table>\n" . "</div>\n";
		return $output;
	}

	/**
	 * @return  string  html representation of question statistics
	 */
	public function displayStats( qp_SpecialPage $page, $pid ) {
		$ctrl = $this->ctrl;
		$current_title = $page->getTitle();
		$output = $this->displayHeader() .
			"<div class=\"qpoll\">\n" . "<table class=\"qdata\">\n" .
			qp_Renderer::displayRow(
				array_map( array( $this, 'categoryentities' ), $ctrl->CategorySpans ),
				array( 'class' => 'spans' ),
				'th',
				array( 'count' => 'colspan', 'name' => 0 )
			) .
			qp_Renderer::displayRow(
				array_map( array( $this, 'categoryentities' ), $ctrl->Categories ),
				array(),
				'th',
				array( 'name' => 0 )
			);
		# multiple choice polls doesn't use real spans, instead, every column is like "span"
		$spansUsed = count( $ctrl->CategorySpans ) > 0 || $ctrl->type == "multipleChoice";
		foreach ( $ctrl->ProposalText as $propkey => &$proposal_text ) {
			if ( isset( $ctrl->Votes[ $propkey ] ) ) {
				if ( $ctrl->Percents === null ) {
					$row = $ctrl->Votes[ $propkey ];
				} else {
					$row = $ctrl->Percents[ $propkey ];
					foreach ( $row as $catkey => &$cell ) {
						# Replace spaces with en spaces
						$formatted_cell = str_replace( " ", "&#8194;", sprintf( '%3d%%', intval( round( 100 * $cell ) ) ) );
						# only percents !=0 are displayed as link
						if ( $cell == 0.0 && $ctrl->question_id !== null ) {
							$cell = array( 0 => $formatted_cell, "style" => "color:gray" );
						} else {
							$cell = array( 0 => $page->qpLink( $current_title, $formatted_cell,
								array( "title" => wfMsgExt( 'qp_votes_count', array( 'parsemag' ), $ctrl->Votes[ $propkey ][ $catkey ] ) ),
								array( "action" => "qpcusers", "id" => $pid, "qid" => $ctrl->question_id, "pid" => $propkey, "cid" => $catkey ) ) );
						}
						if ( $spansUsed ) {
							if ( $ctrl->type == "multipleChoice" ) {
								$cell[ "class" ] = ( ( $catkey & 1 ) === 0 ) ? "spaneven" : "spanodd";
							} else {
								$cell[ "class" ] = ( ( $ctrl->Categories[ $catkey ][ "spanId" ] & 1 ) === 0 ) ? "spaneven" : "spanodd";
							}
						} else {
							$cell[ "class" ] = "stats";
						}
					}
				}
			} else {
				# this proposal has no statistics (no votes)
				$row = array_fill( 0, count( $ctrl->Categories ), '' );
			}
			$row[] = array( 0 => qp_Setup::entities( $proposal_text ), "style" => "text-align:left;" );
			$output .= qp_Renderer::displayRow( $row );
		}
		$output .= "</table>\n" . "</div>\n";
		return $output;
	}

} /* end of qp_QuestionDataResults class */
