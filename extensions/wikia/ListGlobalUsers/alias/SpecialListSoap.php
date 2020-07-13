<?php
/**
 * ListSoap -> ListGlobalUsers/soap
 * @author Cqm
 * VOLDEV-49
 */
class SpecialListSoap extends SpecialRedirectToSpecial {
	function __construct() {
		parent::__construct( 'ListSoap', 'ListGlobalUsers', 'soap' );
	}
}
