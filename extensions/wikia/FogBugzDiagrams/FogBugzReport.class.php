<?php
/**
 * Class which allows to get informations about FogBugz statistics.
 * @author Pawe� Rych�y
 * @author Piotr Paw�owski ( Pepe )
 */

define( "table_name", "fogbugz_cases" );
define( 'date_start', '2012-01-07' );


class FogBugzReport {

	private $app = null;
	private $db = null;
	private $since = null;
	private $until = null;

	public function __construct() {
		$this->app = F::app();
		$this->since = new DateTime( date_start );
		$this->until = new DateTime();
		$this->db = $this->app->wf->GetDB( DB_SLAVE );
	}

	/**
	 * Sets the value of since
	 * @param string $time
	 */
	private function setSinceTime( $time = date_start ) {
		$this->since = new DateTime( $time );
	}

	/**
	 * Query which return information about Month and Year or day of mont for a given week and day of week
	 * @param string $week date in format 'YW'
	 * @param string $day
	 * @param string $d if is not equal 'month' function return day of month
	 * @return array
	 */
	function getMonthQuery( $week, $day = "Monday", $d = 'month' ) {
		if ( $d == 'month'){
			$format = '%M %Y';
		} else {
			$d = 'day_of_month';
			$format = '%d';
		}

		return $this->db->fetchRow(
			$this->db->select(
				array( table_name ),
				array( "date_format( str_to_date( '" . $week . " " . $day . "', '%X%V %W' ),'" . $format . "' ) as '" . $d . "'" ),
				array(),
				__METHOD__
			)
		);
	}

	/**
	 * @param $priority int value 1..7
	 * @param $week string date in YW format
	 * @return array( (priority-1) => (int) accumulated count )
	 */
	private function getCountOfAccumulatedCases( $priority, $week ) {

		return $this->db->fetchRow(
			$this->db->select(
				array( table_name . " as c" ),
				array( "count('ixBug' ) as '" . ( $priority-1 ) . "'" ),
				array(
					'ixProject' => 13,
					"yearweek( c.dtOpened ) <= '" . $week . "'",
				    "( c.dtResolved is null or yearweek( c.dtResolved ) > '" . $week . "' or sStatus = 'Active' ) and c.ixPriority = " . $priority ),
				__METHOD__
			)
		);
	}

	/**
	 * @param $priority int value 1..7
	 * @param $week string date in YW format
	 * @return array( (priority-1) => (int) count ) count of cases created in $week week.
	 */
	private function getCountOfCreatedCases() {

		return
			$this->db->select(
				array( table_name  ),
				array( 'OpenedYW as date', "count( 'ixBug' ) as 'opened_count'", 'ixPriority as priority' ),
				array( 'ixProject' => 13 ),
				__METHOD__,
				array( 'GROUP BY' => 'OpenedYW, ixPriority' )
			);
	}

	/**
	 * Gets average bugs Age
	 * @return array(
	 * 		week_1 	=>	array(
	 * 						'open_avg'] => value
	 *						'resolved_avg' => value
	 *						'all_avg' => value
	 * 		...
	 * 		week_n	=>	array( ... )
	 * )
	 */
	public function bugsAge() {

		$data_temp = array();
		do {
			$week = $this->since->format( 'YW' );

			$res[1] = $this->db->select(
				array( table_name . " as c" ),
				array( "count( 'ixBug' ) as open_count" ),
				array( "( ixProject = 13 )",
					"yearweek(c.dtOpened) <= " . $week,
					"( c.dtResolved is null or yearweek(c.dtResolved) > '" . $week . "' )" ),
				__METHOD__
			);

			$res[2] = $this->db->select(
				array( table_name." as c" ),
				array( "count( 'ixBug' ) as resolved_count" ),
				array( "( ixProject = 13 )", "yearweek( c.dtResolved ) = " . $week ),
				__METHOD__
			);

			$res[3] = $this->db->select(
				array( table_name." as c" ),
				array( "sum( datediff( now(), c.dtOpened ) ) as opened_sum" ),
				array( "( ixProject = 13 )","( yearweek( c.dtOpened ) <= '". $week . "' )",
						"( c.dtResolved is null ) or ( yearweek( c.dtResolved ) > '" . $week . "' )" ),
				__METHOD__
			);

			$res[4] = $this->db->select(
				array( table_name." as c" ),
				array( "sum( datediff( c.dtResolved, c.dtOpened ) ) as resolved_sum" ),
				array( "( ixProject = 13)","( yearweek( c.dtResolved ) = '" . $week . "')" ),
				__METHOD__
			);

			$result = array_merge(
				$this->getMonthQuery( $week, "Monday", 'day_of_month'),
				$this->getMonthQuery( $week ),
				$this->db->fetchRow( $res[1] ),
				$this->db->fetchRow( $res[2] ),
				$this->db->fetchRow( $res[3] ),
				$this->db->fetchRow( $res[4] )
			);

			$data_temp[$week] = $result;

			$this->since->modify( '+1 week' ); //week later

		} while ( $this->since < $this->until );

		$report = $data_temp;

		foreach ( $report as $week => $data ) {
			$count = $data['open_count'] + $data['resolved_count'];
			$avg = 0;
			if ( $count ) {
				$avg = ( $data['opened_sum'] + $data['resolved_sum'] ) / $count;
			}

			$report[$week]['open_avg'] = $data['open_count'] == 0 ? 0 : $data['opened_sum'] / $data['open_count'];
			$report[$week]['resolved_avg'] = $data['resolved_count'] == 0 ? 0 : $data['resolved_sum'] / $data['resolved_count'];
			$report[$week]['all_avg'] = $avg;
		}

		$this->setSinceTime();
		return $report;
	}

