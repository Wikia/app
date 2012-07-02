<?php

/**
 * File defining the settings for the Survey extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Survey#Settings
 *
 * NOTICE:
 * Changing one of these settings can be done by assigning to $egSurveySettings,
 * AFTER the inclusion of the extension itself.
 *
 * @since 0.1
 *
 * @file Survey.settings.php
 * @ingroup Survey
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SurveySettings {

	/**
	 * Returns the default values for the settings.
	 * setting name (string) => setting value (mixed)
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */
	protected static function getDefaultSettings() {
		return array(
			'JSDebug' => false,
			'defaultEnabled' => false,
			'defaultUserType' => Survey::$USER_ALL,
			'defaultNamespaces' => array(),
			'defaultRatio' => 100,
			'defaultExpiry' => 60 * 60 * 24 * 30,
			'defaultMinPages' => 0
		);
	}

	/**
	 * Retruns an array with all settings after making sure they are
	 * initialized (ie set settings have been merged with the defaults).
	 * setting name (string) => setting value (mixed)
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */
	public static function getSettings() {
		static $settings = false;

		if ( $settings === false ) {
			$settings = array_merge(
				self::getDefaultSettings(),
				$GLOBALS['egSurveySettings']
			);
		}

		return $settings;
	}

	/**
	 * Gets the value of the specified setting.
	 * 
	 * @since 0.1
	 * 
	 * @param string $settingName
	 * 
	 * @throws MWException
	 * @return mixed
	 */
	public static function get( $settingName ) {
		$settings = self::getSettings();
		
		if ( !array_key_exists( $settingName, $settings ) ) {
			throw new MWException( 'Attempt to get non-existing setting "' . $settingName . '"' );
		}
		
		return $settings[$settingName];
	}

}
