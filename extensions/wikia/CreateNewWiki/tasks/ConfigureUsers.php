<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\Logger\Loggable;

class ConfigureUsers extends Task {
	use Loggable;

	public function check() {
		if ( $this->taskContext->getFounder()->isAnon() ) {
			return TaskResult::createForError( "Founder is anon" );
		}

		return TaskResult::createForSuccess();
	}

	public function run() {
		$founderId = $this->taskContext->getFounder()->getId();
		$this->debug( implode( ":", [ __METHOD__, "Create user sysop/bureaucrat for user: {$founderId}" ] ) );
		if ( !$this->addUserToGroups() ) {
			$this->warning( implode( ":", [ __METHOD__, "Create user sysop/bureaucrat for user: {$founderId} FAILED" ] ) );
		}

		return TaskResult::createForSuccess();
	}

	public function addUserToGroups() {
		$founderId = $this->taskContext->getFounder()->getId();
		$wikiDBW = $this->taskContext->getWikiDBW();

		$rows = [
			[ "ug_user" => $founderId, "ug_group" => "sysop" ],
			[ "ug_user" => $founderId, "ug_group" => "bureaucrat" ]
		];

		$wikiDBW->replace( "user_groups", [ ], $rows, __METHOD__ );

		return true;
	}
}
