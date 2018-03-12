<?php

class TimeAgoMessaging {

	/**
	 * @param $outputPage OutputPage
	 */
	public static function onBeforePageDisplay( $outputPage ) {
		$outputPage->addModules( "ext.wikia.TimeAgoMessaging" );
	}
}
