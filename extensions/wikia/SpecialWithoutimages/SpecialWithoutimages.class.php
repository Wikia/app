<?php
/**
 * @file
 * @ingroup SpecialPage
 */

/**
 * A special page to show pages without images
 * The image is defined as a file that has not more than 20 incoming links
 *
 * @ingroup SpecialPage
 */
class SpecialWithoutimages extends SpecialPage {

	function __construct() {
		parent::__construct( 'Withoutimages' );
		wfLoadExtensionMessages( 'Withoutimages' );
	}

	function execute() {
		$this->setHeaders();
		list( $limit, $offset ) = wfCheckLimits();
		$wpp = new WithoutimagesPage();
		$wpp->doQuery( $offset, $limit );
	}
}
