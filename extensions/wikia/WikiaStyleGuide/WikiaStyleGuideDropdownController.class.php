<?php

/**
 * Wikia UI Style Guide Dropdown Controller
 * @author Kyle Florence
 */
class WikiaStyleGuideDropdownController extends WikiaController {
	public function multiSelect() {
		JSMessages::enqueuePackage('WikiaStyleGuideDropdown', JSMessages::EXTERNAL);

		$this->response->addAsset('extensions/wikia/WikiaStyleGuide/js/Dropdown.js');
		$this->response->addAsset('extensions/wikia/WikiaStyleGuide/js/MultiSelectDropdown.js');
		$this->response->addAsset('extensions/wikia/WikiaStyleGuide/css/Dropdown.scss');
		$this->response->addAsset('extensions/wikia/WikiaStyleGuide/css/MultiSelectDropdown.scss');

		$this->options = $this->getVal('options', array());
		$this->selected = $this->getVal('selected', array());
		$this->toolbar = $this->getVal('toolbar', '');
		$this->selectAll = $this->getVal('selectAll', '');
	}
}
