<?php
/**
 * @package MediaWiki
 * @subpackage CustomCategoryName
 *
 * @author Maciej Błaszkowski <marooned at wikia.com> [code by Inez]
 */

if(!defined('MEDIAWIKI')) {
	exit( 1 );
}

$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'CustomCategoryNameHook';

function CustomCategoryNameHook($skintpl, $tpl) {
	global $wgRequest;
	$action = $wgRequest->getVal('action', 'view');
	if ($skintpl->mTitle->mNamespace == NS_CATEGORY && ($action == 'view' || $action == 'purge')) {
		$customCategoryName = wfMsg('custom-category-name');
		if (!wfEmptyMsg('custom-category-name', $customCategoryName)) {
			$tpl->set('title', $skintpl->mTitle->getNsText() . ':' . $customCategoryName . ' ' . $skintpl->mTitle->getText());
		}
	}
	return true;
}