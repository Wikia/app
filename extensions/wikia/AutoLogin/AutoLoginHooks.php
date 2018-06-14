<?php

class AutoLoginHooks {
	public function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		global $wgAutoLoginPassiveExternalEndpoint;

		$out->addJsConfigVars( 'wgAutoLoginPassiveExternalEndpoint', $wgAutoLoginPassiveExternalEndpoint );
		$out->addModules( 'ext.wikia.autoLogin' );
	}
}
