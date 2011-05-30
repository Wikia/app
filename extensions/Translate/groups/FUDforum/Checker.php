<?php
/**
 * Implements MessageChecker for FUDforum.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2009-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Message checks for FUDforum
 *
 * @ingroup MessageCheckers
 */
class FUDforumMessageChecker extends MessageChecker {

	protected function FUDforumVariablesCheck( $messages, $code, &$warnings ) {
		return parent::parameterCheck( $messages, $code, $warnings, '/\$[1-9]/' );
	}

	protected function FUDforumLongVariablesCheck( $messages, $code, &$warnings ) {
		return parent::parameterCheck( $messages, $code, $warnings, '/{VAR: [^}]+}/' );
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
