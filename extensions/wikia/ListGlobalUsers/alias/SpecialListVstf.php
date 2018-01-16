<?php
/**
 * ListVstf -> ListGlobalUsers/vstf
 * @author Cqm
 * VOLDEV-49
 */
class SpecialListVstf extends SpecialRedirectToSpecial {
	function __construct() {
		parent::__construct( 'ListVstf', 'ListGlobalUsers', 'vstf' );
	}
}
