<?php
/**
 * Special:FeedbackDashboard. Special page for viewing moodbar comments.
 */
class SpecialFeedbackDashboard extends IncludableSpecialPage {
	protected $showHidden = false;
	protected $action = false;
	
	public function __construct() {
		parent::__construct( 'FeedbackDashboard' );
	}
	
	public function getDescription() {
		return wfMessage( 'moodbar-feedback-title' )->plain();
	}

	public function execute( $par ) {
		global $wgOut, $wgRequest;

		$limit = 20;
		$offset = false;
		$filterType = '';
		$id = intval( $par );
		if ( $id > 0 ) {
			// Special:FeedbackDashboard/123 is an ID/permalink view
			$filters = array( 'id' => $id );
			$filterType = 'id';
			if ( $wgRequest->getCheck( 'show-feedback' ) ) {
				$this->showHidden = true;
			}
			
			if ( $wgRequest->getCheck( 'restore-feedback' ) ) {
				$this->action = 'restore';
			} elseif ( $wgRequest->getCheck( 'hide-feedback' ) ) {
				$this->action = 'hide';
			}
		} else {
			// Determine filters and offset from the query string
			$filters = array();
			$type = $wgRequest->getArray( 'type' );
			if ( $type ) {
				$filters['type'] = $type;
			}
			$username = strval( $wgRequest->getVal( 'username' ) );
			if ( $username !== '' ) {
				$filters['username'] = $username;
			}
			$offset = $wgRequest->getVal( 'offset', $offset );
			if ( count( $filters ) ) {
				$filterType = 'filtered';
			}
		
			// UI should allow users to select one or none
			if ( $wgRequest->getCheck( 'myresponse' ) ) {
				$filters['responsefilter'] = 'myresponse';
			} elseif ( $wgRequest->getCheck( 'showunanswered' ) ) {
				$filters['responsefilter'] = 'showunanswered';
			}
		}
		// Do the query
		$backwards = $wgRequest->getVal( 'dir' ) === 'prev';
		$res = $this->doQuery( $filters, $limit, $offset, $backwards );
		
		// Output HTML
		$wgOut->setPageTitle( wfMsg( 'moodbar-feedback-title' ) );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->addHTML( $this->buildForm( $filterType ) );
		$wgOut->addHTML( $this->buildList( $res ) );
		$wgOut->addModuleStyles( 'ext.moodBar.dashboard.styles' );
		$wgOut->addModules( 'ext.moodBar.dashboard' );
		// Check for interfaceConcurrency extension, remove check when in core.
		if ( class_exists( 'ApiConcurrency') ) {
			$wgOut->addModules( 'jquery.interfaceConcurrency' );
		}

	}
	
