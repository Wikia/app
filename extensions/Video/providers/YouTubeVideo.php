<?php

class YouTubeVideoProvider extends BaseVideoProvider {

	protected $videoIdRegex = '/.*v=([A-Za-z0-9-_]+).*/';

	protected $embedTemplate = '<object width="$width" height="$height"><param name="movie" value="http://www.youtube.com/v/$video_id&fs=1"></param><param name="wmode" value="transparent"></param><param name="allowFullScreen" value="true"></param><embed src="http://www.youtube.com/v/$video_id&fs=1" type="application/x-shockwave-flash" wmode="transparent" allowFullScreen="true" width="$width" height="$height"></embed></object>';

	protected function getRatio() {
		return 425 / 355;
	}

	public static function getDomains() {
		return array( 'youtube.com' );
	}
}