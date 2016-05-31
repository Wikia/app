<?php

namespace ContributionPrototype;

use FormlessAction;
use Wikia\DependencyInjection\Injector;

class CPViewAction extends FormlessAction {

	public function getName() {
		return 'view';
	}

	public function onView() {
		return null;
	}

	public function show() {
		/** @var CPArticleRenderer $renderer */
		$renderer = Injector::getInjector()->get(CPArticleRenderer::class);
		$renderer->render($this->page->getTitle()->getText(), $this->getOutput());
	}
}
