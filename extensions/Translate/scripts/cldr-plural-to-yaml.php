<?php
/**
 * Script to format CLDR plural definitions to more usable format.
 *
 * @author Niklas Laxstrom
 *
 * @copyright Copyright © 2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

// Standard boilerplate to define $IP
if ( getenv( 'MW_INSTALL_PATH' ) !== false ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$dir = dirname( __FILE__ ); $IP = "$dir/../../..";
}
require_once( "$IP/maintenance/Maintenance.php" );

/** Script to format CLDR plural definitions to more usable format.
 * plurals.xml from core.zip must be in the current directory.
 * The script will output plural-CLDR.yaml into current directory.
 */
class CLDRPluralToYaml extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Script to format CLDR plural definitions to more usable format';
	}

	public function execute() {
		$outRulesets = array();
		$outLocales = array();

		$doc = new DOMDocument();
		$doc->load( 'plurals.xml' );

		$rulesets = $doc->getElementsByTagName( "pluralRules" );
		foreach ( $rulesets as $ruleset ) {
			$codes = $ruleset->getAttribute( 'locales' );
			$parsed = array();
			$rules = $ruleset->getElementsByTagName( "pluralRule" );
			foreach ( $rules as $rule ) {
				$parsed[$rule->getAttribute( 'count' )] = $rule->nodeValue;
			}

			$name = "Rule " . chr( count( $outRulesets ) + 65 );

			// Special names for some rules... might not be useful at all
			if ( count( $parsed ) === 0 ) {
				$name = "Zero";
			} elseif ( $codes === 'ar' ) {
				$name = "Arabic";
			} elseif ( count( $parsed ) === 1 ) {
				if ( isset( $parsed['one'] ) && $parsed['one'] === 'n is 1' ) {
					$name = "Default";
				} elseif ( isset( $parsed['one'] ) && $parsed['one'] === 'n in 0..1' ) {
					$name = "One-zero";
				}
			} elseif ( count( $parsed ) === 2 ) {
				if ( isset( $parsed['one'] ) && isset( $parsed['two'] ) ) {
					$name = "Has-dual";
				}
			}

			$outRulesets[$name] = $parsed;

			foreach ( explode( ' ', $codes ) as $code ) {
				$outLocales[$code] = $name;
			}
		}

		file_put_contents( 'plural-cldr.yaml', TranslateYaml::dump( array(
			'locales' => $outLocales,
			'rulesets' => $outRulesets,
		) ) );
	}
}

$maintClass = 'CLDRPluralToYaml';
require_once( DO_MAINTENANCE );
