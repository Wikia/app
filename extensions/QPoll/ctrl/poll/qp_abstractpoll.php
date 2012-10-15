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
 * A poll stub controller which cannot process and render itself
 * to process and render itself, real Poll should extend this class to implement it's own:
 * $this->setHeaders()
 * $this->getPollStore()
 * $this->parseInput()
 * $this->view->renderPoll()
 */
class qp_AbstractPoll {

	# an instance of poll view "linked" to current poll controller
	var $view;

	static $sOrderId = 0; // order of polls on the page (used for sorting of the output)
	static $sPrevPollIDs = array(); // used to check uniqueness of PollId on the page

	# collection of question objects associated with current poll
	var $questions;

	# current user name
	var $username;

	# an ID of the poll on current page (used in declaration/voting mode)
	var $mPollId = null;
	var $mOrderId = null; // order_id in DB that will used to sort out polls on the Special:PollResults statistics page
	# poll address of the poll to display statistics (used in statistical mode)
	var $pollAddr = null;
	var $mQuestionId = null; // the unique index number of the question in the current poll (used to instantiate the questions)

	# current state of poll parsing (no error)
	var $mState = '';
	# true, when the poll is posted (answered)
	var $mBeingCorrected = false;

	# qp_pollStore instance that will be used to transfer poll data from/to DB
	var $pollStore = null;

	/**
	 * possible xml-like attributes the question may have
	 */
	var $questionAttributeKeys = array(
		't[yi]p[eo]', 'name', 'catreq', 'emptytext', 'layout', 'textwidth', 'propwidth', 'showresults'
	);

	/**
	 * default values of 'propwidth', 'textwidth' and 'layout' attributes
	 * will be applied to child questions that do not have these attributes defined
	 *
	 * 'showresults' currently is handled separately, because it has "multivalue"
	 * that can be partially merged from poll to question (similar to CSS)
	 */
	var $defaultQuestionAttributes = array(
		'catreq' => null,
		'emptytext' => null,
		'layout' => null,
		'textwidth' => null,
		'propwidth' => null
	);

	/**
	 * Constructor
	 *
	 * @public
	 */
	function __construct( array $argv, qp_AbstractPollView $view ) {
		$this->mResponse = qp_Setup::$request->response();
		# Determine which messages will be used, according to the language.
		$view->setController( $this );
		# *** get visual style poll attributes ***
		$perRow = intval( array_key_exists( 'perrow', $argv ) ? $argv['perrow'] : 1 );
		if ( $perRow < 1 ) {
			$perRow = 1;
		}
		$view->setPerRow( $perRow );
		$this->view = $view;
		# reset the unique index number of the question in the current poll (used to instantiate the questions)
		$this->mQuestionId = 0; // ( corresponds to 'question_id' DB field )
		$this->username = qp_Setup::getCurrUserName();
		# setup poll view showresults
		if ( array_key_exists( 'showresults', $argv ) && qp_Setup::$global_showresults != 0 ) {
			if ( $argv['showresults'] == 'showresults' ) {
				# default showresults for the empty value of xml attribute
				$argv['showresults'] = '1';
			}
			$this->view->showResults = self::parseShowResults( $argv['showresults'] );
		}
		# get default question attributes, if any
		foreach ( $this->defaultQuestionAttributes as $attr => &$val ) {
			if ( array_key_exists( $attr, $argv ) ) {
				$val = $argv[$attr];
			}
		}
		# every poll on the page should have unique poll id, to minimize the risk of collisions
		# it is required to be set manually via id="value" parameter
		# ( used only in "declaration" mode )
		$this->mPollId = array_key_exists( 'id', $argv ) ? trim( $argv['id'] ) : null;
	}

	/**
	 * Convert the input text to an HTML output.
	 *
	 * @param  $input				Text between <qpoll> and </qpoll> tags, in QPoll syntax.
	 */
	function parsePoll( $input ) {
		if ( ( $result = $this->setHeaders() ) !== true ) {
			# error message box (invalid poll attributes)
			return $result;
		}
		if ( ( $result = $this->getPollStore() ) !== true ) {
			# error message box (cannot load from store)
			return $result;
		}
		if ( $this->parseInput( $input ) === true ) {
			# no output generation - due to active redirect or access denied
			return '';
		} else {
			# increase the order_id counter for the future successfully declared polls
			# (remember, we're in declaration mode, where 'order_id' is important
			self::$sOrderId++;
			# view->renderPoll() assumes that the poll is correctly declared
			return $this->view->renderPoll();
		}
	}

