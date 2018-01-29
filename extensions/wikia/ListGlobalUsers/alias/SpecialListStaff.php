<?php

/**
 * ListStaff -> ListGlobalUsers/staff
 * @author Cqm
 * VOLDEV-49
 */
class SpecialListStaff extends SpecialRedirectToSpecial {
	function __construct() {
		parent::__construct( 'ListStaff', 'ListGlobalUsers', 'staff' );
	}
}
