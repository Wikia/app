<?php

class ConfigureWMF {
	static $settings = array(
		'sitename' => array(
			'wgSitename' => 'string',
		),
		'metans' => array(
			'wgMetaNamespace'     => 'string',
			'wgMetaNamespaceTalk' => 'string',
		),
		'readonly' => array(
			'wgReadOnly' => 'string',
		),
		'patrol' => array(
			'wgUseNPPatrol' => 'bool',
			'wgUseRCPatrol' => 'bool',
		),
		'importsrc' => array(
			'wgImportSources' => 'stringarray',
		),
		'enotif' => array(
			'wgEnotifUserTalk' => 'bool',
			'wgEnotifWatchlist' => 'bool',
		),
		'blockcfg' => array(
			'wgBlockAllowsUTEdit' => 'bool',
		),
		'timezone' => array(
			'wgLocaltimezone' => 'string',
		),
		'logo' => array(
			'wgLogo' => 'logo',
		),
// 		'groupperms' => array(
// 			'wgGroupPermissions' => 'groupperms',
// 		),
// 		'chgrpperms' => array(
// 			'wgAddGroups' => 'grouplist',
// 			'wgRemoveGroups' => 'grouplist',
// 		),
	);

	static $mergable = array( 'wgGroupPermissions', 'wgAddGroups', 'wgRemoveGroups' );

	var $overrides;

	public function __construct() {
		global $IP;

		// No Setup.php yet. Initialise everything by ourselves
		require_once( $IP . '/includes/GlobalFunctions.php' );
		require_once( $IP . '/includes/ObjectCache.php' );
		
		$wgMemc = wfGetMainCache();

		// Caching not yet working
		$cached = false; //$wgMemc->get( 'configurewmf:data' );
		if( $cached ) {
			$this->overrides = $cached;
			return;
		}

		$dbr = self::getSlaveDB();
		$r = $dbr->select( 'config_overrides', array( 'cfg_target', 'cfg_value' ), null, __METHOD__ );
		$overrides = array();
		while( $row = $dbr->fetchObject( $r ) ) {
			$overrides[] = array( 'target' => $row->cfg_target, 'value' => unserialize( $row->cfg_value ) );
		}
		$wgMemc->set( 'configurewmf:data', $overrides );
		$this->overrides = $overrides;
	}

	public static function getSlaveDB() {
		global $wgConfigureDatabase;
		return wfGetLB( $wgConfigureDatabase )->getConnection( DB_SLAVE, 'wikiconfig',
			$wgConfigureDatabase );
	}

	public static function getMasterDB() {
		global $wgConfigureDatabase;
		return wfGetLB( $wgConfigureDatabase )->getConnection( DB_MASTER, 'wikiconfig',
			$wgConfigureDatabase );
	}

	public function getDefaultSetting( $setting ) {
		global $IP, $wgDefaultGroupPermissions;
		// $wgGroupPermissions may be modified by extensions, so we get it in another way
		if( $setting == 'wgGroupPermissions' )
			return $wgDefaultGroupPermissions;
		require( "{$IP}/includes/DefaultSettings.php" );
		return @$$setting;
	}

	static function isWiki( $name ) {
		global $wgLocalDatabases;
		return in_array( $name, $wgLocalDatabases );
	}

	static function isValidTarget( $target ) {
		global $wgConf, $wgConfigureAvailableTags;
		return in_array( $target, $wgConf->wikis ) ||
			in_array( $target, $wgConf->suffixes ) ||
			in_array( $target, $wgConfigureAvailableTags );
	}

	public function getSetting( $target, $setting ) {
		global $wgConf;
		$val = null;
		if( self::isWiki( $target ) ) {
			list( $site, $lang ) = $wgConf->siteFromDB( $target );
			$val = $wgConf->get( $setting, $target, $site,
				array( 'site' => $site, 'lang' => $lang )
			);
		} elseif( isset( $wgConf->settings[$setting][$target] ) ) {
				$val = $wgConf->settings[$setting][$target];
		} elseif( isset( $wgConf->settings[$setting]['default'] ) ) {
			$val = $wgConf->settings[$setting]['default'];
		}
		if( $val !== null )
			return $val;
		else
			return $this->getDefaultSetting( $setting );
	}

	public function getGroupPermissions( $target ) {
		return $this->getSetting( $target, 'wgGroupPermissions' );
	}

	public function getOverride( $name, $target ) {
		$dbr = self::getSlaveDB();
		$row = $dbr->selectRow( 'config_overrides', '*', array( 'cfg_name' => $name, 'cfg_target' => $target ), __METHOD__ );
		if( $row )
			$row->cfg_value = unserialize( $row->cfg_value );
		return $row;
	}

	public function applyConfiguration( &$settings ) {
		foreach( $this->overrides as $override ) {
			foreach( $override['value'] as $varname => $val ) {
				if( in_array( $varname, self::$mergable ) ) {
					// stub
				} else {
					$settings[$varname][$override['target']] = $val;
				}
			}
		}
	}
}
