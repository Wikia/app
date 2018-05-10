<?php

use Wikia\Tasks\Tasks\BaseTask;

class RemoveGlobalUserDataTask extends BaseTask {

	public function removeData( int $userId ) {
		return UserDataRemover::removeGlobalData( $userId );
	}

}
