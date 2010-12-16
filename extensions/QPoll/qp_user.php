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
 * @version 0.6.4
 * @link http://www.mediawiki.org/wiki/Extension:QPoll
 * @author QuestPC <questpc@rambler.ru>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

define( 'QP_CSS_ERROR_COLOR1' , "LightYellow" );
define( 'QP_CSS_ERROR_COLOR2', "#D700D7" );
define( 'QP_CSS_ERROR_STYLE', 'background-color: ' . QP_CSS_ERROR_COLOR1 . ';' );

define( 'QP_ERROR_MISSED_TITLE', 1 );
define( 'QP_ERROR_INVALID_ADDRESS', 2 );

define( 'QP_MAX_TEXT_ANSWER_LENGTH', 1024 );

qp_Setup::init();

/**
 * Extension's parameters.
 */
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'QPoll',
	'version' => '0.6.4',
	'author' => 'QuestPC',
	'url' => 'http://www.mediawiki.org/wiki/Extension:QPoll',
	'description' => 'Allows creation of polls',
	'descriptionmsg' => 'qp_desc',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'QPoll results page',
	'version' => '0.6.4',
	'author' => 'QuestPC',
	'url' => 'http://www.mediawiki.org/wiki/Extension:QPoll',
	'description' => 'QPoll extension [[Special:PollResults]] page for viewing results of the polls',
	'descriptionmsg' => 'qp_desc-sp',
);

class qp_Setup {

	static $ExtDir; // filesys path with windows path fix
	static $ScriptPath; // apache virtual path
	static $messagesLoaded = false; // check whether the extension's localized messages are loaded
	static $article; // Article instance we got from hook parameter
	static $user; // User instance we got from hook parameter

	static function entities( &$s ) {
		return htmlentities( $s, ENT_COMPAT, 'UTF-8' );
	}

	static function specialchars( &$s ) {
		return htmlspecialchars( $s, ENT_COMPAT, 'UTF-8' );
	}

	static function coreRequirements() {
		$required_classes_and_methods = array(
			array( 'Article' => 'doPurge' ),
			array( 'Linker' => 'link' ),
			array( 'OutputPage' => 'isPrintable' ),
			array( 'Parser' => 'getTitle' ),
			array( 'Parser' => 'setHook' ),
			array( 'Parser' => 'recursiveTagParse' ),
			array( 'ParserCache' => 'getKey' ),
			array( 'ParserCache' => 'singleton' ),
			array( 'Title' => 'getArticleID' ),
			array( 'Title' => 'getPrefixedText' ),
			array( 'Title' => 'makeTitle' ),
			array( 'Title' => 'makeTitleSafe' ),
			array( 'Title' => 'newFromID' )
		);
		foreach ( $required_classes_and_methods as &$check ) {
			list( $object, $method ) = each( $check );
			if ( !method_exists( $object, $method ) ) {
				die( "QPoll extension requires " . $object . "::" . $method . " method to be available.<br />\n" .
					"Your version of MediaWiki is incompatible with this extension.\n" );
			}
		}
		if ( !defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
			die( "QPoll extension requires ParserFirstCallInit hook.\nPlease upgrade your MediaWiki installation first.\n" );
		}
	}

	/**
	 * Add this extension to the mediawiki's extensions list.
	 */
	static function init() {
		global $wgScriptPath;
		global $wgAutoloadClasses;
		global $wgExtensionMessagesFiles;
		global $wgSpecialPages;
		global $wgHooks;
		self::coreRequirements();
		self::$ExtDir = str_replace( "\\", "/", dirname( __FILE__ ) );
		$dirs = explode( '/', self::$ExtDir );
		$top_dir = array_pop( $dirs );
		self::$ScriptPath = $wgScriptPath . '/extensions' . ( ( $top_dir == 'extensions' ) ? '' : '/' . $top_dir );
		$wgExtensionMessagesFiles['QPoll'] = self::$ExtDir . '/qp_i18n.php';
		$wgAutoloadClasses['PollResults'] = self::$ExtDir . '/qp_results.php';
		$wgAutoloadClasses['qp_Question'] = self::$ExtDir . '/qp_question.php';
		$wgAutoloadClasses['qp_QuestionStats'] = self::$ExtDir . '/qp_question.php';
		$wgAutoloadClasses['qp_PollStore'] = self::$ExtDir . '/qp_pollstore.php';
		$wgAutoloadClasses['qp_QuestionData'] = self::$ExtDir . '/qp_pollstore.php';
		$wgAutoloadClasses['qp_QueryPage'] = self::$ExtDir . '/qp_results.php';
		// TODO: Use the new technique for i18n of special page aliases
		$wgSpecialPages['PollResults'] = array( 'PollResults' );
		// TODO: Use the new technique for i18n of magic words
		$wgHooks['LanguageGetMagic'][]       = 'qp_Setup::languageGetMagic';
		$wgHooks['MediaWikiPerformAction'][] = 'qp_Setup::mediaWikiPerformAction';
		$wgHooks['ParserFirstCallInit'][] = 'qp_Setup::parserFirstCallInit';
		$wgHooks['LoadAllMessages'][] = 'qp_Setup::loadMessages';
	}

	static function loadMessages() {
		if ( !self::$messagesLoaded ) {
			self::$messagesLoaded = true;
			wfLoadExtensionMessages( 'QPoll' );
		}
		return true;
	}

	static function ParserFunctionsWords( $lang ) {
		$words = array();
		$words[ 'en' ] = array( 'qpuserchoice' => array( 0, 'qpuserchoice' ) );
		# English is used as a fallback, and the English synonyms are
		# used if a translation has not been provided for a given word
		return ( $lang == 'en' || !array_key_exists( $lang, $words ) )
			? $words[ 'en' ]
			: array_merge( $words[ 'en' ], $words[ $lang ] );
	}

