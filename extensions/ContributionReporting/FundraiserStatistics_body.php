<?php
/**
 * Special Page for Contribution statistics extension
 *
 * @file
 * @ingroup Extensions
 */

class SpecialFundraiserStatistics extends SpecialPage {

	/* Functions */

	public function __construct() {
		// Initialize special page
		parent::__construct( 'FundraiserStatistics' );
		// Internationalization
		wfLoadExtensionMessages( 'ContributionReporting' );
	}
	
	public function execute( $sub ) {
		global $wgRequest, $wgOut, $wgUser, $wgLang, $wgScriptPath;
		global $egFundraiserStatisticsFundraisers;
		// Begins ouput
		$this->setHeaders();
		// Adds JavaScript
		$wgOut->addScriptFile( $wgScriptPath . '/extensions/ContributionReporting/FundraiserStatistics.js' );
		// Adds CSS
		$wgOut->addLink(
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'href' => $wgScriptPath . '/extensions/ContributionReporting/FundraiserStatistics.css',
			)
		);
		// Creates arrays that describe the charts and make places where the generated HTML will be stored
		$sources = array(
			'totals' => 1,
			'contributions' => 2,
			'averages' => 3,
			'maximums' => 4,
		);
		$charts = array(
			'totals' => array(),
			'contributions' => array(),
			'averages' => array(),
			'maximums' => array(),
		);
		$htmlViews = '';
		$htmlLegend = '';
		// Gets todays date in a format similar to the dates from the database for easy comparison
		$today = strtotime( date( 'M j Y' ) );
		// Calculates maximum value of all days in all fundraisers
		$max = array( 0, 0, 0, 0, 0 );
		foreach ( $egFundraiserStatisticsFundraisers as $fundraiser ) {
			$fundraiserMax = $this->getContributionsMax( $fundraiser['start'], $fundraiser['end'] );
			if ( $fundraiserMax > $max[$sources['contributions']] ) {
				$max[$sources['contributions']] =  $fundraiserMax;
			}
			$fundraiserMax = $this->getDailyTotalMax( $fundraiser['start'], $fundraiser['end'] );
			if ( $fundraiserMax > $max[$sources['totals']] ) {
				$max[$sources['totals']] =  $fundraiserMax;
			}
			$fundraiserMax = $this->getAveragesMax( $fundraiser['start'], $fundraiser['end'] );
			if ( $fundraiserMax > $max[$sources['averages']] ) {
				$max[$sources['averages']] =  $fundraiserMax;
			}
			$fundraiserMax = $this->getMaximumsMax( $fundraiser['start'], $fundraiser['end'] );
			if ( $fundraiserMax > $max[$sources['maximums']] ) {
				$max[$sources['maximums']] =  $fundraiserMax;
			}
		}
		// Builds the various HTML components
		$view = 0;
		foreach ( $egFundraiserStatisticsFundraisers as $fundraiser ) {
			$htmlLegend .= Xml::element( 'div',
				array( 'class' => "fundraiserstats-legend-{$fundraiser['id']}" ),
				$fundraiser['title']
			);
			$days = $this->getDailyTotals( $fundraiser['start'], $fundraiser['end'] );
			foreach( $sources as $chart => $source ) {
				$column = 0;
				$factor = 200 / $max[$source];
				// Build bars for chart
				foreach( $days as $i => $day ) {
					$height = $factor * $day[$source];
					if ( !isset( $charts[$chart][$column] ) ) {
						$charts[$chart][$column] = '';
					}
					$attributes = array(
						'style' => "height:{$height}px",
						'class' => "fundraiserstats-bar-{$fundraiser['id']}",
						'onMouseOver' => "replaceView( 'fundraiserstats-view-box-{$view}' )"
					);
					$charts[$chart][$column] .= Xml::tags( 'td',
						array( 'valign' => 'bottom' ),
						Xml::element( 'div', $attributes, '', false )
					);
					// Build detail view for the day
					$tdLabelAttributes = array( 'width' => '16%', 'nowrap' => 'nowrap' );
					$tdValueAttributes = array( 'width' => '16%', 'nowrap' => 'nowrap', 'align' => 'right' );
					$htmlViews .= Xml::tags( 'div',
						array(
							'id' => 'fundraiserstats-view-box-' . $view,
							'class' => 'fundraiserstats-view-box',
							'style' => 'display: ' . ( $view == 0 ? 'block' : 'none' )
						),
						Xml::tags( 'table',
							array(
								'cellpadding' => 10,
								'cellspacing' => 0,
								'border' => 0,
								'width' => '100%'
							),
							Xml::tags( 'tr', null,
								Xml::tags( 'td',
									array( 'colspan' => 4 ),
									Xml::element( 'h3', null,
										wfMsg( 'fundraiserstats-day', $i + 1, $fundraiser['title'] )
									)
								)
							) .
							Xml::tags( 'tr', null,
								Xml::element( 'td', $tdLabelAttributes, wfMsg( 'fundraiserstats-date' ) ) .
								Xml::element( 'td', $tdValueAttributes, $day[0] ) .
								Xml::element( 'td', $tdLabelAttributes, wfMsg( 'fundraiserstats-total' ) ) .
								Xml::element( 'td', $tdValueAttributes, $wgLang->formatNum( $day[1] ) ) .
								Xml::element( 'td', $tdLabelAttributes, wfMsg( 'fundraiserstats-max' ) ) .
								Xml::element( 'td', $tdValueAttributes, $wgLang->formatNum( number_format( $day[4], 2 ) ) )
							) .
							Xml::tags( 'tr', null,
								Xml::element( 'td', $tdLabelAttributes, wfMsg( 'fundraiserstats-contributions' ) ) .
								Xml::element( 'td', $tdValueAttributes, $wgLang->formatNum( number_format( $day[2], 2 ) ) ) .
								Xml::element( 'td', $tdLabelAttributes, wfMsg( 'fundraiserstats-avg' ) ) .
								Xml::element( 'td', $tdValueAttributes, $wgLang->formatNum( number_format( $day[3], 2 ) ) )
							)
						)
					);
					$column++;
					$view++;
				}
			}
		}
		// Show bar graphs
		$first = true;
		$htmlCharts = Xml::openElement( 'div', array( 'class' => 'fundraiserstats-chart-tabs' ) );
		foreach ( $charts as $chart => $columns ) {
			$htmlCharts .= Xml::tags( 'div',
				array(
					'id' => "fundraiserstats-chart-{$chart}-tab",
					'class' => 'fundraiserstats-chart-tab-' . ( $first ? 'current' : 'normal' ),
					'onClick' => "replaceChart( 'fundraiserstats-chart-{$chart}' )"
				),
				wfMsg( 'fundraiserstats-tab-' . $chart )
			);
			$first = false;
		}
		$htmlCharts .= Xml::closeElement( 'div' );
		$first = true;
		foreach ( $charts as $chart => $columns ) {
			$htmlCharts .= Xml::tags( 'div',
				array(
					'id' => "fundraiserstats-chart-{$chart}",
					'class' => 'fundraiserstats-chart',
					'style' => 'display:' . ( $first ? 'block' : 'none' ) 
				),
				Xml::tags( 'table',
					array(
						'cellpadding' => 0,
						'cellspacing' => 0,
						'border' => 0
					),
					Xml::tags( 'tr', null,
						implode( $columns )
					)
				)
			);
			$first = false;
		}
		// Show views
		$htmlOut = Xml::tags( 'table',
			array(
				'cellpadding' => 0,
				'cellspacing' => 0,
				'border' => 0
			),
			Xml::tags( 'tr', null,
				Xml::tags( 'td', null,
					$htmlCharts
				)
			) .
			Xml::tags( 'tr', null,
				Xml::tags( 'td', null, $htmlViews )
			)
		);
		$wgOut->addHTML( $htmlOut );
	}
	
	/* Query Functions */
	
	public function getDailyTotals( $start, $end ) {
		$dbr = efContributionReportingConnection();
		$res = $dbr->select( 'public_reporting',
			array(
				"FROM_UNIXTIME(received, '%Y-%m-%d')",
				'sum(converted_amount)',
				'count(*)',
				'avg(converted_amount)',
				'max(converted_amount)',
			),
			$this->getConditions( $dbr, $start, $end ),
			__METHOD__,
			array(
				'ORDER BY' => 'received',
				'GROUP BY' => "FROM_UNIXTIME(received, '%Y-%m-%d')"
			)
		);
		$totals = array();
		while ( $row = $dbr->fetchRow( $res ) ) {
			$totals[] = $row;
		}
		return $totals;
	}
	
	public function getDailyTotalMax( $start, $end ) {
		$dbr = efContributionReportingConnection();
		return $dbr->selectField( 'public_reporting',
			array( 'sum(converted_amount) as sum' ),
			$this->getConditions( $dbr, $start, $end ),
			__METHOD__,
			array(
				'ORDER BY' => 'sum DESC',
				'GROUP BY' => "FROM_UNIXTIME(received, '%Y-%m-%d')",
			)
		);
	}
	
	public function getContributionsMax( $start, $end ) {
		$dbr = efContributionReportingConnection();
		return $dbr->selectField( 'public_reporting',
			array( 'count(converted_amount) as sum' ),
			$this->getConditions( $dbr, $start, $end ),
			__METHOD__,
			array(
				'ORDER BY' => 'sum DESC',
				'GROUP BY' => "FROM_UNIXTIME(received, '%Y-%m-%d')",
			)
		);
	}
	
	public function getAveragesMax( $start, $end ) {
		$dbr = efContributionReportingConnection();
		return $dbr->selectField( 'public_reporting',
			array( 'avg(converted_amount) as sum' ),
			$this->getConditions( $dbr, $start, $end ),
			__METHOD__,
			array(
				'ORDER BY' => 'sum DESC',
				'GROUP BY' => "FROM_UNIXTIME(received, '%Y-%m-%d')",
			)
		);
	}
	
	public function getMaximumsMax( $start, $end ) {
		$dbr = efContributionReportingConnection();
		return $dbr->selectField( 'public_reporting',
			array( 'max(converted_amount) as sum' ),
			$this->getConditions( $dbr, $start, $end ),
			__METHOD__,
			array(
				'ORDER BY' => 'sum DESC',
				'GROUP BY' => "FROM_UNIXTIME(received, '%Y-%m-%d')",
			)
		);
	}
	
	protected function getConditions( $dbr, $start, $end ) {
		global $egFundraiserStatisticsMinimum, $egFundraiserStatisticsMaximum;
		return array(
			'received >= ' . $dbr->addQuotes( wfTimestamp( TS_UNIX, strtotime( $start ) ) ),
			'received <= ' . $dbr->addQuotes( wfTimestamp( TS_UNIX, strtotime( $end ) + 24 * 60 * 60 ) ),
			'converted_amount >= ' . $egFundraiserStatisticsMinimum,
			'converted_amount <= ' . $egFundraiserStatisticsMaximum
		);
	}
}
