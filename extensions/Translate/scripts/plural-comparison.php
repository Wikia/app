<?php
/**
 * Script for comparing different plural implementations.
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

/// Script for comparing different plural implementations.
class PluralCompare extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Script for comparing different plural implementations.';
	}

	public function execute() {
		$mwLanguages = $this->loadMediaWiki();
		$gtLanguages = $this->loadGettext();
		$clLanguages = $this->loadCLDR();

		$allkeys = array_keys( $mwLanguages + $gtLanguages + $clLanguages );
		sort( $allkeys );

		$this->output( sprintf( "%12s %3s %3s %4s\n", 'Code', 'MW', 'Get', 'CLDR' ) );
		foreach ( $allkeys as $index => $code ) {
			$mw = isset( $mwLanguages[$code] ) ? ( $mwLanguages[$code] === false ? '.' : '+' ) : '';
			$gt = isset( $gtLanguages[$code] ) ? ( $gtLanguages[$code] === '(n != 1);' ? '.' : '+' ) : '';
			$cl = isset( $clLanguages[$code] ) ? ( $clLanguages[$code][0] === 'Default' ? '.' : '+' ) : '';
			$this->output( sprintf( "%12s %-3s %-3s %-4s\n", $code, $mw, $gt, $cl ) );

			if ( substr_count( sprintf( '%s%s%s', $mw, $gt, $cl ), '+' ) < 2 ) {
				unset( $allkeys[$index] );
			}
		}

		$this->output( "\n" );
		$c = count( $allkeys );
		$this->output( "Proceeding to test differences in $c languages\n" );

		foreach ( $allkeys as $code ) {
			$output = sprintf( "%3s %3s %3s %4s for [$code]\n", 'I', 'MW', 'Get', 'CLDR' );

			if ( isset( $mwLanguages[$code] ) && $mwLanguages[$code] !== false ) {
				$obj = Language::factory( $code );
			} else {
				$obj = false;
			}

			if ( isset( $gtLanguages[$code] ) ) {
				$gtExp = 'return (int) ' . str_replace( 'n', '$i', $gtLanguages[$code] ) . ';';
			} else {
				$gtExp = false;
			}

			if ( isset( $clLanguages[$code] ) ) {
				$cldrExp = $clLanguages[$code][1];
			} else {
				$cldrExp = false;
			}

			$cldrmap = array();
			$error = false;

			for ( $i = 0; $i <= 200; $i++ ) {
				$mw = $obj ? $obj->convertPlural( $i, array( 0, 1, 2, 3, 4, 5 ) ) : '?';
				$gt = $gtExp ? eval( $gtExp ) : '?';
				$cldr = $cldrExp !== false ? $this->evalCLDRRule( $i, $cldrExp ) : '?';

				if ( self::comp( $mw, $gt ) ) {
					$value = $gt !== '?' ? $gt : $mw;
					if ( !isset( $cldrmap[$cldr] ) ) {
						$cldrmap[$cldr] = $value;
						if ( $cldr !== '?' ) {
							$output .= sprintf( "%3s %-3s %-3s %-6s # Established that %-6s == $mw\n", $i, $mw, $gt, $cldr, $cldr );
						}
						continue;
					} elseif ( self::comp( $cldrmap[$cldr], $value ) ) {
						continue;
					} elseif ( $i > 4 && $value === 1 && self::comp( $cldr, 'other' ) ) {
						if ( $i === 5 ) {
							$output .= "Supressing further output for this language.\n";
						}
						continue;
					}
				}
				$error = true;
				$output .= sprintf( "%3s %-3s %-3s %-6s\n", $i, $mw, $gt, $cldr );
			}

			if ( $error ) {
				$this->output( "$output\n" );
			}
		}

	}

	public static function comp( $a, $b ) {
		return $a === '?' || $b === '?' || $a === $b;
	}

	public function loadCLDR() {
		$filename = dirname( __FILE__ ) . '/../data/plural-cldr.yaml';
		$data = TranslateYaml::load( $filename );
		$languages = array();
		$ruleExps = array();
		foreach ( $data['rulesets'] as $name => $rules ) {
			$ruleExps[$name] = array();
			foreach ( $rules as $rulename => $rule ) {
				$ruleExps[$name][$rulename] = $this->parseCLDRRule( $rule );
			}
		}

		foreach ( $data['locales'] as $code => $rulename ) {
			$languages[$code] = array( $rulename, $ruleExps[$rulename] );
		}

		return $languages;
	}

	public function loadMediaWiki() {
		$mwLanguages = Language::getLanguageNames( true );
		foreach ( $mwLanguages as $code => $name ) {
			$obj = Language::factory( $code );
			$method = new ReflectionMethod( $obj, 'convertPlural' );
			if ( $method->getDeclaringClass()->name === 'Language' ) {
				$mwLanguages[$code] = false;
			}
		}
		return $mwLanguages;
	}

	public function loadGettext() {
		$gtData = file_get_contents( dirname( __FILE__ ) . '/../data/plural-gettext.txt' );
		$gtLanguages = array();
		foreach ( preg_split( '/\n|\r/', $gtData, -1, PREG_SPLIT_NO_EMPTY ) as $line ) {
			list( $code, $rule ) = explode( "\t", $line );
			$rule = preg_replace( '/^.*?plural=/', '', $rule );
			$gtLanguages[$code] = $rule;
		}
		return $gtLanguages;
	}

	public function evalCLDRRule( $i, $rules ) {
		foreach ( $rules as $name => $rule ) {
			if ( eval( "return $rule;" ) ) {
				return $name;
			}
		}

		return "other";
	}

	public function parseCLDRRule( $rule ) {
		$rule = preg_replace( '/\bn\b/', '$i', $rule );
		$rule = preg_replace( '/([^ ]+) mod (\d+)/', 'self::mod(\1,\2)', $rule );
		$rule = preg_replace( '/([^ ]+) is not (\d+)/' , '\1!==\2', $rule );
		$rule = preg_replace( '/([^ ]+) is (\d+)/', '\1===\2', $rule );
		$rule = preg_replace( '/([^ ]+) not in (\d+)\.\.(\d+)/', '!self::in(\1,\2,\3)', $rule );
		$rule = preg_replace( '/([^ ]+) not within (\d+)\.\.(\d+)/', '!self::within(\1,\2,\3)', $rule );
		$rule = preg_replace( '/([^ ]+) in (\d+)\.\.(\d+)/', 'self::in(\1,\2,\3)', $rule );
		$rule = preg_replace( '/([^ ]+) within (\d+)\.\.(\d+)/', 'self::within(\1,\2,\3)', $rule );
		// AND takes precedence over OR
		$andrule = '/([^ ]+) and ([^ ]+)/i';
		while ( preg_match( $andrule, $rule ) ) {
			$rule = preg_replace( $andrule, '(\1&&\2)', $rule );
		}
		$orrule = '/([^ ]+) or ([^ ]+)/i';
		while ( preg_match( $orrule, $rule ) ) {
			$rule = preg_replace( $orrule, '(\1||\2)', $rule );
		}

		return $rule;
	}

	public static function in( $num, $low, $high ) {
		return is_int( $num ) && $num >= $low && $num <= $high;
	}

	public static function within( $num, $low, $high ) {
		return $num >= $low && $num <= $high;
	}

	public static function mod( $num, $mod ) {
		if ( is_int( $num ) ) {
			return (int) fmod( $num, $mod );
		}
		return fmod( $num, $mod );
	}

}

$maintClass = 'PluralCompare';
require_once( DO_MAINTENANCE );
