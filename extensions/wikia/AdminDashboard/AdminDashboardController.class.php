<?php

/**
 * Renders the header chrome and side rail on Special:AdminDashboard
 */
class AdminDashboardController extends WikiaController {

	/**
	 * @var string TAB_GENERAL Name of the General tab on Special:AdminDashboard
	 */
	const TAB_GENERAL = 'general';

	/**
	 * @var string TAB_ADVANCED Name of the Advanced tab on Special:AdminDashboard
	 */
	const TAB_ADVANCED = 'advanced';

	/**
	 * Renders the Admin Dashboard article chrome on Special:AdminDashboard
	 */
	public function chrome() {
		// Get currently active tab from URL parameter (defaults to General)
		$this->tab = $this->wg->Request->getVal( 'tab', static::TAB_GENERAL );
		if ( !in_array( $this->tab, [ static::TAB_GENERAL, static::TAB_ADVANCED ] ) ) {
			$this->tab = static::TAB_ADVANCED;
		}

		// Add SCSS, JS and messages in one package
		$this->wg->Out->addModules( 'ext.AdminDashboard' );

		$this->adminDashboardUrl = $this->wg->Title->getFullURL( [ 'tab' => $this->tab ] );
		$this->adminDashboardUrlGeneral = $this->wg->Title->getFullURL( [ 'tab' => 'general' ] );
		$this->adminDashboardUrlAdvanced = $this->wg->Title->getFullURL( [ 'tab' => 'advanced' ] );
	}

	/**
	 * Stub - renders side rail on Special:AdminDashboard
	 */
	public function rail() {
		// only render template
	}
}
