<?php

class MarketingToolboxHooks {

	public static function onMakeGlobalVariablesScript(&$vars) {
		if (F::app()->wg->title->isSpecial('MarketingToolbox')) {
			$toolboxModel = new MarketingToolboxModel();
			$vars['wgMarketingToolboxConstants'] = $toolboxModel->getAvailableStatuses();
			$vars['wgMarketingToolboxThumbnailSize'] = $toolboxModel->getThumbnailSize();
			$vars['wgMarketingToolboxUrlRegex'] = trim(WikiaValidatorToolboxUrl::URL_RESTRICTIVE_REGEX, 'i/');
			$vars['wgEditHubUrl'] = SpecialPage::getTitleFor('MarketingToolbox','editHub')->getFullURL();
		}

		return true;
	}
}
