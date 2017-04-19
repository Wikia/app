<?php

namespace ContributionPrototype;

use ViewAction;
use FormlessAction;

class CPViewAction extends FormlessAction {

	public function getName() {
		return 'view';
	}

	public function onView() {
		return null;
	}

	public function show() {
		switch ($this->page->getTitle()->getNamespace()) {
			case NS_MAIN:
				Utils::getRenderer()->render($this->page->getTitle(), $this->getOutput());
				break;
			default:
				$this->fallback();
				break;
		}
	}

	private function fallback() {
		$action = new ViewAction($this->page, $this->context);
		$action->show();
	}
}
