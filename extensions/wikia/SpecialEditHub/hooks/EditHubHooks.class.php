<?php

class EditHubHooks {

	public static function onMakeGlobalVariablesScript(&$vars) {
		if (F::app()->wg->title->isSpecial('EditHub')) {
			$toolboxModel = new MarketingToolboxV3Model();
			$vars['wgEditHubConstants'] = $toolboxModel->getAvailableStatuses();
			$vars['wgEditHubThumbnailSize'] = $toolboxModel->getThumbnailSize();
			$vars['wgEditHubUrlRegex'] = trim(WikiaValidatorToolboxUrl::URL_RESTRICTIVE_REGEX, 'i/');
			$vars['wgEditHubUrl'] = SpecialPage::getTitleFor('EditHub','editHub')->getFullURL();
		}

		return true;
	}
}