	/**
	 * Get counts of accumulated cases
	 * @return array(
	 * 		week_1 	=>	array(
	 * 						0 => count of cases with priority 1 created before week_1
	 * 						1 => count of cases with priority 2 created before week_1
	 * 						2 => count of cases with priority 3 created before week_1
	 * 						...
	 * 						6 => count of cases with priority 7 created before week_1
	 * 						'month' => (string) Month Year
	 * 						'day_of_month => (string) day
	 * 		...
	 * 		week_n	=>	array( ... )
	 * )
	 */
	public function getAccumulatedSumsByPriority() {

	    $report = array();
		do {
			$week = $this->since->format( 'YW' );

			for ( $i = 0; $i < 7; $i++ ){
				$res[$i] = $this->getCountOfAccumulatedCases( ( $i+1 ), $week );
			}

			$result = $res[0] + $res[1] + $res[2] + $res[3] +
				$res[4] + $res[5] + $res[6] + $this->getMonthQuery( $week ) +
				$this->getMonthQuery( $week, "Monday", 'day_of_month' );

			$report[$week] = $result;
			$this->since->modify( '+1 week' );
		} while ( $this->since < $this->until );

	    $this->setSinceTime();
	    return $report;
	}

	/**
	 * Get counts of accumulated cases
	 * @return array(
	 * 		week_1 	=>	array(
	 * 						'difference' => difference between resolved and opened cases ( during week_1)
	 * 						'month' => (string) Month Year
	 * 						'day_of_month => (string) day
	 * 		...
	 *
	 * 		week_n	=>	array( ... )
	 * )
	 */
	public function getResolvedAndCreateDiff() {

	   	$report = array();
			$res[1] =  $this->db->select(
				array( table_name . " as c" ),
				array( "ResolvedYW as date, count( 'ixBug' ) as resolved_count" ),
				array( 'ixProject' => 13 ),
				__METHOD__,
				array('GROUP BY' => 'ResolvedYW' )
			);

			$res[0] =  $this->db->select(
				array(  table_name." as c" ),
				array( "OpenedYW as date, count('ixBug') as open_count" ),
				array( 'ixProject' => 13),
				__METHOD__,
				array( 'GROUP BY' => 'OpenedYW' )
			);

			while( $row = $this->db->fetchRow( $res[1]) ) {
	          	$d1[$row['date']] = $row;
			}

			while( $row = $this->db->fetchRow( $res[0]) ) {
	            $d2[$row['date']] = $row;
            }

            do {
               	$i = $this->since->format( 'YW' );
            	if ( empty( $d1[$i] ) ){
					$d1[$i] = 0;
				}
				$this->since->modify( '+1 week' );
            } while ($this->since < $this->until );

            $this->setSinceTime();
            $start = $this->since->format( 'YW' );
            $diff = array();
            $day = array();
            $month = array();

            foreach ( $d1 as $week => &$data ) {
            	if (empty($d2[$week])){
            		$d2[$week] = 0;
            	}

            	if ( $week < $start ) {
            		$d1[$week] = null;
            		$d2[$week] = null;
            	} else {
            		$result[$week] = array(
            			'difference' => $data['resolved_count'] - $d2[$week]['open_count'],
            			'day' =>  $this->getMonthQuery( $week, "Monday", 'day_of_month' ),
            			'month' =>  $this->getMonthQuery( $week )
            		);
            	}
            }
			$report = $result;
			return $report;
	}

