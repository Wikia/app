<?php

class ARecoveryModule {
    /**
     * Checks whether recovery is enabled (on current wiki)
     *
     * @return bool
     */
	public static function isEnabled() {
		global $wgEnableUsingSourcePointProxyForCSS;

		return !empty( $wgEnableUsingSourcePointProxyForCSS );
	}
}
