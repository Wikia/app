<?php

/**
 * AdEngine II Controller
 */
class AdEngine2Controller extends WikiaController {
	const IL_TEMPLATE = 'extensions/wikia/AdEngine/templates/AdEngine2Controller_getILBootstrap.mustache';

	/**
	 * Action to display an ad (or not)
	 */
	public function ad() {
		$this->includeLabel = $this->request->getVal('includeLabel');
		$this->onLoad = $this->request->getVal('onLoad');
		$this->addToAdQueue = $this->request->getVal('addToAdQueue', true);
		$this->pageTypes = $this->request->getVal('pageTypes');
		$this->slotName = $this->request->getVal('slotName');
		$this->showAd = AdEngine2Service::shouldShowAd($this->pageTypes);
	}

	/**
	 * Action to display a recoverable ad product (or not)
	 *
	 * It differs with AdEngine2Controller::ad():
	 * - no .wikia-ad class added to the element
	 */
	public function adEmptyContainer() {
		$this->pageTypes = $this->request->getVal('pageTypes');
		$this->slotName = $this->request->getVal('slotName');
		$this->showAd = AdEngine2Service::shouldShowAd($this->pageTypes);
	}

	/**
	 * Include IL code
	 */
	public static function getILBootstrapCode() {
		return \MustacheService::getInstance()->render(
			self::IL_TEMPLATE, [
				'code' => F::app()->sendRequest( 'AdEngine2ApiController', 'getILCode' )
			]
		);
	}
}
