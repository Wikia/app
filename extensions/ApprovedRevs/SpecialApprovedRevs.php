<?php

/**
 * Special page that displays various lists of pages that either do or do
 * not have an approved revision.
 *
 * @author Yaron Koren
 */
class SpecialApprovedRevs extends SpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'ApprovedRevs' );
	}

	function execute( $query ) {
		global $wgRequest;

		ApprovedRevs::addCSS();
		$this->setHeaders();
		list( $limit, $offset ) = wfCheckLimits();
		
		$mode = $wgRequest->getVal( 'show' );
		$rep = new SpecialApprovedRevsPage( $mode );
		
		if ( method_exists( $rep, 'execute' ) ) {
			return $rep->execute( $query );
		} else {
			return $rep->doQuery( $offset, $limit );
		}
	}
	
}

class SpecialApprovedRevsPage extends QueryPage {
	
	protected $mMode;

	public function __construct( $mode ) {
		if ( $this instanceof SpecialPage ) {
			parent::__construct( 'ApprovedRevs' );
		}
		$this->mMode = $mode;
	}

	function getName() {
		return 'ApprovedRevs';
	}

	function isExpensive() { return false; }

	function isSyndicated() { return false; }

	function getPageHeader() {
		// show the names of the three lists of pages, with the one
		// corresponding to the current "mode" not being linked
		$approvedPagesTitle = SpecialPage::getTitleFor( 'ApprovedRevs' );
		$navLine = wfMsg( 'approvedrevs-view' ) . ' ';
		
		if ( $this->mMode == '' ) {
			$navLine .= Xml::element( 'strong',
				null,
				wfMsg( 'approvedrevs-approvedpages' )
			);
		} else {
			$navLine .= Xml::element( 'a',
				array( 'href' => $approvedPagesTitle->getLocalURL() ),
				wfMsg( 'approvedrevs-approvedpages' )
			);
		}
		
		$navLine .= ' | ';
		
		if ( $this->mMode == 'notlatest' ) {
			$navLine .= Xml::element( 'strong',
				null,
				wfMsg( 'approvedrevs-notlatestpages' )
			);
		} else {
			$navLine .= Xml::element( 'a',
				array( 'href' => $approvedPagesTitle->getLocalURL( array( 'show' => 'notlatest' ) ) ),
				wfMsg( 'approvedrevs-notlatestpages' )
			);
		}
		
		$navLine .= ' | ';
		
		if ( $this->mMode == 'unapproved' ) {
			$navLine .= Xml::element( 'strong',
				null,
				wfMsg( 'approvedrevs-unapprovedpages' )
			);
		} else {
			$navLine .= Xml::element( 'a',
				array( 'href' => $approvedPagesTitle->getLocalURL( array( 'show' => 'unapproved' ) ) ),
				wfMsg( 'approvedrevs-unapprovedpages' )
			);
		}
		
		return Xml::tags( 'p', null, $navLine ) . "\n";
	}

	/**
	 * Set parameters for standard navigation links.
	 */
	function linkParameters() {
		$params = array();
		
		if ( $this->mMode == 'notlatest' ) {
			$params['show'] = 'notlatest';
		} elseif ( $this->mMode == 'unapproved' ) {
			$params['show'] = 'unapproved';
		} else { // all approved pages
		}
		
		return $params;
	}

	function getPageFooter() {
	}

	public static function getNsConditionPart( $ns ) {
		return 'p.page_namespace = ' . $ns;
	}
	
	/**
	 * For compatibility with MW < 1.17.
	 * 
	 * (non-PHPdoc)
	 * @see QueryPage::getSQL()
	 */
	function getSQL() {
		global $egApprovedRevsNamespaces;
		
		$nsCond = '(' . implode( ' OR ', array_map( array( __CLASS__, 'getNsConditionPart' ), $egApprovedRevsNamespaces ) ) . ')';
		
		$dbr = wfGetDB( DB_SLAVE );
		$approved_revs = $dbr->tableName( 'approved_revs' );
		$page = $dbr->tableName( 'page' );
		$page_props = $dbr->tableName( 'page_props' );
		
		if ( $this->mMode == 'notlatest' ) {
			return "SELECT 'Page' AS type,
				p.page_id AS id,
				ar.rev_id AS rev_id,
				p.page_latest AS latest_id
				FROM $approved_revs ar JOIN $page p
				ON ar.page_id = p.page_id
				LEFT OUTER JOIN $page_props pp
				ON ar.page_id = pp_page
				WHERE p.page_latest != ar.rev_id
				AND ($nsCond OR (pp_propname = 'approvedrevs' AND pp_value = 'y'))";
		} elseif ( $this->mMode == 'unapproved' ) {
			return "SELECT 'Page' AS type,
				p.page_id AS id,
				p.page_latest AS latest_id
				FROM $approved_revs ar RIGHT OUTER JOIN $page p
				ON ar.page_id = p.page_id
				LEFT OUTER JOIN $page_props pp
				ON p.page_id = pp_page
				WHERE ar.page_id IS NULL
				AND ($nsCond OR (pp_propname = 'approvedrevs' AND pp_value = 'y'))";
		} else { // all approved pages
			return "SELECT 'Page' AS type,
				p.page_id AS id,
				ar.rev_id AS rev_id,
				p.page_latest AS latest_id
				FROM $approved_revs ar JOIN $page p
				ON ar.page_id = p.page_id
				LEFT OUTER JOIN $page_props pp
				ON ar.page_id = pp_page
				WHERE ($nsCond OR (pp_propname = 'approvedrevs' AND pp_value = 'y'))";
		}
	}

