<?php

/**
 * @package MediaWiki
 * @ingroup Maintenance
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @copyright Copyright © 2011, Krzysztof Krzyżaniak (eloy)
 *
 * @brief simple checkers for SemanticMediaWiki
 *
 */

require_once( dirname(__FILE__) . '/../../Maintenance.php' );

class testSMWStore extends Maintenance {

	/**
	 * @brief main entry point
	 */
	public function execute() {
		$store = smwfGetStore();
		print_r( $store );
	}
}

$maintClass = "testSMWStore";
require_once( DO_MAINTENANCE );
