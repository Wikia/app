<?php
/**
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * TopListBase base class implementation, all the item/list management classes derives from this one
 */

abstract class TopListBase {
	protected $mTitle = null;
	protected $mArticle = null;
	protected $mAuthor = null;
	protected $mCreationTimestamp = null;
	protected $mDataLoaded = false;
	protected $mEditor = null;

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Checks the current state of the items and returns the appropriate mode for the save function
	 *
	 * @param Title $title a Title class instance for the article
	 *
	 * @return mixed a TopListBase instance, false in case $title is not in the NS_TOPLIST namespace
	 */
	protected function _detectProcessingMode( $mode ) {
		if( $mode == TOPLISTS_SAVE_AUTODETECT ) {
			return ( $this->exists() ) ? TOPLISTS_SAVE_UPDATE : TOPLISTS_SAVE_CREATE;
		} else {
			return $mode;
		}
	}

	/**
	 * @author Federico "Lox" Lucignano
	 */
	protected function _loadData( $forceReload = false, $overrideCall = true ) {
		if ( ( !$this->mDataLoaded || $forceReload ) ) {
			$this->mCreationTimestamp = $this->mTitle->getEarliestRevTime();

			$revData = $this->mTitle->getFirstRevision();
			
			if( !empty( $revData ) ) {
				if( !empty( $revData['rev_user'] ) ) {
					$this->mAuthor = User::newFromId( $revData['rev_user'] );
				}
			}

			if( !$overrideCall ) {
				$this->mDataLoaded = true;
			}
		}
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Checks for possible errors for creation/update processes
	 *
	 * @param integer $mode one of TOPLISTS_SAVE_CREATE, TOPLISTS_SAVE_UPDATE or TOPLISTS_SAVE_AUTODETECT
	 * @param User	$user a User instance to check for blocks, $wgUser will be used if omitted
	 *
	 * @return mixed true in case of success, otherwise a multidimensional array of error messages in this form: array( array( 'msg' => MESSAGE_KEY, 'params' => array() ) )
	 */
	public function checkForProcessing( $mode = TOPLISTS_SAVE_AUTODETECT, User $user = null ) {
		global $wgUser;

		$mode = $this->_detectProcessingMode( $mode );
		$this->mEditor = ( !empty( $user ) ) ? $user : $wgUser;

		$name = $this->mTitle->getText();
		$url = $this->mTitle->getLocalURL();
		$errors = array();

		if ( $this->mTitle->exists() && $mode == TOPLISTS_SAVE_CREATE ) {
			$errors[] = array(
				'msg' => 'toplists-error-title-exists',
				'params' => array( $name, $url )
			);
		} elseif ( !$this->mTitle->exists() && $mode == TOPLISTS_SAVE_UPDATE ) {
			$errors[] = array(
				'msg' => 'toplists-error-title-not-exists',
				'params' => array( $name, $url )
			);
		}

		if ( !wfRunHooks( 'TopLists::CreateListTitleCheck', array( $this->mTitle ) ) ) {
			$errors[] = array(
				'msg' => 'toplists-error-title-spam',
				'params' => null
			);
		}

		if ( !$this->mTitle->canExist() ) {
			$errors[] = array(
				'msg' => 'toplists-error-invalid-title',
				'params' => null
			);
		}

		if ( $this->mEditor->isBlockedFrom( $this->mTitle, false ) ) {
			$errors[] = array(
				'msg' => 'toplists-error-article-blocked',
				'params' => null
			);
		}

		return ( empty( $errors ) ) ? true : $errors;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Returns a Title instance for this list
	 *
	 * @return Title a Title instance, null if none is set for this list
	 */
	public function getTitle() {
		return $this->mTitle;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Returns an Article instance for this list
	 *
	 * @return Aricle an Article instance, null if none is set for this list
	 */
	public function getArticle() {
		if( !empty( $this->mTitle ) && empty( $this->mArticle ) ) {
			$this->mArticle = new Article( $this->mTitle );
		}

		return $this->mArticle;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Gets the timestamp for the article first edit (creation)
	 *
	 * @param boolean $forceReload true to force data reload, defaults to false
	 *
	 * @return int the timestamp fot the article first edit, null if the article doesn't exst
	 */
	public function getCreationTimestamp( $forceReload = false ) {
		$this->_loadData( $forceReload );
		return $this->mCreationTimestamp;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Gets the user that has originally created the article
	 *
	 * @param boolean $forceReload true to force data reload, defaults to false
	 *
	 * @return User a user object for the creator of the article, null if the article doesn't exist
	 */
	public function getAuthor( $forceReload = false ) {
		$this->_loadData( $forceReload );
		return $this->mAuthor;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Check if the user can edit/remove the article
	 *
	 * @param User $user the user to check for edit/remove permission, it will default to $wgUser if none is given
	 *
	 * @return boolean true for granted permission, false otherwise
	 */
	public function userCanEdit( User $user = null ) {
		global $wgUser;
		
		if( !empty( $user ) ) {
			$user = $wgUser;
		}

		//TODO: Implement
		return true;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Check if the list represented by the current instance already exists in the DB
	 *
	 * @return boolean true if the list exists, false otherwise
	 */
	public function exists() {
		return ( !empty( $this->mTitle ) ) ? $this->mTitle->exists() : false;
	}
	
	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Creates or updates the article related to this instance
	 *
	 * @param integer $mode one of TOPLISTS_SAVE_CREATE, TOPLISTS_SAVE_UPDATE or TOPLISTS_SAVE_AUTODETECT
	 *
	 * @return mixed true in case of success, otherwise a multidimensional array of error messages in this form: array( array( 'msg' => MESSAGE_KEY, 'params' => array() ) )
	 */
	abstract public function save( $mode = TOPLISTS_SAVE_AUTODETECT );
}
