<?php

/**
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com>
 */

class AjaxPollClass {

	/**
	 * check for table existence
	 */
	const BAR_WIDTH = "250"; #-- pixels

	public $mId, $mBody, $mAttribs, $mParser, $mQuestion, $mStatus, $mTotal;
	public $mTitle, $mCreated;
	public $mAnswers = array();

	public static $mCount = 0; # macbre: count ajax polls on the page

	/**
	 * __construct
	 */
	public function __construct() {

		wfLoadExtensionMessages("AjaxPoll");
	}


	/**
	 * renderFromTag
	 *
	 * static constructor/callback function
	 *
	 * @access public
	 * @static
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @param string $input: Text from tag
	 * @param array $params: atrributions
	 * @param Object $parser: Wiki Parser object
	 */
	static public function renderFromTag( $input, $params, &$parser ) {
		global $wgOut;

		/**
		 * ID of the poll
		 */
		$id = strtoupper( md5( $input ) );
		$input = trim( strip_tags( $parser->recursiveTagParse( $input ) ) );

		$class = new AjaxPollClass;
		$class->mId = $id;
		$class->mBody = $input;
		$class->mTitle = $parser->getTitle();
		$class->mParser = $parser;
		$class->mAttribs = $params;

		return $class->render();
	}

	/**
	 * newFromId
	 *
	 * static constructor/callback function. Doesn't have full information
	 * about poll, used only in Ajax initialization for submitting votes
	 *
	 * @access public
	 * @static
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @param string $poll_id	poll identifier in database
	 */
	static public function newFromId( $poll_id ) {
		global $wgTitle, $wgParser;

		$class = new AjaxPollClass;

		$class->mId = $poll_id;
		$class->mTitle = $wgTitle;
		$class->mParser = $wgParser;
		$class->mAttribs = array();
		$class->mBody = "";

		return $class;
	}