	/**
	 * Warning! When calling, do not forget to htmlquote the arguments, when required!
	 */
	static function fatalErrorNoQuote() {
		$args = func_get_args();
		if ( count( $args ) < 1 ) {
			throw new MWException( 'Too few arguments in ' . __METHOD__ );
		}
		return '<div class="qpoll"><div class="fatalerror">' . call_user_func_array( 'wfMsgHTML', $args ) . '</div></div>';
	}

	static function fatalErrorQuote() {
		$args = func_get_args();
		if ( count( $args ) < 1 ) {
			throw new MWException( 'Too few arguments in ' . __METHOD__ );
		}
		$key = array_shift( $args );
		# quote the params (if any)
		$args = array_map( array( 'qp_Setup', 'specialchars' ), $args );
		array_unshift( $args, $key );
		return call_user_func_array( array( __CLASS__, 'fatalErrorNoQuote' ), $args );
	}

	static function s_getPollTitleFragment( $pollid, $dash = '#' ) {
		return $dash . 'qp_' . Title::escapeFragmentForURL( $pollid );
	}

	/**
	 * Get title fragment part (GET/POST)
	 * @param $pollid  id of poll (null for current poll id)
	 * @param $dash    fragment separator (by default URI-compatible '#', however poll views use '')
	 */
	function getPollTitleFragment( $pollid = null, $dash = '#' ) {
		return self::s_getPollTitleFragment(
			is_null( $pollid ) ? $this->mPollId : $pollid,
			$dash
		);
	}

	static function addPollId ( $pollId ) {
		self::$sPrevPollIDs[] = $pollId;
	}

	function isValidPollId( $pollId ) {
		// more non-allowed chars ?
		return !preg_match( '`#`u', $pollId );
	}

	function isUniquePollId( $pollId ) {
		return !in_array( $pollId, self::$sPrevPollIDs );
	}

	// @input   $addr - source poll address (possibly the short one) in the string or array form
	// @return  array[0] - title where the poll is located
	//          array[1] - pollId string
	//          array[2] - prefixed (complete) poll address
	//          false - invalid source poll address was given
	static function getPrefixedPollAddress( $addr ) {
		if ( is_array( $addr ) ) {
			if ( count( $addr ) > 1 ) {
				list( $titlePart, $pollIdPart ) = $addr;
			} else {
				return false;
			}
		} else {
			preg_match( '`^(.*?)#(.*?)$`u', $addr, $matches );
			if ( count( $matches ) == 3 ) {
				$titlePart = trim( $matches[1] );
				$pollIdPart = trim( $matches[2] );
			} else {
				return false;
			}
		}
		if ( $pollIdPart == '' ) {
			return false;
		}
		if ( $titlePart == '' ) {
			# poll is located at the current page
			$titlePart = qp_Setup::$title->getPrefixedText();
		}
		return array( $titlePart, $pollIdPart, $titlePart . '#' . $pollIdPart );
	}

	/**
	 * Parses attribute line of the question
	 * @param    $attr_str  attribute string from questions header
	 * @modifies $paramkeys  array  key is attribute regexp, value is the value of attribute
	 * @return   string  the value of question's type attribute
	 */
	function getQuestionAttributes( $attr_str, array &$paramkeys ) {
		$paramkeys = qp_Setup::getXmlLikeAttributes( $attr_str, $this->questionAttributeKeys );
		# apply default questions attributes from poll definition, if there is any
		foreach ( $this->defaultQuestionAttributes as $attr => $val ) {
			if ( $paramkeys[$attr] === null ) {
				$paramkeys[$attr] = $val;
			}
		}
		return isset( $paramkeys[ 't[yi]p[eo]' ] ) ? trim( $paramkeys[ 't[yi]p[eo]' ] ) : '';
	}

	// parses source showresults xml parameter value and returns the corresponding showResults array
	// input: $str contains entries separated by ';'
	//   entry 1 is a number of showresults type (always presented)
	//   entries 2..n are optional css-style list of attributes and their values
	// returns showResults parsed array
	//   'type' indicates the type, optional keys contain values of css-style attributes
	static function parseShowResults( $str ) {
		$showResults = array();
		$showResults['type'] = 0;
		$attrs = array_map( 'trim', explode( ';', $str ) );
		if ( count( $attrs ) > 0 ) {
			$showResults['type'] = intval( array_shift( $attrs ) );
			if ( $showResults['type'] < 0 ) {
				$showResults['type'] = 0;
			}
			if ( $showResults['type'] != 0 && count( $attrs ) > 0 ) {
				foreach ( $attrs as &$attr ) {
					preg_match( '`([A-Za-z]+):([#\w]+)`u', $attr, $matches );
					if ( count( $matches ) == 3 ) {
						$showResults[ $matches[1] ] = $matches[2];
					}
				}
			}
		}
		return $showResults;
	}
}
