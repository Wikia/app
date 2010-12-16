<?php
/**
 * Special:ClickTracking
 *
 * @file
 * @ingroup Extensions
 */

class SpecialClickTracking extends SpecialPage {
	
	private static $minimum_date = '20091009'; // YYYYMMDD (+1 for today)

	private static $userTypes = array( "basic" => 0, "intermediate" => 1, "expert" => 2 );
	private $user_defs = array();
	
	
	function __construct() {
		parent::__construct( 'ClickTracking' , 'clicktrack' );
		wfLoadExtensionMessages( 'ClickTracking' );
		UsabilityInitiativeHooks::initialize();
		UsabilityInitiativeHooks::addStyle( 'ClickTracking/SpecialClickTracking.css' );
		UsabilityInitiativeHooks::addScript( 'ClickTracking/SpecialClickTracking.js' );
	}
	
	
	function setDefaults() {
		$this->user_defs["basic"] = array(
			"anonymous" => "1",
			"total_contribs" => array(
				array( "operation" => "<=", "value" => "10" ),
			),
		);
		
		$this->user_defs["intermediate"] = array(
			"anonymous" => "0",
			"total_contribs" => array(
				array( "operation" => "<", "value" => "400" ),
				array( "operation" => ">", "value" => "10" ),
			),
		);
		
		$this->user_defs["expert"] = array(
			"anonymous" => "0",
			"total_contribs" => array(
				array( "operation" => ">=", "value" => "400" ),
			),
		);
		
		
	}
	
	
	
	function execute( $par ) {
		global $wgOut, $wgUser;
		
		// Check permissions
		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}
		
		
		$this->setHeaders();
		$this->setDefaults();
		
		$wgOut->addScript( '<script type="text/javascript">' . "var wgClickTrackUserDefs = " . json_encode( $this->user_defs ) .  '</script>' );
		
		$wgOut->setPageTitle( wfMsg( 'ct-title' ) );
		
		$outputTable = "";
		
		
		// grab top N
		$events = $this->getTopEvents();
		
		// open table
		$outputTable .= Xml::openElement( "table", array( "class" => "sortable click-data", "id" => "clicktrack_data_table" )  );
		
		// create a row for every event
		$i = 0;
		$db_result;
		
		// build row headers
		$header_row = array();
		
		$header_row["event_header"] = wfMsg( 'ct-event-name' );
		$header_row["expert_header"] = wfMsg( 'ct-expert-header' );
		$header_row["intermediate_header"] = wfMsg( 'ct-intermediate-header' );
		$header_row["basic_header"] = wfMsg( 'ct-beginner-header' );
		$header_row["total_header"] = wfMsg( 'ct-total-header' );
		$outputTable .= Xml::buildTableRow( array( "class" => "table_headers" ), $header_row );
		
		// foreach event, build a row
		while ( ( $db_result = $events->fetchRow() ) != null ) {
			++$i;
			$outputTable .= $this->buildRow( $db_result, $i, $this->user_defs );
		}
		
		
		// close table
		$outputTable .= Xml::closeElement( "table" );
		
		$wgOut->addHTML( $outputTable );

		$wgOut->addHTML( $this->buildDateRange() );
		
		// build chart
		$wgOut->addHTML( $this->buildChart( "advanced.hide", 10, "20090815", "20090902", 1 ) );
		
		// $wgOut->addHTML($this->buildControlBox());

