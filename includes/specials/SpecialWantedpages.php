<?php
/**
 * @file
 * @ingroup SpecialPage
 */

/**
 * implements Special:Wantedpages
 * @ingroup SpecialPage
 */
class WantedPagesPage extends QueryPage {
	var $nlinks;

	function WantedPagesPage( $inc = false, $nlinks = true ) {
		$this->setListoutput( $inc );
		$this->nlinks = $nlinks;
		$this->excludetitles = '';
	}

	function getName() {
		return 'Wantedpages';
	}

	function isExpensive() {
		return true;
	}
	function isSyndicated() { return false; }

	function getSQL() {
		global $wgWantedPagesThreshold;
		$count = $wgWantedPagesThreshold - 1;
		$dbr = wfGetDB( DB_SLAVE );
		$pagelinks = $dbr->tableName( 'pagelinks' );
		$page      = $dbr->tableName( 'page' );
		$sql = "SELECT 'Wantedpages' AS type,
			        pl_namespace AS namespace,
			        pl_title AS title,
			        COUNT(*) AS value
			 FROM $pagelinks
			 LEFT JOIN $page AS pg1
			 ON pl_namespace = pg1.page_namespace AND pl_title = pg1.page_title
			 LEFT JOIN $page AS pg2
			 ON pl_from = pg2.page_id
			 WHERE pg1.page_namespace IS NULL
			 AND pl_namespace NOT IN ( 2, 3 )
			 AND pg2.page_namespace != 8
			 $this->excludetitles
			 GROUP BY pl_namespace, pl_title
			 HAVING COUNT(*) > $count";

		wfRunHooks( 'WantedPages::getSQL', array( &$this, &$sql ) );
		return $sql;
	}

	/**
	 * Cache page existence for performance
	 */
	function preprocessResults( &$db, &$res ) {
		$batch = new LinkBatch;
		while ( $row = $db->fetchObject( $res ) )
			$batch->add( $row->namespace, $row->title );
		$batch->execute();

		// Back to start for display
		if ( $db->numRows( $res ) > 0 )
			// If there are no rows we get an error seeking.
			$db->dataSeek( $res, 0 );
	}

	/**
	 * Format an individual result
	 *
	 * @param $skin Skin to use for UI elements
	 * @param $result Result row
	 * @return string
	 */
	public function formatResult( $skin, $result ) {
		$title = Title::makeTitleSafe( $result->namespace, $result->title );
		if( $title instanceof Title ) {
			if( $this->isCached() ) {
				$pageLink = $title->exists()
					? '<s>' . $skin->makeLinkObj( $title ) . '</s>'
					: $skin->makeBrokenLinkObj( $title );
			} else {
				$pageLink = $skin->makeBrokenLinkObj( $title );
			}
			return wfSpecialList( $pageLink, $this->makeWlhLink( $title, $skin, $result ) );
		} elseif (empty($result->title)) {
			return null; // this is a band aid solution but I give up )-: see RT#14387
		} else {
			$tsafe = htmlspecialchars( $result->title );
			return wfMsg( 'wantedpages-badtitle', $tsafe );
		}
	}

	/**
	 * Make a "what links here" link for a specified result if required
	 *
	 * @param $title Title to make the link for
	 * @param $skin Skin to use
	 * @param $result Result row
	 * @return string
	 */
	private function makeWlhLink( $title, $skin, $result ) {
		global $wgLang;
		if( $this->nlinks ) {
			$wlh = SpecialPage::getTitleFor( 'Whatlinkshere' );
			$label = wfMsgExt( 'nlinks', array( 'parsemag', 'escape' ),
				$wgLang->formatNum( $result->value ) );
			return $skin->makeKnownLinkObj( $wlh, $label, 'target=' . $title->getPrefixedUrl() );
		} else {
			return null;
		}
	}

}

class WantedPagesPageWikia extends WantedPagesPage {
	var $excludetitles = '';
	var $excludeorig = '';

	function isExpensive() {
		return ( $this->excludeorig != '' ? false : true );
	}
	function isSyndicated() { return true; }

	function WantedPagesPageWikia( $inc = false, $nlinks = true, $excludetitles = '' ) {
		if ( $excludetitles != '' ) {
			$this->excludeorig = $excludetitles;
			$excludetitles = str_replace( "'", "", $excludetitles );
			$titles = explode( ',', $excludetitles );
			foreach ( $titles as $title ) {
				$this->excludetitles .= " AND pl_title NOT LIKE '%$title%'";
			}
		}
		$this->WantedPagesPage( $inc, $nlinks );
	}

	function getPageHeader() {
		$self = SpecialPage::getTitleFor( $this->getName() );
		$form = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
		$form .= '<table><tr><td align="right">' . Xml::label( "Exclude titles", 'excludetitles' ) . '</td>';
		$form .= '<td>' . Xml::input( 'excludetitles', 30, $this->excludeorig, array( 'id' => 'excludetitles' ) ) . '</td></tr>';
		$form .= '<tr><td></td><td>' . Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . '</td></tr></table>';
		$form .= Xml::hidden( 'offset', $this->offset ) . Xml::hidden( 'limit', $this->limit ) . '</form>';
		return $form;
	}

	function linkParameters() {
		return( array( 'excludetitles' => $this->excludeorig ) );
	}
}

/**
 * constructor
 */
function wfSpecialWantedpages( $par = null, $specialPage ) {
	global $wgRequest;

	$inc = $specialPage->including();

	if ( $inc ) {
		@list( $limit, $nlinks ) = explode( '/', $par, 2 );
		$limit = (int)$limit;
		$nlinks = $nlinks === 'nlinks';
		$offset = 0;
	} else {
		list( $limit, $offset ) = wfCheckLimits();
		$nlinks = true;
	}

	/** Wikia improvements **/
	$excludetitles = '';
	if( $et = $wgRequest->getText( 'excludetitles' ) )
		$excludetitles = $et;

	/**
	$wpp = new WantedPagesPage( $inc, $nlinks );
	/**/
	$wpp = new WantedPagesPageWikia( $inc, $nlinks, $excludetitles );

	if ( ! $wpp->doFeed( $wgRequest->getVal( 'feed' ), $limit ) )
	$wpp->doQuery( $offset, $limit, !$inc );
}
