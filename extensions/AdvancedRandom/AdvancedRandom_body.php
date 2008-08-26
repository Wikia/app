<?php

if ( ! defined( 'MEDIAWIKI' ) )
	die();

class SpecialAdvancedRandom extends SpecialPage {
	/**
	 * Constructor
	 */
	public function __construct() {
		SpecialPage::SpecialPage( 'AdvancedRandom' );
	}

	/**
	 * @see SpecialPage::getDescription
	 */
	function getDescription() {
		return wfMsg( 'advancedrandom' );
	}

	/**
	 * main()
	 */
	public function execute( $params ) {
		global $wgOut;
		wfLoadExtensionMessages( 'AdvancedRandom' );

		$fname = 'SpecialAdvancedRandom::execute';

		wfProfileIn( $fname );

		list( $page, $namespace ) = $this->extractParamaters( $par );

		$ft = Title::newFromText( $page );
		if ( is_null( $ft ) ) {
			$this->redirect( Title::newMainPage() );
			wfProfileOut( $fname );
			return;
		}

		$rand = wfRandom();
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->selectRow(
			array( 'page', 'pagelinks' ),
			array( 'page_namespace', 'page_title', 'page_random' ),
			array(
				'page_id = pl_from',
				'pl_namespace' => $ft->getNamespace(),
				'page_namespace' => $namespace,
				'pl_title' => $ft->getDBkey(),
				"page_random > $rand"
			),
			$fname,
			array(
				'ORDER BY' => 'page_random',
				'USE INDEX' => array(
					'page' => 'page_random',
				)
			)
		);

		$title =& Title::makeTitle( Namespace::getSubject( $namespace ), $res->page_title );
		if ( is_null( $title ) || $title->getText() == '' )
			$title = Title::newMainPage();;
		$this->redirect( $title );
		wfProfileOut( $fname );
	}

	/**
	 * Redirect to a given page
	 *
	 * @param object $title Title object
	 */
	private static function redirect( Title &$title ) {
		global $wgOut;

		$wgOut->redirect( $title->getFullUrl() );
	}

	/**
	 * Parse the page and namespace parts of the input and return them
	 *
	 * @access private
	 *
	 * @param string $par
	 * @return array
	 */
	private static function extractParamaters( $par ) {
		global $wgContLang;

		wfSuppressWarnings();
		list( $page, $namespace ) = explode( '/', $par, 2 );
		wfRestoreWarnings();

		// str*cmp sucks, casts null to ''
		if ( isset( $namespace ) )
			$namespace = $wgContLang->getNsIndex( $namespace );

		if ( is_null( $namespace ) || $namespace === false )
			$namespace = NS_MAIN;

		return array( $page, $namespace );
	}
}
