<?php

/**
 * Class that represents a single upload campaign.
 *
 * @file
 * @ingroup Upload
 *
 * @since 1.2
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class UploadWizardCampaign {

	/**
	 * If the ID of the campaign.
	 * Either this matched a record in the uw_campaigns table or is null.
	 *
	 * @since 1.2
	 * @var integer or null
	 */
	protected $id;

	/**
	 * If the name of the campaign.
	 * This name is the string used to invoke the campaign via campaign=name.
	 *
	 * @since 1.2
	 * @var string
	 */
	protected $name;

	/**
	 * If the campaign is enabled or not.
	 *
	 * @since 1.2
	 * @var boolean
	 */
	protected $isEnabled;

	/**
	 * The campaign configuration.
	 *
	 * @since 1.2
	 * @var array
	 */
	protected $config;

	/**
	 * If the campaign config has been loaded or not.
	 *
	 * @since 1.2
	 * @var boolean
	 */
	protected $loadedConfig = false;

	/**
	 * Create a new instance of $campaignName.
	 *
	 * @since 1.2
	 *
	 * @param integer $id
	 * @param string $name
	 * @param boolean $isEnabled
	 * @param array $config
	 */
	public function __construct( $id, $name = '', $isEnabled = false, array $config = array() ) {
		$this->id = $id;
		$this->name = $name;
		$this->isEnabled = $isEnabled;

		$this->setConfig( $config );
	}

	/**
	 * Returns the UploadWizardCampaign with specified name, or false if there is no such campaign.
	 *
	 * @since 1.2
	 *
	 * @param string $campaignName
	 * @param boolean $loadConfig
	 *
	 * @return UploadWizardCampaign or false
	 */
	public static function newFromName( $campaignName, $loadConfig = true ) {
		return self::newFromDB( array( 'campaign_name' => $campaignName ), $loadConfig );
	}

	/**
	 * Returns the UploadWizardCampaign with specified ID, or false if there is no such campaign.
	 *
	 * @since 1.2
	 *
	 * @param integer $campaignId
	 * @param boolean $loadConfig
	 *
	 * @return UploadWizardCampaign or false
	 */
	public static function newFromId( $campaignId, $loadConfig = true ) {
		return self::newFromDB( array( 'campaign_id' => $campaignId ), $loadConfig );
	}

	/**
	 * Returns a new instance of UploadWizardCampaign build from a database result
	 * obtained by doing a select with the porvided conditions on the uw_campaigns table.
	 * If no campaign matches the conditions, false will be returned.
	 *
	 * @since 1.2
	 *
	 * @param array $conditions
	 * @param boolean $loadConfig
	 *
	 * @return UploadWizardCampaign or false
	 */
	protected static function newFromDB( array $conditions, $loadConfig = true ) {
		$dbr = wfGetDB( DB_SLAVE );

		$campaign = $dbr->selectRow(
			'uw_campaigns',
			array(
				'campaign_id',
				'campaign_name',
				'campaign_enabled',
			),
			$conditions
		);

		if ( !$campaign ) {
			return false;
		}

		$config = $loadConfig ? self::getPropsFromDB( $dbr, $campaign->campaign_id ) : array();

		return new self(
			$campaign->campaign_id,
			$campaign->campaign_name,
			$campaign->campaign_enabled,
			$config
		);
	}

	/**
	 * Returns the list of configuration settings that can be modified by campaigns,
	 * and the HTMLForm input type that can be used to represent their value.
	 * Property name => HTMLForm input type
	 *
	 * @since 1.2
	 *
	 * @return array
	 */
	public static function getConfigTypes() {
		$globalConfig = UploadWizardConfig::getConfig();

		$config = array(
			'headerLabelPage' => array(
				'type' => 'text',
			),
			'skipTutorial' => array(
				'type' => 'check'
			),
			'tutorialTemplate' => array(
				'type' => 'text',
			),
			'tutorialWidth' => array(
				'type' => 'int',
			),
			'tutorialHelpdeskCoords' => array(
				'type' => 'text',
			),
			'idField' => array(
				'type' => 'text',
			),
			'idFieldLabel' => array(
				'type' => 'text',
			),
			'idFieldLabelPage' => array(
				'type' => 'text',
			),
			'idFieldMaxLength' => array(
				'type' => 'int',
			),
			'ownWorkOption' => array(
				'type' => 'radio',
				'options' => array(
					wfMsg( 'mwe-upwiz-campaign-owner-choice' ) => 'choice',
					wfMsg( 'mwe-upwiz-campaign-owner-own' ) => 'own',
					wfMsg( 'mwe-upwiz-campaign-owner-notown' ) => 'notown'
				)
			),
			'licensesOwnWork' => array(
				'type' => 'multiselect',
				'options' => array(),
				'default' => $globalConfig['licensesOwnWork']['licenses']
			),
			'defaultOwnWorkLicence' => array(
				'type' => 'radio',
				'options' => array(),
				'default' => $globalConfig['licensesOwnWork']['defaults'][0]
			),
			'defaultCategories' => array(
				'type' => 'text'
			),
			'autoCategories' => array(
				'type' => 'text'
			),
			'autoWikiText' => array(
				'type' => 'textarea',
				'rows' => 4
			),
			'thanksLabelPage' => array(
				'type' => 'text'
			),
		);

		foreach ( $globalConfig['licenses'] as $licenseName => $licenseDate ) {
			$licenceMsg = UploadWizardHooks::getLicenseMessage( $licenseName, $globalConfig['licenses'] );
			$config['licensesOwnWork']['options'][$licenceMsg] = $licenseName;
		}
		
		$config['defaultOwnWorkLicence']['options'] = $config['licensesOwnWork']['options'];

		return $config;
	}

	/**
	 * Returns the default configuration values.
	 * Property name => array( 'default' => $value, 'type' => HTMLForm input type )
	 *
	 * @since 1.2
	 *
	 * @return array
	 */
	public static function getDefaultConfig() {
		static $config = false;

		if ( $config === false ) {
			$config = array();
			$globalConf = UploadWizardConfig::getConfig();

			foreach ( self::getConfigTypes() as $setting => $data ) {
				if ( array_key_exists( $setting, $globalConf ) ) {
					$config[$setting] = array_merge( array( 'default' => $globalConf[$setting] ), $data );
				}
				elseif ( in_array( $setting, array( 'defaultOwnWorkLicence' ) ) ) {
					// There are some special cases where a setting does not have
					// a direct equivalent in the global config, hence the in_array().
					$config[$setting] = $data;
				}
				else {
					wfWarn( "Nonexiting Upload Wizard configuration setting '$setting' will be ignored." );
				}
			}
		}

		return $config;
	}

	/**
	 * Returns the id of the campaign.
	 *
	 * @since 1.2
	 *
	 * @return intgere
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Returns the name of the campaign.
	 *
	 * @since 1.2
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns if the campaign is enabled.
	 *
	 * @since 1.2
	 *
	 * @return boolean
	 */
	public function getIsEnabled() {
		return $this->isEnabled;
	}

	/**
	 * Sets all config properties.
	 *
	 * @since 1.2
	 *
	 * @param array $config
	 */
	public function setConfig( array $config ) {
		$defaultConfig = self::getDefaultConfig();

		foreach ( $config as $settingName => &$settingValue ) {
			// This can happen when a campaign was created with an option that has been removed from the extension.
			if ( !array_key_exists( $settingName, $defaultConfig ) ) {
				continue;
			}
			
			if ( is_array( $defaultConfig[$settingName]['default'] ) && !is_array( $settingValue ) ) {
				$parts = explode( '|', $settingValue );
				$settingValue = array();

				foreach ( $parts as $part ) {
					$part = trim( $part );

					if ( $part != '' ) {
						$settingValue[] = $part;
					}
				}
			}
		}

		$this->config = $config;

		$this->loadedConfig = count( $this->config ) > 0;
	}

	/**
	 * Returns all set config properties.
	 * Property name => property value
	 *
	 * @since 1.2
	 *
	 * @return array
	 */
	public function getConfig() {
		if ( !$this->loadedConfig ) {
			if ( !is_null( $this->id ) ) {
				$this->config = self::getPropsFromDB( wfGetDB( DB_SLAVE ), $this->id );
			}

			$this->loadedConfig = true;
		}

		return $this->config;
	}

	/**
	 * Returns the configuration, ready for merging with the
	 * global configuration.
	 *
	 * @since 1.2
	 *
	 * @return arrayu
	 */
	public function getConfigForGlobalMerge() {
		$config = $this->getConfig();

		foreach ( $config as $settingName => &$settingValue ) {
			switch ( $settingName ) {
				case 'licensesOwnWork':
					$settingValue = array_merge(
						UploadWizardConfig::getSetting( 'licensesOwnWork' ),
						array( 'licenses' => $settingValue )
					);
					break;
			}
		}

		foreach ( self::getDefaultConfig() as $name => $data ) {
			if ( !array_key_exists( $name, $config ) ) {
				$config[$name] = $data['default'];
			}
		}

		$config['licensesOwnWork']['defaults'] = array( $config['defaultOwnWorkLicence'] );
		unset( $config['defaultOwnWorkLicence'] );

		return $config;
	}

	/**
	 * Returns all config properties by merging the set ones with a list of default ones.
	 * Property name => array( 'default' => $value, 'type' => HTMLForm input type )
	 *
	 * @since 1.2
	 *
	 * @return array
	 */
	public function getAllConfig() {
		$setConfig = $this->getConfig();
		$config = array();

		foreach ( self::getDefaultConfig() as $name => $data ) {
			if ( array_key_exists( $name, $setConfig ) ) {
				$data['default'] = $setConfig[$name];
			}

			$config[$name] = $data;
		}

		return $config;
	}

	/**
	 * Write the campaign to the DB.
	 * If it's already there, it'll be updated, else it'll be inserted.
	 *
	 * @since 1.2
	 *
	 * @return boolean Success indicator
	 */
	public function writeToDB() {
		if ( is_null( $this->id ) ) {
			return $this->insertIntoDB();
		}
		else {
			return $this->updateInDB();
		}
	}

	/**
	 * Insert the campaign into the DB.
	 *
	 * @since 1.2
	 *
	 * @return boolean Success indicator
	 */
	protected function insertIntoDB() {
		$dbw = wfGetDB( DB_MASTER );

		$success = $dbw->insert(
			'uw_campaigns',
			array(
				'campaign_name' => $this->name,
				'campaign_enabled' => $this->isEnabled,
			),
			__METHOD__,
			array( 'campaign_id' => $this->id )
		);

		if ( $success ) {
			$this->id = $dbw->insertId();
			$success &= $this->writePropsToDB( $dbw );
		}

		return $success;
	}

	/**
	 * Update the campaign in the DB.
	 *
	 * @since 1.2
	 *
	 * @return boolean Success indicator
	 */
	protected function updateInDB() {
		$dbw = wfGetDB( DB_MASTER );

		$success = $dbw->update(
			'uw_campaigns',
			array(
				'campaign_name' => $this->name,
				'campaign_enabled' => $this->isEnabled,
			),
			array( 'campaign_id' => $this->id ),
			__METHOD__
		);

		// Delete and insert instead of update.
		// This will not result into dead-data when config vars are removed.
		$success &= $dbw->delete(
			'uw_campaign_conf',
			array( 'cc_campaign_id' => $this->id ),
			__METHOD__
		);

		$success &= $this->writePropsToDB( $dbw );

		return $success;
	}

	/**
	 * Write (insert) the properties into the DB.
	 *
	 * @since 1.2
	 *
	 * @param Database $dbw
	 *
	 * @return boolean Success indicator
	 */
	protected function writePropsToDB( DatabaseBase $dbw ) {
		$success = true;

		if ( array_key_exists( 'defaultOwnWorkLicence', $this->config )
			&& array_key_exists( 'licensesOwnWork', $this->config )
			&& !in_array( $this->config['defaultOwnWorkLicence'], $this->config['licensesOwnWork'] ) ) {
				$this->config['licensesOwnWork'][] = $this->config['defaultOwnWorkLicence'];
		}

		$dbw->begin();

		// TODO: it'd be better to serialize() arrays

		foreach ( $this->config as $prop => $value ) {
			$success &= $dbw->insert(
				'uw_campaign_conf',
				array(
					'cc_campaign_id' => $this->id,
					'cc_property' => $prop,
					'cc_value' => is_array( $value ) ? implode( '|', $value ) : $value
				),
				__METHOD__
			);
		}

		$dbw->commit();

		return $success;
	}

	/**
	 * Get the configuration properties from the DB.
	 *
	 * @since 1.2
	 *
	 * @param Database $dbr
	 * @param integer $campaignId
	 *
	 * @return array
	 */
	protected static function getPropsFromDB( DatabaseBase $dbr, $campaignId ) {
		$config = array();

		$confProps = $dbr->select(
			'uw_campaign_conf',
			array( 'cc_property', 'cc_value' ),
			array( 'cc_campaign_id' => $campaignId ),
			__METHOD__
		);

		foreach ( $confProps as $confProp ) {
			$config[$confProp->cc_property] = $confProp->cc_value;
		}

		return $config;
	}

	/**
	 * Delete the campaign from the DB (when present).
	 *
	 * @since 1.2
	 *
	 * @return boolean Success indicator
	 */
	public function deleteFromDB() {
		if ( is_null( $this->id ) ) {
			return true;
		}

		$dbw = wfGetDB( DB_MASTER );

		$d1 = $dbw->delete(
			'uw_campaigns',
			array( 'campaign_id' => $this->id ),
			__METHOD__
		);

		$d2 = $dbw->delete(
			'uw_campaign_conf',
			array( 'cc_campaign_id' => $this->id ),
			__METHOD__
		);

		return $d1 && $d2;
	}

}
