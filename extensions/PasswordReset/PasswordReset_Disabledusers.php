<?php
/** \file
* \brief Contains code for the DisabledUsers Class (extends QueryPage) which is used by the PasswordReset extension.
*/

///Class for the DisabledUsers page of the PasswordReset extension
/**
 * Special page that generates a list of users
 * that have been disasbled via PasswordReset
 *
 * @ingroup Extensions
 * @author Tim Laqua <t.laqua@gmail.com>
 */
class Disabledusers extends QueryPage {
	public function __construct( $name = 'Disabledusers' ) {
		parent::__construct( $name, 'passwordreset' );
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

	function getQueryInfo() {
		return array(
			'tables' => array ( 'user' ),
			'fields' => array(
				'user_id',
				'user_name AS value'
			),
			'conds' => array ( 'user_password' => 'DISABLED' )
		);
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