		$wgOut->addHTML( $this->buildChartDialog() );
		$wgOut->addHTML( $this->buildUserDefBlankDialog() );
		
	}
	

	/**
	 * Gets the data to build a chart for PHP or JS purposes
	 * @param $event_id  event id this chart is for
	 * @param $minTime minimum day
	 * @param $maxTime maximum day
	 * @param $increment number of day(s) to increment in units
	 * @param $userDefs  user defintions
	 * @param $isUserDefsJSON true if userDefs is JSON
	 * @return array with chart info
	 */
	static function getChartData( $event_id, $minTime, $maxTime, $increment, $userDefs, $isUserDefsJSON = true ) {
		// get data	
		date_default_timezone_set( 'UTC' );
		
		if ( $maxTime == 0 ) {
			$maxTime = gmdate( "Ymd", time() );  // today
		}
		if ( $minTime == 0 ) {
			$minTime = self::$minimum_date;
		}
		
		
		// FIXME: On PHP 5.3+, this will be MUCH cleaner
		$currBeginDate = new DateTime( $minTime );
		$currEndDate = new DateTime( $minTime );
		$endDate = new DateTime( $maxTime );
		
		
		// get user definitions
		if ( $isUserDefsJSON ) {
			$userDefs = json_decode( $userDefs, true );
		}
				
		$basicUserData = array();
		$intermediateUserData = array();
		$expertUserData = array();
		
		// PHP 5.3...hurry!
		$plural = ( $increment == 1 ? "" : "s" );
		
		while ( $currEndDate->format( "U" )  < $endDate->format( "U" )  ) {
			$currEndDate->modify( "+$increment day$plural" );
			
			$minDate = $currBeginDate->format( "Ymd" );
			$maxDate = $currEndDate->format( "Ymd" );
			
			$basicUserData[] = self::getTableValue( $event_id, $userDefs['basic'], $minDate, $maxDate );
			$intermediateUserData[] = self::getTableValue( $event_id, $userDefs['intermediate'], $minDate, $maxDate );
			$expertUserData[] = self::getTableValue( $event_id, $userDefs['expert'], $minDate, $maxDate );
			$currBeginDate->modify( "+$increment day$plural" );
		}
		return array( "expert" => $expertUserData, "basic" => $basicUserData, "intermediate" => $intermediateUserData );
	}

	function buildChart( $event_name, $event_id, $minTime, $maxTime, $increment ) {
		$chartData = self::getChartData( $event_id, $minTime, $maxTime, $increment, $this->user_defs, false );
		$chartSrc = $this->getGoogleChartParams( $event_id, $event_name, $minTime, $maxTime, $chartData["basic"], $chartData["intermediate"], $chartData["expert"] );
		return Xml::element( 'img', array( 'src' => $chartSrc , 'id' => 'chart_img' ) );
	}
	
	
	function getGoogleChartParams( $event_id, $event_name, $minDate, $maxDate, $basicUserData, $intermediateUserData, $expertUserData ) {
		$max = max( max( $basicUserData ), max( $intermediateUserData ), max( $expertUserData ) );
		return "http://chart.apis.google.com/chart?" . wfArrayToCGI(
		array(
			'chs' => '400x400',
			'cht' => 'lc',
			'chco' => 'FF0000,0000FF,00FF00',
			'chtt' => "$event_name from $minDate to $maxDate",
			'chdl' => 'Expert|Intermediate|Beginner',
			'chxt' => 'x,y',
			'chd' => 't:' . implode( "," , $expertUserData ) . "|" .
						implode( "," , $intermediateUserData ) . "|" . implode( "," , $basicUserData ),
			'chds' => "0,$max,0,$max,0,$max"
			) );
	}
	
	
	function buildUserDefBlankDialog() {
		$control = "";
		$control .= Xml::openElement( "div", array( "id" => "user_def_dialog", "class" => "dialog" ) );
		
		// currently editing...----|
		$control .= Xml::openElement( "form", array( "id" => "user_definition_form", "class" => "user_def_form" ) );
		$control .= Xml::openElement( "fieldset", array( "id" => "user_def_alter_fieldset" ) );
		$control .= Xml::openElement( "legend", array( "id" => "user_def_alter_legend" ) );
		$control .= wfMsg( "ct-editing" );
		$control .= Xml::closeElement( "legend" );
		
		// [] anonymous users?
		$control .= Xml::openElement( "div", array( "id" => "anon_users_div", "class" => "checkbox_div control_div" ) );
		$control .= Xml::openElement( "input", array( "type" => "checkbox", "id" => "anon_users_checkbox", "class" => "user_def_checkbox" ) );
		$control .= Xml::closeElement( "input" );
		$control .= wfMsg( "ct-anon-users" );
		$control .= Xml::closeElement( "div" );
		
		// ----------------
		$control .= Xml::openElement( "hr" );
		$control .= Xml::closeElement( "hr" );
		$control .= Xml::openElement( "div", array( "id" => "contrib_opts_container" ) );
		
		// [] users with contributions [>=V] [n    ]
		$control .= Xml::openElement( "div", array( "id" => "total_users_contrib_div", "class" => "checkbox_div control_div" ) );
		$control .= Xml::openElement( "input", array( "type" => "checkbox", "id" => "contrib_checkbox", "class" => "user_def_checkbox" ) );
		$control .= Xml::closeElement( "input" );
		$control .= wfMsg( "ct-user-contribs" );
		
		
		$control .= Xml::closeElement( "div" );
		
		// [] contributions in timespan 1
		$control .= Xml::openElement( "div", array( "id" => "contrib_span_1_div", "class" => "checkbox_div control_div" ) );
		
		$control .= Xml::openElement( "div", array( "id" => "contrib_span_1_text_div", "class" => "checkbox_div" ) );
		$control .= Xml::openElement( "input", array( "type" => "checkbox", "id" => "contrib_span_1_checkbox", "class" => "user_def_checkbox" ) );
		$control .= Xml::closeElement( "input" );
		$control .= wfMsg( "ct-user-span" ) . " 1";
		$control .= Xml::closeElement( "div" );
		$control .= Xml::closeElement( "div" );
		
		// [] contributions in timespan 2
		$control .= Xml::openElement( "div", array( "id" => "contrib_span_2_div", "class" => "checkbox_div control_div" ) );
		
		$control .= Xml::openElement( "div", array( "id" => "contrib_span_2_text_div", "class" => "checkbox_div" ) );
		$control .= Xml::openElement( "input", array( "type" => "checkbox", "id" => "contrib_span_2_checkbox", "class" => "user_def_checkbox" ) );
		$control .= Xml::closeElement( "input" );
		$control .= wfMsg( "ct-user-span" ) . " 2";
		$control .= Xml::closeElement( "div" );
		$control .= Xml::closeElement( "div" );
		
		// [] contributions in timespan 3
		$control .= Xml::openElement( "div", array( "id" => "contrib_span_3_div", "class" => "checkbox_div control_div" ) );
		
		$control .= Xml::openElement( "div", array( "id" => "contrib_span_3_text_div", "class" => "checkbox_div" ) );
		$control .= Xml::openElement( "input", array( "type" => "checkbox", "id" => "contrib_span_3_checkbox", "class" => "user_def_checkbox" ) );
		$control .= Xml::closeElement( "input" );
		$control .= wfMsg( "ct-user-span" ) . " 3";
		$control .= Xml::closeElement( "div" );
		$control .= Xml::closeElement( "div" );
		
		
		
		
		$control .= Xml::closeElement( "div" );// close contrib opts

		$control .= Xml::closeElement( "fieldset" );
		$control .= Xml::closeElement( "form" );
		$control .= Xml::closeElement( "div" );
		return $control;
	}
	
	
	
	function buildUserDefNumberSelect( $include_checkbox, $include_and, $ids ) {
		$control = "";
		if ( $include_checkbox ) {
			$control .= Xml::openElement( "input", array( "type" => "checkbox", "id" => "{$ids}_checkbox", "class" => "number_select_checkbox" ) );
			$control .= Xml::closeElement( "input" );
		}
		
		if ( $include_and ) {
			$control .= wfMsg( "ct-and" );
		}
		
		$control .= Xml::openElement( "select", array( "id" => "{$ids}_ltgt", "class" => "number_select_ltgt" ) );
		$control .= Xml::openElement( "option", array( "id" => "{$ids}_lt", "class" => "number_select_ltgt_opt", "value" => "lt" ) );
		$control .= "&lt;=";
		$control .= Xml::closeElement( "option" );
		$control .= Xml::openElement( "option", array( "id" => "{$ids}_gt", "class" => "number_select_ltgt_opt", "value" => "gt" ) );
		$control .= "&gt;=";
		$control .= Xml::closeElement( "option" );
		$control .= Xml::closeElement( "select" );
		$control .= Xml::openElement( "input", array( "type" => "text", "id" => "{$ids}_text", "class" => "number_select_text" ) );
		$control .= Xml::closeElement( "input" );
		return $control;
	}
	
	
	function buildChartDialog() {
		$control = "";
		$control .= Xml::openElement( "div", array( "id" => "chart_dialog", "class" => "dialog" ) );
		
		$control .= Xml::openElement( "form", array( "id" => "chart_dialog_form", "class" => "chart_form" ) );
		$control .= Xml::openElement( "fieldset", array( "id" => "chart_dialog_alter_fieldset" ) );
		$control .= Xml::openElement( "legend", array( "id" => "chart_dialog_alter_legend" ) );
		$control .= wfMsg( "ct-increment-by" );
		$control .= Xml::closeElement( "legend" );
		
		$control .= Xml::openElement( "table", array( "id" => "chart_dialog_increment_table" ) );
		$control .= Xml::openElement( "tbody", array( "id" => "chart_dialog_increment_tbody" ) );
		
		$control .= Xml::openElement( "tr", array( "id" => "chart_dialog_increment_row" ) );
		
		$control .= Xml::openElement( "td", array( "id" => "chart_dialog_increment_cell" ) );
		$control .= Xml::openElement( "input", array( "type" => "text", "id" => "chart_increment", "class" => "chart_dialog_area", "value" => '1' ) );
		$control .= Xml::closeElement( "input" );
		$control .= Xml::closeElement( "td" );
		
		$control .= Xml::openElement( "td", array( "id" => "chart_dialog_button_cell" ) );
		$control .= Xml::openElement( "input", array( "type" => "button", "id" => "change_graph", "value" => wfMsg( "ct-change-graph" ) )  );
		$control .= Xml::closeElement( "input" );
		$control .= Xml::closeElement( "td" );
		
		$control .= Xml::closeElement( "tr" );
		
		$control .= Xml::closeElement( "tbody" );
		$control .= Xml::closeElement( "table" );
		$control .= Xml::closeElement( "fieldset" );
		$control .= Xml::closeElement( "form" );
		$control .= Xml::closeElement( "div" );
		return $control;
	}
	
	
	function buildDateRange() {
		$control = Xml::openElement( "form", array( "id" => "date_range" ) );
		
		$control .= Xml::openElement( "fieldset", array( "id" => "date_range_fieldset" ) );
		$control .= Xml::openElement( "legend", array( "id" => "date_range_legend" ) );
		$control .= wfMsg( 'ct-date-range' );
		$control .= Xml::closeElement( "legend" );
		

		
		$control .= Xml::openElement( "table", array( "id" => "date_range_table" ) );
		$control .= Xml::openElement( "tbody", array( "id" => "date_range_tbody" ) );
		
		
		$control .= Xml::openElement( "tr", array( "id" => "start_date_row" ) );
		
		$control .= Xml::openElement( "td", array( "id" => "start_date_label", "class" => "date_range_label" ) );
		$control .= Xml::openElement( "input", array( "type" => "checkbox", "id" => "start_date_checkbox", "class" => "date_range_checkbox", "checked" => "" ) );
		$control .= Xml::closeElement( "input" );
		$control .= wfMsg( "ct-start-date" );
		$control .= Xml::closeElement( "td" );
		
		$control .= Xml::openElement( "td", array( "id" => "start_date_textarea" ) );
		$control .= Xml::openElement( "input", array( "type" => "text", "id" => "start_date", "class" => "date_range_input" ) );
		$control .= Xml::closeElement( "input" );
		$control .= Xml::closeElement( "td" );
		
		$control .= Xml::closeElement( "tr" );
		
		$control .= Xml::openElement( "tr", array( "id" => "end_date_row" ) );
		
		$control .= Xml::openElement( "td", array( "id" => "end_date_label", "class" => "date_range_label" ) );
		$control .= Xml::openElement( "input", array( "type" => "checkbox", "id" => "end_date_checkbox", "class" => "date_range_checkbox", "checked" => "" ) );
		$control .= Xml::closeElement( "input" );
		$control .= wfMsg( "ct-end-date" );
		$control .= Xml::closeElement( "td" );
		
		$control .= Xml::openElement( "td", array( "id" => "end_date_textarea" ) );
		$control .= Xml::openElement( "input", array( "type" => "text", "id" => "end_date", "class" => "date_range_input" ) );
		$control .= Xml::closeElement( "input" );
		$control .= Xml::closeElement( "td" );
		
		$control .= Xml::closeElement( "tr" );
		

		$control .= Xml::openElement( "tr", array( "id" => "update_row" ) );
		
		$control .= Xml::openElement( "td" );
		$control .= Xml::closeElement( "td" );
		
		$control .= Xml::openElement( "td", array( "id" => "update_table_button_td" ) );
		$control .= Xml::openElement( "input", array( "type" => "button", "id" => "update_table_button", "class" => "update_button", "value" => wfMsg( "ct-update-table" ) ) );
		$control .= Xml::closeElement( "input" );
		$control .= Xml::closeElement( "td" );
		
		$control .= Xml::closeElement( "tr" );
		
		$control .= Xml::closeElement( "tbody" );
		$control .= Xml::closeElement( "table" );
		$control .= Xml::closeElement( "fieldset" );
		
		$control .= Xml::closeElement( "form" );
		
		return $control;
	}
	
	
	/**
	 * 
	 * @param $minTime
	 * @param $maxTime
	 * @param $userDefs
	 * @param $is_JSON
	 * @return unknown_type
	 */
	public static function buildRowArray( $minTime, $maxTime, $userDefs, $is_JSON = true ) {
		
		
		if ( $minTime == 0 ) {
			$minTime = self::$minimum_date;
		}
		if ( $maxTime == 0 ) {
			$maxTime = gmdate( "Ymd", time() );  // today
		}
		
		if ( $is_JSON ) {
			$userDefs = json_decode( $userDefs, true );
		}
		
		$events = self::getTopEvents( $minTime, $maxTime );
		
		$returnArray = array();
		
		while ( ( $data_result = $events->fetchRow() ) != null ) {
			$outputArray = array();
			$outputArray['event_name'] = $data_result['event_name'];
			$outputArray['event_id'] = $data_result['event_id'];
			$outputArray['expert'] = self::getTableValue( $data_result['event_id'], $userDefs["expert"] );
			$outputArray['intermediate'] = self::getTableValue( $data_result['event_id'], $userDefs["intermediate"] );
			$outputArray['basic'] = self::getTableValue( $data_result['event_id'], $userDefs["basic"] );
			$outputArray['total'] = $data_result["totalevtid"];
			$returnArray[] = $outputArray;
		}
		
		return $returnArray;
				
	}
	
	function buildRow( $data_result, $row_count, $userDefs ) {
			
			$outputRow = Xml::openElement( "tr", array( "class" => "table_data_row" ) );
			
			// event name
			$outputRow .= Xml::openElement( "td",
									array( "class" => "event_name", "id" => "event_name_$row_count", "value" => $data_result['event_id'] ) );
			$outputRow .= $data_result['event_name'];
			$outputRow .= Xml::closeElement( "td" );
			
			// advanced users
			$cellValue = self::getTableValue( $data_result['event_id'], $userDefs["expert"] );
			$outputRow .= Xml::openElement( "td",
									array( "class" => "event_data expert_data", "id" => "event_expert_$row_count",
										"value" => $cellValue ) );
			$outputRow .= $cellValue;
			$outputRow .= Xml::closeElement( "td" );
			
			// intermediate users
			$cellValue = self::getTableValue( $data_result['event_id'], $userDefs["intermediate"] );
			$outputRow .= Xml::openElement( "td",
									array( "class" => "event_data intermediate_data", "id" => "event_intermediate_$row_count",
										"value" => $cellValue ) );
			$outputRow .= $cellValue;
			$outputRow .= Xml::closeElement( "td" );
			
			// basic users
			$cellValue = self::getTableValue( $data_result['event_id'], $userDefs["basic"] );
			$outputRow .= Xml::openElement( "td",
									array( "class" => "event_data basic_data", "id" => "event_basic_$row_count",
									"value" => $cellValue ) );
			$outputRow .= $cellValue;
			$outputRow .= Xml::closeElement( "td" );
			
			// totals
			$cellValue = $data_result["totalevtid"];
			$outputRow .= Xml::openElement( "td",
									array( "class" => "event_data total_data", "id" => "total_$row_count",
									"value" => $cellValue ) );
			$outputRow .= $cellValue;
			$outputRow .= Xml::closeElement( "td" );
			
			
			$outputRow .= Xml::closeElement( "tr" );
			
			return $outputRow;
			
	}

	/**
	 * Space out the dates for date validation
	 * @param $datewithnospaces date with no spaces
	 * @return date with spaces
	 */
	public static function space_out_date( $datewithnospaces ) {
		return ( substr( $datewithnospaces, 0, 4 ) . ' ' . substr( $datewithnospaces, 4, 2 ) . ' ' . substr( $datewithnospaces, 6, 2 ) );
	}
	
	
	/*
	 * get time constraints
	 * @param minTime minimum day (YYYYMMDD)
	 * @param maxTime max day (YYYYMMDD)
	 * NOTE: once some of the constraints have been finalized, this will use more of the Database functions and not raw SQL
	 */
	static function getTimeConstraints( $minTime, $maxTime ) {
		if ( $minTime == 0 || $maxTime == 0 ||
		 	( strptime( SpecialClickTracking::space_out_date( $minTime ), "%Y %m %d" ) === false ) ||
		 	( strptime( SpecialClickTracking::space_out_date( $minTime ), "%Y %m %d" ) === false ) ) {
		 		return array();
		 	}
		else {
			// the dates are stored in the DB as MW_TIMESTAMP formats, add the zeroes to fix that 
			$minTime .= "000000";
			$maxTime .= "000000";

			$dbr = wfGetDB( DB_SLAVE );
			
			// time constraint array
			return array(
				"`action_time` >= " . $dbr->addQuotes( $minTime ) ,
				"`action_time` <= " . $dbr->addQuotes( $maxTime )
			);
			
		}
		
	}
	
	
	/**
	 * Gets the top N events as set in the page pref
	 * @param $time_constraint_statement
	 * @return unknown_type
	 * NOTE: once some of the constraints have been finalized, this will use more of the Database functions and not raw SQL
	 */
	public static function getTopEvents( $minTime = "", $maxTime = "", $normalize_top_results = false ) {
		
		$time_constraint_statement = self::getTimeConstraints( $minTime, $maxTime );
		$time_constraint = $time_constraint_statement;
		
		$dbr = wfGetDB( DB_SLAVE );
		
		// NOTE: This query is a performance nightmare
		// Permission to run it is restricted by default
		$dbresult = $dbr->select(
			array( 'click_tracking', 'click_tracking_events' ),
			array( 'count(event_id) as totalevtid', 'event_id', 'event_name' ),
			$time_constraint,
			__METHOD__,
			array( 'GROUP BY' => 'event_id', 'ORDER BY' => 'totalevtid DESC' ),
			array( 'click_tracking_events' =>
				array( 'LEFT JOIN', 'event_id=id' )
			)
		);
		
		/*		
		$sql = "select count(event_id) as totalevtid, event_id,event_name from click_tracking" .
		 " LEFT JOIN click_tracking_events ON event_id=click_tracking_events.id".
		 " $time_constraint  group by event_id order by totalevtid desc";
		*/
        
		// returns count(event_id),event_id, event_name, top one first
		return $dbresult;
	}

	/**
	 * Gets a table value for a given User ID
	 * NOTE: once some of the constraints have been finalized, this will use more of the Database functions and not raw SQL
	 */
	static function getTableValue( $event_id, $userDef, $minTime = '', $maxTime = '', $normalize_results = false ) {
		
		$dbr = wfGetDB( DB_SLAVE );
		$conds = array_merge(
			self::getTimeConstraints( $minTime, $maxTime ),
			SpecialClickTracking::buildUserDefConstraints( $userDef ),
			array( 'event_id' => $event_id )
		);
		return wfGetDB( DB_SLAVE )->selectField(
			'click_tracking', 'count(*)', $conds, __METHOD__ );
		
	}
	
	/**
	 * Generates a query for a user type definition
	 * @param $include_anon_users boolean, include anon users or not
	 * @param $total_contribs array, nonempty if total contribs to be included
	 * @param $contrib_1 array, nonempty AND conditions for user_contribs_1
	 * @param $contrib_2 array, nonempty AND conditions for user_contribs_1
	 * @param $contrib_3 array, nonempty AND conditions for user_contribs_1
	 * @return unknown_type query
	 */
	public static function buildUserDefConstraints( $def ) {
		
		$dbr = wfGetDB( DB_SLAVE );
		
		$include_anon_users = ( empty( $def['anonymous'] ) ? array():$def['anonymous'] );
		$total_contribs = ( empty( $def['total_contribs'] ) ? array():$def['total_contribs'] );
		$contrib_1 = ( empty( $def['contrib_1'] ) ? array():$def['contrib_1'] );
		$contrib_2 = ( empty( $def['contrib_2'] ) ? array():$def['contrib_2'] );
		$contrib_3 = ( empty( $def['contrib_3'] ) ? array():$def['contrib_3'] );
		
		$or_conds = array();
		$and_conds = array();
		$sql = "";
		
			
		if ( (boolean)$include_anon_users ) {
			$or_conds[] = array( "field" => "is_logged_in", "operation" => "=", "value" => "0" );
		}
		
		if ( !empty( $total_contribs ) ) {
			foreach ( $total_contribs as $contribs ) {
				$and_conds[] = array( "field" => "user_total_contribs", "operation" => SpecialClickTracking::validate_oper( $contribs["operation"] ), "value" => intval( $contribs["value"] ) );
			}
		}
		
		if ( !empty( $contrib_1 ) ) {
			foreach ( $contrib_1 as $contribs ) {
				$and_conds[] = array( "field" => "user_contribs_span1", "operation" => SpecialClickTracking::validate_oper( $contribs["operation"] ), "value" => intval( $contribs["value"] ) );
			}
		}
		if ( !empty( $contrib_2 ) ) {
			foreach ( $contrib_2 as $contribs ) {
				$and_conds[] = array( "field" => "user_contribs_span2", "operation" => SpecialClickTracking::validate_oper( $contribs["operation"] ), "value" => intval( $contribs["value"] ) );
			}
		}
		if ( !empty( $contrib_3 ) ) {
			foreach ( $contrib_3 as $contribs ) {
				$and_conds[] = array( "field" => "user_contribs_span3", "operation" => SpecialClickTracking::validate_oper( $contribs["operation"] ), "value" => intval( $contribs["value"] ) );
			}
		}
		
		foreach ( $and_conds as $cond ) {
			if ( !empty( $sql ) ) {
				$sql .= " AND ";
			}
			$sql .= $cond["field"] . " " . $cond["operation"] . " " . $dbr->addQuotes( $cond["value"] );
		}
		foreach ( $or_conds as $cond ) {
			if ( !empty( $sql ) ) {
				$sql .= " OR ";
			}
			$sql .= $cond["field"] . " " . $cond["operation"] . " " . $dbr->addQuotes( $cond["value"] );
		}
		
		return array( $sql );
	}
	
	public static function validate_oper( $operation ) {
		$o_trim = trim( $operation );
		switch( $o_trim ) { // valid operations
			case ">":
			case "<":
			case "<=":
			case ">=":
			case "=":
				return $o_trim;
			default:
				return "=";
		}
	}
	
	
}