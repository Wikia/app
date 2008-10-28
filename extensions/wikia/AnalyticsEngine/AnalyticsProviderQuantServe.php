<?php

class AnalyticsProviderQuantServe implements iAnalyticsProvider {

	private $account = 'p-8bG6eLqkH6Avk';

	function getSetupHtml(){
		static $called = false;
		if ($called == true){
			return '';
		} else {
			$called = true;
		}

		return  '<script type="text/javascript" src="http://edge.quantserve.com/quant.js"></script>' . "\n" .
			'<script type="text/javascript">_qacct="' . addslashes($this->account) . '";</script>';
	}

	function trackEvent($event, $eventDetails=array()){
		switch ($event){
		  case AnalyticsEngine::EVENT_PAGEVIEW : return '<script type="text/javascript">quantserve();</script>';
                  default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}


}
