<?php

namespace FandomCreator;

use WikiFactory;

class CommunitySetup {

	const WF_VAR_FC_COMMUNITY_ID = 'wgFandomCreatorCommunityId';
	const REASON = 'enabling fandom-creator community';

	private $wikiId;

	private $fandomCreatorCommunityId;

	public function __construct($wikiId, $fandomCreatorCommunityId) {
		$this->wikiId = $wikiId;
		$this->fandomCreatorCommunityId = $fandomCreatorCommunityId;
	}

	public function setup() {
		$varId = WikiFactory::getVarIdByName(self::WF_VAR_FC_COMMUNITY_ID);
		if (!$varId) {
			return false;
		}

		WikiFactory::setFlags($this->wikiId, WikiFactory::FLAG_PROTECTED, false, self::REASON);
		if (!WikiFactory::setVarById($varId, $this->wikiId, $this->fandomCreatorCommunityId, self::REASON)) {
			return false;
		}

		return true;
	}
}
