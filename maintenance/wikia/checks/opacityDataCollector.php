<?php

/**
 * Script that checks in ThemeSettings the opacity setting for a wiki
 * and outputs cityid, cityname and the opacity separated by a comma
 *
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '../../../Maintenance.php' );

class OpacityDataCollectorScript extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Theme Designer Opacity checker';
	}

	public function execute() {
		global $wgCityId, $wgSitename, $wgServer;

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();
		$this->output(implode(',',[$wgCityId, $wgSitename, $wgServer, $settings['page-opacity']]) . "\n");
	}
}

$maintClass = 'OpacityDataCollectorScript';
require_once( RUN_MAINTENANCE_IF_MAIN );
