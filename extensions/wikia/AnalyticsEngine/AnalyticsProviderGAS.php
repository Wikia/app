<?php

class AnalyticsProviderGAS implements iAnalyticsProvider {

	public function getSetupHtml($params=array()){
		global $wgProto;

		static $called = false;
		if($called == true){
			return '';
		}
		$called = true;

		$script = '';

		if (class_exists('Track')) {
			$script .= Track::getViewJS();
		}

		return $script;
	}

	public function trackEvent($event, $eventDetails=array()){
		switch ($event){
			case "lyrics":
				return $this->lyrics();

			case AnalyticsEngine::EVENT_PAGEVIEW:
				return '';

			case 'hub':
				return '';

			case 'onewiki':
				return $this->onewiki($eventDetails[0]);

			case 'pagetime':
			 	return $this->pagetime($eventDetails[0]);

			case "varnish-stat":
				return $this->varnishstat();

			default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

	private function onewiki($city_id){
		return '';
	}

	private function pagetime($skin){
		return '';
	}

	private function varnishstat() {
		return '';
	}

	private function lyrics() {
		return '';
	}
}
