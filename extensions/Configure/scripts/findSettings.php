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

	public function getDbType() {
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
				'wgCollectionVersion', 'wgCollectionStyleVersion',
				'wgCSS',
				'wgDeleteQueueStyleVersion',
				'wgDraftsStyleVersion',
				'edgIP', 'edgValues',
				'wgErrorHandlerErrors', 'wgErrorHandlerOutputDone',
				'wgFlaggedRevStyleVersion', 'wgFlaggedRevsRCCrap',
				'wgGoogleAdSenseCssLocation',
				'wgOggScriptVersion', 'wgEnableJS2system',
				'wgPFHookStub',
				'wgQPollFunctionsHook', 'cell', 'celltag',
				'sdgIP', 'sdgScriptPath', 'sdgNamespaceIndex',
				'sfgIP', 'sfgScriptPath', 'sfgPartialPath', 'sfgNamespaceIndex', 'sfgFancyBoxIncluded',
					'sfgAdderButtons', 'sfgRemoverButtons', 'sfgShowOnSelectCalls', 'sfgJSValidationCalls',
					'sfgAutocompleteMappings', 'sfgAutocompleteDataTypes', 'sfgAutocompleteValues',
					'sfgComboBoxInputs', 'sfgAutogrowInputs',
				'smwgIP', 'smwgScriptPath', 'smwgNamespaceIndex', 'smwgRAPPath', 'smwgSMWBetaCompatible',
				'srfgIP', 'srfgScriptPath', 'srfgJQPlotIncluded',
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
				$name = $ext->getName();
				if( !$ext->isInstalled() ) {
					$this->output( "Extension $name is not installed\n" );
					continue;
				}
				$file = file_get_contents( $ext->getSettingsFile() );
				$m = array();
				preg_match_all( '/\$((wg|eg|edg|sdg|sfg|smwg|srfg|abc|ce[^n]|ub|whoiswatching|wminc)[A-Za-z0-9_]+)\s*\=/', $file, $m );
				$definedSettings = array_unique( $m[1] );
				$allSettings = array_keys( $ext->getSettings() );

				$remain = array_diff( $definedSettings, $allSettings );
				$obsolete = array_diff( $allSettings, $definedSettings, $ignoreObsolete );
				$missing = array();
				foreach ( $remain as $setting ) {
					if ( !ConfigurationSettings::singleton( CONF_SETTINGS_CORE )->isSettingAvailable( $setting ) && !in_array( $setting, $ignoreList ) )
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
					'wgEnableNewpagesUserFilter',
					'wgOldChangeTagsIndex',
				);
			} else {
				$allSettings = array_keys( ConfigurationSettings::singleton( CONF_SETTINGS_CORE )->getAllSettings() );
				$ignoreList = array(
					'wgActions',                   // Needs PHP code
					'wgAPIListModules',            // Extensions only
					'wgAPIMetaModules',            // Extensions only
					'wgAPIModules',                // Extensions only
					'wgAPIPropModules',            // Extensions only
					'wgAjaxExportList',            // Extensions only
					'wgAuth',                      // Object
					'wgAutoloadClasses',           // Extensions only
					'wgAvailableRights',           // Extensions only
					'wgCommandLineMode',           // Internal use
					'wgCompiledFiles',             // Extensions only
					'wgConf',                      // Object
					'wgDBmysql4',                  // Deprecated
					'wgDummyLanguageCodes',        // Internal use
					'wgEditEncoding',              // Deprecated
					'wgEnableNewpagesUserFilter',  // Temporary
					'wgEnableSorbs',               // Deprecated
					'wgExceptionHooks',            // Extensions only
					'wgExperimentalHtmlIds',       // Temporary
					'wgExtensionAliasesFiles',     // Extensions only
					'wgExtensionCredits',          // Extensions only
					'wgExtensionFunctions',        // Extensions only
					'wgExtensionMessagesFiles',    // Extensions only
					'wgFeedClasses',               // Needs PHP code
					'wgFilterCallback',            // Needs PHP code
					'wgHooks',                     // Extensions only
					'wgInputEncoding',             // Deprecated
					'wgJobClasses',                // Extensions only
					'wgJobTypesExcludedFromDefaultQueue', // Extensions only
					'wgLegacySchemaConversion',    // Deprecated
					'wgLogActions',                // Extensions only
					'wgLogActionsHandlers',        // Extensions only
					'wgLogHeaders',                // Extensions only
					'wgLogNames',                  // Extensions only
					'wgLogTypes',                  // Extensions only
					'wgMaintenanceScripts',        // Extensions only
					'wgMemCachedDebug',            // Internal use
					'wgObjectCaches',              // Too dificult
					'wgOldChangeTagsIndex',        // Temporary
					'wgOutputEncoding',            // Deprecated
					'wgPagePropLinkInvalidations', // Extensions only
					'wgParserOutputHooks',         // Extensions only
					'wgParserTestFiles',           // Extensions only
					'wgProxyKey',                  // Deprecated
					'wgResourceLoaderSources',     // Extensions only
					'wgResourceModules',           // Extensions only
					'wgSeleniumTestConfigs',       // Needs PHP code
					'wgSkinExtensionFunctions',    // Extensions only
					'wgSpecialPageCacheUpdates',   // Extensions only
					'wgSpecialPages',              // Extensions only
					'wgSorbsUrl',                  // Deprecated
					'wgStyleSheetPath',            // Deprecated
					'wgTrivialMimeDetection',      // Internal use
					'wgUseTeX',                    // Deprecated
					'wgValidSkinNames',            // Extensions only
					'wgVersion',                   // Internal use
				);
			}

			// Now we'll need to open DefaultSettings.php
			$m = array();
			$defaultSettings = file_get_contents( "$IP/includes/DefaultSettings.php" );
			preg_match_all( '/\$(wg[A-Za-z0-9]+)\s*\=/', $defaultSettings, $m );
			$definedSettings = array_unique( $m[1] );

			$missing = array_diff( $definedSettings, $allSettings );
			$remain = array_diff( $allSettings, $definedSettings );

			$reallyMissing = array_diff( $missing, $ignoreList );

			$obsolete = array();
			foreach ( $remain as $setting ) {
				if ( ConfigurationSettings::singleton( CONF_SETTINGS_CORE )->isSettingAvailable( $setting ) )
					$obsolete[] = $setting;
			}

			// let's show the results:
			$this->printArray( 'missing', $reallyMissing );
			$this->printArray( 'obsolete', $obsolete );

			if ( count( $reallyMissing ) == 0 && count( $obsolete ) == 0 )
				$this->output( "Looks good!\n" );
		}
	}
}

$maintClass = 'FindSettings';
require_once( DO_MAINTENANCE );
