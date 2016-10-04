<?php

class FlowTrackingHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'flow_tracking_js' );

		return true;
	}
}
