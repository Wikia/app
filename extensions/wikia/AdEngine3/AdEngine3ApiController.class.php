<?php

class AdEngine3ApiController extends WikiaController
{
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function getRecCode($partner)
	{
		global $wgUser;

		$this->response->setContentType('text/javascript');
		$this->response->setCachePolicy(WikiaResponse::CACHE_PUBLIC);
		$this->response->setCacheValidity(WikiaResponse::CACHE_LONG);

		if ($wgUser->isAnon()) {
			$resourceLoader = null;

			switch ($partner) {
				case 'bt':
					$resourceLoader = new ResourceLoaderAdEngineBTCode();
					break;

				case 'hmd':
					$resourceLoader = new ResourceLoaderAdEngineHMDCode();
					break;
			}

			if ($resourceLoader) {
				$resourceLoaderContext = new ResourceLoaderContext(new ResourceLoader(), new FauxRequest());
				$this->response->setBody($resourceLoader->getScript($resourceLoaderContext));
			} else {
				$this->response->setBody('');
			}
		} else {
			$this->response->setBody('');
		}
	}
}
