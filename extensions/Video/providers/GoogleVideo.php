<?php

class GoogleVideoProvider extends BaseVideoProvider {

	protected $videoIdRegex = '#docid=(-?\d+)#i';
	protected $embedTemplate = '<embed id=VideoPlayback src=http://video.google.com/googleplayer.swf?docid=-5227581495321189338&hl=en&fs=true style=width:$widthpx;height:$heightpx allowFullScreen=true allowScriptAccess=always type=application/x-shockwave-flash> </embed>';

	public static function getDomains() {
		return array( 'video.google.com' );
	}

	protected function getRatio() {
		return 425 / 355;
	}
}