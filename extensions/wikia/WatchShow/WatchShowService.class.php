<?php

class WatchShowService extends WikiaService {
	public function index() {
		global $wgWatchShowURL,
		       $wgWatchShowCTA,
		       $wgWatchShowButtonLabel,
		       $wgWatchShowCTACA,
		       $wgWatchShowButtonLabelCA,
		       $wgWatchShowImageURL,
		       $wgWatchShowImageURLMobileDarkTheme,
		       $wgWatchShowTrackingPixelURL;

		$this->response->setValues( [
			'url' => $wgWatchShowURL,
			'callToAction' => $wgWatchShowCTA,
			'buttonLabel' => $wgWatchShowButtonLabel,
			'callToActionCA' => $wgWatchShowCTACA,
			'buttonLabelCA' => $wgWatchShowButtonLabelCA,
			// TODO:: Replace $wgWatchShowImageURLMobileDarkTheme with $wgWatchShowImageURLDarkTheme variable once set in Wiki Factory
			'imageURL' => SassUtil::isThemeDark() ? $wgWatchShowImageURLMobileDarkTheme : $wgWatchShowImageURL,
			'trackingPixelURL' => $wgWatchShowTrackingPixelURL,
			'disclaimerMessage' => wfMessage( 'watch-show-disclaimer' )->plain(),
		] );
	}
}
