<?php

class WatchShowService extends WikiaService {
	public function index() {
		global $wgWatchShowURL,
		       $wgWatchShowCTA,
		       $wgWatchShowButtonLabel,
		       $wgWatchShowCTACA,
		       $wgWatchShowButtonLabelCA,
			   $wgWatchShowImageURL,
			   $wgWatchShowImageURLDarkTheme,
		       $wgWatchShowTrackingPixelURL;

		$this->response->setValues( [
			'url' => $wgWatchShowURL,
			'callToAction' => $wgWatchShowCTA,
			'buttonLabel' => $wgWatchShowButtonLabel,
			'callToActionCA' => $wgWatchShowCTACA,
			'buttonLabelCA' => $wgWatchShowButtonLabelCA,
			// TODO:: Replace string with $wgWatchShowImageURLDarkTheme variable once set in Wiki Factory
			'imageURL' => SassUtil::isThemeDark() ? "https://static.wikia.nocookie.net/1d8d22a4-207e-47eb-991e-2d1a1c37f1cf" : $wgWatchShowImageURL,
			'trackingPixelURL' => $wgWatchShowTrackingPixelURL,
		] );
	}
}
