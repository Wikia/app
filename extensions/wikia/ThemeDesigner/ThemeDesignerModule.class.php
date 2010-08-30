<?php
class ThemeDesignerModule extends Module {

	var $wgCdnRootUrl;

	var $wgServer;

	public function executeIndex() {
		global $wgCdnRootUrl, $wgServer;

		$this->wgCdnRootUrl = $wgCdnRootUrl;
		$this->wgServer = $wgServer;
	}

}