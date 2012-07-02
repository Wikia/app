<?php
/**
 * Frequent Pattern Tag Cloud Plug-in
 * Special page for maintenance
 *
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 * @version 1.0
 */

class FreqPatternTagCloudMaintenance extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'FreqPatternTagCloudMaintenance' );
	}

	/**
	 * Executes special page (will be called when accessing special page)
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser;

		$this->setHeaders();

		if ( !$wgUser->isAllowed( 'protect' ) ) {
			// No admin
			$wgOut->addWikiMsg( 'fptc-insufficient-rights-for-maintenance' );
		} else {
			// Refresh frequent pattern rules
			include_once( "includes/FrequentPattern.php" );

			FrequentPattern::deleteAllRules();
			FrequentPattern::computeAllRules();

			// Notify user
			$wgOut->addWikiMsg( 'fptc-refreshed-frequent-patterns' );
		}
	}

}