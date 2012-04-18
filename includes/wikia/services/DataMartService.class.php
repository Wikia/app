<?php
/*
 * DataMart Services
 */
class DataMartService extends Service {
	
	const PERIOD_ID_DAILY = 1;
	const PERIOD_ID_WEEKLY = 2;
	const PERIOD_ID_MONTHLY = 3;
	const PERIOD_ID_QUARTERLY = 4;
	const PERIOD_ID_YEARLY = 5;
	const PERIOD_ID_15MINS = 15;
	const PERIOD_ID_60MINS = 60;
	const PERIOD_ID_ROLLING_7DAYS = 1007;	// every day
	const PERIOD_ID_ROLLING_28DAYS = 1028;	// every day
	const PERIOD_ID_ROLLING_24HOURS = 10024;	// every 15 minutes

	
	protected static function getPageviews() {
		
	}

	public static function getPageviewsDaily() {
		return $pageviews;
	}

	public static function getPageviewsWeekly() {
		return $pageviews;
	}	

	public static function getPageviews() {
		return $pageviews;
	}	

	public static function getPageviewsWeekly() {
		return $pageviews;
	}	
}