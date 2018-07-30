<?php

namespace Wikia\CreateNewWiki\Tasks;

use FandomCreator\CommunitySetup;

class LinkFandomCreatorCommunity extends Task {

	public function run() {
		if (!$this->taskContext->isFandomCreatorCommunity()) {
			return TaskResult::createForSuccess();
		}

		$setup = new CommunitySetup($this->taskContext->getCityId(), $this->taskContext->getFandomCreatorCommunityId());

		if ($setup->setup()) {
			return TaskResult::createForSuccess();
		} else {
			return TaskResult::createForError( "error linking to fandom creator community" );
		}
	}
}
