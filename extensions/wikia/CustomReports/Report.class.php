<?php

class Report extends WikiaModel {
	
	protected $code = null;
	protected $days = null;
	protected $data = null;
	protected $day_list = array();
	
	protected static $colors = array(
		'#3399FF', '#330099', '#CC0000', '#00CC99', '#FF33CC',
		'#00CC00', '#FFFF00', '#FF6600', '#CC99CC', '#CCCC33',
		'#99FF33', '#99CCFF', '#9999FF', '#9933CC', '#66FF33',
		'#66FFCC', '#00FFFF', '#666666', '#663333', '#663300',
		'#660033', '#660000', '#6699FF', '#6633FF', '#669966',
		'#003300', '#006699', '#333366', '#009900', '#999966',
	);
	
	public function __construct($code, $days) {
		$this->code = $code;
		$this->days = $days;
		
		for ($i=($days*-1) ; $i<0 ; $i++) {
			$this->day_list[] = date( 'Y-m-d', strtotime("$i day") );
		}
		parent::__construct();
	}
	
	/*
	 * @desc get report data
	 * @return array of xml of each sub report
	 * @example data
	 * $data = array(
	 * 	'founderemails_clicks' => array(
	 * 		'founder A' => array(
	 * 			'2011-08-31' => 123,
	 * 			'2011-08-30' => 15,
	 * 		),
	 * 		'founder B' => array(
	 * 			'2011-08-31' => 1456,
	 * 			'2011-08-30' => 258,
	 * 		),
	 * 	),
	 * 	'founderemails_sent' => array(
	 * 		'founder A' => array(
	 * 			'2011-08-31' => 555,
	 * 			'2011-08-30' => 1542,
	 * 		),
	 *	),	
	 * );
	 */
	public function get_data() {
		wfProfileIn( __METHOD__ );
		
		// get data
		$curdate = date('Ymd');
		$memKey = wfSharedMemcKey('customreport', $this->code, $curdate, $this->days);
		$this->data = $this->wg->Memc->get($memKey);
		if ( !is_array($this->data) ) {
			$this->data = $this->{'get_'.$this->code}();
		
			$this->patch_zero();
			
			$this->wg->Memc->set($memKey, $this->data, 3600*24);
		}
		
		// convert array to xml
		$xml = array();
		foreach($this->data as $key => $value) {
			$xml[] = $this->convertDataToXML($key, $value);
		}
		
		wfProfileOut( __METHOD__ );
		
		return $xml;
	}

	protected function get_new_wikis() {
		wfProfileIn( __METHOD__ );
		
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$sql =<<<SQL
			select date_format(city_created, '%Y-%m-%d') day, if(city_public=1,'active wikis','deleted wikis') type, count(*) cnt 
			from city_list 
			where city_created > curdate()-interval $this->days day and city_created <= curdate()
			group by day, type;
SQL;

		$result = $db->query($sql);

		$data = array();
		while($row = $db->fetchRow($result)) {
			$data['new_wikis'][$row['type']][$row['day']] = $row['cnt'];
		}

		wfProfileOut( __METHOD__ );

		return $data;
	}
	
	protected function get_new_users() {
		wfProfileIn( __METHOD__ );
		
		$db = wfGetDB( DB_SLAVE, array(), $this->wg->ExternalSharedDB );

		// get total users and confirmed users
		$result = $db->select(
			array( 'user' ),
			array( "date_format(user_registration, '%Y-%m-%d') day", 'count(*) total_users', 
				"count(if(user_email_authenticated is not null and user_email_authenticated != '',1,null)) confirmed_users" ),
			array( "date(user_registration) > curdate()-interval $this->days day" ),
			__METHOD__,
			array('GROUP BY' => 'day')
		);

		$data = array();
		while ( $row = $db->fetchRow($result) ) {
			$data['total_users']['total_users'][$row['day']] = $row['total_users'];
			$data['confirmed_users']['confirmed_users'][$row['day']] = $row['confirmed_users'];
		}

		$db->freeResult( $result );

		// get temp users
		$result = $db->select(
			array( 'user_temp' ),
			array( "date_format(user_registration, '%Y-%m-%d') day", 'count(*) temp_users'  ),
			array( "date(user_registration) > curdate()-interval $this->days day" ),
			__METHOD__,
			array('GROUP BY' => 'day')
		);

		while ( $row = $db->fetchRow($result) ) {
			$data['temp_users']['temp_users'][$row['day']] = $row['temp_users'];
		}

		$db->freeResult( $result );

		// get facebook users
		$result = $db->select(
			array( 'user', 'user_fbconnect' ),
			array( "date_format(user_registration, '%Y-%m-%d') day", 'count(*) facebook_users'  ),
			array( "user_fbconnect.user_fbid is not null and date(user_registration) > curdate() - interval $this->days day and date(user_registration) = date(time)" ),
			__METHOD__,
			array( 'GROUP BY' => 'day' ),
			array(
				'user_fbconnect' => array(
					'LEFT JOIN',
					array( 'user.user_id = user_fbconnect.user_id ' )
				)
			)
		);

		while ( $row = $db->fetchRow($result) ) {
			$data['facebook_users']['facebook_users'][$row['day']] = $row['facebook_users'];
		}

		$db->freeResult( $result );

		wfProfileOut( __METHOD__ );

		return $data;
	}

