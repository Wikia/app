<?php
class AdEngine2ApiController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function getCollapse() {
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}
}
