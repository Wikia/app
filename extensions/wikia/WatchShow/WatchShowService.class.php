<?php

class WatchShowService extends WikiaService {
	public function index() {
		global $wgWatchShowURL,
		       $wgWatchShowCTA,
		       $wgWatchShowButtonLabel,
		       $wgWatchShowImageURL,
		       $wgWatchShowTrackingPixelURL;

		$this->response->setValues( [
				'url' => $wgWatchShowURL,
				'callToAction' => $wgWatchShowCTA,
				'buttonLabel' => $wgWatchShowButtonLabel,
				'imageURL' => $wgWatchShowImageURL,
				'trackingPixelURL' => $wgWatchShowTrackingPixelURL,
			] );
	}
}
