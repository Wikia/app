<?php

class MyHomeAjax {

	/*
	 * Get raw HTML of given feed
	 */
	public static function getFeed() {
		// get request params
		global $wgRequest;
		$type  = $wgRequest->getVal('type', false);
		$since = $wgRequest->getVal('since', wfTimestamp(TS_MW, time()));
		$limit = $wgRequest->getInt('limit', 10);

		// check feed type
		if ( !in_array($type, array('activity', 'watchlist')) ) {
			return false;
		}

		// prepare class names
		$type = ucfirst($type);

		$dataRendererClassName = "{$type}FeedRenderer";
		$dataProviderClassName = "{$type}FeedProvider";

		$dataRenderer = new $dataRendererClassName();
		$dataProvider = new $dataProviderClassName();
		$data = $dataProvider->get($limit, $since);

		// get timestamp of last entry
		$last_entry = end($data);

		// substract one second so we fetch next item
		$last_timestamp = strtotime($last_entry['timestamp']);
		$last_timestamp = wfTimestamp(TS_ISO_8601, $last_timestamp - 1);

		// get feed
		return array(
			'type' => $type,
			'last_timestamp' => $last_timestamp,
			'html' => $dataRenderer->render($data, false /* don't wrap - return just raw rows */),
		);
	}

	/*
	 * Get HTML of video player for given video file
	 *
	 * Used for on-click video play
	 */
	public static function getVideoPlayer() {
		global $wgTitle;

		$video = new VideoPage($wgTitle);
		$video->load();

		// get default video dimensions
		$dimensions = explode('x', $video->getTextRatio());
		$width = intval($dimensions[0]);
		$height = intval($dimensions[1]);

		return array(
			'width' => $width,
			'height' => $height,
			'html' => $video->getEmbedCode($width, true),
		);
	}

	/*
	 * Get HTML for full-size image
	 *
	 * Used for on-click image preview
	 */
	public static function getImagePreview() {
		global $wgTitle;

		//$image =  wfFindFile($wgTitle);

		// limit dimensions of returned image
		global $wgRequest;
		$maxWidth = $wgRequest->getInt('maxwidth', 500) - 20;
		$maxHeight = $wgRequest->getInt('maxheight', 300) - 75;

		// get the correct revision of file
		$timestamp = $wgRequest->getInt('timestamp', time());

		$image = FeedProvider::getFile($wgTitle, $timestamp);

		// get original dimensions of an image
		$width = $image->getWidth();
		$height = $image->getHeight();

		// don't try to make image larger
		if ($width > $maxWidth or $height > $maxHeight) {
			$width = $maxWidth;
			$height = $maxHeight;
		}

		// generate thumbnail
		$thumb = $image->getThumbnail($width, $height);

		return array(
			'width' => $thumb->getWidth(),
			'height' => $thumb->getHeight(),
			'html' => $thumb->toHtml(),
		);
	}
}
