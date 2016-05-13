<?php

class CreateNewWikiHooks
{
	public static function onOasisSkinAssetGroups(&$jsAssets)
	{
		$jsAssets[] = 'create_new_wiki_js';
		return true;
	}
}
