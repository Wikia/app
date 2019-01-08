<?php


class WatchShowService extends WikiaService {
	public function index() {
		global $wgWatchShowURL;

		$this->setVal('url', $wgWatchShowURL);
	}
}
