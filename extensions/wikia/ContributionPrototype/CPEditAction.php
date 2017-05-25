<?php

namespace ContributionPrototype;

use EditAction;
use FormlessAction;

class CPEditAction extends FormlessAction {

	public function getName() {
		return 'edit';
	}

	public function onView() {
		return null;
	}

	public function show() {
		switch ($this->page->getTitle()->getNamespace()) {
			case NS_MAIN:
				Utils::getRenderer()->render($this->page->getTitle(), $this->getOutput(), 'edit');
				break;
			default:
				$this->fallback();
				break;
		}
	}

	private function fallback() {
		$action = new EditAction($this->page, $this->context);
		$action->show();
	}
}