	/**
	 * Build the filter form. The state of each form element is preserved
	 * using data in $wgRequest.
	 * @param $filterType string Value to pass in the <form>'s data-filtertype attribute
	 * @return string HTML
	 */
	public function buildForm( $filterType ) {
		global $wgRequest, $wgMoodBarConfig, $wgSitename, $wgUser;
		$filtersMsg = wfMessage( 'moodbar-feedback-filters' )->escaped();
		$typeMsg = wfMessage( 'moodbar-feedback-filters-type' )->escaped();
		$praiseMsg = wfMessage( 'moodbar-feedback-filters-type-happy' )->escaped();
		$confusionMsg = wfMessage( 'moodbar-feedback-filters-type-confused' )->escaped();
		$issuesMsg = wfMessage( 'moodbar-feedback-filters-type-sad' )->escaped();
		$usernameMsg = wfMessage( 'moodbar-feedback-filters-username' )->escaped();
		$setFiltersMsg = wfMessage( 'moodbar-feedback-filters-button' )->escaped();
		$whatIsMsg = wfMessage( 'moodbar-feedback-whatis' )->escaped();
		$whatIsURL = htmlspecialchars( $wgMoodBarConfig['infoUrl'] );
		$actionURL = htmlspecialchars( $this->getTitle()->getLinkURL() );
		
		$types = $wgRequest->getArray( 'type', array() );
		$happyCheckbox = Xml::check( 'type[]', in_array( 'happy', $types ),
			array( 'id' => 'fbd-filters-type-praise', 'value' => 'happy' ) );
		$confusedCheckbox = Xml::check( 'type[]', in_array( 'confused', $types ),
			array( 'id' => 'fbd-filters-type-confusion', 'value' => 'confused' ) );
		$sadCheckbox = Xml::check( 'type[]', in_array( 'sad', $types ),
			array( 'id' => 'fbd-filters-type-issues', 'value' => 'sad' ) );
		$usernameTextbox = Html::input( 'username', $wgRequest->getText( 'username' ), 'text',
			array( 'id' => 'fbd-filters-username', 'class' => 'fbd-filters-input' ) );
		$filterType = htmlspecialchars( $filterType );
		
		
		$moodbarStat = MoodBarUtil::getMoodBarTypeStats();
		$moodbarStatMsg = wfMessage( 'moodbar-type-stats' )->numParams( $moodbarStat['happy'], $moodbarStat['sad'], $moodbarStat['confused'] )->escaped();
		$feedbackDashboardDescription = wfMessage( 'moodbar-feedback-description' )->params( $wgSitename ); // don't escape because there is html 

		$myResponseFilter = '';
		
		if ( !$wgUser->isAnon() ) {
			$myResponseMsg = wfMessage( 'moodbar-feedback-filters-my-response' )->escaped();
			$myResponseCheckbox = Xml::check( 'myresponse', $wgRequest->getCheck( 'myresponse' ),
								array( 'id' => 'fbd-filters-my-response', 'value' => '1', 'class' => 'fbd-filters-check' ) );
			
			$myResponseFilter = $myResponseCheckbox. '<label for="fbd-filters-my-response" id="fbd-filters-type-my-response-label" class="fbd-filters-label">' . 
						$myResponseMsg . '</label>';
		}

		// Show unanswered filter
		$showUnansweredMsg = wfMessage( 'moodbar-feedback-filters-show-unanswered' )->escaped();
		$showUnansweredCheckbox = Xml::check( 'showunanswered', $wgRequest->getCheck( 'showunanswered' ),
							array( 'id' => 'fbd-filters-show-unanswered', 'value' => '1', 'class' => 'fbd-filters-check' ) );
			
		$showUnansweredFilter = $showUnansweredCheckbox . '<label for="fbd-filters-show-unanswered" id="fbd-filters-type-show-unanswered-label" class="fbd-filters-label">' . 
								$showUnansweredMsg . '</label>';

		$leaderBoardElement = self::buildLeaderBoardElement();

		return <<<HTML
		<div id="fbd-description">
			<div id="fbd-description-text">
				$feedbackDashboardDescription
			</div>
		 	<div id="fbd-stats">
		 		$moodbarStatMsg
		 	</div>
		</div>
		<div id="fbd-filters">
			<form action="$actionURL" data-filtertype="$filterType">
				<h3 id="fbd-filters-title">$filtersMsg</h3>
				<fieldset id="fbd-filters-types">
					<legend class="fbd-filters-label">$typeMsg</legend>
					<ul>
						<li>
							$happyCheckbox
							<label for="fbd-filters-type-praise" id="fbd-filters-type-praise-label">$praiseMsg</label>
						</li>
						<li>
							$confusedCheckbox
							<label for="fbd-filters-type-confusion" id="fbd-filters-type-confusion-label">$confusionMsg</label>
						</li>
						<li>
							$sadCheckbox
							<label for="fbd-filters-type-issues" id="fbd-filters-type-issues-label">$issuesMsg</label>
						</li>
					</ul>
				</fieldset>
				<label for="fbd-filters-username" class="fbd-filters-label">$usernameMsg</label>
				$usernameTextbox
				<br class="fbd-clearfix" />
				$myResponseFilter
				<br class="fbd-clearfix" />
				$showUnansweredFilter
				<br class="fbd-clearfix" />
				<button type="submit" id="fbd-filters-set">$setFiltersMsg</button>
			</form>
			<a href="$whatIsURL" id="fbd-about">$whatIsMsg</a>
			$leaderBoardElement
		</div>
HTML;
	}
	
