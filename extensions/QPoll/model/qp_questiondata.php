<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Poll's single question data object RAM storage.
 * Also, converts question properties from / to "packed" DB state.
 * Currently, category spans and proposal names are packed, not having
 * their own separate DB fields.
 * ( instances usually have short name qdata )
 *
 * *** Please do not instantiate directly. ***
 * *** use qp_QuestionData::factory() instead ***
 *
 */
class qp_QuestionData {

	## associated view instance (singleton)
	static protected $view;

	## DB index (with current scheme is non-unique)
	var $question_id = null;
	## common properties
	var $type;
	var $CommonQuestion;
	var $name = null;
	var $Categories;
	var $CategorySpans;
	var $ProposalText;
	# since v0.8.0a, proposals may be addressed by their names
	# in the interpretation scripts
	var $ProposalNames;
	var $ProposalCategoryId;
	var $ProposalCategoryText;
	var $alreadyVoted = false; // whether the selected user already voted this question ?
	## statistics storage
	# 3d array with number of choices for each [proposal][category]
	var $Votes = null;
	# 3d array with floating point percent values for each [proposal][category],
	# calculated from $this->Votes
	var $Percents = null;

	/**
	 * Constructor
	 * @param $argv  mixed
	 *   array  creates new empty instance to be filled with data loaded from DB at later stage;
	 *     keys of $argv define question data property names;
	 *   qp_StubQuestion  creates qdata from question instance already parsed in tag hook handler;
	 */
	function __construct( $argv ) {
		self::$view = new stdClass;
		if ( is_array( $argv ) ) {
			# create the very new question data
			$this->question_id = $argv['qid'];
			$this->type = $argv['type'];
			$this->CommonQuestion = $argv['common_question'];
			$this->name = $argv['name'];
			$this->Categories = array();
			$this->CategorySpans = array();
			$this->ProposalText = array();
			$this->ProposalNames = array();
			$this->ProposalCategoryId = array();
			$this->ProposalCategoryText = array();
			return;
		} elseif ( $argv instanceof qp_StubQuestion ) {
			# create question data from the already existing question
			$this->applyQuestion( $argv );
			return;
		}
		throw new MWException( "argv is neither an array nor instance of qp_QuestionData in " . __METHOD__ );
	}

	/**
	 * qp_*QuestionData instantiator (factory).
	 * Please use it instead of qp_*QuestionData constructors when
	 * creating qdata instances.
	 */
	static function factory( $argv ) {
		$type = is_array( $argv ) ? $argv['type'] : $argv->mType;
		switch ( $type ) {
		case 'textQuestion' :
			return new qp_TextQuestionData( $argv );
		case 'singleChoice' :
		case 'multipleChoice' :
		case 'mixedChoice' :
			return new qp_QuestionData( $argv );
		default :
			throw new MWException( 'Unknown type of question ' . qp_Setup::specialchars( $type ) . ' in ' . __METHOD__ );
		}
	}

	/**
	 * Get appropriate view for Special:Pollresults
	 */
	function getView() {
		if ( get_class( self::$view ) !== 'qp_QuestionDataResults' ) {
			self::$view = new qp_QuestionDataResults( $this );
		} else {
			self::$view->setController( $this );
		}
		return self::$view;
	}

