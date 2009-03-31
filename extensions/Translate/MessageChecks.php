<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Some checks for common mistakes in translations.
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class MessageChecks {

	// Fastest first
	var $checksForType = array(
		'mediawiki' => array(
			'checkPlural',
			'checkParameters',
			'checkUnknownParameters',
			'checkBalance',
			'checkLinks',
			'checkXHTML',
			'checkPagename',
			'miscMWChecks',
		),
		'freecol' => array(
			'checkFreeColMissingVars',
			'checkFreeColExtraVars',
		),
		'mantis' => array(
			'checkPrintfMissingVars',
			'checkPrintfExtraVars',
			'checkBalance',
		),
		'voctrain' => array(
			'checkI18nSprintMissingVars',
			'checkI18nSprintExtraVars',
			'checkBalance',
		),
	);

	private function __construct() {
		$file = dirname( __FILE__ ) . '/check-blacklist.php';
		$this->blacklist =
			ResourceLoader::loadVariableFromPHPFile( $file, 'checkBlacklist' );
	}

	public static function getInstance() {
		static $obj = null;
		if ( $obj === null ) {
			$obj = new MessageChecks;
		}
		return $obj;
	}

	public function hasChecks( $type ) {
		return isset( $this->checksForType[$type] );
	}

	/**
	 * Entry point which runs all checks.
	 *
	 * @param $message Instance of TMessage.
	 * @return Array of warning messages, html-format.
	 */
	public function doChecks( TMessage $message, $type, $code ) {
		if ( $message->translation === null ) return array();
		$warnings = array();

		foreach ( $this->checksForType[$type] as $check ) {
			$warning = '';
			if ( $this->$check( $message, $code, $warning ) ) {
				$warnings[] = $warning;
			}
		}

		return $warnings;
	}

	public function doFastChecks( TMessage $message, $type, $code ) {
		if ( $message->translation === null ) return false;

		foreach ( $this->checksForType[$type] as $check ) {
			if ( $this->$check( $message, $code ) ) return true;
		}

		return false;
	}

	/**
	 * Checks if the translation uses all variables $[1-9] that the definition
	 * uses.
	 *
	 * @param $message Instance of TMessage.
	 * @return Array of unused parameters.
	 */
	protected function checkParameters( TMessage $message, $code, &$desc = null ) {
		$variables = array( '\$1', '\$2', '\$3', '\$4', '\$5', '\$6', '\$7', '\$8', '\$9' );

		$missing = array();
		$definition = $message->definition;
		$translation = $message->translation;
		if ( strpos( $definition, '$' ) === false ) return false;

		for ( $i = 1; $i < 10; $i++ ) {
			$pattern = '/\$' . $i . '/s';
			if ( preg_match( $pattern, $definition ) && !preg_match( $pattern, $translation ) ) {
				$missing[] = '$' . $i;
			}
		}

		if ( $count = count( $missing ) ) {
			global $wgLang;
			$desc = array( 'translate-checks-parameters',
				implode( ', ', $missing ),
				$wgLang->formatNum( $count ) );
			return true;
		}

		return false;
	}

	protected function checkUnknownParameters( TMessage $message, $code, &$desc = null ) {
		$variables = array( '\$1', '\$2', '\$3', '\$4', '\$5', '\$6', '\$7', '\$8', '\$9' );

		$missing = array();
		$definition = $message->definition;
		$translation = $message->translation;
		if ( strpos( $translation, '$' ) === false ) return false;

		for ( $i = 1; $i < 10; $i++ ) {
			$pattern = '/\$' . $i . '/s';
			if ( !preg_match( $pattern, $definition ) && preg_match( $pattern, $translation ) ) {
				$missing[] = '$' . $i;
			}
		}

		if ( $count = count( $missing ) ) {
			global $wgLang;
			$desc = array( 'translate-checks-parameters-unknown',
				implode( ', ', $missing ),
				$wgLang->formatNum( $count ) );
			return true;
		}

		return false;
	}

	/**
	 * Checks if the translation has even number of opening and closing
	 * parentheses. {, [ and ( are checked.
	 *
	 * @param $message Instance of TMessage.
	 * @return Array of unbalanced paranthesis pairs with difference of opening
	 * and closing count as value.
	 */
	protected function checkBalance( TMessage $message, $code, &$desc = null ) {
		$translation = preg_replace( '/[^{}[\]()]/u', '', $message->translation );
		$counts = array( '{' => 0, '}' => 0, '[' => 0, ']' => 0, '(' => 0, ')' => 0 );

		$i = 0;
		$len = strlen( $translation );
		while ( $i < $len ) {
			$char = $translation[$i];
			isset( $counts[$char] ) ? $counts[$char]++ : var_dump( $char );
			$i++;
		}

		$balance = array();
		if ( $counts['['] !== $counts[']'] ) $balance[] = '[]: ' . ( $counts['['] - $counts[']'] );
		if ( $counts['{'] !== $counts['}'] ) $balance[] = '{}: ' . ( $counts['{'] - $counts['}'] );
		if ( $counts['('] !== $counts[')'] ) $balance[] = '(): ' . ( $counts['('] - $counts[')'] );

		if ( $count = count( $balance ) ) {
			global $wgLang;
			$desc = array( 'translate-checks-balance',
				implode( ', ', $balance ),
				$wgLang->formatNum( $count ) );
			return true;
		}

		return false;
	}

	/**
	 * Checks if the translation uses links that are discouraged. Valid links are
	 * those that link to Special: or {{ns:special}}: or project pages trough
	 * MediaWiki messages like {{MediaWiki:helppage-url}}:. Also links in the
	 * definition are allowed.
	 *
	 * @param $message Instance of TMessage.
	 * @return Array of problematic links.
	 */
	protected function checkLinks( TMessage $message, $code, &$desc = null ) {
		if ( strpos( $message->translation, '[[' ) === false ) return false;

		$matches = array();
		$links = array();
		$tc = Title::legalChars() . '#%{}';
		preg_match_all( "/\[\[([{$tc}]+)(?:\\|(.+?))?]]/sDu", $message->translation, $matches );
		for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
			// if ( preg_match( '/({{ns:)?special(}})?:.*/sDui', $matches[1][$i] ) ) continue;
			// if ( preg_match( '/{{mediawiki:.*}}/sDui', $matches[1][$i] ) ) continue;
			// if ( preg_match( '/user([ _]talk)?:.*/sDui', $matches[1][$i] ) ) continue;
			// if ( preg_match( '/:?\$[1-9]/sDu', $matches[1][$i] ) ) continue;

			$backMatch = preg_quote( $matches[1][$i], '/' );
			if ( preg_match( "/$backMatch/", $message->definition ) ) continue;

			$links[] = "[[{$matches[1][$i]}|{$matches[2][$i]}]]";
		}

		if ( $count = count( $links ) ) {
			global $wgLang;
			$desc = array( 'translate-checks-links',
				implode( ', ', $links ),
				$wgLang->formatNum( $count ) );
			return true;
		}

		return false;
	}

	/**
	 * Checks if the <br /> and <hr /> tags are using the correct syntax.
	 *
	 * @param $message Instance of TMessage.
	 * @return Array of tags in invalid syntax with correction suggestions as
	 * value.
	 */
	protected function checkXHTML( TMessage $message, $code, &$desc = null ) {
		$translation = $message->translation;
		if ( strpos( $translation, '<' ) === false ) return false;

		$tags = array(
			'~<hr *(\\\\)?>~suDi' => '<hr />', // Wrong syntax
			'~<br *(\\\\)?>~suDi' => '<br />',
			'~<hr/>~suDi' => '<hr />', // Wrong syntax
			'~<br/>~suDi' => '<br />',
			'~<(HR|Hr|hR) />~su' => '<hr />', // Case
			'~<(BR|Br|bR) />~su' => '<br />',
		);

		$wrongTags = array();
		foreach ( $tags as $wrong => $correct ) {
			$matches = array();
			preg_match_all( $wrong, $translation, $matches, PREG_PATTERN_ORDER );
			foreach ( $matches[0] as $wrongMatch ) {
				$wrongTags[$wrongMatch] = "$wrongMatch → $correct";
			}
		}

		if ( $count = count( $wrongTags ) ) {
			global $wgLang;
			$desc = array( 'translate-checks-xhtml',
				implode( ', ', $wrongTags ),
				$wgLang->formatNum( $count ) );
			return true;
		}

		return false;
	}

	/**
	 * Checks if the translation doesn't use plural while the definition has one.
	 *
	 * @param $message Instance of TMessage.
	 * @return True if plural magic word is missing.
	 */
	protected function checkPlural( TMessage $message, $code, &$desc = null ) {
		if ( isset( $this->blacklist[$code] )
			&& in_array( 'plural', $this->blacklist[$code] ) )
			return false;

		$definition = $message->definition;
		$translation = $message->translation;
		if ( stripos( $definition, '{{plural:' ) !== false &&
			stripos( $translation, '{{plural:' ) === false ) {
			$desc = array( 'translate-checks-plural' );
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Checks for page names having untranslated namespace.
	 *
	 * @param $message Instance of TMessage.
	 * @return True if namespace has been tampered with.
	 */
	protected function checkPagename( TMessage $message, $code, &$desc = null ) {
		$definition = $message->definition;
		$translation = $message->translation;

		$namespaces = 'help|project|\{\{ns:project}}|mediawiki';
		$matches = array();
		if ( preg_match( "/^($namespaces):[\w\s]+$/ui", $definition, $matches ) ) {
			if ( !preg_match( "/^{$matches[1]}:.+$/u", $translation ) ) {
				$desc = array( 'translate-checks-pagename' );
				return true;
			}
		}
		return false;
	}

	/**
	 * Checks for some miscellaneous messages with special syntax.
	 *
	 * @param $message Instance of TMessage.
	 * @return True if namespace has been tampered with.
	 */
	protected function miscMWChecks( TMessage $message, $code, &$desc = null ) {
		$timeList = array( 'protect-expiry-options', 'ipboptions' );
		if ( in_array( strtolower($message->key), $timeList, true ) ) {
			$defArray = explode( ',', $message->definition );
			$traArray = explode( ',', $message->translation );

			$defCount = count($defArray);
			$traCount = count($traArray);
			if ( $defCount !== $traCount ) {
				$desc = array( 'translate-checks-format', "Parameter count is $traCount; should be $defCount" );
				return true;
			}
			for ( $i = 0; $i < count($defArray); $i++ ) {
				$defItems = array_map( 'trim', explode( ':', $defArray[$i] ) );
				$traItems = array_map( 'trim', explode( ':', $traArray[$i] ) );
				if ( count($traItems) !== 2 ) {
					$desc = array( 'translate-checks-format', "<nowiki>$traArray[$i]</nowiki> is malformed" );
					return true;
				}
				if ( $traItems[1] !== $defItems[1] ) {
					$desc = array( 'translate-checks-format', "<tt><nowiki>$traItems[1] !== $defItems[1]</nowiki></tt>" );
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Checks for translations not containing vars %xx% that are in the
	 * definition.
	 *
	 * @param $message Instance of TMessage.
	 * @return True if namespace has been tampered with.
	 */
	protected function checkFreeColMissingVars( TMessage $message, $code, &$desc = null ) {
		$varPattern = '%[a-zA-Z_]+%';

		if ( !preg_match_all( "/$varPattern/U", $message->definition, $defVars ) ) {
			return false;
		}
		preg_match_all( "/$varPattern/U", $message->translation, $transVars );

		$missing = self::compareArrays( $defVars[0], $transVars[0] );

		if ( $count = count( $missing ) ) {
			global $wgLang;
			$desc = array( 'translate-checks-parameters',
				implode( ', ', $missing ),
				$wgLang->formatNum( $count ) );
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Checks for translations containing vars %xx% that are not in the
	 * definition.
	 *
	 * @param $message Instance of TMessage.
	 * @return True if namespace has been tampered with.
	 */
	protected function checkFreeColExtraVars( TMessage $message, $code, &$desc = null ) {
		$varPattern = '%[a-zA-Z_]+%';

		preg_match_all( "/$varPattern/U", $message->definition, $defVars );
		preg_match_all( "/$varPattern/U", $message->translation, $transVars );

		$missing = self::compareArrays( $transVars[0], $defVars[0] );

		if ( $count = count( $missing ) ) {
			global $wgLang;
			$desc = array( 'translate-checks-parameters-unknown',
				implode( ', ', $missing ),
				$wgLang->formatNum( $count ) );
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Checks for translations not containing vars %d or %s that are in the
	 * definition.
	 *
	 * @param $message Instance of TMessage.
	 * @return True if namespace has been tampered with.
	 */
	protected function checkPrintfMissingVars( TMessage $message, $code, &$desc = null ) {
		if ( !preg_match_all( '/%[sd]/U', $message->definition, $defVars ) ) {
			return false;
		}
		preg_match_all( '/%[sd]/U', $message->translation, $transVars );

		$missing = self::compareArrays( $defVars[0], $transVars[0] );

		if ( $count = count( $missing ) ) {
			global $wgLang;
			$desc = array( 'translate-checks-parameters',
				implode( ', ', $missing ),
				$wgLang->formatNum( $count ) );
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Checks for translations containing vars %d or %s that are not in the
	 * definition.
	 *
	 * @param $message Instance of TMessage.
	 * @return True if namespace has been tampered with.
	 */
	protected function checkPrintfExtraVars( TMessage $message, $code, &$desc = null ) {
		preg_match_all( '/%[sd]/U', $message->definition, $defVars );
		preg_match_all( '/%[sd]/U', $message->translation, $transVars );

		$missing = self::compareArrays( $transVars[0], $defVars[0] );

		if ( $count = count( $missing ) ) {
			global $wgLang;
			$desc = array( 'translate-checks-parameters-unknown',
				implode( ', ', $missing ),
				$wgLang->formatNum( $count ) );
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Checks for translations not containing vars %xx that are in the
	 * definition.
	 *
	 * @param $message Instance of TMessage.
	 * @return True if namespace has been tampered with.
	 */
	protected function checkI18nSprintMissingVars( TMessage $message, $code, &$desc = null ) {
		if ( !preg_match_all( '/%[^% ]+/U', $message->definition, $defVars ) ) {
			return false;
		}
		preg_match_all( '/%[^% ]+/U', $message->translation, $transVars );

		$missing = self::compareArrays( $defVars[0], $transVars[0] );

		if ( $count = count( $missing ) ) {
			global $wgLang;
			$desc = array( 'translate-checks-parameters',
				implode( ', ', $missing ),
				$wgLang->formatNum( $count ) );
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Checks for translations containing vars %xx that are not in the
	 * definition.
	 *
	 * @param $message Instance of TMessage.
	 * @return True if namespace has been tampered with.
	 */
	protected function checkI18nSprintExtraVars( TMessage $message, $code, &$desc = null ) {
		preg_match_all( '/%[^% ]+/U', $message->definition, $defVars );
		preg_match_all( '/%[^% ]+/U', $message->translation, $transVars );

		$missing = self::compareArrays( $transVars[0], $defVars[0] );

		if ( $count = count( $missing ) ) {
			global $wgLang;
			$desc = array( 'translate-checks-parameters-unknown',
				implode( ', ', $missing ),
				$wgLang->formatNum( $count ) );
			return true;
		} else {
			return false;
		}
	}

	protected static function compareArrays( $defs, $trans ) {
		$missing = array();
		foreach ( $defs as $defVar ) {
			if ( !in_array( $defVar, $trans ) ) {
				$missing[] = $defVar;
			}
		}
		return $missing;
	}
}