	/**
	 * Format a single list item from a database row.
	 * @param $row Database row object
	 * @param $params An array of flags. Valid flags:
	 * * admin (user can show/hide feedback items)
	 * * show-anyway (user has asked to see this hidden item)
	 * @param $response An array of response for feedback
	 * @return string HTML
	 */
	public static function formatListItem( $row, $params = array(), $response = array() ) {
		global $wgLang, $wgUser;
		
		$classes = array('fbd-item');
		$toolLinks = array();
		
		//in case there is an error constructing the feedbackitem object, 
		//we don't want to throw an error for the entire page.
		try { 
			$feedbackItem = MBFeedbackItem::load( $row );
		}
		catch (Exception $e) {
			$classes = Sanitizer::encodeAttribute( implode(' ', $classes) );
			$error_message = wfMessage('moodbar-feedback-load-record-error')->escaped();
			return <<<HTML
			<li class="$classes">
				<div class="fbd-item-message" dir="auto">$error_message</div>
				<div style="clear:both"></div>
			</li>
HTML;
		}
		
		// Type
		$type = $feedbackItem->getProperty('type');
		$typeMsg = wfMessage( "moodbar-type-$type" )->params( $feedbackItem->getProperty('user') )->escaped();
		
		// Timestamp
		$timestamp = wfTimestamp( TS_UNIX, $feedbackItem->getProperty('timestamp') );
		$timeMsg = wfMessage( 'ago' )->params( MoodBarUtil::formatTimeSince( $timestamp ) )->escaped();
		
		// Comment
		$comment = htmlspecialchars( $feedbackItem->getProperty('comment') );
		
		// User information
		$userInfo = self::buildUserInfo( $feedbackItem );

		// Tool links
		$toolLinks[] = self::getPermalink( $feedbackItem );
		
		// Continuation data
		$id = $feedbackItem->getProperty('id');
		$continueData = wfTimestamp( TS_MW, $timestamp ) . '|' . intval( $id );

		// Now handle hiding, showing, etc		
		if ( $feedbackItem->getProperty('hidden-state') > 0 ) {
			$toolLinks = array();
			if ( !in_array('show-anyway', $params) ) {
				$userInfo = wfMessage('moodbar-user-hidden')->escaped();
				$comment = wfMessage('moodbar-comment-hidden')->escaped();
				$type = 'hidden';
				$typeMsg = '';
				$classes[] = 'fbd-hidden';
			}
			
			if ( in_array('admin', $params) ) {
				if ( in_array('show-anyway', $params) ) {
					$toolLinks[] = self::getHiddenFooter($feedbackItem, 'shown');
				} else {
					$toolLinks[] = self::getHiddenFooter($feedbackItem, 'hidden');
				}
			}
			
		} elseif ( in_array('admin', $params) ) {
			$toolLinks[] = self::getHideLink( $feedbackItem );
			
		}
		
		$responseElements = self::buildResponseElement( $feedbackItem, $response );
		
		$classes = Sanitizer::encodeAttribute( implode(' ', $classes) );
		$toolLinks = implode("\n", $toolLinks );
		
		return <<<HTML
		<li class="$classes" data-mbccontinue="$continueData">
			<div class="fbd-item-emoticon fbd-item-emoticon-$type">
				<span class="fbd-item-emoticon-label">$typeMsg</span>
			</div>
			<div class="fbd-item-time">$timeMsg</div>
			$userInfo
			<div class="fbd-item-message" dir="auto">$comment</div>
			$toolLinks
			$responseElements
			<div style="clear:both"></div>
		</li>
HTML;
	}
	
