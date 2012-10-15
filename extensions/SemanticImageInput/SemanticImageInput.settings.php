<?php

/**
 * File defining the settings for the Semantic Image Input extension.
 *
 * NOTICE:
 * Changing one of these settings can be done by assigning to $egSIISettings,
 * AFTER the inclusion of the extension itself.
 *
 * @since 0.1
 *
 * @file SemanticImageInput.settings.php
 * @ingroup SII
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SIISettings {

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
			'defaultImage' => 'File:Mail-envelope.png',
			'defaultWidth' => 200
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
				$GLOBALS['egSIISettings']
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
