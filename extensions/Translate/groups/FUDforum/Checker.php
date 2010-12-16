<?php
 /**
 * @file
 * @copyright Copyright © 2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class FUDforumMessageChecker extends MessageChecker {

	/**
	 * Checks for missing and unknown variables in translations.
	 *
	 * @param $messages Iterable list of TMessages.
	 * @param $code Language code of the translations.
	 * @param $warnings Array where warnings are appended to.
	 */
	protected function FUDforumVariablesCheck( $messages, $code, &$warnings ) {
		foreach ( $messages as $message ) {
			$key = $message->key();
			$definition = $message->definition();
			$translation = $message->translation();

			$varPattern = '{(?!PLURAL).*}';
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

	protected function FUDforumSyntaxCheck( $messages, $code, &$warnings ) {
		foreach ( $messages as $message ) {
			$key = $message->key();
			$translation = $message->translation();
			$error = strpos( $translation, '{{PLURAL' ) !== false;

			if ( $error ) {
				$warnings[$key][] = array(
					array( 'syntax', 'plural', $key, $code ),
					'translate-checks-fudforum-syntax',
					'{PLURAL:',
					'{{PLURAL:',
				);
			}
		}
	}

}