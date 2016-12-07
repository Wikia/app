<?php

namespace ContributionPrototype;

use FormlessAction;

class CPViewAction extends FormlessAction {

	public function getName() {
		return 'view';
	}

	public function onView() {
		return null;
	}

	public function show() {
		Utils::getRenderer()->render($this->page->getTitle()->getPartialURL(), $this->getOutput());
	}
}
