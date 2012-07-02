<?php

class VimeoVideoProvider extends BaseVideoProvider {

	protected $videoIdRegex = '/.*\/(.*)/';
	protected $embedTemplate = '<iframe src="http://player.vimeo.com/video/$video_id" width="$width" height="$height" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';

	protected function getRatio() {
		return 400 / 225;
	}

	public static function getDomains() {
		return array( 'vimeo.com' );
	}

}