	/**
	 * Build the HTML for leaderboard
	 * @return html string
	 */
	protected static function buildLeaderBoardElement() {
		global $wgLang;
		
		$topResponders = MoodBarUtil::getTopResponders();

		$html = '';
		
		if ( $topResponders ) {
			foreach ( $topResponders as $row ) {
				$user = User::newFromRow( $row );
				if ( $user && !$user->isAnon() ) {
					$html .= '<li><span>' . $wgLang->formatNum( intval( $row->number ) ) . '</span>' 
							. Linker::userLink( $user->getId(), htmlspecialchars( $user->getName() ) ) . '</li>';
				}
			}
		}

		if ( $html ) {
			$topRespondersTitle = wfMessage( 'moodbar-feedback-top-responders-title' )->escaped();
			
			return <<<HTML
			<div class="fbd-leaderboard-top-responders">
				<h5>$topRespondersTitle</h5>
				<ul class="fbd-leaderboard">
					$html
				</ul>
			</div>
HTML;
		}
		
		return $html;

	}

	protected static function buildResponseElement( $feedbackItem, $response ) {
		global $wgLang, $wgUser;
		
		$responseElements = '';
		
		$id = $feedbackItem->getProperty('id');
		
		$showResponseBox = true;
		
		//Do not show response box if there is a response already
		if ( isset( $response[$id] ) ) {
			$response_detail = $response[$id];

			$responder = User::newFromRow( $response_detail );
			
			if ( $responder && !$responder->isAnon() ) {
				$responsetime 	= MoodBarUtil::formatTimeSince( wfTimestamp( TS_UNIX, $response_detail->mbfr_timestamp ) );
				$commenter 	= $feedbackItem->getProperty('user');
				$permalinkTitle = $commenter->getTalkPage()->getFullText();
				
				if ( property_exists( $response_detail, 'mah_id' ) && intval($response_detail->mah_id ) > 0 ) {
					$individual_response = wfMsgExt('moodbar-feedback-response-helpful-summary', array('parse'),
										$responder->getUserPage()->getFullText(), 
										$responder->getName(), 
										$permalinkTitle . '#feedback-dashboard-response-' . $response_detail->mbfr_id,
										$responsetime,
										$commenter->getUserPage()->getFullText(), 
										$commenter->getName());
				} else {
					$individual_response = wfMsgExt('moodbar-feedback-response-summary', array('parse'),
										$responder->getUserPage()->getFullText(), 
										$responder->getName(), 
										$permalinkTitle . '#feedback-dashboard-response-' . $response_detail->mbfr_id,
										$responsetime);
				}
				$showResponseBox = false;
				
				$responseElements = <<<HTML
								<div class="fbd-item-response">
									$individual_response
								</div>
HTML;
			}			
		}
		//only show response elements if feedback is not hidden, and user is logged in
		elseif ( $showResponseBox && $feedbackItem->getProperty('hidden-state') == false
			&& !$wgUser->isAnon() ) {
			//$respondToThis = "<span>".wfMessage('moodbar-respond-collapsed')->escaped().'</span> '.wfMessage("moodbar-respond-text")->escaped();
			$respondToThis = '<span class="fbd-item-response-collapsed"></span> '.wfMessage("moodbar-respond-text")->escaped();			
			$responseElements = <<<HTML
				<div class="fbd-item-response">
					<a class="fbd-respond-link">$respondToThis</a>
				</div>
HTML;
		}
		
		return $responseElements;
		
	}
	
	/**
	 * Build the "user information" part of an item on the feedback dashboard.
	 * @param $feedbackItem MBFeedbackItem representing the feedback to show
	 * @return string HTML
	 */
	protected static function buildUserInfo( $feedbackItem ) {
		$user = $feedbackItem->getProperty('user');
		$username = htmlspecialchars( $user->getName() );
		
		//$links = Linker::userToolLinks( $user->getId(), $username );
		// 1.17wmf1 compat
		$links = $GLOBALS['wgUser']->getSkin()
				->userToolLinks( $user->getId(), $username );
				
		$userPageUrl = htmlspecialchars($user->getUserPage()->getLocalURL());
		
		$userLink = Linker::userLink( $user->getId(), $username );
		
		return <<<HTML
			<div class="fbd-item-userName">
				$userLink
				<span class="fbd-item-userLinks">
					$links
				</span>
			</div>
HTML;
	}
	
