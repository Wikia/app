<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "ReaderFeedback extension\n";
	exit( 1 );
}

class ReaderFeedbackPage extends UnlistedSpecialPage
{
	const REVIEW_ERROR = 0;
	const REVIEW_OK = 1;
	const REVIEW_DUP = 2;

	// Initialize to handle incomplete AJAX input
	var $page = null;
	var $oldid = 0;
	var $dims = array();
	var $validatedParams = '';
	var $commentary = '';
	
    public function __construct() {
        parent::__construct( 'ReaderFeedback', 'feedback' );
    }

    public function execute( $par ) {
        global $wgRequest, $wgUser, $wgOut;
		$confirm = $wgRequest->wasPosted()
			&& $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) );
		if( $wgUser->isAllowed( 'feedback' ) ) {
			if( $wgUser->isBlocked( !$confirm ) ) {
				$wgOut->blockedPage();
				return;
			}
		} else {
			$wgOut->permissionRequired( 'feedback' );
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		$this->setHeaders();
		# Our target page
		$this->page = Title::newFromURL( $wgRequest->getVal( 'target' ) );
		if( is_null($this->page) ) {
			$wgOut->showErrorPage('notargettitle', 'notargettext' );
			return;
		}
		# Revision ID
		$this->oldid = $wgRequest->getIntOrNull( 'oldid' );
		if( !$this->oldid || !ReaderFeedback::isPageRateable( $this->page ) ) {
			$wgOut->addHTML( wfMsgExt('readerfeedback-main',array('parse')) );
			return;
		}
		# Get our rating dimensions
		$this->dims = array();
		$unsureCount = 0;
		foreach( ReaderFeedback::getFeedbackTags() as $tag => $weight ) {
			$this->dims[$tag] = $wgRequest->getIntOrNull( "wp$tag" );
			if( $this->dims[$tag] === null ) { // nothing sent at all :(
				$wgOut->redirect( $this->page->getLocalUrl() );
				return;
			} elseif( $this->dims[$tags] === -1 ) {
				$unsureCount++;
			}
		}
		# There must actually be *some* ratings
		if( $unsureCount >= count($this->dims) ) {
			$wgOut->redirect( $this->page->getLocalUrl() );
			return;
		}
		# Check validation key
		$this->validatedParams = $wgRequest->getVal('validatedParams');
		if( $this->validatedParams != self::validationKey( $this->oldid, $wgUser->getId() ) ) {
			$wgOut->redirect( $this->page->getLocalUrl() );
		}
		# Submit valid requests. Check honeypot value for bots.
		if( $confirm && !$wgRequest->getVal( 'commentary' ) ) {
			$ok = $this->submit();
		} else {
			$ok = self::REVIEW_ERROR;
		}
		# Go to graphs!
		global $wgMiserMode;
		if( $ok == self::REVIEW_OK && !$wgMiserMode ) {
			$ratingTitle = SpecialPage::getTitleFor( 'RatingHistory' );
			$wgOut->redirect( $ratingTitle->getLocalUrl('target='.$this->page->getPrefixedUrl() ) );
		# Already voted or graph is set to be skipped...
		} else {
			$wgOut->redirect( $this->page->getLocalUrl() );
		}
	}
	
	public static function AjaxReview( /*$args...*/ ) {
		global $wgUser;
		$args = func_get_args();
		// Basic permission check
		if( $wgUser->isAllowed( 'feedback' ) ) {
			if( $wgUser->isBlocked() ) {
				return '<err#><h2>' . wfMsgHtml('blockedtitle') . '</h2>' .
					wfMsg('badaccess-group0');
			}
		} else {
			return '<err#><strong>' . wfMsg('badaccess-group0') . '</<strong>';
		}
		if( wfReadOnly() ) {
			return '<err#><strong>' . wfMsg('formerror') . '</<strong>';
		}
		$tags = ReaderFeedback::getFeedbackTags();
		// Make review interface object
		$form = new ReaderFeedbackPage();
		$form->dims = array();
		$unsureCount = 0;
		$bot = false;
		// Each ajax url argument is of the form param|val.
		// This means that there is no ugly order dependance.
		foreach( $args as $arg ) {
			$set = explode('|',$arg,2);
			if( count($set) != 2 ) {
				return '<err#>' . wfMsg('formerror');
			}
			list($par,$val) = $set;
			switch( $par )
			{
				case "target":
					$form->page = Title::newFromURL( $val );
					if( is_null($form->page) || !ReaderFeedback::isPageRateable( $form->page ) ) {
						return '<err#>' . wfMsg('formerror');
					}
					break;
				case "oldid":
					$form->oldid = intval( $val );
					if( !$form->oldid ) {
						return '<err#>' . wfMsg('formerror');
					}
					break;
				case "validatedParams":
					$form->validatedParams = $val;
					break;
				case "wpEditToken":
					if( !$wgUser->matchEditToken( $val ) ) {
						return '<err#>' . wfMsg('formerror');
					}
					break;
				case "commentary": // honeypot value
					if( $val )
						$bot = true;
					break;
				default:
					$p = preg_replace( '/^wp/', '', $par ); // kill any "wp" prefix
					if( array_key_exists( $p, $tags ) ) {
						$form->dims[$p] = intval($val);
						if( $form->dims[$p] === null ) { // nothing sent at all :(
							return '<err#>' . wfMsg('formerror'); // bad range
						} elseif( $form->dims[$p] === -1 ) {
							$unsureCount++;
						}
					}
					break;
			}
		}
		// Missing params?
		if( count($form->dims) != count($tags) || $unsureCount >= count($form->dims) ) {
			return '<err#>' . wfMsg('formerror');
		}
		// Doesn't match up?
		if( $form->validatedParams != self::validationKey( $form->oldid, $wgUser->getId() ) ) {
			return '<err#>' . wfMsg('formerror');
		}
		$rhist = SpecialPage::getTitleFor( 'RatingHistory' );
		$graphLink = $rhist->getFullUrl( 'target='.$form->page->getPrefixedUrl() );
		$talk = $form->page->getTalkPage();

		$tallyTable = ReaderFeedback::getVoteAggregates( $form->page, 31, $form->dims );
		
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		if( $bot ) {
			$ok = self::REVIEW_ERROR; // don't submit for mindless drones
		} else {
			$ok = $form->submit();
		}
		$dbw->commit();
		switch( $ok ) {
			case self::REVIEW_OK:
				return '<suc#>' .
					"<div class='plainlinks'>" .
						wfMsgExt( 'readerfeedback-success', array('parseinline'), 
							$form->page->getPrefixedText(), $graphLink,
							$talk->getFullUrl( 'action=edit&section=new' ) ) .
						'<h4>'.wfMsgHtml('ratinghistory-table')."</h4>\n$tallyTable" .
					"</div>";
			case self::REVIEW_DUP:
				return '<err#>' .
					"<div class='plainlinks'>" .
						wfMsgExt( 'readerfeedback-voted', array('parseinline'), 
							$form->page->getPrefixedText(), $graphLink,
							$talk->getFullUrl( 'action=edit&section=new' ) ) .
					"</div>";
			default:
				return '<err#>' .
					"<div class='plainlinks'>" .
						wfMsgExt( 'readerfeedback-error', array('parseinline'), 
							$form->page->getPrefixedText(), $graphLink,
							$talk->getFullUrl( 'action=edit&section=new' ) ) .
					"</div>";
		}
	}
	
	protected static function isValid( $int ) {
		return ( !is_null($int) && $int > 0 && $int <= 4 );
	}
	
	public static function validationKey( $rid, $uid ) {
		global $wgReviewCodes;
		# Fall back to $wgSecretKey/$wgProxyKey
		if( empty($wgReviewCodes) ) {
			global $wgSecretKey, $wgProxyKey;
			$key = $wgSecretKey ? $wgSecretKey : $wgProxyKey;
			$p = md5($key.$rid.$uid);
		} else {
			$p = md5($wgReviewCodes[0].$rid.$uid.$wgReviewCodes[1]);
		}
		return $p;
	}
	
	public static function userAlreadyVoted( $title, $revId = 0 ) {
		global $wgUser;
		static $stackDepth = 0;
		# Use page_latest if $revId not given
		$revId = $revId ? $revId : $title->getLatestRevID( Title::GAID_FOR_UPDATE );
		$rev = Revision::newFromTitle( $title, $revId );
		if( !$rev ) return false; // shouldn't happen; just in case
		# Check if this revision is by this user...
		if( $rev->getUserText() === $wgUser->getName() ) {
			# Check if the previous revisions is theirs and they
			# voted on it. Disallow this, to make it harder to make
			# edits just to inflate/deflate rating...
			if( $stackDepth < 2 ) {
				$stackDepth++;
				$prevId = $title->getPreviousRevisionID( $revId );
				if( $prevId && self::userAlreadyVoted( $title, $prevId ) ) {
					return true;
				}
			}
		}
		# Check if user already voted before...
		$dbw = wfGetDB( DB_MASTER );
		if( $wgUser->getId() ) {
			$ipSafe = $dbw->addQuotes( wfGetIP() );
			$userVoted = $dbw->selectField( 'reader_feedback', '1', 
				array( 'rfb_rev_id' => $revId, 
					"(rfb_user = ".$wgUser->getId().") OR (rfb_user = 0 AND rfb_ip = $ipSafe)" ), 
				__METHOD__ );
			if( $userVoted ) {
				return true;
			}
		} else {
			$ipVoted = $dbw->selectField( 'reader_feedback', '1', 
				array( 'rfb_rev_id' => $revId, 'rfb_user' => 0, 'rfb_ip' => wfGetIP() ), 
				__METHOD__ );
			if( $ipVoted ) {
				return true;
			}
		}
		return false;
	}
	
	protected function flattenRatings( $dims ) {
		$s = array();
		foreach( $dims as $tag => $value ) {
			$s[] = "{$tag}={$value}";
		}
		return implode("\n",$s);
	}

	private function submit() {
		global $wgUser;
		$dbw = wfGetDB( DB_MASTER );
		# Get date timestamp...
		$now = wfTimestampNow();
		$date = str_pad( substr( $now, 0, 8 ), 14, '0' );
		if( count($this->dims) == 0 )
			return self::REVIEW_ERROR;
		$ratings = $this->flattenRatings( $this->dims );
		# Make sure revision is valid!
		$rev = Revision::newFromId( $this->oldid );
		if( !$rev || !$rev->getTitle()->equals( $this->page ) ) {
			return self::REVIEW_ERROR; // opps!
		}
		$ip = wfGetIP();
		if( !$wgUser->getId() && !$ip ) {
			return self::REVIEW_ERROR; // we need to keep track somehow
		}
		$article = new Article( $this->page );
		# Check if the user is spamming reviews...
		if( $wgUser->pingLimiter( 'feedback' ) || $wgUser->pingLimiter() ) {
			return self::REVIEW_ERROR;
		}
		# Check if user already voted before...
		if( self::userAlreadyVoted( $this->page, $this->oldid ) ) {
			return self::REVIEW_DUP;
		}
		# Update review records to limit double voting!
		$insertRow = array( 
			'rfb_rev_id'    => $this->oldid,
			'rfb_user'      => $wgUser->getId(),
			'rfb_ip'        => $ip,
			'rfb_timestamp' => $dbw->timestamp( $now ),
			'rfb_ratings'   => $ratings
		);
		# Make sure initial page data is there to begin with...
		$insertRows = array();
		foreach( $this->dims as $tag => $val ) {
			if( $val < 0 ); // don't store "unsure" votes
			$insertRows[] = array(
				'rfh_page_id' => $rev->getPage(),
				'rfh_tag'     => $tag,
				'rfh_total'   => 0,
				'rfh_count'   => 0,
				'rfh_date'    => $date
			);
		}
		$dbw->insert( 'reader_feedback', $insertRow, __METHOD__, 'IGNORE' );
		$dbw->insert( 'reader_feedback_history', $insertRows, __METHOD__, 'IGNORE' );
		# Update aggregate data for this page over time...
		$touched = $dbw->timestamp( $now );
		$insertRows = array();
		foreach( $this->dims as $tag => $val ) {
			if( $val < 0 ) continue; // don't store "unsure" votes
			# Update daily averages
			$dbw->update( 'reader_feedback_history',
				array( 'rfh_total = rfh_total + '.intval($val), 
					'rfh_count = rfh_count + 1'),
				array( 'rfh_page_id' => $rev->getPage(), 
					'rfh_tag' => $tag,
					'rfh_date' => $date ),
				__METHOD__
			);
			# Get effective tag values for this page..
			list($aveVal,$n) = ReaderFeedback::getAverageRating( $article, $tag, true );
			$insertRows[] = array( 
				'rfp_page_id' => $rev->getPage(),
				'rfp_tag'     => $tag,
				'rfp_ave_val' => $aveVal,
				'rfp_count'   => $n,
				'rfp_touched' => $touched
			);
		}
		# Update recent averages
		$dbw->replace( 'reader_feedback_pages', array( 'PRIMARY' ), $insertRows, __METHOD__ );
		# For logged in users, box should disappear
		if( $wgUser->getId() ) {
			$this->page->invalidateCache();
		}
		# Prune expired page aggregate data
		if( 0 == mt_rand( 0, 99 ) ) {
			ReaderFeedback::purgeExpiredAverages();
		}
		return self::REVIEW_OK;
	}
}
