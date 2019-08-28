<?php


class WatchShowService extends WikiaService {
	public function index() {
		global $wgWatchShowURL, $wgWatchShowCTA, $wgWatchShowButtonLabel;

		$this->response->setValues(
			[
				'url' => $wgWatchShowURL,
				'callToAction' => !empty( $wgWatchShowCTA ) ? $wgWatchShowCTA : 'Watch This Show',
				'buttonLabel' => !empty( $wgWatchShowButtonLabel ) ? $wgWatchShowButtonLabel : 'Watch Now',
			]

		);
	}
}