	/**
	 * Gets a permanent link to a given feedback item
	 * @param $feedbackItem MBFeedbackItem to get a link for
	 * @return string HTML
	 */
	protected static function getPermalink( $feedbackItem ) {
		$id = $feedbackItem->getProperty('id');
		$permalinkTitle = SpecialPage::getTitleFor( 'FeedbackDashboard', $id );
		$permalinkText = wfMessage( 'moodbar-feedback-permalink' )->escaped();
		$permalink = $GLOBALS['wgUser']->getSkin()->link( $permalinkTitle, $permalinkText );
		return Xml::tags( 'div', array( 'class' => 'fbd-item-permalink' ), "($permalink)" );
	}
	
	/** 
	 * Gets the footer for a hidden comment
	 * @param $feedbackItem The feedback item in question.
	 * @param $mode The mode to show in. Either 'shown' or 'hidden'
	 * @return string HTML
	 */
	protected static function getHiddenFooter( $feedbackItem, $mode ) {
		global $wgLang;
		
		$id = $feedbackItem->getProperty('id');
		$permalinkTitle = SpecialPage::getTitleFor( 'FeedbackDashboard', $id );
		if ( $mode === 'shown' ) {
			$linkText = wfMessage( 'moodbar-feedback-restore' )->escaped();
			$query = array('restore-feedback' => '1');
			$link = $GLOBALS['wgUser']->getSkin()
					->link( $permalinkTitle, $linkText, array(), $query );
			$link = Xml::tags( 'span', array( 'class' => 'fbd-item-restore' ), "($link)" );
			
			$feedback_hidden_detail = self::getFeedbackHiddenDetail($id);

			if($feedback_hidden_detail === false) {
				$footer = wfMessage('moodbar-hidden-footer-without-log')->
									rawParams( $link )->escaped();	
			}
			else {
				$footer = wfMessage('moodbar-hidden-footer')->
									rawParams( htmlspecialchars( $feedback_hidden_detail->log_user_text ), 
									$wgLang->date($feedback_hidden_detail->log_timestamp), 
									$wgLang->time($feedback_hidden_detail->log_timestamp),  
									htmlspecialchars( $feedback_hidden_detail->log_comment ), 
									$link )->escaped();	
			}
						
			return Xml::tags( 'div', array( 'class' => 'error' ), $footer );
		} elseif ( $mode === 'hidden' ) {
			$linkText = wfMessage('moodbar-feedback-show')->escaped();
			$query = array('show-feedback' => '1');
			$link = $GLOBALS['wgUser']->getSkin()
					->link( $permalinkTitle, $linkText, array(), $query );
			return Xml::tags( 'div', array( 'class' => 'fbd-item-show' ), "($link)" );
		}
	}
	
