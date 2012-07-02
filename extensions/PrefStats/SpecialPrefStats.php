<?php
/**
 * Special:PrefStats
 *
 * @file
 * @ingroup Extensions
 */

class SpecialPrefStats extends SpecialPage {

	/**
	 * Constructor -- set up the special page
	 */
	public function __construct() {
		parent::__construct( 'PrefStats' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgPrefStatsTrackPrefs;
		$this->setHeaders();

		// Check permissions
		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		$wgOut->setPageTitle( wfMsg( 'prefstats-title' ) );

		if ( !isset( $wgPrefStatsTrackPrefs[$par] ) ) {
			$this->displayTrackedPrefs();
			return;
		}

		$this->displayPrefStats( $par );
	}

	function displayTrackedPrefs() {
		global $wgOut, $wgUser, $wgPrefStatsTrackPrefs;
		if ( !count( $wgPrefStatsTrackPrefs ) ) {
			$wgOut->addWikiMsg( 'prefstats-noprefs' );
			return;
		}
		$wgOut->addWikiMsg( 'prefstats-list-intro' );
		$wgOut->addHTML( Xml::openElement( 'ul' ) );
		foreach ( $wgPrefStatsTrackPrefs as $pref => $value ) {
			$wgOut->addHTML( Xml::tags( 'li', array(),
				$wgUser->getSkin()->link(
					$this->getTitle( $pref ),
					htmlspecialchars( wfMsg( 'prefstats-list-elem', $pref,
						$value ) ) ) ) );
		}
		$wgOut->addHTML( Xml::closeElement( 'ul' ) );
	}

	function displayPrefStats( $pref ) {
		global $wgOut, $wgRequest, $wgPrefStatsExpensiveCounts;
		$stats = $this->getPrefStats( $pref,
			$wgRequest->getIntOrNull( 'inc' ) );
		$counters = $this->getCounters( $pref );
		$message = $wgPrefStatsExpensiveCounts ?
			'prefstats-counters-expensive' :
			'prefstats-counters';
		$wgOut->addWikiMsgArray( $message, $counters );
		$wgOut->addHTML( $this->incLinks( $pref ) );
		$wgOut->addHTML( Xml::element( 'br' ) );
		$wgOut->addHTML( Xml::element( 'img', array( 'src' =>
			$this->getGoogleChartParams( $stats ) ) ) );
	}

	function incLinks( $pref ) {
		global $wgPrefStatsTimeFactors, $wgLang;
		$factors = array();
		foreach ( $wgPrefStatsTimeFactors as $message => $factor ) {
			$attrs = array();
			if ( !is_null( $factor ) ) {
				$attrs['inc'] = $factor;
			}
			$factors[] = Xml::element( 'a', array( 'href' =>
				$this->getTitle( $pref )->getFullURL( $attrs )
				), wfMsg( $message ) );
		}
		return wfMsg( 'prefstats-factors',
					$wgLang->pipeList( $factors ) );
	}

	function getGoogleChartParams( $stats ) {
		global $wgPrefStatsChartDimensions;
		$max = max( $stats[0] ) + max( $stats[1] );
		$min = min( min( $stats[0] ), min( $stats[1] ) );
		return 'http://chart.apis.google.com/chart?' . wfArrayToCGI(
		array(
			'chs' => implode( 'x', $wgPrefStatsChartDimensions ),
			'cht' => 'bvs',
			'chds' => '0,' . $max,
			'chd' => 't:' . implode( ',', $stats[0] ) . '|' .
					implode( ',', $stats[1] ),
			'chxt' => 'x,y,x',
			'chxr' => '1,' . $min . ',' . $max,
			'chxl' => '2:|' . wfMsg( 'prefstats-xaxis' ) .
				'|0:|' . implode( '|', array_keys( $stats[0] ) ),
			'chm' => 'N*f0zy*,000000,0,-1,11|N*f0zy*,000000,1,-1,11',
			'chco' => '4D89F9,C6D9FD',
			'chbh' => 'a',
			'chdl' => wfMsg( 'prefstats-legend-out' ) . '|' .
				wfMsg( 'prefstats-legend-in' )
		) );
	}

	function getCounters( $pref ) {
		global $wgMemc, $wgPrefStatsCacheTime;
		if ( $wgPrefStatsCacheTime === false ) {
			return $this->reallyGetCounters( $pref );
		}

		$key = wfMemcKey( 'prefstats', 'counters', $pref );
		$cached = $wgMemc->get( $key );
		if ( $cached ) {
			return $cached;
		}
		$retval = $this->reallyGetCounters( $pref );
		$wgMemc->set( $key, $retval, $wgPrefStatsCacheTime );
		return $retval;
	}

	function reallyGetCounters( $pref ) {
		global $wgPrefStatsExpensiveCounts, $wgPrefStatsTrackPrefs;
		$val = $wgPrefStatsTrackPrefs[$pref];

		$dbr = wfGetDB( DB_SLAVE );
		$c2 = $dbr->selectField( 'prefstats', 'COUNT(*)', array(
				'ps_pref' => $pref,
				'ps_duration IS NULL'
			), __METHOD__ );
		$c3 = $dbr->selectField( 'prefstats', 'COUNT(*)', array(
				'ps_pref' => $pref,
				'ps_duration IS NOT NULL'
			), __METHOD__ );
		$c1 = $c2 + $c3;
		if ( $wgPrefStatsExpensiveCounts ) {
			$c4 = $dbr->selectField( 'user_properties', 'COUNT(*)',
				array(	'up_property' => $pref,
					'up_value' => $val
				), __METHOD__ );
		} else {
			$c4 = 0;
		}
		return array( $c1, $c2, $c3, $c4 );
	}

	function getPrefStats( $pref, $inc = null ) {
		global $wgMemc, $wgPrefStatsCacheTime;
		if ( $wgPrefStatsCacheTime === false ) {
			return $this->reallyGetPrefStats( $pref, $inc );
		}

		$key = wfMemcKey( 'prefstats', 'stats', $pref, $inc );
		$cached = $wgMemc->get( $key );
		if ( $cached ) {
			return $cached;
		}
		$retval = $this->reallyGetPrefStats( $pref, $inc );
		$wgMemc->set( $key, $retval, $wgPrefStatsCacheTime );
		return $retval;
	}

	function reallyGetPrefStats( $pref, $inc = null ) {
		global $wgPrefStatsTimeUnit, $wgPrefStatsDefaultScaleBars;
		$max = ceil( $this->getMaxDuration( $pref ) /
			$wgPrefStatsTimeUnit );
		$inc = max( 1, ( is_null( $inc ) ? ceil( $max / $wgPrefStatsDefaultScaleBars ) : $inc ) );
		$retval = array();
		for ( $i = 0; $i <= $max; $i += $inc ) {
			$end = min( $max, $i + $inc );
			$key = $i . '-' . $end;
			list( $out, $in ) = $this->countBetween( $pref,
				$i * $wgPrefStatsTimeUnit,
				$end * $wgPrefStatsTimeUnit );
			$retval[0][$key] = $out;
			$retval[1][$key] = $in;
		}
		return $retval;
	}

	/**
	 * Get the highest duration in the database
	 */
	function getMaxDuration( $pref ) {
		$dbr = wfGetDB( DB_SLAVE );
		$max1 = $dbr->selectField( 'prefstats', 'MAX(ps_duration)',
			array( 'ps_pref' => $pref ), __METHOD__ );
		$minTS = $dbr->selectField( 'prefstats', 'MIN(ps_start)',
			array( 'ps_pref' => $pref,
				'ps_duration IS NULL' ), __METHOD__ );
		$max2 = wfTimestamp( TS_UNIX ) - wfTimestamp( TS_UNIX, $minTS );
		return max( $max1, $max2 );
	}

	/**
	 * Count the number of users having $pref enabled between
	 * $min and $max seconds
	 * @return array( opted out, still opted in )
	 */
	function countBetween( $pref, $min, $max ) {
		$dbr = wfGetDB( DB_SLAVE );
		$count1 = $dbr->selectField( 'prefstats', 'COUNT(*)', array(
				'ps_pref' => $pref,
				'ps_duration < ' . intval( $max ),
				'ps_duration >= ' . intval( $min )
			), __METHOD__ );
		$maxTS = wfTimestamp( TS_UNIX ) - $min;
		$minTS = wfTimestamp( TS_UNIX ) - $max;
		$count2 = $dbr->selectField( 'prefstats', 'COUNT(*)', array(
				'ps_pref' => $pref,
				'ps_duration IS NULL',
				'ps_start <' . $dbr->addQuotes( $dbr->timestamp( $maxTS ) ),
				'ps_start >=' . $dbr->addQuotes( $dbr->timestamp( $minTS ) )
			), __METHOD__ );
		return array( $count1, $count2 );
	}
}
