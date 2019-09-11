<?php


class WatchShowService extends WikiaService {
	public function index() {
		global $wgWatchShowURL, $wgWatchShowCTA, $wgWatchShowButtonLabel;

		$this->response->setValues(
			[
				'url' => $wgWatchShowURL,
				'callToAction' => $wgWatchShowCTA,
				'buttonLabel' => $wgWatchShowButtonLabel,
			]
		);
	}
}
