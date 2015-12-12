<?php

class InternalLinkingController extends WikiaController {

	public function index() {
		$title = $this->wg->title;
		if ( !$title instanceof Title ) {
			return true;
		}

		$helper = new InternalLinkingHelper();

		$this->relatedWikis = $helper->getRelatedWikis();
		$this->relatedLanguages = $helper->getRelatedLanguages();

	}

}
