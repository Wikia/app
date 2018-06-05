<?php

namespace FandomCreator\Api;

use FandomCreator\CommunitySetup;
use WikiaApiController;

class CommunitySetupController extends WikiaApiController {

	const PARAM_WIKI_ID = 'mwWikiId';
	const PARAM_FC_ID = 'fcId';

	public function allowsExternalRequests() {
		return false;
	}

	public function setup() {
		$params = $this->request->getParams();
		if (!$this->request->wasPosted()) {
			$this->response->setCode(405);
			return;
		}

		if (empty($params[self::PARAM_WIKI_ID]) || empty($params[self::PARAM_FC_ID])) {
			$this->response->setCode(400);
			return;
		}

		$setup = new CommunitySetup($params[self::PARAM_WIKI_ID], $params[self::PARAM_FC_ID]);
		if ($setup->setup()) {
			// i want this to be 204 but through the icache internal proxy that ends up being a 503 :|
			$this->response->setCode(200);
		} else {
			$this->response->setCode(503);
		}
	}
}
