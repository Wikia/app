<?php

class AdEngine3ApiController extends WikiaController
{
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function getRecCode()
	{
		global $wgUser;

		$this->response->setContentType('text/javascript');
		$this->response->setCachePolicy(WikiaResponse::CACHE_PUBLIC);
		$this->response->setCacheValidity(WikiaResponse::CACHE_LONG);

		if ($wgUser->isAnon()) {
			$resourceLoader = null;
			$type = $this->request->getVal('type', 'rec');

			switch ($type) {
				case 'bt':
					$resourceLoader = new ResourceLoaderAdEngine3BTCode();
					break;

				case 'hmd':
					$resourceLoader = new ResourceLoaderAdEngine3HMDCode();
					break;

				default:
					$this->response->setBody('');
			}

			if ($resourceLoader) {
				$resourceLoaderContext = new ResourceLoaderContext(new ResourceLoader(), new FauxRequest());
				$this->response->setBody($resourceLoader->getScript($resourceLoaderContext));
			}
		} else {
			$this->response->setBody('');
		}
	}
}