	/**
	 * Gets count of created cases for each week
	 * @return array(
	 * 		week_1 	=>	array(
	 * 						0 => count of cases with priority 1 created in week_1
	 * 						1 => count of cases with priority 2 created in week_1
	 * 						2 => count of cases with priority 3 created in week_1
	 * 						...
	 * 						6 => count of cases with priority 7 created in week_1
	 * 						'month' => (string) Month Year
	 * 						'day_of_month => (string) day
	 * 		...
	 * 		week_n	=>	array( ... )
	 * )
	 */
	public function getCreatedSumsByPriority() {
		$results = array();
		$res = $this->getCountOfCreatedCases();
		$buffer = array();
		for ( $i = 0; $i < $res->numRows(); $i++ ) {
			$buffer = $res->fetchRow();
			$results[] = array(
				'date' => $buffer['date'],
				'opened_count' => $buffer['opened_count'],
				'priority' => $buffer['priority']
			);
			$buffer = array();
		}


		$report = array();
		$counter = 0;

		do {
			$week = $this->since->format( 'YW' );
			$res = array();
			for ( $i = 0; $i < 7; $i++ ){
				$res[] = 0;
			}
			for ($i = 0; $i < count($results); $i++) {
				if ($week == $results[$i]['date']) {
					$res[$results[$i]['priority'] - 1] = $results[$i]['opened_count'];
				}
			}

			$report[$week] = $res + $this->getMonthQuery( $week ) + $this->getMonthQuery( $week, "Monday", 'day_of_month');

			if( $this->since->format( 'YW' ) == $this->until->format( 'YW' ) ) {
				$report[$week]['last'] = true;
			}

			$this->since->modify( '+1 week' );
		} while ( $this->since < $this->until );
	    $this->setSinceTime();
	    return $report;
	}

	/**
	* function copy last element from each subarrays of param
	* and push it to this subarrays
	* @param array(array())
	*/
	public function copy_last_element( &$table ){
		foreach( $table as &$data ) {
			$last_element = array_pop( $data );
			$last_copy = $last_element;
			array_push( $data, $last_element );
			$last_copy[0]++;
			$data[] = $last_copy;
		}
	}

	/**
	 * This function gets all necessary data from database
	 * @return data array
	 */
	public function getPreparedData() {

		// BUGS AGE - preparing data

		$opened = array();
		$resolved = array();
		$all = array();
		$xticks = array();
		$lastMonth = null;

		$report= new FogBugzReport();
		$bugsAge = $report->bugsAge();

		foreach ( $bugsAge as $week => $data ) {
			$opened[] = array( $week, $data["open_avg"] );
			$resolved[] = array( $week, $data["resolved_avg"] );
			$all[] = array( $week, $data["all_avg"] );
			$xDay[] =array( $week, $data['day_of_month'] );
			if ( $lastMonth != $data['month'] ){
				$lastMonth = $data['month'];
				if ( $lastMonth != "January 2011" ){

					$xticks[] = array( $week, $lastMonth );
				}
			}
		}

		$data_send[0] = array(
			"opened" => $opened,
			"resolved" => $resolved,
			"all" => $all,
			"xticks" => $xticks,
			"day_of_month" => $xDay
		);

		// ACCUMULATED SUMS BY PRIORITY - preparing data

		$p = array( array() );
    	$bugsAccumulatedSumsByPriority = $report->getAccumulatedSumsByPriority();

    	for ( $i = 0; $i < 7; $i++ ) {
    		foreach ( $bugsAccumulatedSumsByPriority as $week => $data ) {
    			$p[$i][] = array( $week, $data[$i] );
    		}
    	}

		for ( $i = 0; $i < 7; $i++ ) {
    		$data_send[1][] = $p[$i];
    	}

    	// CREATED BY PRIORITY AND CREATED P1, P2, P3 ( weekly ) - preparing data

    	$p = array( array() );
        $bugsCreatedSumsByPriority = $report->getCreatedSumsByPriority();

		for ( $i = 0; $i<7; $i++ ) {
			foreach ( $bugsCreatedSumsByPriority as $week => $data ) {
				$p[$i][] = array( $week, $data[$i] );
			}
		}

		for ( $i = 0; $i < 7; $i++ ){
    		$data_send[2][$i] = $p[$i];
    	}
    	// BUGS RESOLVED AND CREATED DIFF
		$bugsResolvedAndCreatedDiff = $report->getResolvedAndCreateDiff();
		$diff = array();
    	foreach ( $bugsResolvedAndCreatedDiff as $week => $data ) {
			$diff[] = array( $week,( int ) $data['difference'] );
		}
		$data_send[3] = array(
			"diff" => $diff,
			"xticks" => $xticks
		);

	  	for ( $i=0; $i < 2; $i++ ) {
			$this->copy_last_element( $data_send[$i] );
		}
		return $data_send;
	}
}
