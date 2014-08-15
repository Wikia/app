<?php

class EditHubHooks {

	public static function onMakeGlobalVariablesScript(&$vars) {
		if (F::app()->wg->title->isSpecial('EditHub')) {
			$editHubModel = new EditHubModel();
			$vars['wgEditHubConstants'] = $editHubModel->getAvailableStatuses();
			$vars['wgEditHubThumbnailSize'] = $editHubModel->getThumbnailSize();
			$vars['wgEditHubUrlRegex'] = trim(WikiaValidatorRestrictiveUrl::URL_RESTRICTIVE_REGEX, 'i/');
			$vars['wgEditHubUrl'] = SpecialPage::getTitleFor('EditHub','editHub')->getFullURL();
		}

		return true;
	}
}
