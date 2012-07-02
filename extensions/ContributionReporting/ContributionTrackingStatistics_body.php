<?php
/**
 * Special Page for Contribution tracking statistics extension
 *
 * @file
 * @ingroup Extensions
 */

// Special page ContributionTrackingStatistics
class SpecialContributionTrackingStatistics extends SpecialPage {

	public static $number_of_days_to_show = 7;
	/* Functions */

	public function __construct() {
		// Initialize special page
		parent::__construct( 'ContributionTrackingStatistics' );
	}

	public function execute( $sub ) {
		global $wgOut, $wgRequest;
		
		# Emergency short cut until this is back in working order
		$wgOut->redirect( SpecialPage::getTitleFor( 'FundraiserStatistics' )->getFullURL() );
		return;

		$start = $wgRequest->getIntOrNull( 'start' );
		$end = $wgRequest->getIntOrNull( 'end' );
		$format = $wgRequest->getIntOrNull( 'format' );

		// Begin output
		$this->setHeaders();

		$wgOut->addWikiMsg('contribstats-header');
		// Build Header
		$htmlOut = Xml::openElement( 'table',
				array(
					'boder' => 0,
					'cellpadding' => 1,
					'width' => '100%',
				)
		);

		$htmlOut .=  Xml::tags( 'tr', null,
				Xml::element( 'td', array( 'align' => 'left' ),
					wfMsg( 'contribstats-imperfect-data' ) ) .
				Xml::element( 'td', array( 'align' => 'right' ),
					wfTimestamp( TS_DB ) . ' (UTC)')
		);
		$htmlOut .= Xml::tags( 'tr', null,
				Xml::element( 'td', array( 'align' => 'left' ),
					wfMsg( 'contribstats-fraud-note' ) . " " .
						wfMsg( 'contribstats-unaudited' ) )
		);
		$htmlOut .= Xml::tags( 'tr', null,
				Xml::element(  'td', array( 'align' => 'left' ),
					'PP = ' . wfMsg( 'contribstats-paypal-donations' ) . ', ' .
							'CC = ' . wfMsg( 'contribstats-credit-card' ) )
		);
		$htmlOut .= Xml::closeElement( 'table' );

		$wgOut->addHTML( $htmlOut );

		// Show day totals
		if ( $start && $end && $format ) {
			$this->showTotalsForRange( array( $start, $end ), $format );
		} else {
			$end = time();
			$format = 1;
			$offset = SpecialContributionTrackingStatistics::$number_of_days_to_show * 24 * 60 * 60;
			$this->showTotalsForRange( array( ( $end - $offset ), $end ), $format );
		}
		$wgOut->addWikiMsg('contribstats-footer');
	}

	/* Display Functions */

	// Generic Table Display for Totals
	// FORMAT: 1 daily, 2 weekly, 3 Monthly, 4 Combined
	public function showTotalsForRange( $range, $format ) {
		list( $start, $end ) = $range;
		$current = $end;

		switch( $format ) {
			case 1:
				while( $current > $start ) {
					$this->showDayTotals( $current );
					$current = $current - 24 * 60 * 60;
				}
				break;
			case 2:
				break;
			case 3:
				break;
			case 4:
				$totals = $this->getTotalsInRange( $range );
				$this->showCombinedTotals( $totals, $range );
				break;

		}
	}

	// Display tracking information for one day
	public function showDayTotals( $timestamp ) {
		global $wgOut;
		$totals = $this->getDayTotals( $timestamp );

		$msg = wfMsg( 'contribstats-day-totals' ) . " - " . date( 'o-m-d', $timestamp );
		$htmlOut = Xml::element( 'h3', null, $msg );

		if( isset( $totals ) ) {
			$htmlOut .= $this->createTable( $totals );
		} else {
			$htmlOut .= wfMsg( 'contribstats-nodata' );
		}

		// Output HTML
		$wgOut->addHTML( $htmlOut );
	}

