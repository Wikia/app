<?php


class WatchShowService extends WikiaService {
	public function index() {
		global $wgWatchShowURL, $wgWatchShowCTA;

		$this->response->setValues(
			[
				'url' => $wgWatchShowURL,
				'callToAction' => !empty( $wgWatchShowCTA ) ? $wgWatchShowCTA : 'Watch This Show'
			]

		);
	}
}
