<?php
interface iAnalyticsProvider {
	public function getSetupHtml($params=array());
	public function trackEvent($eventName, $eventDetails=array());
}