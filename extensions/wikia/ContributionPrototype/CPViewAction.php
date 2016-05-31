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
		global $wgDBname, $wgCityId;
		
		$article = new CPArticle(
				$wgCityId, 
				$wgDBname, 
				$this->page->getTitle()->getBaseText(), 
				$this->getOutput());
		
		$article->view();
	}
}
