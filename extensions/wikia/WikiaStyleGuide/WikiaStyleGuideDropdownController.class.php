<?php

/**
 * UISG Dropdown Controller
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class WikiaStyleGuideDropdownController extends WikiaController {
	public function multiSelect() {
		$this->response->addAsset('extensions/wikia/WikiaStyleGuide/js/Dropdown.MultiSelect.js');
		$this->response->addAsset('extensions/wikia/WikiaStyleGuide/css/Dropdown.MultiSelect.scss');

		$this->options = $this->getVal('options', array());
		$this->selected = $this->getVal('selected', array());
	}
}
