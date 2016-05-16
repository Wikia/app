<?php

namespace Wikia\CreateNewWiki\Tasks;

class ConfigureUsers implements Task {
	use \Wikia\Logger\Loggable;

	private $taskContext;

	public function __construct( TaskContext $taskContext ) {
		$this->taskContext = $taskContext;
	}

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
		$this->debug( implode( ":", ["CreateWiki", __CLASS__, "Create user sysop/bureaucrat for user: {$founderId}"] ) );
		if ( !$this->addUserToGroups() ) {
			// @TODO should this be an error? - it wasn't before the changes but looks like an error to me
			$this->warning( implode( ":", ["CreateWiki", __CLASS__, "Create user sysop/bureaucrat for user: {$founderId} FAILED"] ) );
		}

		return TaskResult::createForSuccess();
	}

	public function addUserToGroups() {
		$founderId = $this->taskContext->getFounder()->getId();
		$wikiDBW = $this->taskContext->getWikiDBW();

		if ( empty( $founderId ) ) {
			$this->warning( implode( ":", ["CreateWiki", __CLASS__, "FounderId is empty"] ) );
			return false;
		}

		$wikiDBW->replace( "user_groups", [ ], [ "ug_user" => $founderId, "ug_group" => "sysop" ] );
		$wikiDBW->replace( "user_groups", [ ], [ "ug_user" => $founderId, "ug_group" => "bureaucrat" ] );

		return true;
	}
}
