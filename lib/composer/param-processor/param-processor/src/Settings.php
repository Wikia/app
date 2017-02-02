<?php

namespace ParamProcessor;

/**
 * File defining the settings for the ParamProcessor extension.
 * More info can be found at https://www.mediawiki.org/wiki/Extension:Validator#Settings
 *
 * NOTICE:
 * Changing one of these settings can be done by assigning to $egValidatorSettings,
 * AFTER the inclusion of the extension itself.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class Settings {

	/**
	 * Constructs a new instance of the settings object from global state.
	 *
	 * @since 1.0
	 *
	 * @param array $globalVariables
	 *
	 * @return Settings
	 */
	public static function newFromGlobals( array $globalVariables ) {
		return new self( $globalVariables['egValidatorSettings'] );
	}

	/**
	 * @since 1.0
	 *
	 * @var array
	 */
	private $settings;

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 *
	 * @param array $settings
	 */
	public function __construct( array $settings ) {
		$this->settings = $settings;
	}

	/**
	 * Returns the setting with the provided name.
	 * The specified setting needs to exist.
	 *
	 * @since 1.0
	 *
	 * @param string $settingName
	 *
	 * @return mixed
	 */
	public function get( $settingName ) {
		return $this->settings[$settingName];
	}

}
