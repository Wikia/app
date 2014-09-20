<?php

	/*
	 * Get click tracking data from our system (wikia_mailer.mail table) and display them in csv format
	 * Usage: php get_stats.php --category=[founder/all] --days=[1/../n] --source=[wikia/sendgrid] --username=username --password=password
	 */
	 Class EmailStats {
		
		protected $category = 'founder';
		protected $days = 1;
		protected $source = 'wikia';
		protected $username = NULL;
		protected $password = NULL;
		protected $total = array( 'sent' => 0, 'opens' => 0, 'clicks' => 0);
		
		public function __construct($params) {
			foreach($params as $key => $value) {
				$this->$key = $value;
			}
		}
		
		public function get_stats() {
			if ($this->source=='sendgrid')
				$csv = $this->get_stats_sendgrid();
			else
				$csv = $this->get_stats_wikia();
			return $csv;
		}
		
		// get data from mail table in wikia_mailer database
		protected function get_stats_wikia() {
			global $wgWikiaMailerDB;
						
			// get data
			$db = wfGetDB(DB_SLAVE, array(), $wgWikiaMailerDB);

			$sql_founder = ($this->category=='founder') ? "and category like '%FounderEmails%'" : '';

			$sql =<<<SQL
				select if(category is null,'unknown',category) type, count(*) sent, count(if(opened is not null,1,null)) opens, count(if(clicked is not null,1,null)) clicks 
				from wikia_mailer.mail 
				where created > curdate()-interval $this->days day and created <= curdate() $sql_founder
				group by type;
SQL;

			$result = $db->query($sql);
			
			while($row = $db->fetchRow($result)) {
				$data[] = $row;

				foreach($this->total as $key => &$value) {
					$value += intval($row[$key]);
				}
			}
			
			$csv = $this->show_csv($data);

			return $csv;
		}
		
		// get data from sendgrid
		protected function get_stats_sendgrid() {
			$base_url = 'https://sendgrid.com/api/stats.get.xml?api_user='.$this->username.'&api_key='.$this->password;
			
			// get category list
			$url = $base_url."&list=true";
			$response = Http::get($url);
			if(!$response)
				die("Error: Cannot connect to sendgrid\n");
			
			$xml = new SimpleXMLElement($response);
			$categories = array();
			foreach($xml as $category) {
				if ($this->filter_category($category))
					$categories[] = (string) $category;
			}
			
			// get data
			$data = array();
			$this->total['requests'] = 0;
			$start_date = date('Y-m-d', strtotime("-".$this->days." days"));
			$end_date = date('Y-m-d', strtotime("-1 days"));
			$base_url .= "&start_date=".$start_date."&end_date=".$end_date;
			foreach($categories as $category) {
				$url = $base_url.'&category='.trim($category);
				$response = Http::get($url);
				if (self::is_xml($response)) {
					$xml = new SimpleXMLElement($response);
					foreach($xml as $day) {
						$row['type'] = (string) $day->category;
						$row['requests'] = (int) $day->requests;
						$row['sent'] = (int) $day->delivered;
						$row['opens'] = (int) $day->opens;
						$row['clicks'] = (int) $day->clicks;

						if (array_key_exists($row['type'],$data)) {
							foreach($row as $key => $element) {
								if (is_numeric($element))
									$data[$row['type']][$key] += $element;
							}
						} else {
							$data[$row['type']] = $row;
						}

						foreach($this->total as $key => &$value) {
							$value += $row[$key];
						}
					}
				}
			}
			
			$csv = $this->show_csv($data);
			
			return $csv;
		}
		
		protected function to_csv($row) {
			$row['clicks_sent'] = self::percentage($row['clicks'], $row['sent']);
			$row['opens_sent'] = self::percentage($row['opens'], $row['sent']);
			$row['sent_pct'] = self::percentage($row['sent'], $this->total['sent']);
			$row['opens_pct'] = self::percentage($row['opens'], $this->total['opens']);
			$row['clicks_pct'] = self::percentage($row['clicks'], $this->total['clicks']);
					
			$csv = "$row[type]";
			if($this->source=='sendgrid') {
				$row['requests_pct'] = self::percentage($row['requests'], $this->total['requests']);
				$csv .= ",$row[requests],$row[requests_pct]%";
			}
			$csv .= ",$row[sent],$row[sent_pct]%,";
			$csv .= "$row[opens],$row[opens_pct]%,$row[opens_sent]%,";
			$csv .= "$row[clicks],$row[clicks_pct]%,$row[clicks_sent]%\n";
			return $csv;
		}
		
		protected function show_csv($data) {
			// header
			$csv = ($this->source=='sendgrid') ? "Sendgrid: " : "";
			$csv .= ucwords($this->category)." Emails for Last ".$this->days." days\n";
			$csv .= "Date: ".date("m/d/Y")."\n\n";
			$csv .= "Category,";
			if ($this->source=='sendgrid')
				$csv .= "Requests,Requests(%),";
			$csv .= "Sent,Sent(%),Opens,Opens(%),Opens/Sent(%),Clicks,Clicks(%),Clicks/Sent(%)\n";
			
			// body
			if($data) {
				foreach($data as $row) {
					$csv .= $this->to_csv($row);
				}

				$this->total['type'] = 'Total';
				$csv .= $this->to_csv($this->total);
			}			
			
			return $csv;
		}
				
		protected static function percentage($a,$b) {
			$a = intval($a);
			$b = intval($b);
			if ($b==0)
				return 0;
			return round((($a/$b)*100), 2);
		}
		
		protected static function is_xml($response) {
			if (strstr($response,'<?xml '))
				return TRUE;
			
			return FALSE;
		}
		
		protected function filter_category($category) {
			if (preg_match('/[\n|\:]/',$category))
				return FALSE;
			
			if ($this->category=='founder' && !strstr($category,'FounderEmail'))
				return FALSE;
			
			return TRUE;
		}

	 }

	// ------------------------------------ Main ---------------------------------------------

	ini_set( "include_path", dirname( __FILE__ ) . "/../../../maintenance/" );

	require_once( "commandLine.inc" );
	
	$categories = array('founder','all');
	$sources = array('wikia','sendgrid');
	$command = 'Usage: php get_stats.php --category=[founder/all] --days=[1/../n] --source=[wikia/sendgrid] --username=username --password=password';
	
	if (isset($options['help']))
		die("$command\n");

	if (array_key_exists('category', $options) && !in_array($options['category'], $categories))
		die("Invalid category. $command\n");

	if (array_key_exists('days', $options) && !is_numeric($options['days']))
		die("Invalid time period. $command\n");

	if (array_key_exists('source', $options) && !in_array($options['source'], $sources))
		die("Invalid source. $command\n");
	
	if (array_key_exists('source', $options) && $options['source']!='wikia' && !(array_key_exists('username', $options) && array_key_exists('password', $options)))
		die("Invalid format. $command\n");

	$mc_key = wfMemcKey("stats_emails_$options[category]_$options[source]_$options[days]");
	$csv = $wgMemc->get($mc_key);
	if (!$csv) {
		$stats = new EmailStats($options);
		$csv = $stats->get_stats();
		$wgMemc->set($mc_key, $csv, 24*3600);
	}
	
	echo $csv."\n";

