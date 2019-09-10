<?php


class WatchShowService extends WikiaService {
	public function index() {
		global $wgWatchShowURL,
		       $wgWatchShowCTA,
		       $wgWatchShowButtonLabel,
		       $wgWatchShowImageUrl,
		       $wgScriptPath;

		$this->response->setValues(
			[
				'url' => $wgWatchShowURL,
				'callToAction' => !empty( $wgWatchShowCTA ) ? $wgWatchShowCTA : 'Watch This Show',
				'buttonLabel' => !empty( $wgWatchShowButtonLabel ) ? $wgWatchShowButtonLabel : 'Watch Now',
				'imageUrl' => !empty( $wgWatchShowImageUrl ) ? $wgWatchShowImageUrl : "$wgScriptPath/extensions/wikia/WatchShow/images/moviesanywhere.svg",
			]

		);
	}
}
