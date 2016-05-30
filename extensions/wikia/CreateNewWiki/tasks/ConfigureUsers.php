<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\Logger\Loggable;

class ConfigureUsers extends Task {
	use Loggable;

	public function prepare() {
		global $wgUser;

		$this->taskContext->setFounder( $wgUser );

		return TaskResult::createForSuccess();
	}

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

		if ( empty($founderId) ) {
			$this->warning( implode( ":", [ __METHOD__, "FounderId is empty" ] ) );
			return false;
		}

		$wikiDBW->replace( "user_groups", [ ], [ "ug_user" => $founderId, "ug_group" => "sysop" ] );
		$wikiDBW->replace( "user_groups", [ ], [ "ug_user" => $founderId, "ug_group" => "bureaucrat" ] );

		return true;
	}
}