	/**
	 * save
	 *
	 * save data about poll into database
	 *
	 * @access private
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @return boolean	status of operation
	 */
	private function save() {
		global $wgParser;
		$status = false;

		if( is_null( $this->mId ) ) {
			return $status;
		}

		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		$oRow = $dbw->selectRow(
			array( "poll_info" ),
			array( "*" ),
			array( "poll_id" => $this->mId ),
			__METHOD__
		);
		if( isset( $oRow->poll_id ) ) {
			$this->mCreated = $oRow->poll_date;
		} else {
			$this->mCreated = date("Y-m-d H:i:s");
			$status = $dbw->insert(
				"poll_info",
				array(
					"poll_id" => $this->mId,
					"poll_txt" => $this->mBody,
					"poll_date" => $this->mCreated,
					"poll_title" => $wgParser->mTitle->getText(),
				),
				__METHOD__
			);
		}
		$dbw->commit();
		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * renderVotes
	 *
	 * get HTML for votes
	 *
	 * @return array: votes for this pool
	 */
	public function getVotes() {
		global $wgLang;

		if ( is_null( $this->mId ) ) {
			return null;
		}
		wfProfileIn( __METHOD__ );

		$votes = array();
		$total = 0;

		$dbr = wfGetDB( DB_SLAVE );
		$oRes = $dbr->select(
			array( "poll_vote" ),
			array( "poll_answer", "poll_user" ),
			array( "poll_id" => $this->mId ),
			__METHOD__
		);

		while( $oRow = $dbr->fetchObject( $oRes ) ) {
			if( isset( $votes[ $oRow->poll_answer ] ) ) {
				$votes[ $oRow->poll_answer ][ "value" ]++;
			} else {
				$votes[ $oRow->poll_answer ][ "value" ] = 1;
			}
			$total++;
		}
		$dbr->freeResult( $oRes );

		/**
		 * count percentage of answers
		 */
		foreach( $votes as $nr => $vote ) {
			$percent = $vote[ "value" ] / $total * 100;
			$votes[ $nr ][ "percent" ] = round($percent, 2);
			$votes[ $nr ][ "pixels" ] = $this->percent2pixels( $percent );

			$percent = $wgLang->formatNum(round($percent, 2));
			$votes[ $nr ][ "title" ] = wfMsg("ajaxpoll-percentVotes", $percent);
			$votes[ $nr ][ "key" ] = $nr;
		}
		wfProfileOut( __METHOD__ );

		return array( $votes, $total );
	}

	/**
	 * render
	 *
	 * render HTML code of poll
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak (eloy)
	 *
	 * @return string: rendered HTML code
	 */
	public function render() {
		global $wgRequest, $wgContLang;

		wfProfileIn( __METHOD__ );

		wfDebug("AjaxPoll: rendering poll #" . self::$mCount . "\n");

		/**
		 * check, maybe form is submited?
		*/
		if( $wgRequest->wasPosted() ) {
			wfDebug( __METHOD__."(): posted without ajax\n" );
			$this->doSubmit( $wgRequest );
		}
		/**
		 * save if not saved
		 */
		$this->save();

		wfDebug( __METHOD__."(): rendering Ajax poll {$this->mId}\n" );
		list( $question, $answers ) = $this->parseInput();
		list( $votes, $total ) = $this->getVotes();

		// macbre: add CSS to the first ajax poll on the page
		$before = '<!-- AjaxPoll #'. self::$mCount .' -->';

		// RT #20789
		global $wgWysiwygTemplatesParserEnabled;
		if (empty($wgWysiwygTemplatesParserEnabled)) {
			global $wgExtensionsPath, $wgStyleVersion;

			// load CSS/JS only when needed
			$before .= <<<JS
<script type="text/javascript">/*<![CDATA[*/
wgAfterContentAndJS.push(function() {
	if (!window.AjaxPollLoaded) {
		importStylesheetURI('{$wgExtensionsPath}/wikia/AjaxPoll/AjaxPoll.css?{$wgStyleVersion}');
		importScriptURI('{$wgExtensionsPath}/wikia/AjaxPoll/AjaxPoll.js?{$wgStyleVersion}');
		window.AjaxPollLoaded = true;
	}
});
/*]]>*/</script>
JS;
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$timestamp = wfTimestamp( TS_MW, $this->mCreated );
		$oTmpl->set_vars( array(
			"id"		=> $this->mId,
			"votes"		=> $votes,
			"total"		=> $total,
			"answers"	=> $answers,
			"question"	=> $question,
			"title"		=> $this->mTitle,
			"status"	=> $this->mStatus,
			"attribs"	=> $this->mAttribs,
			"created_time"	=> $wgContLang->time( $timestamp ),
			"created_date"	=> $wgContLang->date( $timestamp ),
		));

		$before .= $oTmpl->execute( "poll" );
		$out = "";
		/**
		 * trim lines to avoid parser false behaviour
		 */
		$lines = explode( "\n", $before );
		if( is_array( $lines ) ) {
			foreach( $lines as $line ) {
				$out .= trim( $line );
			}
		} else {
			$out = trim( $before );
		}

		self::$mCount++;

		wfProfileOut( __METHOD__ );

		return $out;
	}

	/**
	 * percent2pixels
	 *
	 * count number of pixels which represents percentage of answers
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 * @access private
	 *
	 * @return integer	number of pixels
	 */
	private function percent2pixels( $percent ) {
		return (int )( ( $percent * self::BAR_WIDTH ) / 100 );
	}

	/**
	 * parseInput
	 *
	 * parse text from tag, serparate question, split answers
	 *
	 * @access private
	 *
	 * @return mixed: question and answers
	 */
	private function parseInput() {

		$answers = array();
		$lines = explode( "\n", trim( $this->mBody ) );
		if( is_array( $lines ) ) {
			foreach( $lines as $nr => $line ) {
				if( $nr == 0 ) {
					$question = $line;
				} else {
					/**
					 * $nr + 1 is for compatibility with old poll extension
					 */
					$answers[ $nr + 1 ] = $line;
				}
			}
		}

		/**
		 * parse tag attributes
		 */
		$this->parseAttribs();

		/**
		 * put to local variables anyway
		 */
		$this->mQuestion = $question;
		$this->mAnswers = $answers;

		return array( $question, $answers );
	}

	/**
	 * parseAttribs
	 *
	 * parse tag attributes
	 *
	 * @access private
	 *
	 */
	private function parseAttribs() {
		$this->mStatus = isset( $this->mAttribs["status"] )
			? $this->mAttribs["status"] : "open";

	}

	/**
	 * doSubmit
	 *
	 * parse tag attributes
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 * @access public
	 *
	 * @param object	$request	WebRequest object
	 *
	 * @return array	rendered HTML answer and status of operation
	 */
	public function doSubmit( &$request ) {
		global $wgUser, $wgTitle, $parserMemc;

		$status = false;
		$vote = $request->getVal( "wpPollRadio" . $this->mId, null );

		if( !is_null( $vote ) ) {
			if( $this->doVote( $vote ) ) {
				$status = wfMsg( "ajaxpoll-thankyou" );

				// invalidate cache
				$wgTitle->invalidateCache();

				// clear parser cache
				$oArticle = new Article($wgTitle);
				$parserCache =& ParserCache::singleton();
				$parserMemc->set( $parserCache->getKey($oArticle, $wgUser), null, 0 );

				// Send purge
				$update = SquidUpdate::newSimplePurge( $wgTitle );
				$update->doUpdate();
			} else {
				$status = wfMsg( "ajaxpoll-error" );
			}
		}
		list ( $votes, $total ) = $this->getVotes();
		$response = array(
			"id" =>	$this->mId,
			"votes" => $votes,
			"total" => $total,
			"status" => $status
		);
		return $response;
	}

	/**
	 * doVote
	 *
	 * store vote in database
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 * @access private
	 *
	 * @param integer	$answer	number of question
	 *
	 */
	private function doVote( $answer ) {
		global $wgUser;

		wfProfileIn( __METHOD__ );

		$ip = wfGetIP();
		$user = $wgUser->getName();

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		/**
		 * delete old answer (if any)
		 */
		$dbw->delete(
			"poll_vote",
			array(
				"poll_id"     => $this->mId,
				"poll_user"   => $user,
			),
			__METHOD__
		);

		/**
		 * insert new one
		 */
	    $status = $dbw->insert(
			"poll_vote",
			array(
				"poll_id"     => $this->mId,
				"poll_user"   => $user,
				"poll_ip"     => $ip,
				"poll_answer" => $answer,
				"poll_date"   => date("Y-m-d H:i:s")
			),
			__METHOD__
		);
		$dbw->commit();

		wfDebug( __METHOD__ . "(): invalidate cache because of voting\n" );
		$this->mTitle->invalidateCache();

		wfProfileOut( __METHOD__ );

		return $status;
	}

	static function _log( $what ){
		error_log( print_r( $what, true ) );
	}

	/**
	 * create table with update.php
	 */
	static public function schemaUpdate() {
		global $wgDBtype, $wgExtNewFields, $wgExtPGNewFields, $wgExtNewIndexes, $wgExtNewTables;
		$wgExtNewTables[] = array( "poll_vote", dirname(__FILE__) . "/patch-create-poll_vote.sql" );

		return true;
	}
}
