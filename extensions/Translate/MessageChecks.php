<?php
/**
 * Message checking framework.
 *
 * @copyright Copyright © 2008-2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class MessageChecker {
	protected $checks = array();
	protected $group  = null;
	private static $globalBlacklist = null;

	public function __construct( MessageGroup $group ) {
		if ( self::$globalBlacklist === null ) {
			$file = dirname( __FILE__ ) . '/check-blacklist.php';
			$list = ResourceLoader::loadVariableFromPHPFile( $file, 'checkBlacklist' );
			$keys = array( 'group', 'check', 'subcheck', 'code', 'message' );
			foreach ( $list as $key => $pattern ) {
				foreach ( $keys as $checkKey ) {
					if ( !isset( $pattern[$checkKey] ) ) {
						$list[$key][$checkKey] = '#';
					} elseif ( is_array( $pattern[$checkKey] ) ) {
						$list[$key][$checkKey] =
							array_map( array( $this, 'foldValue' ), $pattern[$checkKey] );
					} else {
						$list[$key][$checkKey] = $this->foldValue( $pattern[$checkKey] );
					}
				}
			}

			self::$globalBlacklist = $list;
		}

		$this->group = $group;
	}

	protected function foldValue( $value ) {
		return str_replace( ' ', '_', strtolower( $value ) );
	}

	/**
	 * Set the tests for this checker. Array of callables with descriptive keys.
	 * The callbacks will be called with parameters:
	 * - array of TMessages
	 * - language code
	 * - array of warnings (by reference)
	 * To add new warnings, use:
	 * $warnings[$key][] = array(
	 *    array( 'printf', $subcheck, $key, $code ), # check idenfitication
	 *    'translate-checks-parameters-unknown', # check warning message
	 *    array( 'PARAMS', $params ), # special param list, formatted later with $wgLang->commaList
	 *    array( 'COUNT', count($params) ), # number of params, formatted later with $wgLang->formatNum
	 *    'Any other param to the message',
	 * );
	 */
	public function setChecks( $checks ) {
		foreach ( $checks as $k => $c ) {
			if ( !is_callable( $c ) ) {
				unset( $checks[$k] );
				wfWarn( "Check function for check $k is not callable" );
			}
		}
		$this->checks = $checks;
	}

	public function addCheck( $check ) {
		if ( is_callable( $check ) ) {
			$this->checks[] = $check;
		}
	}

	/**
	 * Checks one message, returns array of warnings that can be passed to
	 * OutputPage::addWikiMsg or similar.
	 */
	// Remember to return array!
	public function checkMessage( TMessage $message, $code ) {
		$warningsArray = array();
		$messages = array( $message );
		foreach ( $this->checks as $check ) {
			call_user_func_array( $check, array( $messages, $code, &$warningsArray ) );
		}
		$warningsArray = $this->filterWarnings( $warningsArray );
		if ( !count( $warningsArray ) ) return array();
		$warnings = $warningsArray[$message->key()];
		$warnings = $this->fixMessageParams( $warnings );
		return $warnings;
	}

	/**
	 * Checks one message, returns true if any check matches.
	 * @return bool
	 */
	public function checkMessageFast( TMessage $message, $code ) {
		$warningsArray = array();
		$messages = array( $message );
		foreach ( $this->checks as $check ) {
			call_user_func_array( $check, array( $messages, $code, &$warningsArray ) );
			if ( count( $warningsArray ) ) return true;
		}

		return false;
	}

	/**
	 * Filtering happens after all checks have been run by calling this function.
	 */
	protected function filterWarnings( $warningsArray ) {
		$groupId = $this->group->getId();

		// There is array of messages...
		foreach ( $warningsArray as $mkey => $warnings ) {
			// ... each which have array of warnings
			foreach ( $warnings as $wkey => $warning ) {
				$check = array_shift( $warning );
				foreach ( self::$globalBlacklist as $pattern ) {
					if ( !$this->match( $pattern['group'], $groupId ) ) continue;
					if ( !$this->match( $pattern['check'], $check[0] ) ) continue;
					if ( !$this->match( $pattern['subcheck'], $check[1] ) ) continue;
					if ( !$this->match( $pattern['message'], $check[2] ) ) continue;
					if ( !$this->match( $pattern['code'], $check[3] ) ) continue;
					unset( $warningsArray[$mkey][$wkey] );
				}
			}
		}

	
		return $warningsArray;
	}

	/**
	 * Matches check information against blacklist pattern.
	 */
	protected function match( $pattern, $value ) {
		if ( $pattern === '#' ) {
			return true;
		} elseif ( is_array( $pattern ) ) {
			return in_array( strtolower( $value ), $pattern, true );
		} else {
			return strtolower( $value ) === $pattern;
		}
	}

	/**
	 * Converts the special params to something nice. Currently useless, but
	 * useful if in the future blacklist can work with parameter level too.
	 */
	protected function fixMessageParams( $warnings ) {
		global $wgLang;
		foreach ( $warnings as $wkey => $warning ) {
			array_shift( $warning );
			$message = array( array_shift( $warning ) );
			foreach ( $warning as $param ) {
				if ( !is_array( $param ) ) {
					$message[] = $param;
				} else {
					list( $type, $value ) = $param;
					if ( $type === 'COUNT' ) {
						$message[] = $wgLang->formatNum( $value );
					} elseif ( $type === 'PARAMS' ) {
						$message[] = $wgLang->commaList( $value );
					} else {
						throw new MWException( "Unknown type $type" );
					}
				}
			}
			$warnings[$wkey] = $message;
		}
		return $warnings;
	}

	/**
	 * Compares two arrays return items that don't exist in the latter.
	 */
	protected static function compareArrays( $defs, $trans ) {
		$missing = array();
		foreach ( $defs as $defVar ) {
			if ( !in_array( $defVar, $trans ) ) {
				$missing[] = $defVar;
			}
		}
		return $missing;
	}

	/**
	 * Example check function.
	 * Checks for missing and unknown printf formatting characters in
	 * translations.
	 * @param $messages Iterable list of TMessages.
	 * @param $code Language code of the translations.
	 * @param $warnings Array where warnings are appended to.
	 */
	protected function printfCheck( $messages, $code, &$warnings ) {
		foreach ( $messages as $message ) {
			$key = $message->key();
			$definition = $message->definition();
			$translation = $message->translation();

			preg_match_all( '/%[sd]/U', $definition, $defVars );
			preg_match_all( '/%[sd]/U', $translation, $transVars );

			# Check for missing variables in the translation
			$subcheck = 'missing';
			$params = self::compareArrays( $defVars[0], $transVars[0] );
			if ( count( $params ) ) {
				$warnings[$key][] = array(
					array( 'printf', $subcheck, $key, $code ),
					'translate-checks-parameters',
					array( 'PARAMS', $params ),
					array( 'COUNT', count( $params ) ),
				);
			}

			# Check for unknown variables in the translation
			$subcheck = 'unknown';
			$params = self::compareArrays( $transVars[0], $defVars[0] );
			if ( count( $params ) ) {
				$warnings[$key][] = array(
					array( 'printf', $subcheck, $key, $code ),
					'translate-checks-parameters-unknown',
					array( 'PARAMS', $params ),
					array( 'COUNT', count( $params ) ),
				);
			}
		}
	}

	/**
	 * Checks if the translation has even number of opening and closing
	 * parentheses. {, [ and ( are checked.
	 *
	 * @param $messages Iterable list of TMessages.
	 * @param $code Language code of the translations.
	 * @param $warnings Array where warnings are appended to.
	 */
	protected function braceBalanceCheck( $messages, $code, &$warnings ) {
		foreach ( $messages as $message ) {
			$key = $message->key();
			$translation = $message->translation();
			$translation = preg_replace( '/[^{}[\]()]/u', '', $translation );

			$subcheck = 'brace';
			$counts = array(
				'{' => 0, '}' => 0,
				'[' => 0, ']' => 0,
				'(' => 0, ')' => 0,
			);

			$len = strlen( $translation );
			for ( $i = 0; $i < $len; $i++ ) {
				$char = $translation[$i];
				$counts[$char]++;
			}

			$balance = array();
			if ( $counts['['] !== $counts[']'] ) $balance[] = '[]: ' . ( $counts['['] - $counts[']'] );
			if ( $counts['{'] !== $counts['}'] ) $balance[] = '{}: ' . ( $counts['{'] - $counts['}'] );
			if ( $counts['('] !== $counts[')'] ) $balance[] = '(): ' . ( $counts['('] - $counts[')'] );

			if ( count( $balance ) ) {
				$warnings[$key][] = array(
					array( 'balance', $subcheck, $key, $code ),
					'translate-checks-balance',
					array( 'PARAMS', $balance ),
					array( 'COUNT', count( $balance ) ),
				);
			}
		}
	}

}