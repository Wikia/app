<?php

/**
 * AdEngine3 Controller
 */
class AdEngine3Controller extends WikiaController {
	/**
	 * Action to display an ad (or not)
	 */
	public function ad() {
		$this->includeLabel = $this->request->getVal('includeLabel');
		$this->onLoad = $this->request->getVal('onLoad');
		$this->addToAdQueue = $this->request->getVal('addToAdQueue', true);
		$this->pageTypes = $this->request->getVal('pageTypes');
		$this->slotName = $this->request->getVal('slotName');
		$this->showAd = AdEngine3Service::shouldShowAd($this->pageTypes);
	}

	/**
	 * Action to display a recoverable ad product (or not)
	 *
	 * It differs with AdEngine3Controller::ad():
	 * - no .wikia-ad class added to the element
	 */
	public function adEmptyContainer() {
		$this->pageTypes = $this->request->getVal('pageTypes');
		$this->slotName = $this->request->getVal('slotName');
		$this->showAd = AdEngine3Service::shouldShowAd($this->pageTypes);
	}
}