	/**
	 * Used as of MW 1.17.
	 * 
	 * (non-PHPdoc)
	 * @see QueryPage::getSQL()
	 */	
	function getQueryInfo() {
		global $egApprovedRevsNamespaces;

		$namespacesString = '(' . implode( ',', $egApprovedRevsNamespaces ) . ')';
		if ( $this->mMode == 'notlatest' ) {
			return array(
				'tables' => array(
					'ar' => 'approved_revs',
					'p' => 'page',
					'pp' => 'page_props',
				),
				'fields' => array(
					'p.page_id AS id',
					'ar.rev_id AS rev_id',
					'p.page_latest AS latest_id',
				),
				'join_conds' => array(
					'p' => array(
						'JOIN', 'ar.page_id=p.page_id'
					),
					'pp' => array(
						'LEFT OUTER JOIN', 'ar.page_id=pp_page'
					),
				),
				'conds' => "p.page_latest != ar.rev_id AND ((p.page_namespace IN $namespacesString) OR (pp_propname = 'approvedrevs' AND pp_value = 'y'))",
			);
		} elseif ( $this->mMode == 'unapproved' ) {
			return array(
				'tables' => array(
					'ar' => 'approved_revs',
					'p' => 'page',
					'pp' => 'page_props',
				),
				'fields' => array(
					'p.page_id AS id',
					'p.page_latest AS latest_id'
				),
				'join_conds' => array(
					'p' => array(
						'RIGHT OUTER JOIN', 'ar.page_id=p.page_id'
					),
					'pp' => array(
						'LEFT OUTER JOIN', 'ar.page_id=pp_page'
					),
				),
				'conds' => "ar.page_id IS NULL AND ((p.page_namespace IN $namespacesString) OR (pp_propname = 'approvedrevs' AND pp_value = 'y'))",
			);
		} else { // all approved pages
			return array(
				'tables' => array(
					'ar' => 'approved_revs',
					'p' => 'page',
					'pp' => 'page_props',
				),
				'fields' => array(
					'p.page_id AS id',
					'ar.rev_id AS rev_id',
					'p.page_latest AS latest_id',
				),
				'join_conds' => array(
					'p' => array(
						'JOIN', 'ar.page_id=p.page_id',
					),
					'pp' => array(
						'LEFT OUTER JOIN', 'ar.page_id=pp_page'
					),
				),
				'conds' => "(p.page_namespace IN $namespacesString) OR (pp_propname = 'approvedrevs' AND pp_value = 'y')",
			);
		}
	}

	function getOrder() {
		return ' ORDER BY p.page_namespace, p.page_title ASC';
	}

	function getOrderFields() {
		return array( 'p.page_namespace', 'p.page_title' );
	}

	function sortDescending() {
		return false;
	}

	function formatResult( $skin, $result ) {
		$title = Title::newFromId( $result->id );
		
		// link introduced in 1.16, where makeLinkObj got deprecated
		$pageLink = is_callable( array( $skin, 'link' ) ) ? $skin->link( $title ) : $skin->makeLinkObj( $title );
		
		if ( $this->mMode == 'unapproved' ) {
			global $egApprovedRevsShowApproveLatest;
			
			$line = $pageLink;
			if ( $egApprovedRevsShowApproveLatest &&
				$title->userCan( 'approverevisions' ) ) {
				$line .= ' (' . Xml::element( 'a',
					array( 'href' => $title->getLocalUrl(
						array(
							'action' => 'approve',
							'oldid' => $result->latest_id
						)
					) ),
					wfMsg( 'approvedrevs-approvelatest' )
				) . ')';
			}
			
			return $line;
		} elseif ( $this->mMode == 'notlatest' ) {
			$diffLink = Xml::element( 'a',
				array( 'href' => $title->getLocalUrl(
					array(
						'diff' => $result->latest_id,
						'oldid' => $result->rev_id
					)
				) ),
				wfMsg( 'approvedrevs-difffromlatest' )
			);
			
			return "$pageLink ($diffLink)";
		} else { // main mode (pages with an approved revision)
			global $wgUser, $wgOut, $wgLang;
			
			$additionalInfo = Xml::element( 'span',
				array (
					'class' => $result->rev_id == $result->latest_id ? 'approvedRevIsLatest' : 'approvedRevNotLatest'
				),
				wfMsg( 'approvedrevs-revisionnumber', $result->rev_id )
			);

			// Get data on the most recent approval from the
			// 'approval' log, and display it if it's there.
			$sk = $wgUser->getSkin();
			$loglist = new LogEventsList( $sk, $wgOut );
			$pager = new LogPager( $loglist, 'approval', '', $title->getText() );
			$pager->mLimit = 1;
			$pager->doQuery();
			$row = $pager->mResult->fetchObject();
			
			if ( !empty( $row ) ) {
				$time = $wgLang->timeanddate( wfTimestamp( TS_MW, $row->log_timestamp ), true );
				$userLink = $sk->userLink( $row->log_user, $row->user_name );
				$additionalInfo .= ', ' . wfMsg( 'approvedrevs-approvedby', $userLink, $time );
			}
			
			return "$pageLink ($additionalInfo)";
		}
	}
	
}
