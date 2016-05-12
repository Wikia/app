<?php

namespace Wikia\CreateNewWiki\Tasks;

use CreateWikiException;
use User;

class ConfigureUsers implements Task {

	const ERROR_USER_IN_ANON = 12;

	private $taskContext;
	private $uploader;

	public function __construct(TaskContext $taskContext ) {
		$this->taskContext = $taskContext;
	}

	public function prepare() {
		global $wgUser;

		$this->taskContext->setFounder($wgUser);

		$this->uploader  = User::newFromName( 'CreateWiki script' );
		$this->uploader->getId();
	}

	public function check() {
		if ( $this->taskContext->getFounder()->isAnon() ) {
			wfProfileOut( __METHOD__ );
			throw new CreateWikiException('Founder is anon', self::ERROR_USER_IN_ANON);
		}
	}

	public function run() {
		$founderId = $this->taskContext->getFounder()->getId();
		wfDebugLog( "createwiki", __METHOD__ . ": Create user sysop/bureaucrat for user: {$founderId} \n", true );
		if ( !$this->addUserToGroups() ) {
			wfDebugLog( "createwiki", __METHOD__ . ": Create user sysop/bureaucrat for user: {$founderId} failed \n", true );
		}
	}

	private function addUserToGroups() {
		$founderId = $this->taskContext->getFounder()->getId();
		$wikiDBW = $this->taskContext->getWikiDBW();

		if ( $founderId ) {
			return false;
		}

		$wikiDBW->replace( "user_groups", [ ], [ "ug_user" => $founderId, "ug_group" => "sysop" ] );
		$wikiDBW->replace( "user_groups", [ ], [ "ug_user" => $founderId, "ug_group" => "bureaucrat" ] );

		return true;
	}
}
