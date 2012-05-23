<?php

/**
 * UISG Multiple Select Dropdown Controller
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class MultiSelectDropdownController extends WikiaController {
	public function index() {
		$this->options = $this->getVal('options', array());
		$this->selected = $this->getVal('selected', array());
	}
}