	/**
	 * Gets a link to hide the current feedback item from view
	 * @param $feedbackItem The feedback item to show a hide link for
	 * @return string HTML
	 */
	protected static function getHideLink( $feedbackItem ) {
		$id = $feedbackItem->getProperty('id');
		$permalinkTitle = SpecialPage::getTitleFor( 'FeedbackDashboard', $id );
		$permalinkText = wfMessage( 'moodbar-feedback-hide' )->escaped();
		$link = $GLOBALS['wgUser']->getSkin()
				->link( $permalinkTitle, $permalinkText,
					array(), array('hide-feedback' => '1') );
		return Xml::tags( 'div', array( 'class' => 'fbd-item-hide' ), "($link)" );
	}
	
	
	/**
	 * Build a comment list from a query result
	 * @param $res array Return value of doQuery()
	 * @return string HTML
	 */
	public function buildList( $res ) {
		global $wgRequest, $wgUser;
		$list = '';
		
		$params = array();
		if ( $wgUser->isAllowed('moodbar-admin') ) {
			$params[] = 'admin';
			
			if ( $this->showHidden ) {
				$params[] = 'show-anyway';
			}
		}
		
		$response = self::getResponseSummary( $res['rows'] );
		
		foreach ( $res['rows'] as $row ) {
			$list .= self::formatListItem( $row, $params, $response );
		}
		
		if ( $list === '' ) {
			return '<div id="fbd-list">' . wfMessage( 'moodbar-feedback-noresults' )->escaped() . '</div>';
		} else {
			// FIXME: We also need to show the More link (hidden) if there were no results
			$olderRow = $res['olderRow'];
			$newerRow = $res['newerRow'];
			$html = "<ul id=\"fbd-list\">$list</ul>";
			
			// Only set for showing an individual row.
			$form = null;
			if ( $this->action == 'restore' ) {
				$form = new MBRestoreForm( $row->mbf_id );
			} elseif ( $this->action == 'hide' ) {
				$form = new MBHideForm( $row->mbf_id );
			}
			
			if ( $form ) {
				$result = $form->show();
				if ( $result === true ) {
					global $wgOut;
					$title = SpecialPage::getTitleFor( 'FeedbackDashboard',
						$row->mbf_id );
					$wgOut->redirect( $title->getFullURL() );
				} else {
					$html .= "\n$result\n";
				}
			}
			
			// Output the "More" link
			$moreText = wfMessage( 'moodbar-feedback-more' )->escaped();
			$attribs = array( 'id' => 'fbd-list-more' );
			if ( !$olderRow ) {
				// There are no more rows. Hide the More link
				// We still need to output it because the JS may need it later
				$attribs['style'] = 'display: none;';
			}
			$html .= Html::rawElement( 'div', $attribs, '<a href="#">' . $moreText . '</a>' );
			
			// Paging links for no-JS clients
			$olderURL = $newerURL = false;
			if ( $olderRow ) {
				$olderOffset = wfTimestamp( TS_MW, $olderRow->mbf_timestamp ) . '|' . intval( $olderRow->mbf_id );
				$olderURL = htmlspecialchars( $this->getTitle()->getLinkURL( $this->getQuery( $olderOffset, false ) ) );
			}
			if ( $newerRow ) {
				$newerOffset = wfTimestamp( TS_MW, $newerRow->mbf_timestamp ) . '|' . intval( $newerRow->mbf_id );
				$newerURL = htmlspecialchars( $this->getTitle()->getLinkURL( $this->getQuery( $newerOffset, true ) ) );
			}
			$olderText = wfMessage( 'moodbar-feedback-older' )->escaped();
			$newerText = wfMessage( 'moodbar-feedback-newer' )->escaped();
			$html .= '<div id="fbd-list-newer-older"><div id="fbd-list-newer">';
			if ( $newerURL ) {
				$html .= "<a href=\"$newerURL\">$newerText</a>";
			} else {
				$html .= "<span class=\"fbd-page-disabled\">$newerText</span>";
			}
			$html .= '</div><div id="fbd-list-older">';
			if ( $olderURL ) {
				$html .= "<a href=\"$olderURL\">$olderText</a>";
			} else {
				$html .= "<span class=\"fbd-page-disabled\">$olderText</span>";
			}
			$html .= '</div></div><div style="clear: both;"></div>';
			return $html;
		}
	}
	
