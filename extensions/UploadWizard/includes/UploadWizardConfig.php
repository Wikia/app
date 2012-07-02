<?php

/**
 * Static class with methods for interacting with the Upload Wizards configuration.
 *
 * @file
 * @ingroup Upload
 * 
 * @since 1.2
 * 
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class UploadWizardConfig {
	
	/**
	 * Holder for configuration specified via url arguments.
	 * This will override other config when returned via getConfig.
	 * 
	 * @since 1.2
	 * @var array
	 */
	protected static $urlConfig = array();
	
	/**
	 * Returns the globally configuration, optionaly combined with campaign sepcific
	 * configuration. 
	 * 
	 * @since 1.2
	 * 
	 * @param string|null $campaignName
	 * 
	 * @return array
	 */
	public static function getConfig( $campaignName = null ) {
		global $wgUploadWizardConfig;
		static $mergedConfig = false;
		
		if ( !$mergedConfig ) {
			$wgUploadWizardConfig = array_merge( self::getDefaultConfig(), $wgUploadWizardConfig );
			$mergedConfig = true;
		}
		
		if ( !is_null( $campaignName ) ) {
			$wgUploadWizardConfig = array_merge( $wgUploadWizardConfig, self::getCampaignConfig( $campaignName ) );
		}
		
		return array_merge( $wgUploadWizardConfig, self::$urlConfig );
	}
	
	/**
	 * Returns the value of a single configuration setting.
	 * 
	 * @since 1.2
	 * 
	 * @param string $settingName
	 * @param string|null $campaignName
	 * 
	 * @return mixed
	 */
	public static function getSetting( $settingName, $campaignName = null ) {
		$config = self::getConfig();
		return $config[$settingName];
	}
	
	/**
	 * Sets a configuration setting provided by URL.
	 * This will override other config when returned via getConfig. 
	 * 
	 * @param string $name
	 * @param mixed $value
	 * 
	 * @since 1.2
	 */
	public static function setUrlSetting( $name, $value ) {
		self::$urlConfig[$name] = $value;
	}
	
	/**
	 * Returns the default global config, from UploadWizard.config.php.
	 * 
	 * @since 1.2
	 * 
	 * @return array
	 */
	protected static function getDefaultConfig() {
		global $wgUpwizDir;
		$configPath =  $wgUpwizDir . '/UploadWizard.config.php';
		return is_file( $configPath ) ? include( $configPath ) : array();
	}
	
	/**
	 * Returns the configuration of the specified campaign, 
	 * or an empty array when the campaign is not found or not enabled.
	 * 
	 * @since 1.2
	 *
	 * @param string $campaignName
	 * 
	 * @return array
	 */
	protected static function getCampaignConfig( $campaignName ) {
		if ( !is_null( $campaignName ) ) {
			$campaign = UploadWizardCampaign::newFromName( $campaignName );
	
			if ( $campaign !== false && $campaign->getIsEnabled() ) {
				return $campaign->getConfigForGlobalMerge();
			}			
		}
		
		return array();
	}
	
	/**
	 * Get a list of available third party licenses from the config.
	 * 
	 * @since 1.2
	 * 
	 * @return array
	 */
	public static function getThirdPartyLicenses() {
		$thirdParty = self::getSetting( 'licensesThirdParty' );
		$licenses = array();
		
		foreach ( $thirdParty['licenseGroups'] as $group ) {
			$licenses = array_merge( $licenses, $group['licenses'] );
		}
		
		return $licenses;
	}
	
}
