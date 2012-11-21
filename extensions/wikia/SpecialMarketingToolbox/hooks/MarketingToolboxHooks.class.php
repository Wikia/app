<?php

class MarketingToolboxHooks {

	public static function onMakeGlobalVariablesScript(&$vars) {
		if (F::app()->wg->title->isSpecial('MarketingToolbox')) {
			$toolboxModel = new MarketingToolboxModel();
			$vars['wgMarketingToolboxConstants'] = $toolboxModel->getAvailableStatuses();
			$vars['wgEditHubUrl'] = SpecialPage::getTitleFor('EditHub')->getLocalURL();
		}

		return true;
	}
}