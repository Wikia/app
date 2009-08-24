<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class ReaderFeedback extends UnlistedSpecialPage
{
	// Initialize to handle incomplete AJAX input
	var $page = null;
	var $oldid = 0;
	var $dims = array();
	var $validatedParams = '';
	var $commentary = '';
	
    public function __construct() {
        UnlistedSpecialPage::UnlistedSpecialPage( 'ReaderFeedback', 'feedback' );
		wfLoadExtensionMessages( 'FlaggedRevs' );
    }

    public function execute( $par ) {
        global $wgRequest, $wgUser, $wgOut;
		$confirm = $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) );
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
		$this->page = Title::newFromUrl( $wgRequest->getVal( 'target' ) );
		if( is_null($this->page) ) {
			$wgOut->showErrorPage('notargettitle', 'notargettext' );
			return;
		}
		# Revision ID
		$this->oldid = $wgRequest->getIntOrNull( 'oldid' );
		if( !$this->oldid || !FlaggedRevs::isPageRateable( $this->page ) ) {
			$wgOut->addHTML( wfMsgExt('readerfeedback-main',array('parse')) );
			return;
		}
		# Get our rating dimensions
		$this->dims = array();
		$unsureCount = 0;
		foreach( FlaggedRevs::getFeedbackTags() as $tag => $weight ) {
			$this->dims[$tag] = $wgRequest->getIntOrNull( "wp$tag" );
			if( $this->dims[$tag] === NULL ) { // nothing sent at all :(
				$wgOut->redirect( $this->page->getLocalUrl() );
				return;
			} else if( $this->dims[$tags] === -1 ) {
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
			$ok = false;
		}
		# Go to graphs!
		global $wgMiserMode;
		if( $ok && !$wgMiserMode ) {
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
				return '<err#><h2>' . wfMsgHtml('blockedtitle') . '</h2>' . wfMsg('badaccess-group0');
			}
		} else {
			return '<err#><strong>' . wfMsg('badaccess-group0') . '</<strong>';
		}
		if( wfReadOnly() ) {
			return '<err#><strong>' . wfMsg('formerror') . '</<strong>';
		}
		$tags = FlaggedRevs::getFeedbackTags();
		// Make review interface object
		$form = new ReaderFeedback();
		$form->dims = array();
		$unsureCount = 0;
		$bot = false;
		// Each ajax url argument is of the form param|val.
		// This means that there is no ugly order dependance.
		foreach( $args as $x => $arg ) {
			$set = explode('|',$arg,2);
			if( count($set) != 2 ) {
				return '<err#>' . wfMsg('formerror');
			}
			list($par,$val) = $set;
			switch( $par )
			{
				case "target":
					$form->page = Title::newFromUrl( $val );
					if( is_null($form->page) || !FlaggedRevs::isPageRateable( $form->page ) ) {
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
						if( $form->dims[$p] === NULL ) { // nothing sent at all :(
							return '<err#>' . wfMsg('formerror'); // bad range
						} else if( $form->dims[$p] === -1 ) {
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
		$graphLink = SpecialPage::getTitleFor( 'RatingHistory' )->getFullUrl( 'target='.$form->page->getPrefixedUrl() );
		$talk = $form->page->getTalkPage();
		
		wfLoadExtensionMessages( 'RatingHistory' );
		$tallyTable = FlaggedRevs::getVoteAggregates( $form->page, 31, $form->dims );
		
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		$ok = ( $bot || $form->submit() ); // don't submit for mindless drones
		$dbw->commit();
		if( $ok ) {
			return '<suc#>'.wfMsgExt( 'readerfeedback-success', array('parseinline'), 
				$form->page->getPrefixedText(), $graphLink, $talk->getFullUrl( 'action=edit&section=new' ) ) .
				'<h4>'.wfMsgHtml('ratinghistory-table')."</h4>\n$tallyTable";
		} else {
			return '<err#>'.wfMsgExt( 'readerfeedback-voted', array('parseinline'), 
				$form->page->getPrefixedText(), $graphLink, $talk->getFullUrl( 'action=edit&section=new' ) );
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
		$userVoted = false;
		# Use page_latest if $revId not given
		$revId = $revId ? $revId : $title->getLatestRevID( GAID_FOR_UPDATE );
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
			return false;
		$ratings = $this->flattenRatings( $this->dims );
		# Make sure revision is valid!
		$rev = Revision::newFromId( $this->oldid );
		if( !$rev || !$rev->getTitle()->equals( $this->page ) ) {
			return false; // opps!
		}
		$ip = wfGetIP();
		if( !$wgUser->getId() && !$ip ) {
			return false; // we need to keep track somehow
		}
		$article = new Article( $this->page );
		# Check if user already voted before...
		if( self::userAlreadyVoted( $this->page, $this->oldid ) ) {
			return false;
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
		$overall = 0;
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
			list($aveVal,$n) = FlaggedRevs::getAverageRating( $article, $tag, true );
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
		# Clear out any dead data
		$dbw->delete( 'reader_feedback_pages', array('rfp_page_id' => $rev->getPage(), 
			'rfp_tag' => 'overall'), __METHOD__ );
		# For logged in users, box should disappear
		if( $wgUser->getId() ) {
			$this->page->invalidateCache();
		}
		return true;
	}
}
