<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}
wfLoadExtensionMessages( 'FlaggedRevs' );

class ReaderFeedback extends UnlistedSpecialPage
{
	// Initialize to handle incomplete AJAX input
	var $page = null;
	var $oldid = 0;
	var $dims = array();
	var $validatedParams = '';
	
    function __construct() {
        UnlistedSpecialPage::UnlistedSpecialPage( 'ReaderFeedback', 'feedback' );
    }

    function execute( $par ) {
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
		foreach( FlaggedRevs::getFeedbackTags() as $tag => $weight ) {
			$this->dims[$tag] = $wgRequest->getIntOrNull( "wp$tag" );
			if( is_null($this->dims[$tag]) ) {
				$wgOut->redirect( $this->page->getLocalUrl() );
			}
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
				return '<err#>';
			}
		} else {
			return '<err#>';
		}
		if( wfReadOnly() ) {
			return '<err#>';
		}
		$tags = FlaggedRevs::getFeedbackTags();
		// Make review interface object
		$form = new ReaderFeedback();
		$form->dims = array();
		$bot = false;
		// Each ajax url argument is of the form param|val.
		// This means that there is no ugly order dependance.
		foreach( $args as $x => $arg ) {
			$set = explode('|',$arg,2);
			if( count($set) != 2 ) {
				return '<err#>';
			}
			list($par,$val) = $set;
			switch( $par )
			{
				case "target":
					$form->page = Title::newFromUrl( $val );
					if( is_null($form->page) || !FlaggedRevs::isPageRateable( $form->page ) ) {
						return '<err#>';
					}
					break;
				case "oldid":
					$form->oldid = intval( $val );
					if( !$form->oldid ) {
						return '<err#>';
					}
					break;
				case "validatedParams":
					$form->validatedParams = $val;
					break;
				case "wpEditToken":
					if( !$wgUser->matchEditToken( $val ) ) {
						return '<err#>';
					}
					break;
				case "commentary": // honeypot value
					$bot = true;
					break;
				default:
					$p = preg_replace( '/^wp/', '', $par ); // kill any "wp" prefix
					if( array_key_exists( $p, $tags ) ) {
						$form->dims[$p] = intval($val);
					}
					break;
			}
		}
		// Missing params?
		if( count($form->dims) != count($tags) ) {
			return '<err#>';
		}
		// Doesn't match up?
		if( $form->validatedParams != self::validationKey( $form->oldid, $wgUser->getId() ) ) {
			return '<err#>';
		}
		$graphLink = SpecialPage::getTitleFor( 'RatingHistory' )->getFullUrl( 'target='.$form->page->getPrefixedUrl() );
		if( $bot || $form->submit() ) {
			return '<suc#>'.wfMsgExt( 'readerfeedback-success', array('parseinline'), 
				$form->page->getPrefixedText(), $graphLink );
		} else {
			return '<err#>'.wfMsgExt( 'readerfeedback-voted', array('parseinline'), 
				$form->page->getPrefixedText(), $graphLink );
		}
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

	private function submit() {
		global $wgUser;
		$dbw = wfGetDB( DB_MASTER );
		# Get date timestamp...
		$date = str_pad( substr( wfTimestampNow(), 0, 8 ), 14, '0' );
		# Make sure revision is valid!
		$rev = Revision::newFromId( $this->oldid );
		if( !$rev || !$rev->getTitle()->equals( $this->page ) ) {
			return false; // opps!
		}
		$article = new Article( $this->page );
		# Check if user already voted before...
		if( $wgUser->getId() ) {
			$ipSafe = $dbw->strencode( wfGetIP() );
			$userVoted = $dbw->selectField( 'reader_feedback', '1', 
				array( 'rfb_rev_id' => $this->oldid, 
					"(rfb_user = ".$wgUser->getId().") OR (rfb_user = 0 AND rfb_ip = '$ipSafe')" ), 
				__METHOD__ );
			if( $userVoted ) {
				return false;
			}
		} else {
			$ipVoted = $dbw->selectField( 'reader_feedback', '1', 
				array( 'rfb_rev_id' => $this->oldid, 'rfb_user' => 0, 'rfb_ip' => wfGetIP() ), 
				__METHOD__ );
			if( $ipVoted ) {
				return false;
			}
		}
		$dbw->begin();
		# Update review records to limit double voting!
		$insertRow = array( 
			'rfb_rev_id' => $this->oldid, 
			'rfb_user'   => $wgUser->getId(), 
			'rfb_ip'     => wfGetIP() 
		);
		$dbw->insert( 'reader_feedback', $insertRow, __METHOD__, 'IGNORE' );
		# Make sure initial page data is there to begin with...
		$insertRows = array();
		foreach( $this->dims as $tag => $val ) {
			$insertRows[] = array(
				'rfh_page_id' => $rev->getPage(),
				'rfh_tag'     => $tag,
				'rfh_total'   => 0,
				'rfh_count'   => 0,
				'rfh_date'    => $date
			);
		}
		$dbw->insert( 'reader_feedback_history', $insertRows, __METHOD__, 'IGNORE' );
		# Update aggregate data for this page over time...
		$touched = $dbw->timestamp( wfTimestampNow() );
		$overall = 0;
		$insertRows = array();
		foreach( $this->dims as $tag => $val ) {
			$dbw->update( 'reader_feedback_history',
				array( 'rfh_total = rfh_total + '.intval($val), 
					'rfh_count = rfh_count + 1'),
				array( 'rfh_page_id' => $rev->getPage(), 
					'rfh_tag' => $tag,
					'rfh_date' => $date ),
				__METHOD__ );
			# Get effective tag values for this page..
			list($aveVal,$n) = FlaggedRevs::getAverageRating( $article, $tag, true );
			$insertRows[] = array( 
				'rfp_page_id' => $rev->getPage(),
				'rfp_tag'     => $tag,
				'rfp_ave_val' => $aveVal,
				'rfp_count'   => $n,
				'rfp_touched' => $touched
			);
			$overall += FlaggedRevs::getFeedbackWeight( $tag ) * $aveVal;
		}
		# Get overall data for this page. Used to rank best/worst pages...
		if( isset($n) ) {
			$insertRows[] = array( 
				'rfp_page_id' => $rev->getPage(),
				'rfp_tag'     => 'overall',
				'rfp_ave_val' => ($overall / count($this->dims)),
				'rfp_count'   => $n,
				'rfp_touched' => $touched
			);
		}
		$dbw->replace( 'reader_feedback_pages', array( 'PRIMARY' ), $insertRows, __METHOD__ );
		# Done!
		$dbw->commit();
		return true;
	}
}
