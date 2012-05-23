<?php

/**
 * UISG Dropdown Controller
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class DropdownController extends WikiaController {
	public function multiSelect() {
		$this->response->addAsset('extensions/wikia/WikiaStyleGuide/js/Dropdown/MultiSelectDropdown.js');
		$this->response->addAsset('extensions/wikia/WikiaStyleGuide/css/Dropdown/MultiSelectDropdown.scss');

		$this->options = $this->getVal('options', array());
		$this->selected = $this->getVal('selected', array());
	}
}
