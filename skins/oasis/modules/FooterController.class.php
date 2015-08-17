<?php
class FooterController extends WikiaController {

	public function executeIndex() {
		global $wgShowMyToolsOnly,
			   $wgEnableWikiaBarExt,
			   $wgSuppressToolbar;

		// show for anons as well (BugId:20730)
		$this->showNotifications = empty( $wgSuppressToolbar ) && empty( $wgEnableWikiaBarExt );
		$this->showToolbar = !( $this->isAdminToolbarSupressed() || $wgSuppressToolbar ) && empty( $wgEnableWikiaBarExt );

		if ( $this->showToolbar == false ) {
			return;
		}

		// show only "My Tools" dropdown on toolbar
		if ( !empty( $wgShowMyToolsOnly ) ) {
			return;
		}
	}

	/**
	 * @desc AdminToolBar isn't displayed in OasisFooter if $wgSupressToolbar variable is set to true (for instance on edit pages), user is an anon or WikiaBar extension is turned on
	 * @return bool
	 */
	protected function isAdminToolbarSupressed() {
		global $wgUser, $wgSuppressToolbar, $wgEnableWikiaBarExt;
		return empty( $wgSuppressToolbar ) && empty( $wgEnableWikiaBarExt ) && !$wgUser->isAnon();
	}
}
