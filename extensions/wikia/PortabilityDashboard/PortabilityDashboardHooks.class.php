<?php

class PortabilityDashboardHooks {

	public static function updateUnconvertedInfoboxes( $count ) {
		if ( $count !== false ) {
			global $wgCityId;
			( new PortabilityDashboardModel() )->updateInfoboxesCount( $wgCityId, $count );
		}

		return true;
	}


	public static function updateNotClassifiedTemplates( $count ) {
		if ( $count !== false ) {
			global $wgCityId;
			( new PortabilityDashboardModel() )->updateTemplatesTypeCount( $wgCityId, $count );
		}

		return true;
	}
}
