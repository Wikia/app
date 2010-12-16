<?php
/**
 * Special:CooperationStatistics
 */

class CooperationStatistics extends IncludableSpecialPage {
	public function __construct() {
		parent::__construct( 'CooperationStatistics' );
	}

	public function execute( $par ) {
		global $wgCooperationStatsGoogleCharts, $wgOut;

		wfLoadExtensionMessages( 'CooperationStatistics' );
		$nb_of_revuser = wfMsg( 'cooperationstatistics-limit-few-revisors' );
		$nbpages = $this->getNbOfPages( $nb_of_revuser, '<=' );
		if( !$this->mIncluding )
			$this->OutputTableRaw( $nbpages, $nb_of_revuser, 'init' );

		$retval = array();
		$retval[$nb_of_revuser] = $this->getNbOfPages( $nb_of_revuser, '=' );
		$nb_of_revuser++;
		$range = 1 + wfMsg( 'cooperationstatistics-limit-many-revisors' ) - $nb_of_revuser;
		for ( $j = 0; $j < $range; $j++ ) {
			$nbpages = $this->getNbOfPages( $nb_of_revuser, '=' );
			if( !$this->mIncluding )
				$this->OutputTableRaw( $nbpages, $nb_of_revuser, '=' );
			$retval[$nb_of_revuser] = $nbpages;
			$nb_of_revuser++;
		}

		$nbpages = $this->getNbOfPages( $nb_of_revuser, '>=' );
		if( !$this->mIncluding )
			$this->OutputTableRaw( $nbpages, $nb_of_revuser, 'end' );
		$retval[$nb_of_revuser] = $nbpages;

		if ( $wgCooperationStatsGoogleCharts == True ) {
			$wgOut->addHTML( Xml::element( 'img', array( 'src' =>
				$this->getGoogleChartBarParams( $retval ) ) )
							. Xml::element( 'img', array( 'src' =>
				$this->getGoogleChartParams( $retval ) ) ) );
		}
	}

	private function getGoogleChartBarParams( $stats ) {
		global $wgCoopStatsChartBarDimensions;
		return "http://chart.apis.google.com/chart?" . wfArrayToCGI(
		array(
			'chs' => $wgCoopStatsChartBarDimensions,
			'cht' => 'bvs',
			'chds' => '0,' . max( $stats ),
			'chd' => 't:' . implode( ',', $stats ),
			'chxt' => 'x,y',
			'chxr' => '1,' . 0 . ',' . max( $stats ),
			'chl' => implode( '|', array_keys( $stats ) ) . "++"
		) );
	}

	private function getGoogleChartParams( $stats ) {
		global $wgCoopStatsChartDimensions;
		return "http://chart.apis.google.com/chart?" . wfArrayToCGI(
		array(
			'chs' => $wgCoopStatsChartDimensions,
			'cht' => 'p3',
			'chd' => 't:' . implode( ',', $stats ),
			'chds' => '0,' . max( $stats ),
			'chl' => implode( wfMsg( 'word-separator' ) . wfMsg( 'cooperationstatistics-users' ) . ' |', array_keys( $stats ) ) . wfMsg( 'word-separator' ) . wfMsg( 'cooperationstatistics-legendmore' )
		) );
	}

	private function InitPageAndHtmlTable( ) {
		global $wgOut;
		$this->setHeaders();
		$wgOut->setPagetitle( wfMsg( "cooperationstatistics" ) );
		$wgOut->addWikiMsg( "cooperationstatistics-text" );
		$wgOut->addHTML( "<table class=\"wikitable sortable\"><tr><td>" );
		$wgOut->addWikiMsg( "cooperationstatistics-tablearticle" );
		$wgOut->addHTML( "</td>
		<td>" );
		$wgOut->addWikiMsg( "cooperationstatistics-tablevalue" );
		$wgOut->addHTML( "</td>
		</tr>" );
	}

	private function OutputTableRaw( $nbpages, $nb_of_revuser, $msg ) {
		global $wgOut;

		if ( $msg == 'init' ) $this->InitPageAndHtmlTable();

		$wgOut->addHTML( "	<tr>
		<td align='left'>" );
		$wgOut->addWikiMsg( 'cooperationstatistics-articles', $nbpages );
		$wgOut->addHTML( "			</td>
		<td align='left'>" );

		if ( $msg == 'init' ) $wgOut->addWikiMsg( 'cooperationstatistics-nblessusers', $nb_of_revuser, $nbpages );
		if ( $msg == '=' ) $wgOut->addWikiMsg( 'cooperationstatistics-nbusers', $nb_of_revuser, $nbpages );
		if ( $msg == 'end' ) $wgOut->addWikiMsg( 'cooperationstatistics-nbmoreusers', $nb_of_revuser, $nbpages );

		$wgOut->addHTML( "			</td>
	</tr>" );

		if ( $msg == 'end' )	$wgOut->addHTML( "</table>" );
	}

	private function getNbOfPages( $nb, $relation ) {
		$sql = self::getSQL( $nb, $relation );
		$db = wfGetDB( DB_SLAVE );
		$res = $db->query( $sql, __METHOD__ );

		return $db->numRows( $res );
	}

	private function getSQL( $nb_of_revuser, $symbol ) {
		$dbr = wfGetDB( DB_SLAVE );
		list( $revision, $page ) = $dbr->tableNamesN( 'revision', 'page' );

		return
			"
			SELECT
				page_title as title,
				COUNT(distinct rev_user) as value
			FROM $revision
			JOIN $page ON page_id = rev_page
			WHERE page_is_redirect=0 AND page_namespace = " . NS_MAIN . "
			GROUP BY page_namespace, page_title
			HAVING COUNT(distinct rev_user)$symbol$nb_of_revuser
			";
	}
}
