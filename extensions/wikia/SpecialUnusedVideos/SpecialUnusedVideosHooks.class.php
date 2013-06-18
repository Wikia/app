<?php

/**
 * SpecialUnusedVideos Hooks
 * @author Garth Webb, Hyun Lim, Liz Lee, Saipetch Kongkatong
 */
class SpecialUnusedVideosHooks {

	/**
	 * Hook: add UnusedVideos page to wgQuery
	 * @param array $wgQueryPages
	 * @return true
	 */
	public static function registerUnusedVideos( &$wgQueryPages ) {
		$wgQueryPages[] = array( 'UnusedVideos', 'UnusedVideos' );
		return true;
	}

}
