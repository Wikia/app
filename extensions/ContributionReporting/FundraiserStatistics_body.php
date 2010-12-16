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
		parent::__construct( 'FundraiserStatistics' );
		wfLoadExtensionMessages( 'ContributionReporting' );
	}
	
	public function execute( $sub ) {
		global $wgRequest, $wgOut, $wgUser, $wgLang, $wgScriptPath, $egFundraiserStatisticsFundraisers;
		
		/* Configuration (this isn't totally static data, some of it gets built on the fly) */
		
		$charts = array(
			'totals' => array(
				'data' => array(),
				'index' => 1,
				'query' => 'dailyTotalMax',
				'precision' => 2,
				'label' => 'fundraiserstats-total',
				'max' => 0,
			),
			'contributions' => array(
				'data' => array(),
				'index' => 2,
				'query' => 'contributionsMax',
				'precision' => 0,
				'label' => 'fundraiserstats-contributions',
				'max' => 0,
			),
			'averages' => array(
				'data' => array(),
				'index' => 3,
				'query' => 'averagesMax',
				'precision' => 2,
				'label' => 'fundraiserstats-avg',
				'max' => 0,
			),
			'maximums' => array(
				'data' => array(),
				'index' => 4,
				'query' => 'maximumsMax',
				'precision' => 2,
				'label' => 'fundraiserstats-max',
				'max' => 0,
			),
			'ytd' => array(
				'data' => array(),
				'index' => 5,
				'query' => 'yearlyTotalMax',
				'precision' => 2,
				'label' => 'fundraiserstats-ytd',
				'max' => 0,
			),
		);
		
		/* Setup */
		
		$this->setHeaders();
		$wgOut->addScriptFile( $wgScriptPath . '/extensions/ContributionReporting/FundraiserStatistics.js' );
		$wgOut->addLink(
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'href' => $wgScriptPath . '/extensions/ContributionReporting/FundraiserStatistics.css',
			)
		);
		
		/* Display */
		
		// Chart maximums
		foreach ( $egFundraiserStatisticsFundraisers as $fundraiser ) {
			foreach ( $charts as $name => $chart ) {
				$chartMax = $this->query( $charts[$name]['query'], $fundraiser['start'], $fundraiser['end'] );
				if ( $chartMax > $charts[$name]['max'] ) {
					$charts[$name]['max'] = $chartMax;
				}
			}
		}
		// Scale factors
		foreach ( $charts as $name => $chart ) {			
			$charts[$name]['factor'] = $factor = 300 / $chart['max'];
		}
		// HTML-time!
		$view = 0;
		$htmlViews = '';
		foreach ( $egFundraiserStatisticsFundraisers as $fundraiser ) {
			$days = $this->query( 'dailyTotals', $fundraiser['start'], $fundraiser['end'] );
			foreach ( $charts as $name => $chart ) {
				$column = 0;
				foreach( $days as $i => $day ) {
					if ( !isset( $charts[$name]['data'][$column] ) ) {
						$charts[$name]['data'][$column] = '';
					}
					$height = $chart['factor'] * $day[$chart['index']];
					$attributes = array(
						'style' => "height:{$height}px",
						'class' => "fundraiserstats-bar-{$fundraiser['id']}",
						'onMouseOver' => "replaceView( 'fundraiserstats-view-box-{$view}' )"
					);
					$charts[$name]['data'][$column] .= Xml::tags(
						'td', array( 'valign' => 'bottom' ), Xml::element( 'div', $attributes, '', false )
					);
					$htmlView = Xml::openElement( 'tr' );
					$count = 0;
					foreach ( $charts as $subchart ) {
						$htmlView .= Xml::element(
							'td', array( 'width' => '16%', 'nowrap' => 'nowrap' ), wfMsg( $subchart['label'] )
						);
						$htmlView .= Xml::element(
							'td',
							array( 'width' => '16%', 'nowrap' => 'nowrap', 'align' => 'right' ),
							$wgLang->formatNum( number_format( $day[$subchart['index']], $subchart['precision'] ) )
						);
						if ( ++$count % 3 == 0 ) {
							$htmlView .= Xml::closeElement( 'tr' ) . Xml::openElement( 'tr' );
						}
					}
					$htmlView .= Xml::closeElement( 'tr' );
					$htmlViews .= Xml::tags(
						'div',
						array(
							'id' => 'fundraiserstats-view-box-' . $view,
							'class' => 'fundraiserstats-view-box',
							'style' => 'display: ' . ( $view == 0 ? 'block' : 'none' )
						),
						Xml::tags(
							'table',
							array( 'cellpadding' => 10, 'cellspacing' => 0, 'border' => 0, 'width' => '100%' ),
							Xml::tags(
								'tr',
								null,
								Xml::tags(
									'td',
									array( 'colspan' => 6 ),
									Xml::element( 'h3', array( 'style' => 'float:right;color:gray;' ), $day[0] ) .
									Xml::tags(
										'h3',
										array( 'style' => 'float:left;color:black;' ),
										wfMsgExt( 'fundraiserstats-day', array( 'parseinline' ), $i + 1, $fundraiser['title'] )
									) .
									Xml::element( 'div', array( 'style' => 'clear:both;' ), '', false )
								)
							) .
							$htmlView
						)
					);
					$column++;
					$view++;
				}
			}
		}
		// Tabs
		$first = true;
		$htmlCharts = Xml::openElement( 'div', array( 'class' => 'fundraiserstats-chart-tabs' ) );
		foreach ( $charts as $chart => $columns ) {
			$htmlCharts .= Xml::tags(
				'div',
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
		// Charts
		$first = true;
		foreach ( $charts as $name => $chart ) {
			$htmlCharts .= Xml::tags(
				'div',
				array(
					'id' => "fundraiserstats-chart-{$name}",
					'class' => 'fundraiserstats-chart',
					'style' => 'display:' . ( $first ? 'block' : 'none' ) 
				),
				Xml::tags(
					'table',
					array( 'cellpadding' => 0, 'cellspacing' => 0, 'border' => 0 ),
					Xml::tags( 'tr', null, implode( $chart['data'] ) )
				)
			);
			$first = false;
		}
		// Output
		$wgOut->addHTML(
			Xml::tags(
				'table',
				array(
					'cellpadding' => 0,
					'cellspacing' => 0,
					'border' => 0
				),
				Xml::tags( 'tr', null, Xml::tags( 'td', null, $htmlCharts ) ) .
				Xml::tags( 'tr', null, Xml::tags( 'td', null, $htmlViews ) )
			)
		);
	}
	
	/* Private Functions */
	
	private function query( $type, $start, $end ) {
		global $wgMemc, $egFundraiserStatisticsMinimum, $egFundraiserStatisticsMaximum;
		
		$key = wfMemcKey( 'fundraiserstatistics', $type, $start, $end );
		$cache = $wgMemc->get( $key );
		if ( $cache != false && $cache != -1 ) {
			return $cache;
		}
		// Use database
		$dbr = efContributionReportingConnection();
		$conditions = array(
			'received >= ' . $dbr->addQuotes( wfTimestamp( TS_UNIX, strtotime( $start ) ) ),
			'received <= ' . $dbr->addQuotes( wfTimestamp( TS_UNIX, strtotime( $end ) + 24 * 60 * 60 ) ),
			'converted_amount >= ' . $egFundraiserStatisticsMinimum,
			'converted_amount <= ' . $egFundraiserStatisticsMaximum
		);
		switch ( $type ) {
			case 'dailyTotals':
				$select = $dbr->select( 'public_reporting',
					array(
						"FROM_UNIXTIME(received, '%Y-%m-%d')",
						'sum(converted_amount)',
						'count(*)',
						'avg(converted_amount)',
						'max(converted_amount)',
					),
					$conditions,
					__METHOD__,
					array(
						'ORDER BY' => 'received',
						'GROUP BY' => "FROM_UNIXTIME(received, '%Y-%m-%d')"
					)
				);
				$result = array();
				$ytd = 0;
				while ( $row = $dbr->fetchRow( $select ) ) {
					$row[] = $ytd += $row[1]; // YTD
					$result[] = $row;
				}
				break;
			case 'dailyTotalMax':
				$result = $dbr->selectField( 'public_reporting',
					array( 'sum(converted_amount) as sum' ),
					$conditions,
					__METHOD__,
					array(
						'ORDER BY' => 'sum DESC',
						'GROUP BY' => "FROM_UNIXTIME(received, '%Y-%m-%d')",
					)
				);
				break;
			case 'yearlyTotalMax':
				$result = $dbr->selectField( 'public_reporting',
					array( 'sum(converted_amount) as sum' ),
					$conditions,
					__METHOD__
				);
				break;
			case 'contributionsMax':
				$result = $dbr->selectField( 'public_reporting',
					array( 'count(converted_amount) as sum' ),
					$conditions,
					__METHOD__,
					array(
						'ORDER BY' => 'sum DESC',
						'GROUP BY' => "FROM_UNIXTIME(received, '%Y-%m-%d')",
					)
				);
				break;
			case 'averagesMax':
				$result = $dbr->selectField( 'public_reporting',
					array( 'avg(converted_amount) as sum' ),
					$conditions,
					__METHOD__,
					array(
						'ORDER BY' => 'sum DESC',
						'GROUP BY' => "FROM_UNIXTIME(received, '%Y-%m-%d')",
					)
				);
				break;
			case 'maximumsMax':
				$result = $dbr->selectField( 'public_reporting',
					array( 'max(converted_amount) as sum' ),
					$conditions,
					__METHOD__,
					array(
						'ORDER BY' => 'sum DESC',
						'GROUP BY' => "FROM_UNIXTIME(received, '%Y-%m-%d')",
					)
				);
				break;
		}
		if ( isset( $result ) ) {
			// Cache invalidates once per minute
			$wgMemc->set( $key, $result, 60 );
			return $result;
		}
		return null;
	}
}
