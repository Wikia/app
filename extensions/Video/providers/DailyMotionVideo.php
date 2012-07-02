<?php

class DailyMotionVideoProvider extends BaseVideoProvider {

	protected $videoIdRegex = '#/video/([a-zA-Z0-9]+)_.*#';
	protected $embedTemplate = '<iframe frameborder="0" width="$width" height="$height" src="http://www.dailymotion.com/embed/video/$video_id"></iframe>';

	protected function getRatio() {
		return 425 / 355;
	}

	public static function getDomains() {
		return array( 'dailymotion.com' );
	}
}