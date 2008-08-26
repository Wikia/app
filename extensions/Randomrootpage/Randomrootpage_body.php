<?php
if (!defined('MEDIAWIKI')) die();

class SpecialRandomrootpage extends SpecialPage {

	public function __construct() {
		SpecialPage::SpecialPage( 'Randomrootpage' );
	}

	private $namespace = NS_MAIN;  // namespace to select pages from

	public function getNamespace() {
		return $this->namespace;
	}

	public function setNamespace ( $ns ) {
		if( $ns < NS_MAIN ) $ns = NS_MAIN;
		$this->namespace = $ns;
	}

	// Don't select redirects
	public function isRedirect(){
		return false;
	}

	public function execute( $par ) {
		global $wgOut, $wgContLang;

		wfLoadExtensionMessages( 'Randomrootpage' );

		if ($par)
			$this->setNamespace( $wgContLang->getNsIndex( $par ) );

		$title = $this->getRandomTitle();

		if( is_null( $title ) ) {
			$this->setHeaders();
			$wgOut->addWikiMsg( strtolower( $this->mName ) . '-nopages' );
			return;
		}

		$query = $this->isRedirect() ? 'redirect=no' : '';
		$wgOut->redirect( $title->getFullUrl( $query ) );
	}


	/**
	 * Choose a random title.
	 * @return Title object (or null if nothing to choose from)
	 */
	public function getRandomTitle() {
		$randstr = wfRandom();
		$row = $this->selectRandomPageFromDB( $randstr );

		/* If we picked a value that was higher than any in
		 * the DB, wrap around and select the page with the
		 * lowest value instead!  One might think this would
		 * skew the distribution, but in fact it won't cause
		 * any more bias than what the page_random scheme
		 * causes anyway.  Trust me, I'm a mathematician. :)
		 */
		if( !$row )
			$row = $this->selectRandomPageFromDB( "0" );

		if( $row )
			return Title::makeTitleSafe( $this->namespace, $row->page_title );
		else
			return null;
	}

	private function selectRandomPageFromDB( $randstr ) {
		global $wgExtraRandompageSQL;
		$fname = 'RandomPage::selectRandomPageFromDB';

		$dbr = wfGetDB( DB_SLAVE );

		$use_index = $dbr->useIndexClause( 'page_random' );
		$page = $dbr->tableName( 'page' );

		$ns = (int) $this->namespace;
		$redirect = $this->isRedirect() ? 1 : 0;

		$extra = $wgExtraRandompageSQL ? "AND ($wgExtraRandompageSQL)" : "";
		$sql = "SELECT page_title
			FROM $page $use_index
			WHERE page_namespace = $ns
			AND page_is_redirect = $redirect
			AND page_random >= $randstr
			AND page_title NOT LIKE '%/%'
			$extra
			ORDER BY page_random";

		$sql = $dbr->limitResult( $sql, 1, 0 );
		$res = $dbr->query( $sql, $fname );
		return $dbr->fetchObject( $res );
	}
}
