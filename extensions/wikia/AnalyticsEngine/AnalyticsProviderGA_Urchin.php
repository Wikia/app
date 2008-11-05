<?php

class AnalyticsProviderGA_Urchin implements iAnalyticsProvider {


	public function getSetupHtml(){
		static $called = false;
		if ($called == true){
			return '';
		} else {
			$called = true;
		}

		return  '<script type="text/javascript" src="http://www.google-analytics.com/urchin.js"></script>' . "\n";
	}

	public function trackEvent($event, $eventDetails=array()){
		switch ($event){
		  case AnalyticsEngine::EVENT_PAGEVIEW:
			return '<script type="text/javascript">_uff=0;_uacct="UA-288915-1";urchinTracker();</script>';
		  case 'hub':
			if (empty($eventDetails['name'])){
				return '<!-- Missing category name  for hub tracking event -->';
			}
			$hub = "/" . str_replace(' ', '_', $eventDetails['name']);
			return '<script type="text/javascript">_uff=0;_uacct="UA-288915-2";urchinTracker("' .addslashes($hub).'");</script>';
		  case 'onewiki':
			return $this->onewiki($eventDetails[0]);
                  default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

	/* For certain wikis, we issue an additional call to track page views independently */
	private function onewiki($city_id){
		$cities=array(
		    "304"=>"UA-288915-3", "831"=>"UA-288915-4", "2965"=>"UA-288915-5", "147"=>"UA-288915-7", "462"=>"UA-288915-8",
		    "410"=>"UA-288915-9", "530"=>"UA-288915-10", "324"=>"UA-288915-11", "602"=>"UA-288915-12", "2973"=>"UA-288915-13",
		    "690"=>"UA-288915-14", "3085"=>"UA-288915-16", "125"=>"UA-288915-17", "634"=>"UA-288915-18", "5711"=>"UA-288915-19",
		    "528"=>"UA-288915-20", "3814"=>"UA-288915-21", "351"=>"UA-288915-22", "411"=>"UA-288915-23", "2719"=>"UA-288915-24",
		    "3355"=>"UA-288915-26", "534"=>"UA-288915-28", "1766"=>"UA-288915-29", "2205"=>"UA-288915-30", "2962"=>"UA-288915-31",
		    "2871"=>"UA-288915-32", "5329"=>"UA-288915-33", "6966"=>"UA-288915-34", "51"=>"UA-2697185-4", "1657"=>"UA-784542-1",
		    "59"=>"UA-363124-1", "38"=>"UA-89493-2", "1323"=>"UA-89493-2", "769"=>"UA-992722-1", "1107"=>"UA-265325-1",
		    "549"=>"UA-89493-1", "1167"=>"UA-89493-3", "1870"=>"UA-346766-6", "1448"=>"UA-550357-1", "989"=>"UA-371419-1",
		    "706"=>"UA-444393-1", "816"=>"UA-84972-5", " 383"=>"UA-921254-1", "2161"=>"UA-921115-1", "3616"=>"UA-145089-1",
		    "3756"=>"UA-145089-1", "2233"=>"UA-145089-1", "2234"=>"UA-145089-1", "2235"=>"UA-145089-1", "2236"=>"UA-145089-1",
		    "2237"=>"UA-145089-4", "2020"=>"UA-87586-8", "171"=>"UA-978350-1", "1928"=>"UA-657201-1", "1864"=>"UA-855317-1",
		    "1404"=>"UA-722649-1", "702"=>"UA-680784-1", "909"=>"UA-968098-1", "999"=>"UA-818628-1", "1981"=>"UA-776391-1",
		    "1916"=>"UA-1153537-1", "1778"=>"UA-1068008-1", "2307"=>"UA-1276867-1", "2166"=>"UA-1291238-2", "133"=>"UA-1362746-1",
		    "2342"=>"UA-1368221-1", "645"=>"UA-1368532-1", "2193"=>"UA-1368560-1", "667"=>"UA-1377241-1", "2195"=>"UA-1263121-1",
		    "3236"=>"UA-2100028-5", "193"=>"UA-1946686-3", "2165"=>"UA-1946686-2", "88"=>"UA-1072717-1");

		if (empty($cities[$city_id])){
			return '<!-- No tracking for this wiki -->';
		} else {
			return '<script type="text/javascript">_uff=0;_uacct="' . addslashes($cities[$city_id]) . '";urchinTracker();</script>';
		}

	}

}
