<?php

namespace ContributionPrototype;

use FormlessAction;

class CPEditAction extends FormlessAction {

	public function getName() {
		return 'edit';
	}

	public function onView() {
		return null;
	}

	public function show() {
		Utils::getRenderer()->render($this->page->getTitle()->getPartialURL(), $this->getOutput(), 'edit');
	}
}
