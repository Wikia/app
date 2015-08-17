<?php

class CorporateFooterHooks {
	static public function onOasisSkinAssetGroups( &$jsAssets ) {
		$jsAssets[] = 'corporate_footer_js';
		return true;
	}
}
