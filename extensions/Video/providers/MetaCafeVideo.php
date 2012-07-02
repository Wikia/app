<?php

class MetaCafeVideoProvider extends BaseVideoProvider {
	protected $videoIdRegex = '#/watch/(\d+)/#';
	// heh, the URL needed some text to work :)
	protected $embedTemplate = '<embed flashVars="playerVars=autoPlay=no" src="http://www.metacafe.com/fplayer/$video_id/johnduhart_was_here.swf" width="$width" height="$height" wmode="transparent" allowFullScreen="true" allowScriptAccess="always" name="Metacafe_$video_id" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>';

	protected function getRatio() {
		return 400 / 345;
	}

	public static function getDomains() {
		return array( 'metacafe.com' );
	}
}