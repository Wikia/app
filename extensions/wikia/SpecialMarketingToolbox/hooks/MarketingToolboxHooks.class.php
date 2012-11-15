<?php

class MarketingToolboxHooks {

	public static function onMakeGlobalVariablesScript(&$vars) {
		if (F::app()->wg->title->isSpecial('MarketingToolbox')) {
			$toolboxModel = new MarketingToolboxModel();
			$vars['wgMarketingToolboxConstants'] = $toolboxModel->getAvailableStatuses();
		}

		return true;
	}
}