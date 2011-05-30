<?php
/**
 * Implements MessageChecker for Mwlib.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Message checks for FUDforum
 *
 * @ingroup MessageCheckers
 */
class MwlibMessageChecker extends MessageChecker {

	protected function MwlibVariablesCheck( $messages, $code, &$warnings ) {
		return parent::parameterCheck( $messages, $code, $warnings, '/%\([a-z]+\)[a-z]/' );
	}

}
