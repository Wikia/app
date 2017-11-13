<?php

/**
* Maintenance script to unescape wordmark-text which was double escaped by mistake
* This is one time use script
* @usage
* 	# this will process wordmark-text for wiki with ID 119:
* 	migrateWikiWordmarks --dry-run --wiki 119 --verbose
*   # or
*   /usr/wikia/backend/bin/run_maintenance '--script=wikia/WikiFactoryVariables/unescapeWordmarkText.php --dry-run' --id=119
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
	const KEY_NAME = 'wordmark-text';
	const WIKI_FACTORY_VARIABLE = "wgOasisThemeSettings";

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Unescapes wordmark-text variable in wgOasisThemeSettings";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'file', 'File of wiki ids', false, true, 'f' );
	}

	private function unescape( $value ) {
		$cnt = 0;
		do {
			$cnt++;
			$old_value = $value;
			$value = Sanitizer::decodeCharReferences( $value );
			$value = htmlspecialchars_decode( $value, ENT_QUOTES );
		} while ( $value !== $old_value || $cnt >= 10 );

		return $value;
	}

	public function execute() {
		global $wgCityId;
		$this->dryRun  = $this->hasOption( 'dry-run' );
		$fileName = $this->getOption( 'file', false );
		$wgUser = User::newFromName( Wikia::BOT_USER, false );

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

		if ( !array_key_exists( self::KEY_NAME, $settings ) ) {
			$this->output("Key does not exists for $wgCityId - skipping" . PHP_EOL);
			if ( $fh ) {
				fclose( $fh );
			}
			return false;
		}

		$oldValue = $keyValue = $settings[self::KEY_NAME];

		if ( empty( $keyValue ) ) {
			$this->output( "Key is empty for $wgCityId - skipping" . PHP_EOL );

			if ( $fh ) {
				fclose( $fh );
			}
			return false;
		}

		$this->output( "Updating " . self::KEY_NAME. " for " . $wgCityId . PHP_EOL );

		$keyValue = $this->unescape( $keyValue );

		if ( $keyValue == Sanitizer::decodeCharReferences( $oldValue ) ) {
			$this->output( "Value not changed '" . $keyValue . "' - skipping" . PHP_EOL );

			if ( $fh ) {
				fclose( $fh );
			}
			return false;
		}

		$settings[self::KEY_NAME] = $keyValue;
		$this->output("Setting " . self::KEY_NAME . " to " . var_export( $keyValue, true ) . "for:". $wgCityId .PHP_EOL );
		if ( $fh ) {
			fwrite( $fh, sprintf("%d, \"%s\", \"%s\"\n", $wgCityId, $oldValue, $keyValue));
		}

		if ( !$this->dryRun ) {
			$globalStateWrapper = new Wikia\Util\GlobalStateWrapper( [
				'wgUser' => $wgUser
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

}

$maintClass = "MigrateWikiWordmarks";
require_once( RUN_MAINTENANCE_IF_MAIN );
