<?php


class LinkSuggestController extends WikiaApiController {
	public function getLinkSuggestions() {
		$output = LinkSuggest::getLinkSuggest( RequestContext::getMain()->getRequest() );

		$this->response->setCacheValidity( 60 * 60 * 1000 ); // 1h

		if ( $this->request->getVal('format') === 'array' ) {
			$this->response->setData($output);
		} else {
			$this->response->setBody($output);
		}
	}
}
