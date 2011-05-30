<?php
/**
 * %Message checking framework.
 *
 * @file
 * @defgroup MessageCheckers Message Checkers
 *
 */

/**
 * Message checkers try to find common mistakes so that translators can fix
 * them quickly. To implement your own checks, extend this class and add a
 * method of the following type:
 * @code
 * protected function myCheck( $messages, $code, &$warnings ) {
 * 	foreach ( $messages as $message ) {
 * 		$key = $message->key();
 * 		$translation = $message->translation();
 * 		if ( strpos( $translation, 'smelly' ) !== false ) {
 * 			$warnings[$key][] = array(
 * 				array( 'badword', 'smelly', $key, $code ),
 * 				'translate-checks-badword', // Needs to be defined in i18n file
 * 				array( 'PARAMS', 'smelly' ),
 * 			);
 * 		}
 * 	}
 * }
 * @endcode
 *
 * Warnings are of format: <pre>
 * $warnings[$key][] = array(
 *    array( 'printf', $subcheck, $key, $code ), # check idenfitication
 *    'translate-checks-parameters-unknown', # check warning message
 *    array( 'PARAMS', $params ), # optional special param list, formatted later with Language::commaList()
 *    array( 'COUNT', count($params) ), # optional number of params, formatted later with Language::formatNum()
 *    'Any other parameters to the message',
 * </pre>
 *
 * @ingroup MessageCheckers
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class MessageChecker {
	protected $checks = array();
	protected $group  = null;
	private static $globalBlacklist = null;

	/**
	 * Cosntructs a suitable checker for given message group.
	 * @param $group MessageGroup
	 */
	public function __construct( MessageGroup $group ) {
		if ( self::$globalBlacklist === null ) {
			$file = dirname( __FILE__ ) . '/check-blacklist.php';
			$list = PHPVariableLoader::loadVariableFromPHPFile( $file, 'checkBlacklist' );
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

	/**
	 * Normalises check keys.
	 * @param $value \string check key
	 * @return \string normalised check key
	 */
	protected function foldValue( $value ) {
		return str_replace( ' ', '_', strtolower( $value ) );
	}

	/**
	 * Set the tests for this checker. Array of callables with descriptive keys.
	 * @param $checks \array List of checks (suitable methods in this class)
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

	/**
	 * Adds one tests for this checker.
	 * @see setChecks()
	 */
	public function addCheck( $check ) {
		if ( is_callable( $check ) ) {
			$this->checks[] = $check;
		}
	}

	/**
	 * Checks one message, returns array of warnings that can be passed to
	 * OutputPage::addWikiMsg or similar.
	 *
	 * @param $message TMessage
	 * @param $code \string Language code
	 * @return \array
	 */
	public function checkMessage( TMessage $message, $code ) {
		$warningsArray = array();
		$messages = array( $message );

		foreach ( $this->checks as $check ) {
			call_user_func_array( $check, array( $messages, $code, &$warningsArray ) );
		}

		$warningsArray = $this->filterWarnings( $warningsArray );
		if ( !count( $warningsArray ) ) {
			return array();
		}

		$warnings = $warningsArray[$message->key()];
		$warnings = $this->fixMessageParams( $warnings );

		return $warnings;
	}

	/**
	 * Checks one message, returns true if any check matches.
	 * @param $message TMessage
	 * @param $code \string Language code
	 * @return \bool True if there is a problem, false otherwise.
	 */
	public function checkMessageFast( TMessage $message, $code ) {
		$warningsArray = array();
		$messages = array( $message );

		foreach ( $this->checks as $check ) {
			call_user_func_array( $check, array( $messages, $code, &$warningsArray ) );
			if ( count( $warningsArray ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Filters warnings defined in check-blacklist.php.
	 * @param $warningsArray \array List of warnings produces by checkMessage().
	 * @return \array List of filtered warnings.
	 */
	protected function filterWarnings( $warningsArray ) {
		$groupId = $this->group->getId();

		// There is an array of messages...
		foreach ( $warningsArray as $mkey => $warnings ) {
			// ... each which has an array of warnings.
			foreach ( $warnings as $wkey => $warning ) {
				$check = array_shift( $warning );
				// Check if the key is blacklisted...
				foreach ( self::$globalBlacklist as $pattern ) {
					if ( !$this->match( $pattern['group'], $groupId ) )     continue;
					if ( !$this->match( $pattern['check'], $check[0] ) )    continue;
					if ( !$this->match( $pattern['subcheck'], $check[1] ) ) continue;
					if ( !$this->match( $pattern['message'], $check[2] ) )  continue;
					if ( !$this->match( $pattern['code'], $check[3] ) )     continue;

					// If all of the aboce match, filter the check
					unset( $warningsArray[$mkey][$wkey] );
				}
			}
		}

		return $warningsArray;
	}

	/**
	 * Matches check information against blacklist pattern.
	 * @param $pattern \string
	 * @param $value \string The actual value in the warnings produces by the check
	 * @return \bool True of the pattern matches the value.
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
	 * @param $warnings \array List of warnings
	 * @return List of warning messages with parameters.
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
	 * @param $defs \array
	 * @param $trans \array
	 * @return Items of $defs that are not in $trans.
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
	 * Checks for missing and unknown printf formatting characters in
	 * translations.
	 * @param $messages \mixed Iterable list of TMessage objects.
	 * @param $code \string Language code
	 * @param $warnings \array Array where warnings are appended to.
	 */
	protected function printfCheck( $messages, $code, &$warnings ) {
		return $this->parameterCheck( $messages, $code, $warnings, '/%(\d+\$)?[sduf]/U' );
	}

	/**
	 * Checks for missing and unknown python string interpolation operators in
	 * translations.
	 * @param $messages \mixed Iterable list of TMessage objects.
	 * @param $code \string Language code
	 * @param $warnings \array Array where warnings are appended to.
	 */
	protected function pythonInterpolationCheck( $messages, $code, &$warnings ) {
		return $this->parameterCheck( $messages, $code, $warnings, '/\%\([a-zA-Z0-9]*?\)[diouxXeEfFgGcrs]/U' );
	}

	/**
	 * Checks if the translation has even number of opening and closing
	 * parentheses. {, [ and ( are checked.
	 * @param $messages \mixed Iterable list of TMessage objects.
	 * @param $code \string Language code
	 * @param $warnings \array Array where warnings are appended to.
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
			if ( $counts['['] !== $counts[']'] ) {
				$balance[] = '[]: ' . ( $counts['['] - $counts[']'] );
			}

			if ( $counts['{'] !== $counts['}'] ) {
				$balance[] = '{}: ' . ( $counts['{'] - $counts['}'] );
			}

			if ( $counts['('] !== $counts[')'] ) {
				$balance[] = '(): ' . ( $counts['('] - $counts[')'] );
			}

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

	/**
	 * Checks for missing and unknown printf formatting characters in
	 * translations.
	 * @param $messages \mixed Iterable list of TMessage objects.
	 * @param $code \string Language code
	 * @param $warnings \array Array where warnings are appended to.
	 * @param $pattern \string Regular expression for matching variables.
	 */
	protected function parameterCheck( $messages, $code, &$warnings, $pattern ) {
		foreach ( $messages as $message ) {
			$key = $message->key();
			$definition = $message->definition();
			$translation = $message->translation();

			preg_match_all( $pattern, $definition, $defVars );
			preg_match_all( $pattern, $translation, $transVars );

			// Check for missing variables in the translation
			$subcheck = 'missing';
			$params = self::compareArrays( $defVars[0], $transVars[0] );

			if ( count( $params ) ) {
				$warnings[$key][] = array(
					array( 'variable', $subcheck, $key, $code ),
					'translate-checks-parameters',
					array( 'PARAMS', $params ),
					array( 'COUNT', count( $params ) ),
				);
			}

			// Check for unknown variables in the translatio
			$subcheck = 'unknown';
			$params = self::compareArrays( $transVars[0], $defVars[0] );

			if ( count( $params ) ) {
				$warnings[$key][] = array(
					array( 'variable', $subcheck, $key, $code ),
					'translate-checks-parameters-unknown',
					array( 'PARAMS', $params ),
					array( 'COUNT', count( $params ) ),
				);
			}
		}
	}

	protected function balancedTagsCheck( $messages, $code, &$warnings ) {
		foreach ( $messages as $message ) {
			$key = $message->key();
			$translation = $message->translation();

			libxml_use_internal_errors( true );
			libxml_clear_errors();
			$doc = simplexml_load_string( Xml::tags( 'root', null, $translation ) );
			if ( $doc ) continue;

			$errors = libxml_get_errors();
			$params = array();
			foreach ( $errors as $error ) {
				if ( $error->code !== 76 && $error->code !== 73 ) continue;
				$params[] = "<br />• [{$error->code}] $error->message";
			}

			if ( !count( $params ) ) continue;

			$warnings[$key][] = array(
				array( 'tags', 'balance', $key, $code ),
				'translate-checks-format',
				array( 'PARAMS', $params ),
				array( 'COUNT', count( $params ) ),
			);
		}

		libxml_clear_errors();
	}

}
