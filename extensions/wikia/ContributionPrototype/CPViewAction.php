<?php

namespace ContributionPrototype;

use FormlessAction;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Gateway\UrlProvider;

class CPViewAction extends FormlessAction {

	public function getName() {
		return 'view';
	}

	public function onView() {
		return null;
	}

	public function show() {
		/** @var CPArticleRenderer $renderer */
		$renderer = $this->getRenderer();
		$renderer->render($this->page->getTitle()->getPartialURL(), $this->getOutput());
	}

	/**
	 * @return CPArticleRenderer
	 */
	private function getRenderer() {
		global $wgContributionPrototypeExternalHost, $wgCityId, $wgDBname;

		/** @var UrlProvider $urlProvider */
		$urlProvider = Injector::getInjector()->get(UrlProvider::class);

		return new CPArticleRenderer(
				$wgContributionPrototypeExternalHost,
				$wgCityId,
				$wgDBname,
				$urlProvider);
	}
}