	public function createTable( $totals ) {
		// Table headers
		global $wgAllowedTemplates, $wgAllowedSupport;
		global $wgAllowedPaymentMethod, $wgContributionReportingBaseURL;

		$htmlOut = Xml::openElement( 'table',
				array(
					'class' => 'sortable',
					'border' => 0,
					'cellpadding' => 5,
					'width' => '100%'
				)
		);

		$htmlOut .= Xml::element( 'th', array( 'align' => 'left' ), wfMsg( 'contribstats-banner' ) ) ;
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left' ), wfMsg( 'contribstats-landingpage' ) ) ;
		$htmlOut .= Xml::element( 'th', array( 'align' => 'center' ), wfMsg( 'contribstats-payment-type' ) ) ;
		$htmlOut .= Xml::element( 'th', array( 'align' => 'center' ), wfMsg( 'contribstats-payment-type-hits' ) ) ;
		$htmlOut .= Xml::element( 'th', array( 'align' => 'center' ), wfMsg( 'contribstats-donations' ) );
		$htmlOut .= Xml::element( 'th', array( 'align' => 'center' ), wfMsg( 'contribstats-amount' ) );
		$htmlOut .= Xml::element( 'th', array( 'align' => 'center' ), wfMsg( 'contribstats-average' ) );
		$htmlOut .= Xml::element( 'th', array( 'align' => 'center' ), wfMsg( 'contribstats-max' ) );

		foreach( $totals as $template ) {
			//grab info from utm_src, 'unpack' template, landing page, donation page thus far
			$expanded_template = explode(".", $template[0]);
			if(!isset($expanded_template[1])) {
				$expanded_template[1] = "";
			}
			if(!isset($expanded_template[2])) {
				$expanded_template[2] = "";
			}

			if ( ! in_array($expanded_template[0], $wgAllowedTemplates ) ) {
				continue;
			}
			if( ($expanded_template[1] != "") && (! in_array($expanded_template[1], $wgAllowedSupport)) ){
				continue;
			}
			if( ($expanded_template[2] != "") && (! in_array($expanded_template[2], $wgAllowedPaymentMethod)) ){
				continue;
			}
			// Pull together templates, clicks, donations, conversion rate
			$amount = ( $template[3] == 0 ) ? 0 : $template[3];

			$link = $wgContributionReportingBaseURL.$expanded_template[0];
			$template_link = Xml::element('a', array('href' =>"$link"), $expanded_template[0]);

			//average donations
			$average = 0;
			if($template[2] != 0){
				$average = $amount / $template[2];
			}

			$htmlOut .= Xml::tags( 'tr', null,
					Xml::tags( 'td', array( 'align' => 'left'), $template_link ) .
					Xml::element( 'td', array( 'align' => 'left'), $expanded_template[1] ) .
					Xml::element( 'td', array( 'align' => 'center'), $expanded_template[2] ) .
					Xml::element( 'td', array( 'align' => 'center'), $template[1] + $template[2] ) .
					Xml::element( 'td', array( 'align' => 'center'), $template[2] ) .
					Xml::element( 'td', array( 'align' => 'center'), $amount ) .
					Xml::element( 'td', array( 'align' => 'center'), round($average, 2) ) .
					Xml::element( 'td', array( 'align' => 'center'), $template[4] )
			);
		}

		$htmlOut .= Xml::closeElement( 'table' );

		return $htmlOut;
	}

	//Display tracking information for combined totals
	public function showCombinedTotals( $totals, $range ) {
		global $wgOut;

		$msg = date( 'o-m-d', wfTimestamp( TS_UNIX, $range[0] ) ) . ' - ' .
			date( 'o-m-d', wfTimestamp( TS_UNIX, $range[1] ) ) ;
		$htmlOut = Xml::element( 'h3', null, $msg );

		if( isset( $totals ) ) {
			$htmlOut .= $this->createTable( $totals );
		} else {
			$htmlOut .= wfMsg( 'contribstats-nodata' );
		}

		// Output HTML
		$wgOut->addHTML( $htmlOut );
	}

	/* Query Functions */

	/**
	 * Totals for today
	 *
	 * @param $timestamp string
	 * @return array
	 */
	public function getDayTotals( $timestamp = 0 ) {
		$range = array();
		$end_format = 'Ymd235959';

		$range[0] = strtotime( date( 'Ymd000000' , wfTimestamp(TS_UNIX, $timestamp) ) );
		$range[1] = strtotime( date( $end_format , wfTimestamp(TS_UNIX, $timestamp) ) );

		return $this->getTotalsInRange($range);
	}

	//Generalized lookup
	//$range @array( star, end ) UNIXTIME
	public function getTotalsInRange( $range ){
		$dbr = efContributionTrackingConnection();

		$conds[] = "ts >=" . $dbr->addQuotes( date( 'YmdHis', $range[0] ) );
		$conds[] = "ts <=" . $dbr->addQuotes( date( 'YmdHis', $range[1] ) );

		$res = $dbr->select(
			array( 'contribution_tracking',
				   'civicrm.public_reporting',
			),
			array(
				'utm_source',
				'sum(isnull(contribution_tracking.contribution_id)) as miss',
				'sum(not isnull(contribution_tracking.contribution_id)) as hit',
				'sum(converted_amount) as converted_amount',
				'max(converted_amount) as max_converted_amt'
			),
			$conds,
			__METHOD__,
			array(
				'ORDER BY' => 'hit desc',
				'GROUP BY' => 'utm_source'
			),
			array( 'civicrm.public_reporting' =>
				array(
					'LEFT JOIN',
					'contribution_tracking.contribution_id = civicrm.public_reporting.contribution_id',
				)
			)

		);

		$result = array();
		foreach ( $res as $row ) {
			foreach( $row as $value ) {
				$result[] = $value;
			}
		}
		return $result;
	}

	/**
	 * Given a day figure out what its week bounds are
	 *
	 * @param $day
	 * @return array
	 */
	public function weekRange( $day ) {
		$day = wfTimestamp( TS_UNIX, $day );
		$start = ( date( 'w', $day ) == 0) ? $day : strtotime('last sunday', $day ); // Use current Sunday
		return array(
			date( 'Ymd000000', $start ),
			date( 'Ymd235959', strtotime( 'next sunday', $start) )
		);
	}
}
