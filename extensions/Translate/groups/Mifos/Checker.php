<?php

/**
 * Implements MessageChecker for Mifos.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Message checks for Mifos
 *
 * @ingroup MessageCheckers
 */
class MifosMessageChecker extends MessageChecker {
	protected function MifosVariablesCheck( $messages, $code, &$warnings ) {
		return parent::parameterCheck( $messages, $code, $warnings, '/{[0-9]}/' );
	}
}
