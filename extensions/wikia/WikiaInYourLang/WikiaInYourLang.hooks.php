<?php

namespace Wikia\WikiaInYourLang;

class WikiaInYourLangHooks {

	public static function onBeforePageDisplay() {
		global $wgOut;
		$wgOut->addModules( 'ext.wikiaInYourLang' );
		return true;
	}
}
