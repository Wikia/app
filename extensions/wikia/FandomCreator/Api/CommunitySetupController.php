<?php

namespace FandomCreator\Api;

use Exception;
use WikiaApiController;
use WikiFactory;

class CommunitySetupController extends WikiaApiController {

	const PARAM_WIKI_ID = 'mwWikiId';
	const PARAM_FC_ID = 'fcId';

	const WF_VAR_FC_COMMUNITY_ID = 'wgFandomCreatorCommunityId';
	const REASON = 'enabling fandom-creator community';

	public function allowsExternalRequests() {
		return false;
	}

	public function setup() {
		$params = $this->request->getParams();
		if (!$this->request->wasPosted()) {
			$this->response->setCode(405);
		}

		if (empty($params[self::PARAM_WIKI_ID]) || empty($params[self::PARAM_FC_ID])) {
			$this->response->setCode(400);
			return;
		}

		$varId = WikiFactory::getVarIdByName(self::WF_VAR_FC_COMMUNITY_ID);
		if (!$varId) {
			$this->response->setCode(501);
			$this->response->setData(['error' => 'cannot set because link variable unavailable']);
			return;
		}

		$wikiId = $params[self::PARAM_WIKI_ID];
		$fcId = $params[self::PARAM_FC_ID];

		try {
			WikiFactory::setFlags($wikiId, WikiFactory::FLAG_PROTECTED, false, self::REASON);
			if (!WikiFactory::setVarById($varId, $wikiId, $fcId, self::REASON)) {
				throw new Exception("saving WF variable failed");
			}
			$this->response->setCode(204);
		} catch (Exception $e) {
			$this->response->setCode(503);
		}
	}
}
