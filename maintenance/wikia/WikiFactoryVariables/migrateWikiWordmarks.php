<?php

/**
* Maintenance script to manage WikiFactory variable for one wiki or multiple wikis (from file)
* - enable/disable the extension (set to true/false)
* - set value to the variable (only string, integer, boolean types)
* - remove variable from the wiki
* - get the variable value
* This is one time use script
* @usage
* 	# this will migrate wordmark-image-url for wiki with ID 119:
* 	migrateWikiWordmarks --dry-run --wiki 119 --verbose --keyName wordmark-image-url
*   # or
*   /usr/wikia/backend/bin/run_maintenance '--script=wikia/WikiFactoryVariables/migrateWikiWordmarks.php --dry-run --verbose --keyName wordmark-image-url' --id=119
*/

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

use \Wikia\Logger\WikiaLogger;

/**
 * Class MigrateWikiWordmarks
 */
class MigrateWikiWordmarks extends Maintenance {

	protected $dryRun  = false;
	protected $verbose = false;
	protected $keyName = '';
	const WIKI_FACTORY_VARIABLE = "wgOasisThemeSettings";

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Migrates variables in wgOasisThemeSettings to HTTPS";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'keyName', 'Key in WikiFactory variable which should be migrated to https', true, true, 'k' );
		$this->addOption( 'file', 'File of wiki ids', false, true, 'f' );
	}

	public function getWordmarkUrl( $wordmarkUrl ) {
		global $wgCityId;

		$wgUploadPath = WikiFactory::getVarValueByName(
			'wgUploadPath',
			$wgCityId
		);

		if ( !VignetteRequest::isVignetteUrl( $wordmarkUrl ) ) {
			$wordmarkPath = explode( '/images/', $wordmarkUrl )[0];

			if ( !empty( $wordmarkPath ) ) {
				$wordmarkUrl = str_replace(
					$wordmarkPath . '/images',
					$wgUploadPath,
					$wordmarkUrl
				);
			}

			$wordmarkUrl = wfReplaceImageServer( $wordmarkUrl, SassUtil::getCacheBuster() );
		}

		return $wordmarkUrl;
	}

	public function execute() {
		global $wgCityId, $wgMedusaHostPrefix;
		$this->dryRun  = $this->hasOption( 'dry-run' );
		$this->verbose = $this->hasOption( 'verbose' );
		$this->keyName = $this->getOption( 'keyName', '' );
		$fileName = $this->getOption( 'file', false );

		if ( empty( $this->keyName ) ) {
			$this->error( "Error: Empty key name." . PHP_EOL );
			return false;
		}

		$varData = (array) WikiFactory::getVarByName( self::WIKI_FACTORY_VARIABLE, $wgCityId, true );
		if ( empty( $varData['cv_id'] ) ) {
			$this->error( "Error: " . self::WIKI_FACTORY_VARIABLE . " not found." . PHP_EOL );
			return false;
		}

		$themeSettings = new ThemeSettings( $wgCityId );

		$fh = false;
		if ( $fileName ) {
			$fh = fopen( $fileName, "a" );
			if ( !$fh ) {
				$this->error( "Could not open file '$fileName' for write!'" . PHP_EOL );
				return false;
			}
		}

		$settings = $themeSettings->getSettings();

		if ( !array_key_exists( $this->keyName, $settings ) ) {
			$this->output("Key does not exists for $wgCityId - skipping" . PHP_EOL);
			if ( $fh ) {
				fclose( $fh );
			}
			return false;
		}

		$oldValue = $keyValue = $settings[$this->keyName];
		if ( $this->keyName == "wordmark-image-url" ) {
			$oldFinalValue = $themeSettings->getWordmarkUrl();
		} else {
			$oldFinalValue = wfReplaceImageServer( $oldValue, time() );
		}

		if ( empty( $keyValue ) ) {
			$this->output( "Key is empty for $wgCityId - skipping" . PHP_EOL );

			if ( $fh ) {
				fclose( $fh );
			}
			return false;
		}

		$this->output( "Updating {$this->keyName} for " . $wgCityId . PHP_EOL );

		$keyValue = str_replace( 'http://', 'https://',
			str_replace( "//{$wgMedusaHostPrefix}images", '//' . str_replace( '.', '-', $wgMedusaHostPrefix ) . 'images', $keyValue ) );

		if ( $keyValue == $oldValue ) {
			$this->output( "Value not changed " . $keyValue . "- skipping" . PHP_EOL );

			if ( $fh ) {
				fclose( $fh );
			}
			return false;
		}

		$settings[$this->keyName] = $keyValue;
		if ( $this->keyName == "wordmark-image-url" ) {
			$newFinalValue = $this->getWordmarkUrl( $keyValue );
		} else {
			$newFinalValue = wfReplaceImageServer( $keyValue, time() );
		}
		$this->debug("Setting " . $this->keyName . " to " . var_export( $keyValue, true ) . "for:". $wgCityId .PHP_EOL );
		if ( $fh ) {
			fwrite( $fh, sprintf("%d, \"%s\", \"%s\", \"%s\", \"%s\"\n", $wgCityId, $oldValue, $oldFinalValue, $keyValue, $newFinalValue));
		}

		if ( !$this->dryRun ) {
			// Related to SUS-2942 - we cannot change a setting that is not in defaultSettings
			$refObject = new ReflectionObject( $themeSettings );
			$refProperty = $refObject->getProperty( 'defaultSettings' );
			$refProperty->setAccessible( true );
			$defaultSettings = $refProperty->getValue( $themeSettings );
			if ( !array_key_exists( $defaultSettings, $this->keyName ) ) {
				$defaultSettings[ $this->keyName ] = '';
				$refProperty->setValue( $themeSettings, $defaultSettings );
			}
			$globalStateWrapper = new Wikia\Util\GlobalStateWrapper( [
				'wgUser' => User::newFromName( Wikia::BOT_USER, false )
			] );

			$globalStateWrapper->wrap( function () use ( $themeSettings, $settings ) {
				$themeSettings->saveSettings( $settings );
			} );
		}

		if ( $fh ) {
			fclose( $fh );
		}

		$this->output(" ... DONE." . PHP_EOL );
	}

	/**
	 * Print the message if verbose is enabled
	 * @param $msg
	 */
	protected function debug( $msg ) {
		if ( $this->verbose ) {
			$this->output( $msg );
		}
	}

}

$maintClass = "MigrateWikiWordmarks";
require_once( RUN_MAINTENANCE_IF_MAIN );
