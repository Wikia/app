<?php
/**
 * Translatable page parse exception.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2009-2012 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Class to signal syntax errors in translatable pages.
 *
 * @ingroup PageTranslation
 */
class TPException extends MWException {
	protected $msg = null;

	/**
	 * @param $msg \string Message key.
	 */
	public function __construct( $msg ) {
		$this->msg = $msg;
		parent::__construct( call_user_func_array( 'wfMsg', $msg ) );
	}

	/**
	 * @return \string A localised error message.
	 */
	public function getMsg() {
		return $this->msg;
	}
}
