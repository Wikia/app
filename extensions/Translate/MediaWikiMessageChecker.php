<?php
/**
 * Implements MessageChecker for %MediaWiki.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * %MediaWiki specific message checks.
 *
 * @ingroup MessageCheckers
 */
class MediaWikiMessageChecker extends MessageChecker {
	/**
	 * Checks if the translation uses all variables $[1-9] that the definition
	 * uses and vice versa.
	 *
	 * @param $messages \array Iterable list of TMessage objects.
	 * @param $code \string Language code of the translations.
	 * @param $warnings \array Array where warnings are appended to.
	 */
	protected function wikiParameterCheck( $messages, $code, &$warnings ) {
		return parent::parameterCheck( $messages, $code, $warnings, '/\$[1-9]/' );
	}

	/**
	 * Checks if the translation uses links that are discouraged. Valid links are
	 * those that link to Special: or {{ns:special}}: or project pages trough
	 * MediaWiki messages like {{MediaWiki:helppage-url}}:. Also links in the
	 * definition are allowed.
	 *
	 * @param $messages \array Iterable list of TMessage objects.
	 * @param $code \string Language code of the translations.
	 * @param $warnings \array Array where warnings are appended to.
	 */
	protected function wikiLinksCheck( $messages, $code, &$warnings ) {
		$tc = Title::legalChars() . '#%{}';

		foreach ( $messages as $message ) {
			$key = $message->key();
			$definition = $message->definition();
			$translation = $message->translation();

			$subcheck = 'extra';
			$matches = $links = array();
			preg_match_all( "/\[\[([{$tc}]+)(\\|(.+?))?]]/sDu", $translation, $matches );
			for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
				$backMatch = preg_quote( $matches[1][$i], '/' );

				if ( preg_match( "/\[\[$backMatch/", $definition ) ) {
					continue;
				}

				$links[] = "[[{$matches[1][$i]}{$matches[2][$i]}]]";
			}

			if ( count( $links ) ) {
				$warnings[$key][] = array(
					array( 'links', $subcheck, $key, $code ),
					'translate-checks-links',
					array( 'PARAMS', $links ),
					array( 'COUNT', count( $links ) ),
				);
			}

			$subcheck = 'missing';
			$matches = $links = array();
			preg_match_all( "/\[\[([{$tc}]+)(\\|(.+?))?]]/sDu", $definition, $matches );
			for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
				$backMatch = preg_quote( $matches[1][$i], '/' );

				if ( preg_match( "/\[\[$backMatch/", $translation ) ) {
					continue;
				}

				$links[] = "[[{$matches[1][$i]}{$matches[2][$i]}]]";
			}

			if ( count( $links ) ) {
				$warnings[$key][] = array(
					array( 'links', $subcheck, $key, $code ),
					'translate-checks-links-missing',
					array( 'PARAMS', $links ),
					array( 'COUNT', count( $links ) ),
				);
			}
		}
	}

	/**
	 * Checks if the \<br /> and \<hr /> tags are using the correct syntax.
	 *
	 * @param $messages \array Iterable list of TMessage objects.
	 * @param $code \string Language code of the translations.
	 * @param $warnings \array Array where warnings are appended to.
	 */
	protected function XhtmlCheck( $messages, $code, &$warnings ) {
		foreach ( $messages as $message ) {
			$key = $message->key();
			$translation = $message->translation();
			if ( strpos( $translation, '<' ) === false ) {
				continue;
			}

			$subcheck = 'invalid';
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

			if ( count( $wrongTags ) ) {
				$warnings[$key][] = array(
					array( 'xhtml', $subcheck, $key, $code ),
					'translate-checks-xhtml',
					array( 'PARAMS', $wrongTags ),
					array( 'COUNT', count( $wrongTags ) ),
				);
			}
		}
	}

	/**
	 * Checks if the translation doesn't use plural while the definition has one.
	 *
	 * @param $messages \array Iterable list of TMessage objects.
	 * @param $code \string Language code of the translations.
	 * @param $warnings \array Array where warnings are appended to.
	 */
	protected function pluralCheck( $messages, $code, &$warnings ) {
		foreach ( $messages as $message ) {
			$key = $message->key();
			$definition = $message->definition();
			$translation = $message->translation();

			$subcheck = 'missing';
			if (
				stripos( $definition, '{{plural:' ) !== false &&
				stripos( $translation, '{{plural:' ) === false
			) {
				$warnings[$key][] = array(
					array( 'plural', $subcheck, $key, $code ),
					'translate-checks-plural',
				);
			}
		}
	}

	/**
	 * Checks for page names that they have an untranslated namespace.
	 *
	 * @param $messages \array Iterable list of TMessage objects.
	 * @param $code \string Language code of the translations.
	 * @param $warnings \array Array where warnings are appended to.
	 */
	protected function pagenameMessagesCheck( $messages, $code, &$warnings ) {
		foreach ( $messages as $message ) {
			$key = $message->key();
			$definition = $message->definition();
			$translation = $message->translation();

			$subcheck = 'namespace';
			$namespaces = 'help|project|\{\{ns:project}}|mediawiki';
			$matches = array();
			if ( preg_match( "/^($namespaces):[\w\s]+$/ui", $definition, $matches ) ) {
				if ( !preg_match( "/^{$matches[1]}:.+$/u", $translation ) ) {
					$warnings[$key][] = array(
						array( 'pagename', $subcheck, $key, $code ),
						'translate-checks-pagename',
					);
				}
			}
		}
	}

	/**
	 * Checks for some miscellaneous messages with special syntax.
	 *
	 * @param $messages \array Iterable list of TMessage objects.
	 * @param $code \string Language code of the translations.
	 * @param $warnings \array Array where warnings are appended to.
	 */
	protected function miscMWChecks( $messages, $code, &$warnings ) {
		$timeList = array( 'protect-expiry-options', 'ipboptions' );

		foreach ( $messages as $message ) {
			$key = $message->key();
			$definition = $message->definition();
			$translation = $message->translation();


			if ( in_array( strtolower( $key ), $timeList, true ) ) {
				$defArray = explode( ',', $definition );
				$traArray = explode( ',', $translation );

				$subcheck = 'timelist-count';
				$defCount = count( $defArray );
				$traCount = count( $traArray );
				if ( $defCount !== $traCount ) {
					$warnings[$key][] = array(
						array( 'miscmw', $subcheck, $key, $code ),
						'translate-checks-format',
						"Parameter count is $traCount; should be $defCount", // @todo Missing i18n.
					);
					continue;
				}

				for ( $i = 0; $i < count( $defArray ); $i++ ) {
					$defItems = array_map( 'trim', explode( ':', $defArray[$i] ) );
					$traItems = array_map( 'trim', explode( ':', $traArray[$i] ) );

					$subcheck = 'timelist-format';
					if ( count( $traItems ) !== 2 ) {
						$warnings[$key][] = array(
							array( 'miscmw', $subcheck, $key, $code ),
							'translate-checks-format',
							"<nowiki>$traArray[$i]</nowiki> is malformed", // @todo Missing i18n.
						);
						continue;
					}

					$subcheck = 'timelist-format-value';
					if ( $traItems[1] !== $defItems[1] ) {
						$warnings[$key][] = array(
							array( 'miscmw', $subcheck, $key, $code ),
							'translate-checks-format',
							"<tt><nowiki>$traItems[1] !== $defItems[1]</nowiki></tt>",
						);
						continue;
					}
				}
			}
		}
	}
}
