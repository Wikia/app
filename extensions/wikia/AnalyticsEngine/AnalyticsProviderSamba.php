<?php

class AnalyticsProviderSamba {
	private static $template = 'extensions/wikia/AnalyticsEngine/templates/samba.mustache';

	public function getSetupHtml( $params = array() ) {
		global $wgCityId;
		$wikiFactoryHub = WikiFactoryHub::getInstance();

		if ( $wikiFactoryHub->getVerticalId( $wgCityId ) == WikiFactoryHub::VERTICAL_ID_TV ) {
			return \MustacheService::getInstance()->render( self::$template, [] );
		}

		return '';
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}