	static function languageGetMagic( &$magicWords, $langCode ) {
		foreach ( self::ParserFunctionsWords( $langCode ) as $word => $trans )
			$magicWords [$word ] = $trans;
		return true;
	}

	static function clearCache() {
		$parserCache = ParserCache::singleton();
		$key = $parserCache->getKey( self::$article, self::$user );
		$parserCache->mMemc->delete( $key );
		self::$article->doPurge();
	}

	static function mediaWikiPerformAction( $output, $article, $title, $user, $request, $wiki ) {
		global $wgCookiePrefix;
		global $qp_enable_showresults;
		self::$article = $article;
		self::$user = $user;
		# setup proper integer global showresults level
		if ( isset( $qp_enable_showresults ) ) {
			if ( !is_int( $qp_enable_showresults ) ) {
				# convert from older v0.5 boolean value
				$qp_enable_showresults = (int) (boolean) $qp_enable_showresults;
			}
			if ( $qp_enable_showresults < 0 ) {
				$qp_enable_showresults = 0;
			}
			if ( $qp_enable_showresults > 2 ) {
				$qp_enable_showresults = 2;
			}
		} else {
			$qp_enable_showresults = 0;
		}
		if ( isset( $_COOKIE[$wgCookiePrefix . 'QPoll'] ) ) {
			$request->response()->setCookie( 'QPoll', '', time() - 86400 ); // clear cookie
			self::clearCache();
		} elseif ( $request->getVal( 'pollId' ) !== null ) {
			self::clearCache();
		}
		return true;
	}

	/**
	 * Register the extension with the WikiText parser.
	 */
	static function parserFirstCallInit() {
		global $wgParser;
		global $wgExtensionCredits;
		global $wgQPollFunctionsHook;
		global $wgContLang;
		global $wgJsMimeType, $wgOut;
		# Ouput the style and the script to the header once for all.
		$head  = '<style type="text/css">' . "\n";
		$head .= '.qpoll .fatalerror { border: 1px solid gray; padding: 4px; ' . QP_CSS_ERROR_STYLE . ' }' . "\n";
		$head .= '</style>' . "\n";
		$head .= '<script type="' . $wgJsMimeType . '" src="' . self::$ScriptPath . '/qp_user.js"></script>' . "\n";
		$wgOut->addScript( $head );
		$wgOut->addExtensionStyle( self::$ScriptPath . '/qp_user.css' );
		if ( $wgContLang->isRTL() ) {
			$wgOut->addExtensionStyle( self::$ScriptPath . '/qp_user_rtl.css' );
		}
		# setup tag hook
		$wgParser->setHook( "qpoll", "qp_Setup::renderPoll" );
		$wgQPollFunctionsHook = new qp_FunctionsHook();
		# setup function hook
		$wgParser->setFunctionHook( 'qpuserchoice', array( &$wgQPollFunctionsHook, 'qpuserchoice' ), SFH_OBJECT_ARGS );
		return true;
	}

	/**
	 * Call the poll parser on an input text.
	 *
	 * @param  $input				Text between <qpoll> and </qpoll> tags, in QPoll syntax.
	 * @param  $argv				An array containing any arguments passed to the extension
	 * @param  &$parser				The wikitext parser.
	 *
	 * @return 						An HTML poll.
	 */

	/* @param  $input				Text between <qpoll> and </qpoll> tags, in QPoll syntax. */
	static function renderPoll( $input, $argv, $parser ) {
		if ( array_key_exists( 'address', $argv ) ) {
			$qpoll = new qp_PollStats( $argv, $parser );
		} else {
			$qpoll = new qp_Poll( $argv, $parser );
		}
		return $qpoll->parsePoll( $input );
	}

}

/***
	* a poll stub which cannot process and render itself
	* to process and render itself, real Poll should extend this class to implement it's own:
		$this->getPollStore()
		$this->parseInput()
		$this->generateOutput()
 ***/
class qp_AbstractPoll {

	static $skin;
	static $sOrderId = 0; // order of polls on the page (used for sorting of the output)
	static $sPrevPollIDs = Array(); // used to check uniqueness of PollId on the page
	static $messagesLoaded = false; // check whether the extension localized messages are loaded

	var $parser; // parser for parsing tags content
	var $username;

	# an ID of the poll on current page (used in declaration/voting mode)
	var $mPollId = null;
	var $mOrderId = null; // order_id in DB that will used to sort out polls on the Special:PollResults statistics page
	# poll address of the poll to display statistics (used in statistical mode)
	var $pollAddr = null;
	var $mQuestionId = null; // the unique index number of the question in the current poll (used to instantiate the questions)

	var $mState = ''; // current state of poll parsing (no error)
	var $dependsOn = ''; // optional address of the poll which must be answered first
	var $mBeingCorrected = false; // true, when the poll is posted (answered)

	# the following showresults types are currently available:
	# 0 - none; 1 - percents; 2 - bars
	# may contain extra options (color, width) for selected display type
	var $showResults = Array( 'type' => 0 ); // hide showResults by default

	// qp_pollStore instance that will be used to transfer poll data from/to DB
	var $pollStore = null;

