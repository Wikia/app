<?php

/**
 * VideoTracker
 * @author Jakub "Szeryf" Kurcek
 */

class VideoTracker {

	static public function onBeforePageDisplay( &$out, &$sk ) {

		global $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;

		$out->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/VideoTracking/js/VideoTracking.js?{$wgStyleVersion}\" ></script>\n");
		return true;
	}
}

