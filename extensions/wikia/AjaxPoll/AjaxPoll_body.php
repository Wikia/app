<?php

/**
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com>
 */

class AjaxPollClass {

	/**
	 * check for table existence
	 */
	const BAR_WIDTH = "250"; #-- pixels
	const MEMC_PREFIX_GETVOTES = 'AjaxPollClass::getVotes';

	public $mId, $mBody, $mAttribs, $mParser, $mQuestion, $mStatus, $mTotal;
	/* @var Title $mTitle */
	public $mTitle, $mCreated;
	public $mAnswers = array();

	public static $mCount = 0; # macbre: count ajax polls on the page

	/**
	 * renderFromTag
	 *
	 * static constructor/callback function
	 *
	 * @access public
	 * @static
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @param string $input : Text from tag
	 * @param array $params : atrributions
	 * @param Object $parser : Wiki Parser object
	 *
	 * @return string
	 */
	static public function renderFromTag( $input, $params, $parser ) {
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

		/**
		 * Render poll as closed for polls in forum posts to be migrated to feeds.
		 */
		if ( !empty( getenv( 'FORUM_MIGRATION' ) ) ) {
			$class->mAttribs['status'] = 'close';
		}

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
	 * @param string $poll_id poll identifier in database
	 *
	 * @return AjaxPollClass
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
					"poll_title" => $this->mTitle->getText(),
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
	 * @param bool $isSubmit
	 *
	 * @return array : votes for this poll
	 */
	public function getVotes( $isSubmit = false ) {
		global $wgLang, $wgMemc;

		if ( is_null( $this->mId ) ) {
			return null;
		}
		wfProfileIn( __METHOD__ );

		$votes = array();
		$total = 0;

		$memcKey = $this->getVotesMemKey();
		if ( !$isSubmit ) {
			$votes = $wgMemc->get( $memcKey );
		}
		if ( !empty( $votes ) ) {
			foreach( $votes as $ansData ){
				$total += $ansData["value"];
			}
		} else {
			$dbr = wfGetDB( $isSubmit ? DB_MASTER : DB_SLAVE );

			$votes = ( new WikiaSQL() )
				->SELECT( 'poll_answer' )
					->COUNT( '*' )->AS_( 'count' )
				->FROM( 'poll_vote' )
				->WHERE( 'poll_id' )->EQUAL_TO( $this->mId )
				->GROUP_BY( 'poll_answer' )
				->runLoop( $dbr, function( &$votes, $row ) use ( &$total ) {
					$votes[$row->poll_answer]['value'] = $row->count;
					$total += $row->count;
				} );

			/**
			 * count percentage of answers
			 */
			foreach( $votes as $nr => &$vote ) {
				$percent = $vote[ 'value' ] / $total * 100;
				$vote['percent'] = round( $percent, 2 );
				$vote['pixels'] = $this->percent2pixels( $percent );
				$vote['key'] = $nr;

				/* @var Language $wgLang */
				$percent = $wgLang->formatNum(round($percent, 2));
				$vote[ "title" ] = wfMsg("ajaxpoll-percentVotes", $percent);
			}

			// NOTE: Remember to purge everywhere that poll_vote is updated.
			$wgMemc->set( $memcKey, $votes, 3600 );
		}
		wfProfileOut( __METHOD__ );

		return [ $votes, $total ];
	}

	protected function getVotesMemKey() {
		return wfMemcKey( self::MEMC_PREFIX_GETVOTES, $this->mId );
	}

	/**
	 * render
	 *
	 * render HTML code of poll
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak (eloy)
	 * @author Marooned (switching to JSSnippets)
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

		$before = '<!-- AjaxPoll #'. self::$mCount .' -->';

		// load CSS/JS only when needed
		$before .= JSSnippets::addToStack(
			array(
				'/extensions/wikia/AjaxPoll/css/AjaxPoll.scss',
				'/extensions/wikia/AjaxPoll/js/AjaxPoll.js'
			),
			array(),
			'AjaxPoll.init'
		);

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$timestamp = wfTimestamp( TS_MW, $this->mCreated );
		$oTmpl->set_vars( array(
			'id'		=> $this->mId,
			'votes'		=> $votes,
			'total'		=> $total,
			'answers'	=> $answers,
			'question'	=> $question,
			'title'		=> $this->mTitle,
			'status'	=> $this->mStatus,
			'attribs'	=> $this->mAttribs,
			'created_time'	=> $wgContLang->time( $timestamp ),
			'created_date'	=> $wgContLang->date( $timestamp ),
			'forum_migration' => !empty( getenv( 'FORUM_MIGRATION' ) )
		));

		$before .= $oTmpl->render( 'poll' );
		$out = '';
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

		/**
		 * because this parser tag contains elements of interface we need to
		 * inform parser to vary parser cache key by user lang option
		 */
		$this->mParser->mOutput->recordOption('userlang');

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
	 * @param int $percent
	 *
	 * @return int number of pixels
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
		$question = '';
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
		global $wgTitle, $wgMemc;
		wfProfileIn( __METHOD__ );

		$status = false;
		$vote = $request->getVal( "wpPollRadio" . $this->mId, null );

		if( !is_null( $vote ) ) {
			if( $this->doVote( $vote ) ) {
				$status = wfMsg( "ajaxpoll-thankyou" );

				// invalidate cache
				$wgTitle->invalidateCache();

				// Send purge for the article (don't purge its history page - PLATFORM-92)
				SquidUpdate::purge([ $wgTitle->getFullURL() ]);
			} else {
				$status = wfMsg( "ajaxpoll-error" );
			}
		}
		list ( $votes, $total ) = $this->getVotes(true); //true because we need DB_MASTER and we don't want to use memcache here
		$response = array(
			"id" =>	$this->mId,
			"votes" => $votes,
			"total" => $total,
			"status" => $status
		);

		// Purge the vote stats.
		$memcKey = $this->getVotesMemKey();
		$wgMemc->delete($memcKey);

		wfProfileOut( __METHOD__ );
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
	 * @param integer $answer number of question
	 *
	 * @return bool
	 */
	private function doVote( $answer ) {
		global $wgUser, $wgRequest;

		wfProfileIn( __METHOD__ );

		$ip = $wgRequest->getIP();
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
		global $wgExtNewTables;
		$wgExtNewTables[] = array( "poll_vote", __DIR__ . "/patch-create-poll_vote.sql" );
		$wgExtNewTables[] = array( "poll_info", __DIR__ . "/patch-create-poll_info.sql" );
		return true;
	}
}
