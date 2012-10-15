<?php
/**
 * Bartek Łapiński's notes from WikiaVideo extension:
 * needs an API key - to be done last
 * 1. create a token
 * http://api.sevenload.com/rest/1.0/tokens/create with user and password
 *
 * 2. load the data using the token
 * http://api.sevenload.com/rest/1.0/items/A2C4E6G \
 *  ?username=XYZ&token-id=8b8453ca4b79f500e94aac1fc7025b0704f3f2c7
 */

class SevenloadVideoProvider extends BaseVideoProvider {
	protected $videoIdRegex = '#/([a-zA-Z0-9]+)-[a-zA-Z0-9\-]*?(?:(?:\#|\?).*?)?$#';
	protected $embedTemplate = '<object type="application/x-shockwave-flash" data="http://en.sevenload.com/pl/$video_id/$widthx$height/swf" width="$width" height="$height"><param name="allowFullscreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="movie" value="http://en.sevenload.com/pl/$video_id/$widthx$height/swf" /></object>';

	protected function getRatio() {
		return 500 / 408;
	}

	public static function getDomains() {
		return array( 'sevenload.com' );
	}
}