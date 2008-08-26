<?php
/** \file
* \brief Contains code for the DisabledUsers Class (extends QueryPage) which is used by the PasswordReset extension.
*/

///Class for the DisabledUsers page of the PasswordReset extension
/**
 * Special page that generates a list of users
 * that have been disasbled via PasswordReset
 *
 * @addtogroup Extensions
 * @author Tim Laqua <t.laqua@gmail.com>
 */

class Disabledusers extends SpecialPage {
	///StalePages Class Constructor
	public function __construct() {
		SpecialPage::SpecialPage( 'Disabledusers', 'passwordreset' );
	}

	function getDescription() {
		return wfMsg( 'disabledusers' );
	}

	function execute( $parameters ) {
		$this->setHeaders();
		list( $limit, $offset ) = wfCheckLimits();

		$sp = new DisabledusersPage();

		$sp->doQuery( $offset, $limit );
	}
}

class DisabledusersPage extends QueryPage {
	function getName() {
		return "Disabledusers";
	}

	function isExpensive() {
		return true;
	}

	function getPageHeader() {
		global $wgOut;
		return $wgOut->parse( wfMsg( 'disabledusers-summary', 270 ) );
	}

	function isSyndicated() {
		return false;
	}

	function getSQL() {
		global $wgDBtype;
		$db = wfGetDB( DB_SLAVE );
		$user = $db->tableName( 'user' );

		return
			"SELECT 'Disabledusers' as type, 
			user_id, 
			user_name as value 
			FROM $user
			WHERE user_password='DISABLED'";
	}

	function sortDescending() {
		return false;
	}

	function formatResult( $skin, $result ) {
		global $wgUser;

		$formattedRow = $skin->userLink( $result->user_id, $result->value ) . 
						$skin->userToolLinks( $result->user_id, $result->value );
		return $formattedRow;
	}
}
