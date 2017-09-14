<?php

namespace ContributionPrototype;

use FormlessAction;
use HistoryAction;

class CPHistoryAction extends FormlessAction {

	public function getName() {
		return 'history';
	}

	public function requiresWrite() {
		return false;
	}

	public function requiresUnblock() {
		return false;
	}

	public function onView() {
		return null;
	}

	public function show() {
		switch ($this->page->getTitle()->getNamespace()) {
			case NS_MAIN:
				Utils::getRenderer()->render($this->page->getTitle(), $this->getOutput(), 'history');
				break;
			default:
				$this->fallback();
				break;
		}
	}

	private function fallback() {
		$action = new HistoryAction($this->page, $this->context);
		$action->show();
	}
}