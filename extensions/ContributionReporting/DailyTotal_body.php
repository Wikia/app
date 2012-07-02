<?php
/**
 * Special Page for Contribution statistics extension
 *
 * @file
 * @ingroup Extensions
 */

class SpecialDailyTotal extends UnlistedSpecialPage {

	protected $sharedMaxAge = 300; // Cache for 5 minutes on the server side
	protected $maxAge = 300; // Cache for 5 minutes on the client side

	public function __construct() {
		parent::__construct( 'DailyTotal' );
	}

	public function execute( $sub ) {
		global $wgRequest, $wgOut;
		
		$this->setHeaders();
		
		// Get request data
		$action = $wgRequest->getText( 'action' );
		$fudgeFactor = $wgRequest->getInt( 'adjustment' );
		$timezone = $wgRequest->getText( 'timezone', '0' );
		
		$zoneList = array (
			'-12' => array( 'name' => 'Kwajalein', 'offset' => '-12:00' ),
			'-11' => array( 'name' => 'Pacific/Midway', 'offset' => '-11:00' ),
			'-10' => array( 'name' => 'Pacific/Honolulu', 'offset' => '-10:00' ),
			'-9' => array( 'name' => 'America/Anchorage', 'offset' => '-09:00' ),
			'-8' => array( 'name' => 'America/Los_Angeles', 'offset' => '-08:00' ),
			'-7' => array( 'name' => 'America/Denver', 'offset' => '-07:00' ),
			'-6' => array( 'name' => 'America/Tegucigalpa', 'offset' => '-06:00' ),
			'-5' => array( 'name' => 'America/New_York', 'offset' => '-05:00' ),
			'-4.5' => array( 'name' => 'America/Caracas', 'offset' => '-04:30' ),
			'-4' => array( 'name' => 'America/Halifax', 'offset' => '-04:00' ),
			'-3.5' => array( 'name' => 'America/St_Johns', 'offset' => '-03:30' ),
			'-3' => array( 'name' => 'America/Sao_Paulo', 'offset' => '-03:00' ),
			'-2' => array( 'name' => 'Atlantic/South_Georgia', 'offset' => '-02:00' ),
			'-1' => array( 'name' => 'Atlantic/Azores', 'offset' => '-01:00' ),
			'0' => array( 'name' => 'UTC', 'offset' => '+00:00' ),
			'1' => array( 'name' => 'Europe/Belgrade', 'offset' => '+01:00' ),
			'2' => array( 'name' => 'Europe/Minsk', 'offset' => '+02:00' ),
			'3' => array( 'name' => 'Asia/Kuwait', 'offset' => '+03:00' ),
			'3.5' => array( 'name' => 'Asia/Tehran', 'offset' => '+03:30' ),
			'4' => array( 'name' => 'Asia/Muscat', 'offset' => '+04:00' ),
			'5' => array( 'name' => 'Asia/Yekaterinburg', 'offset' => '+05:00' ),
			'5.5' => array( 'name' => 'Asia/Kolkata', 'offset' => '+05:30' ),
			'5.75' => array( 'name' => 'Asia/Katmandu', 'offset' => '+05:45' ),
			'6' => array( 'name' => 'Asia/Dhaka', 'offset' => '+06:00' ),
			'6.5' => array( 'name' => 'Asia/Rangoon', 'offset' => '+06:30' ),
			'7' => array( 'name' => 'Asia/Krasnoyarsk', 'offset' => '+07:00' ),
			'8' => array( 'name' => 'Asia/Brunei', 'offset' => '+08:00' ),
			'9' => array( 'name' => 'Asia/Seoul', 'offset' => '+09:00' ),
			'9.5' => array( 'name' => 'Australia/Darwin', 'offset' => '+09:30' ),
			'10' => array( 'name' => 'Australia/Canberra', 'offset' => '+10:00' ),
			'11' => array( 'name' => 'Asia/Magadan', 'offset' => '+11:00' ),
			'12' => array( 'name' => 'Pacific/Fiji', 'offset' => '+12:00' ),
			'13' => array( 'name' => 'Pacific/Tongatapu', 'offset' => '+13:00' ),
		);
		
		// Translate timezone param to timezone name for PHP
		if ( array_key_exists( $timezone, $zoneList ) ) {
			$timeZoneName = $zoneList[$timezone]['name'];
		} else {
			$timeZoneName = 'UTC';
		}
		
		// Translate timezone param to timezone offset for MySQL
		if ( array_key_exists( $timezone, $zoneList ) ) {
			$timeZoneOffset = $zoneList[$timezone]['offset'];
		} else {
			$timeZoneOffset = '+00:00';
		}
		
		$setTimeZone = date_default_timezone_set( $timeZoneName );
		$today = date( 'Y-m-d' ); // Get the current date in the requested timezone
		$output = $this->getTodaysTotal( $timeZoneOffset, $today, $fudgeFactor );

		header( "Cache-Control: max-age=$this->maxAge,s-maxage=$this->sharedMaxAge" );
		if ( $action == 'raw' ) {
			$wgOut->disable();
			echo $output;
		} else {
			$wgOut->setRobotpolicy( 'noindex,nofollow' );
			$wgOut->addHTML( $output );
		}
	}

	/* Private Functions */

	/**
	 * Get the total amount of money raised for today
	 * @param string $timeZoneOffset The timezone to request the total for
	 * @param string $today The current date in the requested time zone, e.g. '2011-12-16'
	 * @param int $fudgeFactor How much to adjust the total by
	 * @return integer
	 */
	private function getTodaysTotal( $timeZoneOffset, $today, $fudgeFactor = 0 ) {
		global $wgMemc, $egFundraiserStatisticsMinimum, $egFundraiserStatisticsMaximum, $egFundraiserStatisticsCacheTimeout;

		// Delete this block once there is timezone support in the populating script
		$setTimeZone = date_default_timezone_set( 'UTC' );
		$today = date( 'Y-m-d' ); // Get the current date in UTC
		$timeZoneOffset = '+00:00';
		
		$key = wfMemcKey( 'fundraiserdailytotal', $timeZoneOffset, $today, $fudgeFactor );
		$cache = $wgMemc->get( $key );
		if ( $cache != false && $cache != -1 ) {
			return $cache;
		}
		
		// Use MediaWiki slave database
		$dbr = wfGetDB( DB_SLAVE );
		
		$result = $dbr->select(
			'public_reporting_days',
			'round( prd_total ) AS total',
			array( 'prd_date' => $today ),
			__METHOD__
		);
		$row = $dbr->fetchRow( $result );
		
		if ( $row['total'] > 0 ) {
			$total = $row['total'];
		} else {
			$total = 0;
		}
		
		// Make sure the fudge factor is a number
		if ( is_nan( $fudgeFactor ) ) {
			$fudgeFactor = 0;
		}

		// Add the fudge factor to the total
		$total += $fudgeFactor;
		
		$wgMemc->set( $key, $total, $egFundraiserStatisticsCacheTimeout );
		return $total;
	}
}
