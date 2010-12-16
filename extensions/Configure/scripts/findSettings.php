<?php

/**
 * Maintenance script that find settings that aren't configurable by the
 * extension.
 * Based on findhooks.php
 *
 * @file
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 * @license GPLv2 or higher
 */

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false )
	$IP = dirname( __FILE__ ) . '/../../..';

require_once( "$IP/maintenance/Maintenance.php" );

class FindSettings extends Maintenance {
	function __construct() {
		parent::__construct();
		$this->mDescription = "Script that find settings that aren't configurable by the extension.";
		$this->addOption( 'ext', 'search for extensions settings' );
		$this->addOption( 'from-doc', 'compare with settings from mediawiki.org instead settings from this extension' );
		$this->addOption( 'alpha', 'get the alphabetical list of settings' );
	}

	protected function getDbType() {
		return Maintenance::DB_NONE;
	}

	/**
	 * Nicely output the array
	 * @param $msg A message to show before the value
	 * @param $arr An array
	 * @param $sort Boolean : wheter to sort the array (Default: true)
	 */
	function printArray( $msg, $arr, $sort = true ) {
		if ( $sort ) asort( $arr );
		foreach ( $arr as $v ) $this->output( "$msg: $v\n" );
	}

	/**
	 * @todo Maybe split this in sub functions
	 */
	function execute() {
		global $IP;

		$coreSettings = ConfigurationSettings::singleton( CONF_SETTINGS_CORE );
		if ( $this->hasOption( 'ext' ) ) {
			$exts = ConfigurationSettings::singleton( CONF_SETTINGS_EXT )->getAllExtensionsObjects();
			$ignoreList = array(
				# Core
				'wgTitle', 'wgArticle', 'wgContLang', 'wgLang', 'wgOut', 'wgParser', 'wgMessageCache',
				'wgVersion',
				# Extensions
				'wgAbuseFilterStyleVersion',
				'wgAdminLinksIP',
				'wgExtCategoryTests',
				'wgCategoryTreeUseCategoryTable', 'wgCategoryTreeVersion',
				'wgCategoryWatch',
				'wgCentralAuthStyleVersion',
				'wgCheckUserStyleVersion',
				'wgCaptcha', 'wgConfirmEditIP',
				'wgCitationCache', 'wgCitationCounter', 'wgCitationRunning',
				'wgCodeReviewStyleVersion',
				'wgCollectionVersion', 'wgCollectionStyleVersion',
				'wgCSS',
				'wgDeleteQueueStyleVersion',
				'wgDraftsStyleVersion',
				'edgIP', 'edgValues',
				'wgErrorHandlerErrors', 'wgErrorHandlerOutputDone',
				'wgFlaggedRevStyleVersion',
				'wgGoogleAdSenseCssLocation',
				'wgOggScriptVersion', 'wgEnableJS2system',
				'wgPFHookStub',
				'wgQPollFunctionsHook', 'cell', 'celltag',
				'sdgIP', 'sdgScriptPath', 'sdgNamespaceIndex',
				'sfgIP', 'sfgScriptPath', 'sfgNamespaceIndex',
				'smwgIP', 'smwgScriptPath', 'smwgNamespaceIndex', 'smwgRAPPath', 'smwgSMWBetaCompatible',
				'srfgIP', 'srfgScriptPath',
				'wgUserBoardScripts', 'wgUserProfileDirectory', 'wgUserProfileScripts', 'wgUserRelationshipScripts',
				'wgTimelineSettings',
				'wgTitleBlacklist',
				'wgAutoCreateCategoryPagesObject',
				'wgSpecialRefactorVersion',
				'wgUniwikiFormatChangesObject',
				'wgGenericEditPageClass', 'wgSwitchMode',
				'egValidatorDir',
				'wgWatchersAddCache',
				'wgWikiArticleFeedsParser', 'wgWikiFeedPresent',
				'wgWikilogStyleVersion',
			);
			$ignoreObsolete = array(
				'wgCommentSpammerLog',
				'qp_enable_showresults',
			);
			foreach ( $exts as $ext ) {
				if( !$ext->isInstalled() ) continue; // must exist
				$file = file_get_contents( $ext->getSettingsFile() );
				$name = $ext->getName();
				$m = array();
				preg_match_all( '/\$((wg|eg|edg|sdg|sfg|smwg|srfg|abc|ce[^n]|ub|whoiswatching|wminc)[A-Za-z0-9_]+)\s*\=/', $file, $m );
				$definedSettings = array_unique( $m[1] );
				$allSettings = array_keys( $ext->getSettings() );

				$remain = array_diff( $definedSettings, $allSettings );
				$obsolete = array_diff( $allSettings, $definedSettings, $ignoreObsolete );
				$missing = array();
				foreach ( $remain as $setting ) {
					if ( !$coreSettings->isSettingAvailable( $setting ) && !in_array( $setting, $ignoreList ) )
						$missing[] = $setting;
				}
				if ( count( $missing ) == 0 && count( $obsolete ) == 0 ) {
					# echo "Extension $name ok\n";
				} else {
					$this->output( "Extension $name:\n" );
					$this->printArray( '  missing', $missing );
					$this->printArray( '  obsolete', $obsolete );
				}
			}
		} else {
			// Get our settings defs
			if ( $this->hasOption( 'from-doc' ) ) {
				if ( $this->hasOption( 'alpha' ) ) {
					$page = "Manual:Configuration_settings_(alphabetical)";
				} else {
					$page = "Manual:Configuration_settings";
				}
				$cont = Http::get( "http://www.mediawiki.org/w/index.php?title={$page}&action=raw" );
				$m = array();
				preg_match_all( '/\[\[[Mm]anual:\$(wg[A-Za-z0-9]+)\|/', $cont, $m );
				$allSettings = array_unique( $m[1] );
				$ignoreList = array(
					'wgEnableNewpagesUserFilter', 'wgOldChangeTagsIndex', 'wgVectorExtraStyles'
				);
			} else {
				$allSettings = array_keys( $coreSettings->getAllSettings() );
				$ignoreList = array(
					'wgAuth', 'wgCommandLineMode', 'wgCheckSerialized', 'wgConf',
					'wgDBconnection', 'wgDummyLanguageCodes', 'wgEnableNewpagesUserFilter',
					'wgEnableSerializedMessages', 'wgEnableSorbs', 'wgExperimentalHtmlIds',
					'wgLegacySchemaConversion', 'wgMaintenanceScripts', 'wgMemCachedDebug',
					'wgOldChangeTagsIndex', 'wgProxyKey', 'wgSorbsUrl', 'wgValidSkinNames',
					'wgVectorExtraStyles', 'wgVersion',
				);
			}

			// Now we'll need to open DefaultSettings.php
			$m = array();
			$defaultSettings = file_get_contents( "$IP/includes/DefaultSettings.php" );
			preg_match_all( '/\$(wg[A-Za-z0-9]+)\s*\=/', $defaultSettings, $m );
			$definedSettings = array_unique( $m[1] );

			$missing = array_diff( $definedSettings, $allSettings );
			$remain = array_diff( $allSettings, $definedSettings );
			$obsolete = array();
			foreach ( $remain as $setting ) {
				if ( $coreSettings->isSettingAvailable( $setting ) )
					$obsolete[] = $setting;
			}

			// let's show the results:
			$this->printArray( 'missing', array_diff( $missing, $ignoreList ) );
			$this->printArray( 'obsolete', $obsolete );

			if ( count( $missing ) == 0 && count( $obsolete ) == 0 )
				$this->output( "Looks good!\n" );
		}
	}
}

$maintClass = 'FindSettings';
require_once( DO_MAINTENANCE );