	/**
	 * Get a set of comments from the database.
	 * 
	 * The way paging is handled by this function is a bit weird. $offset is taken from
	 * the last row that was displayed, as opposed to the first row that was not displayed.
	 * This means that if $offset is set, the first row in the result (the one matching $offset)
	 * is dropped, as well as the last row. The dropped rows are only used to detect the presence
	 * or absence of more rows in each direction, the offset values for paging are taken from the
	 * first and last row that are actually shown.
	 * 
	 * $retval['olderRow'] is the row whose offset should be used to display older rows, or null if
	 * there are no older rows. This means that, if there are older rows, $retval['olderRow'] is set
	 * to the oldest row in $retval['rows']. $retval['newerRows'] is set similarly.
	 * 
	 * @param $filters array Array of filters to apply. Recognized keys are 'type' (array), 'username' (string) and 'id' (int)
	 * @param $limit int Number of comments to fetch
	 * @param $offset string Query offset. Timestamp and ID of the last shown result, formatted as 'timestamp|id'
	 * @param $backwards bool If true, page in ascending order rather than descending order, i.e. get $limit rows after $offset rather than before $offset. The result will still be sorted in descending order
	 * @return array( 'rows' => array( row, row, ... ), 'olderRow' => row|null, 'newerRow' => row|null )
	 */
	public function doQuery( $filters, $limit, $offset, $backwards ) {
		global $wgUser;
		
		$dbr = wfGetDB( DB_SLAVE );
		
		// Set $conds based on $filters
		$conds = array();
		if ( isset( $filters['type'] ) ) {
			$conds['mbf_type'] = $filters['type'];
		}
		if ( isset( $filters['username'] ) ) {
			$user = User::newFromName( $filters['username'] ); // Returns false for IPs
			if ( !$user || $user->isAnon() ) {
				$conds['mbf_user_id'] = 0;
				$conds['mbf_user_ip'] = $filters['username'];
			} else {
				$conds['mbf_user_id'] = $user->getID();
				$conds[] = 'mbf_user_ip IS NULL';
			}
		}
		if ( isset( $filters['id'] ) ) {
			$conds['mbf_id'] = $filters['id'];
		} elseif ( !$wgUser->isAllowed('moodbar-admin') ) {
			$conds['mbf_hidden_state'] = 0;
		}
		
		// Process $offset
		if ( $offset !== false ) {
			$arr = explode( '|', $offset, 2 );
			$ts = $dbr->addQuotes( $dbr->timestamp( $arr[0] ) );
			$id = isset( $arr[1] ) ? intval( $arr[1] ) : 0;
			$op = $backwards ? '>' : '<';
			$conds[] = "mbf_timestamp $op $ts OR (mbf_timestamp = $ts AND mbf_id $op= $id)";
		}
		
		// Do the actual query
		$desc = $backwards ? '' : ' DESC';
		
		$table     = array( );
		$option    = array( 'LIMIT' => $limit + 2, 'ORDER BY' => "mbf_timestamp$desc, mbf_id$desc" );
		$tableJoin = array( 'user' => array( 'LEFT JOIN', 'user_id=mbf_user_id' ) ); 
		
		
		// View my response or unanswered feedback
		if ( isset( $filters['responsefilter'] ) ) {
			switch ( $filters['responsefilter'] ) {
				case 'myresponse':
					if ( !$wgUser->isAnon() ) {
						$table[] = 'moodbar_feedback_response';
						$option['GROUP BY'] = 'mbf_id';
						$conds[] = 'mbf_id=mbfr_mbf_id';
						$conds['mbfr_user_id'] = $wgUser->getId();
					}
				break;
				
				case 'showunanswered':
					$conds['mbf_latest_response'] = 0; 
				break;
			}
		}
		
		$table[] = 'moodbar_feedback';
		$table[] = 'user';
		
		$res = $dbr->select( $table, array(
				'user_name', 'mbf_id', 'mbf_type',
				'mbf_timestamp', 'mbf_user_id', 'mbf_user_ip', 'mbf_comment',
				'mbf_anonymous', 'mbf_hidden_state', 'mbf_latest_response'
			),
			$conds,
			__METHOD__,
			$option,
			$tableJoin
		);
		$rows = iterator_to_array( $res, /*$use_keys=*/false );
		
		// Figure out whether there are newer and older rows
		$olderRow = $newerRow = null;
		$count = count( $rows );
		if ( $offset && $count > 0 ) {
			// If there is an offset, drop the first row
			if ( $count > 1 ) {
				array_shift( $rows );
				$count--;
			}
			// We now know there is a previous row
			$newerRow = $rows[0];
		}
		if ( $count > $limit ) {
			// If there are rows past the limit, drop them
			array_splice( $rows, $limit );
			// We now know there is a next row
			$olderRow = $rows[$limit - 1];
		}
		
		// If we got things backwards, reverse them
		if ( $backwards ) {
			$rows = array_reverse( $rows );
			list( $olderRow, $newerRow ) = array( $newerRow, $olderRow );
		}
		return array( 'rows' => $rows, 'olderRow' =>  $olderRow, 'newerRow' => $newerRow );
	}
	