	/**
	 * Constructor
	 *
	 * @public
	 */
	function __construct( $argv, &$parser ) {
		global $wgUser, $wgRequest, $wgLanguageCode;
		global $qp_enable_showresults;
		$this->parser = &$parser;
		$this->mRequest = &$wgRequest;
		$this->mResponse = $wgRequest->response();
		# Determine which messages will be used, according to the language.
		self::loadMessages();
		# load current skin
		if ( self::$skin === null ) {
			self::$skin = $wgUser->getSkin();
		}
		# reset the unique index number of the question in the current poll (used to instantiate the questions)
		$this->mQuestionId = 0; // ( correspons to 'question_id' DB field )
		$this->username = self::currentUserName();

		# *** get visual style poll attributes ***
		$this->perRow = intval( array_key_exists( 'perrow', $argv ) ? $argv['perrow'] : 1 );
		if ( $this->perRow < 1 )
			$this->perRow = 1;
		$this->currCol = $this->perRow;
		if ( array_key_exists( 'showresults', $argv ) && $qp_enable_showresults != 0 ) {
			if ( $argv['showresults'] == 'showresults' ) {
				# default showresults for the empty value of xml attribute
				$argv['showresults'] = '1';
			}
			$this->showResults = self::parse_showResults( $argv['showresults'] );
		}
		# every poll on the page should have unique poll id, to minimize the risk of collisions
		# it is required to be set manually via id="value" parameter
		# ( used only in "declaration" mode )
		$this->mPollId = array_key_exists( 'id', $argv ) ? trim( $argv['id'] ) : null;
		if ( array_key_exists( 'dependance', $argv ) ) {
			$this->dependsOn = trim( $argv['dependance'] );
		}
	}

	/**
	 * Convert the input text to an HTML output.
	 *
	 * @param  $input				Text between <qpoll> and </qpoll> tags, in QPoll syntax.
	 */
	function parsePoll( $input ) {
		if ( ( $result = $this->getPollStore() ) !== true ) {
			# error message box (invalid poll attributes)
			return $result;
		}
		if ( ( $result = $this->parseInput( $input ) ) === true ) {
			# no output generation - due to active redirect or access denied
			return '';
		} else {
			# generateOutput() assumes that the poll is not being submitted and is correctly declared
			return $this->generateOutput( $result );
		}
	}

	static function fatalError() {
		$args = func_get_args();
		$result = 'Extension bug: ' . __METHOD__ . ' called without arguments';
		if ( count( $args > 0 ) ) {
			$result = call_user_func_array( 'wfMsgHTML', $args );
		}
		return '<div class="qpoll"><div class="fatalerror">' . $result . '</div></div>';
	}

	# title fragment part (GET/POST)
	static function getPollTitleFragment( $pollid, $dash = '#' ) {
		return $dash . 'qp_' . Title::escapeFragmentForURL( $pollid );
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

	static function loadMessages() {
		if ( !self::$messagesLoaded ) {
			self::$messagesLoaded = true;
			wfLoadExtensionMessages( 'QPoll' );
		}
		return true;
	}

	static function currentUserName() {
		global $qp_AnonForwardedFor;
		global $wgUser, $wgSquidServers;
		global $wgUsePrivateIPs;
		if ( $qp_AnonForwardedFor === true && $wgUser->isAnon() ) {
			/* collect the originating IPs
				borrowed from ProxyTools::wfGetIP
				bypass trusted proxies list check */
			# Client connecting to this webserver
			if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
				$ipchain = array( IP::canonicalize( $_SERVER['REMOTE_ADDR'] ) );
			} else {
				# Running on CLI?
				$ipchain = array( '127.0.0.1' );
			}
			$ip = $ipchain[0];

			# Append XFF on to $ipchain
			$forwardedFor = wfGetForwardedFor();
			if ( isset( $forwardedFor ) ) {
				$xff = array_map( 'trim', explode( ',', $forwardedFor ) );
				$xff = array_reverse( $xff );
				$ipchain = array_merge( $ipchain, $xff );
			}
			$username = "";
			foreach ( $ipchain as $i => $curIP ) {
				if ( $wgUsePrivateIPs || IP::isPublic( $curIP ) ) {
					$username .= IP::canonicalize( $curIP ) . '/';
				}
			}
			if ( $username != "" ) {
				# remove trailing slash
				$username = substr( $username, 0, strlen( $username ) - 1 );
			} else {
				$username .= IP::canonicalize( $ipchain[0] );
			}
		} else {
			$username = $wgUser->getName();
		}
		return $username;
	}

