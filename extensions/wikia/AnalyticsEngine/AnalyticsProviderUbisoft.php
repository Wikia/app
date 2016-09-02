<?php

class AnalyticsProviderUbisoft implements iAnalyticsProvider {

    const TEMPLATE_PATH = 'extensions/wikia/AnalyticsEngine/templates/ubisoft.mustache';
    const DISABLED_MESSAGE = '<!-- Ubisoft disabled -->';
    const URL = 'https://ubistatic2-a.akamaihd.net/worldwide_analytics/tagcommander/wikia/tc_WikiaEMEA_1.js';

    /**
     * @param array $params
     * @return null
     */
    public function getSetupHtml( $params = array() ) {
        return null;
    }

    /**
     * @param $eventName
     * @param array $eventDetails
     * @return string
     */
    public function trackEvent( $eventName, $eventDetails = array() ) {
        return self::isEnabled() ? $this->getScript() : self::DISABLED_MESSAGE;
    }

    /**
     * @return bool
     */
    public static function isEnabled() {
        global $wgEnableUbisoft, $wgNoExternals;

        return $wgEnableUbisoft && !$wgNoExternals;
    }

    /**
     * @return string
     */
    private function getScript() {
        return \MustacheService::getInstance()->render( self::TEMPLATE_PATH, [
            'url' => self::URL
        ] );
    }
}