	/**
	 * Check whether the previousely stored poll header is
	 * compatible with the one defined on the page.
	 *
	 * Used to reject previous vote in case the header is incompatble.
	 */
	function isCompatible( qp_StubQuestion $question ) {
		if ( $question->mType != $this->type ) {
			return false;
		}
		if ( count( $question->mCategorySpans ) != count( $this->CategorySpans ) ) {
			return false;
		}
		foreach ( $question->mCategorySpans as $spanidx => &$span ) {
			if ( !isset( $this->CategorySpans[$spanidx] ) ||
					$span['count'] != $this->CategorySpans[$spanidx]['count'] ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Integrate spans into categories
	 */
	function packSpans() {
		if ( count( $this->CategorySpans ) > 0 ) {
			foreach ( $this->Categories as &$Cat ) {
				if ( array_key_exists( 'spanId', $Cat ) ) {
					$Cat['name'] = $this->CategorySpans[ $Cat['spanId'] ]['name'] . "\n" . $Cat['name'];
					unset( $Cat['spanId'] );
				}
			}
			unset( $this->CategorySpans );
			$this->CategorySpans = array();
		}
	}

	/**
	 * Restore spans from categories
	 */
	function restoreSpans() {
		if ( count( $this->CategorySpans ) == 0 ) {
			$prevSpanName = '';
			$spanId = -1;
			foreach ( $this->Categories as &$Cat ) {
				$a = explode( "\n", $Cat['name'] );
				if ( count( $a ) > 1 ) {
					if ( $prevSpanName != $a[0] ) {
						$spanId++;
						$prevSpanName = $a[0];
						$this->CategorySpans[ $spanId ]['count'] = 0;
					}
					$Cat['name'] = $a[1];
					$Cat['spanId'] = $spanId;
					$this->CategorySpans[ $spanId ]['name'] = $a[0];
					$this->CategorySpans[ $spanId ]['count']++;
				} else {
					$prevSpanName = '';
				}
			}
		}
	}

	public function applyQuestion( qp_StubQuestion $question ) {
		$this->question_id = $question->mQuestionId;
		$this->type = $question->mType;
		$this->CommonQuestion = $question->mCommonQuestion;
		$this->name = $question->mName;
		$this->Categories = $question->mCategories;
		$this->CategorySpans = $question->mCategorySpans;
		$this->ProposalText = $question->mProposalText;
		$this->ProposalNames = $question->mProposalNames;
		$this->ProposalCategoryId = $question->mProposalCategoryId;
		$this->ProposalCategoryText = $question->mProposalCategoryText;
	}

	/**
	 * Set count of votes (user choices) for the selected proposal / category
	 * @param  $propkey  integer  proposal id
	 * @param  $catkey  integer  category id
	 */
	function setVote( $propkey, $catkey, $count ) {
		if ( !is_array( $this->Votes ) ) {
			$this->Votes = array();
		}
		if ( !array_key_exists( $propkey, $this->Votes ) ) {
			$this->Votes[ $propkey ] = array_fill( 0, count( $this->Categories ), 0 );
		}
		$this->Votes[ $propkey ][ $catkey ] = $count;
	}

	/**
	 * Calculates Percents[] properties for specified question from
	 * it's Votes[] properties.
	 * @param  $store
	 *   instance of qp_PollStore associated with $this qdata
	 */
	function calculateQuestionStatistics( qp_PollStore $store ) {
		if ( !isset( $this->Votes ) ) {
			return;
		}
		# $this has votes
		$this->restoreSpans();
		$spansUsed = count( $this->CategorySpans ) > 0 ;
		foreach ( $this->ProposalText as $propkey => $proposal_text ) {
			if ( isset( $this->Votes[ $propkey ] ) ) {
				$votes_row = &$this->Votes[ $propkey ];
				if ( $this->type == "singleChoice" ) {
					if ( $spansUsed ) {
						$row_totals = array_fill( 0, count( $this->CategorySpans ), 0 );
					} else {
						$votes_total = 0;
					}
					foreach ( $this->Categories as $catkey => $cat ) {
						if ( isset( $votes_row[ $catkey ] ) ) {
							if ( $spansUsed ) {
								$row_totals[ intval( $cat[ "spanId" ] ) ] += $votes_row[ $catkey ];
							} else {
								$votes_total += $votes_row[ $catkey ];
							}
						}
					}
				} else {
					$votes_total = $store->totalUsersAnsweredQuestion( $this );
				}
				foreach ( $this->Categories as $catkey => $cat ) {
					$num_of_votes = '';
					if ( isset( $votes_row[ $catkey ] ) ) {
						$num_of_votes = $votes_row[ $catkey ];
						if ( $spansUsed ) {
							if ( isset( $this->Categories[ $catkey ][ "spanId" ] ) ) {
								$votes_total = $row_totals[ intval( $this->Categories[ $catkey ][ "spanId" ] ) ];
							}
						}
					}
					$this->Percents[ $propkey ][ $catkey ] = ( $votes_total > 0 ) ? (float) $num_of_votes / (float) $votes_total : 0.0;
				}
			}
		}
	}

} /* end of qp_QuestionData class */

/**
 *
 * *** Please do not instantiate directly. ***
 * *** use qp_QuestionData::factory() instead ***
 *
 */
class qp_TextQuestionData extends qp_QuestionData {

	/**
	 * Questions of type="text" require a different view logic in Special:Pollresults page
	 */
	/**
	 * Get appropriate view for Special:Pollresults
	 */
	function getView() {
		if ( get_class( self::$view ) !== 'qp_TextQuestionDataResults' ) {
			self::$view =  new qp_TextQuestionDataResults( $this );
		} else {
			self::$view->setController( $this );
		}
		return self::$view;
	}

} /* end of qp_TextQuestionData class */