	// @input   $addr - source poll address (possibly the short one) in the string or array form
	// @return  array[0] - title where the poll is located
	//          array[1] - pollId string
	//          array[2] - prefixed (complete) poll address
	//          false - invalid source poll address was given
	static function getPrefixedPollAddress( $addr ) {
		global $wgArticle;
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
			$titlePart = $wgArticle->getTitle()->getPrefixedText();
		}
		return array( $titlePart, $pollIdPart, $titlePart . '#' . $pollIdPart );
	}

	// parses source showresults xml parameter value and returns the corresponding showResults array
	// input: $str contains entries separated by ';'
	//   entry 1 is a number of showresults type (always presented)
	//   entries 2..n are optional css-style list of attributes and their values
	// returns showResults parsed array
	//   'type' indicates the type, optional keys contain values of css-style attributes
	static function parse_showResults( $str ) {
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

/**
 * Processes poll markup in statistical mode (only to show the results)
 */
class qp_PollStats extends qp_AbstractPoll {

	function __construct( $argv, &$parser ) {
		global $qp_enable_showresults;
		parent::__construct( $argv, $parser );
		$this->pollAddr = trim( $argv['address'] );
		# statistical mode is active, but $qp_enable_showresults still can be false
		if ( $qp_enable_showresults == 0 ) {
			$this->showResults = false;
		}
	}

	# prepare qp_PollStore object
	# @return    true on success ($this->pollStore has been created successfully), error string on failure
	function getPollStore() {
		if ( $this->mPollId !== null ) {
			$this->mState = "error";
			return self::fatalError( 'qp_error_id_in_stats_mode' );
		}
		if ( $this->dependsOn !== '' ) {
			$this->mState = "error";
			return self::fatalError( 'qp_error_dependance_in_stats_mode' );
		}
		$this->pollStore = qp_PollStore::newFromAddr( $this->pollAddr );
		if ( !( $this->pollStore instanceof qp_PollStore ) || $this->pollStore->pid === null ) {
			return self::fatalError( 'qp_error_no_such_poll', $this->pollAddr );
		}
		if ( !$this->pollStore->loadQuestions() ) {
			$this->mState = "error";
			return self::fatalError( 'qp_error_no_stats', $this->pollAddr );
		}
		$this->pollStore->setLastUser( $this->username, false );
		# do not check the result, because we may show results even if the user hasn't voted
		$this->pollStore->loadUserAlreadyVoted();
		return true;
	}

	# Replace questions from QPoll syntax to HTML
	# @param    $input - A question in QPoll statistical mode syntax
	# @return   string representing rendered set of the questions / boolean true - stop further processing
	function parseInput( $input ) {
		$write_row = Array();
		$write_col = Array();
		$questions = Array();
		# question attributes split pattern
		$splitPattern = '`\s*{|}\s*\n*`u';
		# preg_split counts the matches starting from zero
		$unparsedAttributes = preg_split( $splitPattern, $input, -1, PREG_SPLIT_NO_EMPTY );
		# we count questions starting from 1
		array_unshift( $unparsedAttributes, null );
		unset( $unparsedAttributes[0] );
		# first pass: parse the headers
		foreach ( $this->pollStore->Questions as &$qdata ) {
			$question = new qp_QuestionStats( $this->parser, $qdata->type, $qdata->question_id, $this->showResults );
			if ( isset( $unparsedAttributes[$qdata->question_id] ) ) {
				$attr_str = $unparsedAttributes[$qdata->question_id];
			} else {
				$attr_str = '';
			}
			if ( ( $type = $question->parseAttributes( $attr_str ) ) != '' ) {
				# there cannot be type attribute of question in statistical display mode
				$question->setState( 'error', wfMsg( 'qp_error_type_in_stats_mode', $type ) );
			}
			$questions[] = $question;
		}
		# analyze question headers
		# check for showresults attribute
		$questions_set = Array();
		foreach ( $questions as &$question ) {
			if ( $question->showResults['type'] != 0 &&
						method_exists( 'qp_Question', 'addShowResults' . $question->showResults['type'] ) ) {
				$questions_set[] = $question->mQuestionId;
			}
		}
		# load the statistics for all/selective/none of questions
		if ( count( $questions_set ) > 0 ) {
			if ( count( $questions_set ) == count( $questions ) ) {
				$this->pollStore->loadTotals();
			} else {
				$this->pollStore->loadTotals( $questions_set );
			}
			$this->pollStore->calculateStatistics();
		}
		# second pass: parse the statistics
		foreach ( $questions as &$question ) {
			# render the question statistics only when showResuls isn't 0 (suppress stats)
			if ( $question->showResults['type'] != 0 ) {
				if ( $this->perRow > 1 ) {
					$write_col[] = array( '__tag' => 'td', 'valign' => 'top', 0 => $this->parseStats( $question ), '__end' => "\n" );
					if ( $this->currCol == 1 ) {
						$write_row[] = array( '__tag' => 'tr', 0 => $write_col, '__end' => "\n" );
						$write_col = Array();
					}
					if ( --$this->currCol < 1 ) {
						$this->currCol = $this->perRow;
					}
				} else {
					$write_row[] = $this->parseStats( $question );
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
			return qp_Renderer::renderHTMLobject( $question_table );
		} else {
			return qp_Renderer::renderHTMLobject( $write_row );
		}
	}

	# encloses the output of $this->parseQuestions() into the output tag wrappers
	# @param   $input - the output of $this->parseQuestions()
	# @return  rendered "final" html
	function generateOutput( $input ) {
		global $wgOut;
		# Generates the output.
		$qpoll_div = array( '__tag' => 'div', 'class' => 'qpoll', 0 => $input );
		return qp_Renderer::renderHTMLobject( $qpoll_div );
	}

	# populate the question with data and build it's HTML representation
	# returns HTML representation of the question
	function parseStats( qp_QuestionStats &$question ) {
		global $qp_enable_showresults;
		# parse the question body
		$buffer = '';
		if ( $question->getQuestionAnswer( $this->pollStore ) ) {
		# check whether the current global showresults level allows to display statistics
			if ( $qp_enable_showresults == 0 ||
					( $qp_enable_showresults <= 1 && !$question->alreadyVoted ) ) {
				# suppress the output
				return '';
			}
			$buffer = $question->renderStats();
		}
		$output_table = array( '__tag' => 'table', '__end' => "\n", 'class' => 'object' );
		# Determine the side border color the question.
		$output_table[] = array( '__tag' => 'tbody', '__end' => "\n", 0 => $buffer );
		$tags = array( '__tag' => 'div', '__end' => "\n", 'class' => 'question',
			0 => array( '__tag' => 'div', '__end' => "\n", 'class' => 'header',
				0 => array( '__tag' => 'span', 'class' => 'questionId', 0 => $question->mQuestionId )
			),
			1 => $this->parser->recursiveTagParse( $question->mCommonQuestion . "\n" )
		);
		$tags[] = &$output_table;
		return qp_Renderer::renderHTMLobject( $tags );
	}

}

/**
 * Processes poll markup in declaration/voting mode
 */
class qp_Poll extends qp_AbstractPoll {

	function __construct( $argv, &$parser ) {
		parent::__construct( $argv, $parser );
		# order_id is used to sort out polls on the Special:PollResults statistics page
		$this->mOrderId = self::$sOrderId;
		# Determine if this poll is being corrected or not, according to the pollId
		$this->mBeingCorrected = ( $this->mRequest->getVal( 'pollId' ) == $this->mPollId );
	}

	# prepare qp_PollStore object
	# @return    true on success ($this->pollStore has been created successfully), error string on failure
	function getPollStore() {
		# check the headers for errors
		if ( $this->mPollId == null ) {
			$this->mState = "error";
			return self::fatalError( 'qp_error_no_poll_id' );
		}
		if ( !self::isValidPollId( $this->mPollId ) ) {
			$this->mState = "error";
			return self::fatalError( 'qp_error_invalid_poll_id', $this->mPollId );
		}
		if ( !self::isUniquePollId( $this->mPollId ) ) {
			$this->mState = "error";
			return self::fatalError( 'qp_error_already_used_poll_id', $this->mPollId );
		}
		self::addPollId( $this->mPollId ); // add current poll id to the static list of poll ids on this page
		if ( $this->pollAddr !== null ) {
			$this->mState = "error";
			return self::fatalError( 'qp_error_address_in_decl_mode' );
		}
		if ( $this->dependsOn != '' ) {
			$depsOnAddr = self::getPrefixedPollAddress( $this->dependsOn );
			if ( is_array( $depsOnAddr ) ) {
				$this->dependsOn = $depsOnAddr[2];
			} else {
				return self::fatalError( 'qp_error_invalid_dependance_value', $this->mPollId, $this->dependsOn );
			}
		}
		if ( ( $dependanceResult = $this->checkDependance( $this->dependsOn ) ) !== true ) {
			# return an error string
			# here we create a pollstore only to update poll attributes (order_id,dependance), in case these were changed
			$this->pollStore = new qp_PollStore( array(
				'from' => 'poll_get',
				'poll_id' => $this->mPollId,
				'order_id' => $this->mOrderId,
				'dependance' => $this->dependsOn ) );
			return $dependanceResult;
		}
		if ( $this->mBeingCorrected ) {
			$this->pollStore = new qp_PollStore( array(
			'from' => 'poll_post',
			'poll_id' => $this->mPollId,
			'order_id' => $this->mOrderId,
			'dependance' => $this->dependsOn ) );
			$this->pollStore->loadQuestions();
			$this->pollStore->setLastUser( $this->username, false );
			$this->pollStore->loadUserAlreadyVoted();
		} else {
			$this->pollStore = new qp_PollStore( array(
				'from' => 'poll_get',
				'poll_id' => $this->mPollId,
				'order_id' => $this->mOrderId,
				'dependance' => $this->dependsOn ) );
			$this->pollStore->loadQuestions();
			$this->pollStore->setLastUser( $this->username, false );
			# to show previous choice of current user, if that's available
			# do not check the result, because user can vote even if haven't voted before
			$this->pollStore->loadUserVote();
		}
		return true;
	}

	# parse the text enclosed in poll tag
	# @param    $input - text enclosed in poll tag
	# @return   string representing rendered set of the questions / boolean true - stop further processing
	function parseInput( $input ) {
		global $wgTitle, $wgArticle;
		# Process the input
		$output = $this->parseQuestions( $input );
		# check whether the poll was successfully submitted
		if ( $this->pollStore->stateComplete() ) {
			# store user vote to the DB (when the poll is fine)
			$this->pollStore->setLastUser( $this->username );
			$this->pollStore->setUserVote();
		}
		if ( $this->pollStore->voteDone ) {
			$this->mResponse->setcookie( 'QPoll', 'clearCache', time() + 20 );
			$this->mResponse->header( 'HTTP/1.0 302 Found' );
			$this->mResponse->header( 'Location: ' . $wgTitle->getFullURL() . self::getPollTitleFragment( $this->mPollId ) );
			return true;
		}
		return $output;
	}

	# encloses the output of $this->parseQuestions() into the output tag wrappers
	# @param   $input - the output of $this->parseQuestions()
	# @return  rendered "final" html
	function generateOutput( $input ) {
		global $wgOut, $wgRequest;
		# increase the order_id counter for the future successfully declared polls
		# (remember, we're in declaration mode, where 'order_id' is important
		self::$sOrderId++;
		# Generates the output.
		$qpoll_div = array( '__tag' => 'div', 'class' => 'qpoll' );
		$qpoll_div[] = array( '__tag' => 'a', 'name' => self::getPollTitleFragment( $this->mPollId, '' ), 0 => '' );
		$qpoll_form = array( '__tag' => 'form', 'method' => 'post', 'action' => self::getPollTitleFragment( $this->mPollId ), '__end' => "\n" );
		$qpoll_div[] = &$qpoll_form;
		# Determine the content of the settings table.
		$settings = Array();
		if ( $this->mState != '' ) {
			$settings[0][] = array( '__tag' => 'td', 'class' => 'margin', 'style' => 'background: ' . QP_CSS_ERROR_COLOR2 . ';' );
			$settings[0][] = array( '__tag' => 'td', 0 => wfMsgHtml( 'qp_result_' . $this->mState ) );
		}
		# Build the settings table.
		if ( count( $settings ) > 0 ) {
			$settingsTable = array( '__tag' => 'table', 'class' => 'settings', '__end' => "\n" );
			foreach ( $settings as $settingsTr ) {
				$settingsTable[] = array( '__tag' => 'tr', 0 => $settingsTr, '__end' => "\n" );
			}
			$qpoll_form[] = &$settingsTable;
		}
		$qpoll_form[] = array( '__tag' => 'input', 'type' => 'hidden', 'name' => 'pollId', 'value' => $this->mPollId );
		$qpoll_form[] = array( '__tag' => 'div', 'class' => 'pollQuestions', 0 => $input );
		$submitBtn = array( '__tag' => 'input', 'type' => 'submit' );
		$submitMsg = 'qp_vote_button';
		if ( $this->pollStore->isAlreadyVoted() ) {
			$submitMsg = 'qp_vote_again_button';
		}
		if ( $this->mBeingCorrected ) {
			if ( $this->pollStore->getState() == "complete" ) {
				$submitMsg = 'qp_vote_again_button';
			}
		} else {
			if ( $this->pollStore->getState() == "error" ) {
				$submitBtn[ 'disabled' ] = 'disabled';
			}
		}
		# disable submit button in preview mode & printable version
		if ( $wgRequest->getVal( 'action' ) == 'submit' ||
				$wgOut->isPrintable() ) {
			$submitBtn[ 'disabled' ] = 'disabled';
		}
		$submitBtn[ 'value' ] = wfMsgHtml( $submitMsg );
		$p = array( '__tag' => 'p' );
		$p[] = $submitBtn;
		$qpoll_form[] = &$p;
		return qp_Renderer::renderHTMLobject( $qpoll_div );
	}

	# check whether the poll is dependant on other polls
	# @param     $dependsOn - poll address on which the current (recursive) poll is dependant
	# @param     $nonVotedDepLink - maintains different logic for recursion
	#	value: string - link to the poll in chain which has not been voted yet OR
	#	value: boolean - false when there was no poll in the chain which has not been voted yet
	# @return    true when dependance is fulfilled, error message otherwise
	private function checkDependance( $dependsOn, $nonVotedDepLink = false ) {
		# check the headers for dependance to other polls
		if ( $dependsOn !== '' ) {
			$depPollStore = qp_PollStore::newFromAddr( $dependsOn );
			if ( $depPollStore instanceof qp_PollStore ) {
				# process recursive dependance
				$depTitle = $depPollStore->getTitle();
				$depPollId = $depPollStore->mPollId;
				$depLink = self::$skin->link( $depTitle, $depTitle->getPrefixedText() . ' (' . $depPollStore->mPollId . ')' );
				if ( $depPollStore->pid === null ) {
					return self::fatalError( 'qp_error_missed_dependance_poll', $this->mPollId, $depLink, $depPollId );
				}
				if ( !$depPollStore->loadQuestions() ) {
					return self::fatalError( 'qp_error_vote_dependance_poll', $depLink );
				}
				$depPollStore->setLastUser( $this->username, false );
				if ( $depPollStore->loadUserAlreadyVoted() ) {
					# user already voted in current the poll in chain
					if ( $depPollStore->dependsOn === '' ) {
						if ( $nonVotedDepLink === false ) {
							# there was no non-voted deplinks in the chain at some previous level of recursion
							return true;
						} else {
							# there is an non-voted deplink in the chain at some previous level of recursion
							return self::fatalError( 'qp_error_vote_dependance_poll', $nonVotedDepLink );
						}
					} else {
						return $this->checkDependance( $depPollStore->dependsOn, $nonVotedDepLink );
					}
				} else {
					# user hasn't voted in current the poll in chain
					if ( $depPollStore->dependsOn === '' ) {
						# current element of chain is not voted and furthermore, doesn't depend on any other polls
						return self::fatalError( 'qp_error_vote_dependance_poll', $depLink );
					} else {
						# current element of chain is not voted, BUT it has it's own dependance
						# so we will check for the most deeply nested poll which hasn't voted, yet
						return $this->checkDependance( $depPollStore->dependsOn, $depLink );
					}
				}
			} else {
				# process poll address errors
				switch ( $depPollStore ) {
				case QP_ERROR_INVALID_ADDRESS :
					return self::fatalError( 'qp_error_invalid_dependance_value', $this->mPollId, $dependsOn );
				case QP_ERROR_MISSED_TITLE :
					$depSplit = self::getPrefixedPollAddress( $dependsOn );
					if ( is_array( $depSplit ) ) {
						list( $depTitleStr, $depPollId ) = $depSplit;
						$depTitle = Title::newFromURL( $depTitleStr );
						$depTitleStr = $depTitle->getPrefixedText();
						$depLink = self::$skin->link( $depTitle, $depTitleStr );
						return self::fatalError( 'qp_error_missed_dependance_title', $this->mPollId, $depLink, $depPollId );
					} else {
						return self::fatalError( 'qp_error_invalid_dependance_value', $this->mPollId, $dependsOn );
					}
				default :
					throw new MWException( __METHOD__ . ' invalid dependance poll store found' );
				}
			}
		} else {
			return true;
		}
	}

	# Replace questions from QPoll syntax to HTML
	# @param    $input - A question in QPoll syntax
	# @return   string representing rendered set of the questions / empty string "suggests" redirect
	function parseQuestions( $input ) {
		$write_row = Array();
		$write_col = Array();
		$questions = Array();
		$splitPattern = '`(^|\n\s*)\n\s*{`u';
		$unparsedQuestions = preg_split( $splitPattern, $input, -1, PREG_SPLIT_NO_EMPTY );
		$questionPattern = '`(.*?[^|\}])\}[ \t]*(\n(.*)|$)`su';
		# first pass: parse the headers
		foreach ( $unparsedQuestions as $unparsedQuestion ) {
			# If this "unparsedQuestion" is not a full question,
			# we put the text into a buffer to add it at the beginning of the next question.
			if ( !empty( $buffer ) ) {
				$unparsedQuestion = "$buffer\n\n{" . $unparsedQuestion;
			}
			if ( preg_match( $questionPattern, $unparsedQuestion, $matches ) ) {
				$buffer = "";
				$header = isset( $matches[1] ) ? $matches[1] : '';
				$body = isset( $matches[3] ) ? $matches[3] : null;
				$questions[] = $this->parseQuestionHeader( $header, $body );
			} else {
				$buffer = $unparsedQuestion;
			}
		}
		# analyze question headers
		# check for showresults attribute
		$questions_set = Array();
		foreach ( $questions as &$question ) {
			if ( $question->showResults['type'] != 0 &&
						method_exists( 'qp_Question', 'addShowResults' . $question->showResults['type'] ) ) {
				$questions_set[] = $question->mQuestionId;
			}
		}
		# load the statistics for all/selective/none of questions
		if ( count( $questions_set ) > 0 ) {
			if ( count( $questions_set ) == count( $questions ) ) {
				$this->pollStore->loadTotals();
			} else {
				$this->pollStore->loadTotals( $questions_set );
			}
			$this->pollStore->calculateStatistics();
		}
		# second pass: parse the body
		foreach ( $questions as &$question ) {
			if ( $this->perRow > 1 ) {
				$write_col[] = array( '__tag' => 'td', 'valign' => 'top', 0 => $this->parseQuestionBody( $question ), '__end' => "\n" );
				if ( $this->currCol == 1 ) {
					$write_row[] = array( '__tag' => 'tr', 0 => $write_col, '__end' => "\n" );
					$write_col = Array();
				}
				if ( --$this->currCol < 1 ) {
					$this->currCol = $this->perRow;
				}
			} else {
				$write_row[] = $this->parseQuestionBody( $question );
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
			return qp_Renderer::renderHTMLobject( $question_table );
		} else {
			return qp_Renderer::renderHTMLobject( $write_row );
		}
	}

	# Convert a question on the page from QPoll syntax to HTML
	# @param   $header : the text of question "main" header (common question and XML-like attrs)
	#          $body   : the text of question body (starting with body header which defines categories and spans, followed by proposal list)
	# @return            question object with parsed headers and no data loaded
	function parseQuestionHeader( $header, $body ) {
		$question = new qp_Question( $this->parser, $this->mBeingCorrected, ++$this->mQuestionId, $this->showResults );
		# parse questions common question and XML attributes
		$question->parseMainHeader( $header );
		if ( $question->getState() != 'error' ) {
			# load previous user choice, when it's available and DB header is compatible with parsed header
			if ( $body === null || !method_exists( $question, $question->mType . 'ParseBody' ) ) {
				$question->setState( 'error', wfMsgHtml( 'qp_error_question_not_implemented', qp_Setup::entities( $question->mType ) ) );
			} else {
				# parse the categories and spans (metacategories)
				$question->parseBodyHeader( $body );
			}
		}
		return $question;
	}

	# populate the question with data and build it's HTML representation
	# returns HTML representation of the question
	function parseQuestionBody( &$question ) {
		global $qp_enable_showresults;
		if ( $question->getState() == 'error' ) {
			# error occured during the previously performed header parsing, do not process further
			$buffer = $question->getHeaderError();
			# http get: invalid question syntax, parse errors will cause submit button disabled
			$this->pollStore->stateError();
		} else {
			# populate $question with raw source values
			$question->getQuestionAnswer( $this->pollStore );
			# check whether the global showresults level prohibits to show statistical data
			# to the users who hasn't voted
			if ( $qp_enable_showresults <= 1 && !$question->alreadyVoted ) {
				# suppress statistical results when the current user hasn't voted the question
				$question->showResults = Array( 'type' => 0 );
			}
			# parse the question body
			# store the html result into the buffer to determine some parameters before outputing it
			# warning! parameters are passed only by value, not the reference
			$buffer = $question-> { $question->mType . 'ParseBody' } ();
			if ( $this->mBeingCorrected ) {
				if ( $question->getState() == '' ) {
					# question is OK, store it into pollStore
					$question->store( $this->pollStore );
				} else {
					# http post: not every proposals were answered: do not update DB
					$this->pollStore->stateIncomplete();
				}
			} else {
				# this is the get, not the post: do not update DB
				if ( $question->getState() == '' ) {
					$this->pollStore->stateIncomplete();
				} else {
					# http get: invalid question syntax, parse errors will cause submit button disabled
					$this->pollStore->stateError();
				}
			}
		}
		$output_table = array( '__tag' => 'table', '__end' => "\n", 'class' => 'object' );
		# Determine the side border color the question.
		if ( $question->getState() != "" ) {
			global $wgContLang;
			$style = $wgContLang->isRTL() ? 'border-right' : 'border-left';
			$style .= ': 3px solid ' . QP_CSS_ERROR_COLOR2 . ';';
			$output_table[ 'style' ] = $style;
			$this->mState = $question->getState();
		}
		$output_table[] = array( '__tag' => 'tbody', '__end' => "\n", 0 => &$buffer );
		$tags = array( '__tag' => 'div', '__end' => "\n", 'class' => 'question',
			0 => array( '__tag' => 'div', '__end' => "\n", 'class' => 'header',
				0 => array( '__tag' => 'span', 'class' => 'questionId', 0 => $question->mQuestionId )
			),
			1 => $this->parser->recursiveTagParse( $question->mCommonQuestion . "\n" )
		);
		$tags[] = &$output_table;
		return qp_Renderer::renderHTMLobject( $tags );
	}

}

/* render output data */
class qp_Renderer {
	// the stucture of $tag is like this:
	// array( "__tag"=>"td", "class"=>"myclass", 0=>"text before li", 1=>array( "__tag"=>"li", 0=>"text inside li" ), 2=>"text after li" )
	// both tagged and tagless lists are supported
	static function renderHTMLobject( &$tag ) {
		$tag_open = "";
		$tag_close = "";
		$tag_val = null;
		if ( is_array( $tag ) ) {
			ksort( $tag );
			if ( array_key_exists( '__tag', $tag ) ) {
				# list inside of tag
				$tag_open .= "<" . $tag[ '__tag' ];
				foreach ( $tag as $attr_key => &$attr_val ) {
					if ( is_int( $attr_key ) ) {
						if ( $tag_val === null )
							$tag_val = "";
						if ( is_array( $attr_val ) ) {
							# recursive tags
							$tag_val .= self::renderHTMLobject( $attr_val );
						} else {
							# text
							$tag_val .= $attr_val;
						}
					} else {
						# string keys are for tag attributes
						if ( substr( $attr_key, 0, 2 ) != "__" ) {
							# include only non-reserved attributes
							$tag_open .= " $attr_key=\"" . $attr_val . "\"";
						}
					}
				}
				if ( $tag_val !== null ) {
					$tag_open .= ">";
					$tag_close .= "</" . $tag[ '__tag' ] . ">";
				} else {
					$tag_open .= " />";
				}
				if ( array_key_exists( '__end', $tag ) ) {
					$tag_close .= $tag[ '__end' ];
				}
			} else {
				# tagless list
				$tag_val = "";
				foreach ( $tag as $attr_key => &$attr_val ) {
					if ( is_int( $attr_key ) ) {
						if ( is_array( $attr_val ) ) {
							# recursive tags
							$tag_val .= self::renderHTMLobject( $attr_val );
						} else {
							# text
							$tag_val .= $attr_val;
						}
					} else {
						ob_start();
						var_dump( $tag );
						$tagdump = ob_get_contents();
						ob_end_clean();
						$tag_val = "invalid argument: tagless list cannot have tag attribute values in key=$attr_key, $tagdump";
					}
				}
			}
		} else {
			# just a text
			$tag_val = $tag;
		}
		return $tag_open . $tag_val . $tag_close;
	}

	# creates one "htmlobject" row of the table
	# elements of $row can be either a string/number value of cell or an array( "count"=>colspannum, "attribute"=>value, 0=>html_inside_tag )
	# attribute maps can be like this: ("name"=>0, "count"=>colspan" )
	static function newRow( $row, $rowattrs = "", $celltag = "td", $attribute_maps = null ) {
		$result = "";
		if ( count( $row ) > 0 ) {
			foreach ( $row as &$cell ) {
				if ( !is_array( $cell ) ) {
					$cell = array( 0 => $cell );
				}
				$cell[ '__tag' ] = $celltag;
				$cell[ '__end' ] = "\n";
				if ( is_array( $attribute_maps ) ) {
					# converts ("count"=>3) to ("colspan"=>3) in table headers - don't use frequently
					foreach ( $attribute_maps as $key => $val ) {
						if ( array_key_exists( $key, $cell ) ) {
							$cell[ $val ] = $cell[ $key ];
							unset( $cell[ $key ] );
						}
					}
				}
			}
			$result = array( '__tag' => 'tr', 0 => $row, '__end' => "\n" );
			if ( is_array( $rowattrs ) ) {
				$result = array_merge( $rowattrs, $result );
			} elseif ( $rowattrs !== "" )  {
				$result[0][] = __METHOD__ . ':invalid rowattrs supplied';
			}
		}
		return $result;
	}

	# add row to the table
	static function addRow( &$table, $row, $rowattrs = "", $celltag = "td", $attribute_maps = null ) {
		$table[] = self::newRow( $row, $rowattrs, $celltag, $attribute_maps );
	}

	# add column to the table
	static function addColumn( &$table, $column, $rowattrs = "", $celltag = "td", $attribute_maps = null ) {
		if ( count( $column ) > 0 ) {
			$row = 0;
			foreach ( $column as &$cell ) {
				if ( !is_array( $cell ) ) {
					$cell = array( 0 => $cell );
				}
				$cell[ '__tag' ] = $celltag;
				$cell[ '__end' ] = "\n";
				if ( is_array( $attribute_maps ) ) {
					# converts ("count"=>3) to ("rowspan"=>3) in table headers - don't use frequently
					foreach ( $attribute_maps as $key => $val ) {
						if ( array_key_exists( $key, $cell ) ) {
							$cell[ $val ] = $cell[ $key ];
							unset( $cell[ $key ] );
						}
					}
				}
				if ( is_array( $rowattrs ) ) {
					$cell = array_merge( $rowattrs, $cell );
				} elseif ( $rowattrs !== "" ) {
					$cell[ 0 ] = __METHOD__ . ':invalid rowattrs supplied';
				}
				if ( !array_key_exists( $row, $table ) ) {
					$table[ $row ] = array( '__tag' => 'tr', '__end' => "\n" );
				}
				$table[ $row ][] = $cell;
				if ( array_key_exists( 'rowspan', $cell ) ) {
					$row += intval( $cell[ 'rowspan' ] );
				} else {
					$row++;
				}
			}
			$result = array( '__tag' => 'tr', 0 => $column, '__end' => "\n" );
		}
	}

	static function displayRow( $row, $rowattrs = "", $celltag = "td", $attribute_maps = null ) {
		return self::renderHTMLobject( self::newRow( $row, $rowattrs, $celltag, $attribute_maps ) );
	}

	// use newRow() or addColumn() to add resulting row/column to the table
	// if you want to use the resulting row with renderHTMLobject(), don't forget to apply attrs=array('__tag'=>'td')
	static function applyAttrsToRow( &$row, $attrs ) {
		if ( is_array( $attrs ) && count( $attrs > 0 ) ) {
			foreach ( $row as &$cell ) {
				if ( !is_array( $cell ) ) {
					$cell = array_merge( $attrs, array( $cell ) );
				} else {
					foreach ( $attrs as $attr_key => $attr_val ) {
						if ( !array_key_exists( $attr_key, $cell ) ) {
							$cell[ $attr_key ] = $attr_val;
						}
					}
				}
			}
		}
	}
}

class qp_FunctionsHook {

	var $frame;
	var $args;

	var $pollAddr;
	var $pollStore;
	var $question_id = '';
	var $proposal_id = '';
	var $defaultProposalText;

	var $error_message = 'no_such_poll';

	function qpuserchoice( &$parser, $frame, $args ) {
		qp_Setup::loadMessages();
		$this->frame = &$frame;
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
							if ( is_numeric( $this->proposal_id ) && $this->proposal_id >= 0 ) {
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
		if ( is_numeric( $this->question_id ) ) {
			$this->question_id = intval( $this->question_id );
			$this->pollStore->loadQuestions();
			$this->pollStore->setLastUser( qp_AbstractPoll::currentUserName(), false );
			$this->pollStore->loadUserVote();
			$this->error_message = 'missing_question_id';
			if ( array_key_exists( $this->question_id, $this->pollStore->Questions ) ) {
				return $this->pollStore->Questions[ $this->question_id ];
			}
		}
		return false;
	}

	function qpuserchoiceValidResult( $qdata ) {
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
		# do not need to use qp_Setup::entities because the result is a wikitext (will be escaped by parser)
		return $result;
	}

}
