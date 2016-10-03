<?php

class FlowTrackingHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'flow_tracking_create_page_js' );

		return true;
	}
}
