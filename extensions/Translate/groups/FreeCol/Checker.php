<?php
 /**
 * @file
 * @copyright Copyright © 2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class FreeColMessageChecker extends MessageChecker {

	/**
	 * Checks for missing and unknown variables in translations.
	 *
	 * @param $messages Iterable list of TMessages.
	 * @param $code Language code of the translations.
	 * @param $warnings Array where warnings are appended to.
	 */
	protected function FreeColVariablesCheck( $messages, $code, &$warnings ) {
		foreach ( $messages as $message ) {
			$key = $message->key();
			$definition = $message->definition();
			$translation = $message->translation();

			$varPattern = '%[a-zA-Z_]+%';
			preg_match_all( "/$varPattern/U", $definition, $defVars );
			preg_match_all( "/$varPattern/U", $translation, $transVars );

			# Check for missing variables in the translation
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

			# Check for unknown variables in the translation
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

	/**
	 * Checks for bad escapes in translations.
	 *
	 * @param $messages Iterable list of TMessages.
	 * @param $code Language code of the translations.
	 * @param $warnings Array where warnings are appended to.
	 */
	protected function FreeColEscapesCheck( $messages, $code, &$warnings ) {
		foreach ( $messages as $message ) {
			$key = $message->key();
			$translation = $message->translation();

			$varPattern = '\\\\[^nt\'"]';
			preg_match_all( "/$varPattern/U", $translation, $transVars );

			# Check for missing variables in the translation
			$subcheck = 'invalid';
			$params = $transVars[0];
			if ( count( $params ) ) {
				$warnings[$key][] = array(
					array( 'escape', $subcheck, $key, $code ),
					'translate-checks-escape',
					array( 'PARAMS', $params ),
					array( 'COUNT', count( $params ) ),
				);
			}
		}
	}

}