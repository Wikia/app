<?php

class GlobalFooterHooks {

	static public function onSkinCopyrightFooter( $title, $type, &$msg, &$link, &$forContent ) {
		$forContent = false;
		return true;
	}

	static public function onOasisSkinAssetGroups(&$jsAssets) {
		$jsAssets[] = 'global_footer_js';
		return true;
	}
}
