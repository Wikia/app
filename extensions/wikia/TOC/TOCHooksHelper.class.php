<?php

class TOCHooksHelper {

	public static function onOverwriteTOC( &$title, &$toc ) {

		if (!empty($toc)) {
			$toc = F::app()->renderView('TOCCOntroller', 'index');
		}

		return true;
	}

	public static function onOasisSkinAssetGroups( &$assetsArray ) {

		$assetsArray[] = 'toc_js';

		return true;
	}

	public static function onMonobookSkinAssetGroups( &$assetsArray ) {

		$assetsArray[] = 'toc_js';

		return true;
	}
}
