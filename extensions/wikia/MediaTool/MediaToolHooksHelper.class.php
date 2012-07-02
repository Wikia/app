<?php

/**
 * MediaTool Hooks Helper
 * @author Piotr Bablok
 */

class MediaToolHooksHelper extends WikiaModel {

	function onEditPageLayoutExecute() {

		$this->wg->Out->addScript("<script type=\"{$this->wg->JsMimeType}\" src=\"{$this->wg->ExtensionsPath}/wikia/MediaTool/js/MediaTool.js\"></script>");
		$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/MediaTool/css/MediaTool.scss'));

		return true;
	}

}