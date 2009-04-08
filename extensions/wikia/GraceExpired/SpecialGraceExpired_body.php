<?php

class GraceExpiredSpecialPage extends SpecialPage {
        function __construct() {
                wfLoadExtensionMessages('Graceexpired');
                parent::__construct( 'Graceexpired' );
        }



	function beginPageList() {
		$s = '<ul id="pagehistory">';
		
		return $s;
	}

	function endPageList() {
		$s = '</ul>';

		return $s;
	}

	function execute( $par ) {
		global $wgOut;

		wfProfileIn( __METHOD__ );

		$this->setHeaders();

		$wgOut->setPageTitle( wfMsg( 'graceexpired' ) );

		$pager = new GraceExpiredPager ();
		$this->linesonpage = $pager->getNumRows();
		$wgOut->addHTML(
			'<div>' . $wgOut->parse( wfMsg( 'graceexpired-header' ) ) . '</div>' .
			$pager->getNavigationBar() .
			$this->beginPageList() .
			$pager->getBody() .
			$this->endPageList() .
			$pager->getNavigationBar()
		);

		wfProfileOut( __METHOD__ );
	}
}

class GraceExpiredPager extends ReverseChronologicalPager {
	const buildNs = 100;

	function getQueryInfo() {
		$date = date('YmdHis', strtotime('-2 week'));

		$query = array(
			'tables' => array( 'page', 'revision', 'categorylinks' ),
			'fields' => array( 'page_title', 'page_namespace', 'cl_to', 'rev_timestamp' ),
			'conds' => array( 
#				'page_namespace' => self::buildNs,
				'page_is_redirect' => 0,
				'page_latest = rev_id',
				"rev_timestamp < $date",
				'cl_from = page_id',
				"cl_to in ('Abandoned', 'Trash_builds', 'Build_stubs', 'Trash_Builds')"
			),
			'options' => 'ORDER BY rev_id ASC',
		);

		return $query;
	}

	function formatRow( $row ) {
		global $wgUser, $wgLang;

		$sk = $wgUser->getSkin();

		$output = '<li>' .
			wfMsg( 'graceexpired-row',
				/* article   */ $sk->makeKnownLinkObj( Title::newFromText( $row->page_title, $row->page_namespace ) ),
				/* category  */ $sk->makeKnownLinkObj( Title::newFromText( $row->cl_to, NS_CATEGORY ), $row->cl_to ),
				/* last edit */ $wgLang->timeanddate( wfTimestamp( TS_MW, $row->rev_timestamp ), true ) 
			) . '</li>';

		return $output;
	}

	function getIndexField() {
		return 'page_title';
	}

}
