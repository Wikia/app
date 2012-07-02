<?php
/**
 * @file
 * @author William Lee <wlee@wikia-inc.com>
 * @see http://trac.wikia-code.com/changeset/39940
 */

class MovieClipsVideoProvider extends BaseVideoProvider {
	protected $videoIdRegex = '#/([a-zA-Z0-9]+)-.*?#';
	protected $embedTemplate = '<object width="$width" height="$height" type="application/x-shockwave-flash" data="http://static.movieclips.com/embedplayer.swf?config=http://config.movieclips.com/player/config/embed/$video_id/%3Floc%3DUS&endpoint=http://movieclips.com/api/v1/player/test/action/&start=0&v=1.0.15" style="display:block; overflow:hidden;">
<param name="movie" value="http://static.movieclips.com/embedplayer.swf?config=http://config.movieclips.com/player/config/embed/$video_id/%3Floc%3DUS&endpoint=http://movieclips.com/api/v1/player/test/action/&start=0&v=1.0.15" />
<param name="wmode" value="transparent" />
<param name="allowscriptaccess" value="always" />
<param name="allowfullscreen" value="true" />
<embed src="http://static.movieclips.com/embedplayer.swf?config=http://config.movieclips.com/player/config/embed/$video_id/%3Floc%3DUS&endpoint=http://movieclips.com/api/v1/player/test/action/&start=0&v=1.0.15" type="application/x-shockwave-flash" width="$width" height="$height" wmode="transparent" allowscriptaccess="always" allowfullscreen="true"></embed>
</object>';

	protected function getRatio() {
		return 560 / 304;
	}

	public static function getDomains() {
		return array( 'movieclips.com' );
	}
}