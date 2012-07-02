<?php

class WeGameVideoProvider extends BaseVideoProvider {
	protected $videoIdRegex = '#/watch/([a-zA-Z0-9_\-]+)/#';
	protected $embedTemplate = '<object width="$width" height="$height"><param name="movie" value="http://www.wegame.com/static/flash/player.swf?xmlrequest=http://www.wegame.com/player/video/$video_id"></param><param name="flashVars" value="xmlrequest=http://www.wegame.com/player/video/$video_id&embedPlayer=true"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.wegame.com/static/flash/player.swf?xmlrequest=http://www.wegame.com/player/video/$video_id&embedPlayer=true" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="$width" height="$height"></embed></object>';

	public static function getDomains() {
		return array( 'wegame.com' );
	}

	protected function getRatio() {
		return 488 / 387;
	}
}