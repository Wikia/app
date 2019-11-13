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
			'imageURL' => SassUtil::isThemeDark() ? $wgWatchShowImageURLDarkTheme : $wgWatchShowImageURL,
			'trackingPixelURL' => $wgWatchShowTrackingPixelURL,
		] );
	}
}
