<?php

class WatchShowService extends WikiaService {
	public function index() {
		global $wgWatchShowURL,
		       $wgWatchShowGeos,
		       $wgWatchShowEnabledDate,
		       $wgWatchShowCTA,
		       $wgWatchShowButtonLabel,
		       $wgWatchShowImageURL,
		       $wgWatchShowTrackingPixelURL;

		$this->response->setValues( [
			'url' => $wgWatchShowURL,
			'datetime' => $wgWatchShowEnabledDate,
			'geos' => $wgWatchShowGeos,
			'callToAction' => $wgWatchShowCTA,
			'buttonLabel' => $wgWatchShowButtonLabel,
			'imageURL' => $wgWatchShowImageURL,
			'trackingPixelURL' => $wgWatchShowTrackingPixelURL,
		] );
	}
}
