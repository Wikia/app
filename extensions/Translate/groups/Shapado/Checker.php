<?php
/**
 * Implements MessageChecker for Shapado.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2009-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Message checks for Shapado
 *
 * @ingroup MessageCheckers
 */
class ShapadoMessageChecker extends MessageChecker {
	/**
	 * Checks for missing and unknown variables in translations.
	 *
	 * @param $messages \array Iterable list of TMessage objects.
	 * @param $code \string Language code of the translations.
	 * @param $warnings \array Array where warnings are appended to.
	 */
	protected function ShapadoVariablesCheck( $messages, $code, &$warnings ) {
		return parent::parameterCheck( $messages, $code, $warnings, '/%{[a-zA-Z_]+}/' );
	}
}
