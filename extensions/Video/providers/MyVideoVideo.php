<?php

class MyVideoVideoProvider extends BaseVideoProvider {
	protected $videoIdRegex = '#/watch/(\d+)/?#';
	protected $embedTemplate = '<object width="$width" height="$height"><param name="movie" value="http://www.myvideo.de/movie/$video_id"></param><param name="AllowFullscreen" value="true"></param><param name="AllowScriptAccess" value="always"></param><embed src="http://www.myvideo.de/movie/$video_id" width="$width" height="$height" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"></embed></object>';

	protected function getRatio() {
		return 470 / 406;
	}

	public static function getDomains() {
		return array( 'myvideo.de' );
	}
}