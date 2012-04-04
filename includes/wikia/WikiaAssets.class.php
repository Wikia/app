<?php

class WikiaAssets {

	// leave it for a while (BugId:25943)
	public static function combined() {
		header('HTTP/1.0 503 Temporary error');
		exit();
	}
}