	/**
	 * Get a query string array for a given offset, using filter parameters obtained from $wgRequest.
	 * @param $offset string Value for &offset=
	 * @param $backwards bool If true, set &dir=prev
	 * @return array
	 */
	protected function getQuery( $offset, $backwards ) {
		global $wgRequest;
		$query = array(
			'type' => $wgRequest->getArray( 'type', array() ),
			'username' => $wgRequest->getVal( 'username' ),
			'offset' => $offset,
		);

		if ( $wgRequest->getCheck( 'myresponse' ) ) {
			$query['myresponse'] = $wgRequest->getVal( 'myresponse' );	
		}
		elseif ( $wgRequest->getCheck( 'showunanswered' ) ) {
			$query['showunanswered'] = $wgRequest->getVal( 'showunanswered' ) ;
		}

		if ( $backwards ) {
			$query['dir'] = 'prev';
		}
		return $query;
	}
	
	/**
	 * Get admin's username/timestamp/reason for hiding a feedback
	 * @param $mbf_id primary key for moodbar_feedback
	 * @return ResultWrapper|bool
	 */
	protected static function getFeedbackHiddenDetail( $mbf_id ) {
		$dbr = wfGetDB( DB_SLAVE );

		return $dbr->selectRow( array( 'logging' ),
					array( 'log_user_text', 'log_timestamp', 'log_comment' ),
					array( 'log_namespace' => NS_SPECIAL,  
						'log_title' => 'FeedbackDashboard/' . intval( $mbf_id ),
						'log_action' => 'hide',
						'log_type' => 'moodbar' ),
					__METHOD__,
					array( 'LIMIT' => 1, 'ORDER BY' => "log_timestamp DESC" )
		);
	}
	
	/**
	 * Get the latest response summary for a set of feedback
	 * @param $res Iterator of Db row with index mbf_latest_response for feedback
	 * @return array
	 */
	public static function getResponseSummary( $res ) {
		$dbr = wfGetDB( DB_SLAVE );

		$mbfrIds = array();

		foreach ( $res as $row ) {
			if ( $row->mbf_latest_response != 0 ) {
				$mbfrIds[] = $row->mbf_latest_response;
			}
		}

		$response = array();

		if ( count( $mbfrIds ) > 0 ) {

			$table  = array( 'user', 'moodbar_feedback_response' );
			$select = array( 'mbfr_id', 'mbfr_mbf_id', 'mbfr_timestamp', 'user_id', 'user_name', 'user_real_name' );
			$conds  = array( 'mbfr_id' => $mbfrIds, 'mbfr_user_id = user_id' );
			$tableJoin = array();

			// Adding markashelpful data if the extension is enabled
			if ( MoodBarUtil::isMarkAsHelpfulEnabled() ) {
				$table[] = 'moodbar_feedback';
				$table[] = 'mark_as_helpful';
				// Is there a workaround that does not specify INNER JOIN explicitly?
				$tableJoin['moodbar_feedback'] = array( 'INNER JOIN', 'mbfr_mbf_id = mbf_id' );
				$tableJoin['mark_as_helpful']  = array( 'LEFT JOIN', "mah_type = 'mbresponse' AND mah_item = mbfr_id AND mah_user_id = mbf_user_id" );
				$select[] = 'mah_id';
			}

			$res = $dbr->select( $table, $select, $conds, __METHOD__, array(), $tableJoin );

			foreach ( $res as $row ) {
				$response[$row->mbfr_mbf_id] = $row;
			}
		}

		return $response;
	}

}