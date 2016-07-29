<?php

namespace UserRenameTool\Tasks;

use Wikia\Tasks\Tasks\BaseTask;

class WikiRenameBase extends BaseTask {

	const FLAG_RENAME_WIKIS_TMPL = 'wikis_to_update_%s';
	const FLAG_RENAME_WIKI_DONE_TMPL = 'wiki_%d_rename_%s';

	/** @var  \UserRenameToolProcessLocal */
	protected $process;
	
	/** @var array $params
	 *		requestor_id => ID of the user requesting this rename action
	 *		requestor_name => Name of the user requesting this rename action
	 *		rename_user_id => ID of the user to rename
	 *		rename_old_name => Current username of the user to rename
	 *		rename_new_name => New username for the user to rename
	 *		reason => Reason for requesting username change
	 *		rename_fake_user_id => The ID of the fake account created with the old user name.
	 *                             See UserRenameToolProcess::createFakeUser
	 *		phalanx_block_id => Phalanx login block ID
	 */
	protected $params;
	
	/** @var \User The user being renamed */
	protected $fakeUser;

	protected function setupLogging() {
		$this->process = \UserRenameToolProcessLocal::newFromData( $this->params );
		$this->process->setRequestorUser();
	}

	/**
	 * Return the flag to use for returning list of wiki IDs that remain to be processed for this rename.
	 * The flag has the format:
	 *
	 *    wikis_to_update_%s
	 *
	 * Where %s is the new username.
	 *
	 * @return string
	 */
	protected function getWikisToRenameFlag() {
		$newName = $this->params['rename_new_name'];
		return sprintf( self::FLAG_RENAME_WIKIS_TMPL, $newName );
	}

	/**
	 * Record the current list of wikis that need to have the target user renamed.
	 *
	 * @param array $wikiIds
	 *
	 * @throws \Exception
	 */
	protected function recordWikisLeftToUpdate( array $wikiIds ) {
		$user = $this->getFakeUser();
		$user->setGlobalFlag( $this->getWikisToRenameFlag(), $wikiIds );
		$user->saveSettings();
	}

	/**
	 * Returns the list of wiki IDs that still need to be updated
	 *
	 * @return array
	 *
	 * @throws \Exception
	 */
	protected function getWikisLeftToUpdate() {
		$user = $this->getFakeUser();
		$user->clearInstanceCache();
		return $user->getGlobalFlag( $this->getWikisToRenameFlag() );
	}

	/**
	 * Return the flag to use for checking whether a wiki had the rename process finish for the current user name.
	 * The flag has the format:
	 *
	 *    wiki_%d_rename_%s
	 *
	 * Where %d is the wiki ID and %s is the new username.
	 *
	 * @param $wikiId
	 *
	 * @return string
	 */
	protected function getWikiRenamedFlag( $wikiId ) {
		$newName = $this->params['rename_new_name'];
		return sprintf( self::FLAG_RENAME_WIKI_DONE_TMPL, $wikiId, $newName );
	}

	/**
	 * Record that the wiki given by its ID was renamed as a user flag to the DB.  See getWikiRenamedFlag
	 * for the format of this flag.
	 *
	 * @param $wikiId
	 *
	 * @throws \Exception
	 */
	protected function recordWikiRenamed( $wikiId ) {
		$flagName = $this->getWikiRenamedFlag( $wikiId );
		$user = $this->getFakeUser();
		$user->setGlobalFlag( $flagName, time() );
		$user->saveSettings();
		$user->saveToCache();
	}

	/**
	 * Return true if the wiki given by its ID had the rename process run for the current name change
	 *
	 * @param $wikiId
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 */
	protected function checkWikiRenamed( $wikiId ) {
		$flagName = $this->getWikiRenamedFlag( $wikiId );
		$user = $this->getFakeUser();
		$user->clearInstanceCache();

		return $user->getGlobalFlag( $flagName, 0 ) > 0;
	}

	protected function getFakeUser() {
		if ( !empty( $this->fakeUser ) ) {
			return $this->fakeUser;
		}

		if ( empty( $this->params['rename_fake_user_id'] ) ) {
			$errMessage = "Rename user ID not found";
			$this->error( $errMessage );
			throw new \Exception( $errMessage );
		}
		$this->fakeUser = \User::newFromId( $this->params['rename_fake_user_id'] );
		if ( empty( $this->fakeUser ) ) {
			$errMessage = "Unable to create user object from ID " . $this->params['rename_fake_user_id'];
			$this->error( $errMessage );
			throw new \Exception( $errMessage );
		}

		return $this->fakeUser;
	}
}