	protected function get_founderemails() {
		wfProfileIn( __METHOD__ );
		
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalDatawareDB);

		$sql =<<<SQL
			select date_format(created, '%Y-%m-%d') day, if(category is null,'unknown',category) type, 
				count(*) sent, count(if(clicked is not null,1,null)) clicks, count(if(opened is not null,1,null)) opens
			from wikia_mailer.mail 
			where created > curdate()-interval $this->days day and created <= curdate() and category like 'FounderEmails%'
			group by day, type;
SQL;

		$result = $db->query($sql);

		$data = array();
		while($row = $db->fetchRow($result)) {
			$data['founderemails_sent'][$row['type']][$row['day']] = $row['sent'];
			$data['founderemails_opens'][$row['type']][$row['day']] = $row['opens'];
			$data['founderemails_clicks'][$row['type']][$row['day']] = $row['clicks'];
			$data['founderemails_clicks_per_sent'][$row['type']][$row['day']] = self::percentage($row['clicks'],$row['sent']);
			$data['founderemails_opens_per_sent'][$row['type']][$row['day']] = self::percentage($row['opens'],$row['sent']);
		}
		
		wfProfileOut( __METHOD__ );

		return $data;
	}
	
	protected function get_allemails() {
		wfProfileIn( __METHOD__ );
		
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalDatawareDB);

		$sql =<<<SQL
			select date_format(created, '%Y-%m-%d') day, if(category is null,'unknown',category) type, 
				count(*) sent, count(if(clicked is not null,1,null)) clicks, count(if(opened is not null,1,null)) opens
			from wikia_mailer.mail 
			where created > curdate()-interval $this->days day and created <= curdate()
			group by day, type;
SQL;

		$result = $db->query($sql);

		$data = array();
		while($row = $db->fetchRow($result)) {
			$data['allemails_sent'][$row['type']][$row['day']] = $row['sent'];
			$data['allemails_opens'][$row['type']][$row['day']] = $row['opens'];
			$data['allemails_clicks'][$row['type']][$row['day']] = $row['clicks'];
			$data['allemails_clicks_per_sent'][$row['type']][$row['day']] = self::percentage($row['clicks'],$row['sent']);
			$data['allemails_opens_per_sent'][$row['type']][$row['day']] = self::percentage($row['opens'],$row['sent']);
		}
		
		wfProfileOut( __METHOD__ );

		return $data;
	}
	
	protected function convertDataToXML($code, $data=array()) {
		// header
		$xml = "<graph caption='".wfMsg('report-name-'.$code).
				"' xAxisName='".wfMsg('report-xaxis').
				"' yAxisName='".wfMsg('report-yaxis-'.$code).
				"' showValues='0' decimalPrecision='0' formatNumberScale='0' showShadow='0' ".
				$this->graph_set_legend().
				$this->graph_set_rotate_name().
				$this->graph_set_max_y_axis($data).
				">";
		
		// x-axis
		$xml .= "<categories>";
		foreach($this->day_list as $day) {
			$xml .= "<category name='$day' />";
		}
		$xml .= "</categories>";
		
		// dataset
		if(!empty($data)) {
			$i = 0;
			foreach($data as $seriesname => $sets) {
				$xml .= "<dataset seriesname='$seriesname' showValue='1' color='".self::$colors[($i%30)]."'>";
				foreach($sets as $value) {
					$xml .= "<set value='".$value."' />";
				}
				$xml .= "</dataset>";
				$i++;
			}
		}
		
		$xml .= '</graph>';
		
		return $xml;
	}
	
	protected function patch_zero() {
		foreach ($this->data as &$sub_report) {
			foreach ($sub_report as &$sets) {
				foreach($this->day_list as $day) {
					if (!isset($sets[$day]))
						$sets[$day] = 0;
				}
				ksort($sets);
			}
		}
	}
	
	protected static function percentage($a,$b) {
		$a = intval($a);
		$b = intval($b);
		if ($b==0)
			return 0;
		return round((($a/$b)*100), 2);
	}

	protected function graph_set_legend() {
		return (count($this->data) > 1) ? "" : "showLegend='0'";
	}
	
	protected function graph_set_rotate_name() {
		return ($this->days > 7) ? "rotateNames='1'" : "";
	}
	
	protected function graph_set_max_y_axis($data) {
		$max = 0;
		foreach($data as $sets) {
			$max_sets = max($sets);
			if ($max < $max_sets)
				$max = $max_sets;
		}
		return ($max==0) ? "yaxismaxvalue='10'" : "";
	}

	protected static function filter_category($category, $cond) {
		if (preg_match('/[\n|\:|\r]/',$category))
			return FALSE;

		if ($cond=='founder' && !strstr($category,'FounderEmail'))
			return FALSE;

		return TRUE;
	}

}
