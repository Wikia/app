<?php

/**
 * ListHelpers -> ListUser/helper
 * @author Cqm
 * VOLDEV-49
 */
class SpecialListHelpers extends SpecialRedirectToSpecial {
	function __construct() {
		parent::__construct( 'ListHelpers', 'ListGlobalUsers', 'helper' );
	}
}
