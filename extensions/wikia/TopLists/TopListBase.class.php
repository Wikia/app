<?php
/**
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * TopListBase base class implementation, all the item/list management classes derives from this one
 */

class TopListBase {
	protected $mTitle = null;
	protected $mArticle = null;
	protected $mAuthor = null;
	protected $mCreationTimestamp = null;
	protected $mDataLoaded = false;
	protected $mEditor = null;

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Factory method
	 *
	 * @param string $name a string representation of the article title
	 *
	 * @return mixed a TopListBase instance, false in case $name represents a title not in the NS_TOPLIST namespace
	 */
	static public function newFromText( $name ) {
		$title = Title::newFromText( $name, NS_TOPLIST );

		if ( !( $title instanceof Title ) ) {
			return false;
		}

		return self::newFromTitle( $title );
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Factory method
	 *
	 * @param Title $title a Title class instance for the article
	 *
	 * @return mixed a TopListBase instance, false in case $title is not in the NS_TOPLIST namespace
	 */
	static public function newFromTitle( Title $title ) {
		if ( $title->getNamespace() == NS_TOPLIST ) {
			$list = new self();
			$list->mTitle = $title;

			return $list;
		}

		return false;
	}

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
	 *
	 * Fetches informations about the first revision of the article
	 *
	 * @param boolean $forceMaster true to force read form DB_MASTER (useful to get rid of replication delay/lag), false (default) for DB_SLAVE
	 *
	 * @return Array an array containing a 'userId' and a 'timestamp' elements, representing in order rev_user and rev_timestamp from the rev_page table,
	 * if the article exists, null otherwise
	 */
	protected function _getFirstRevision( $forceMaster = false ) {
		if( $this->exists() ) {
			$dbs = wfGetDB( ( $forceMaster ) ? DB_MASTER : DB_SLAVE );
			
			$res = $dbs->selectRow(
				'revision',
				array(
					'rev_user AS userId',
					'rev_timestamp AS timestamp'
				),
				array(
					'rev_page' => $this->mTitle->getArticleID()
				),
				__METHOD__,
				array(
					'ORDER BY' => 'rev_timestamp ASC',
					'LIMIT' => '1'
				)
			);
		} else {
			$res = null;
		}
		
                return $res;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 */
	protected function _loadData( $forceReload = false, $overrideCall = true ) {
		if( ( !$this->mDataLoaded || $forceReload ) ) {
			$revData = $this->_getFirstRevision();
			
			if( !empty( $revData ) ) {
				if( !empty( $revData['userId'] ) ) {
					$this->mAuthor = User::newFromId( $revData['userId'] );
				}

				if( !empty( $revData['timetamp'] ) ) {
					$this->mCreationTimestamp = ( int ) $revData['timetamp'];
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

		$listName = $this->mTitle->getText();
		$listUrl = $this->mTitle->getLocalURL();
		$errors = array();

		if ( $this->mTitle->exists() && $mode == TOPLISTS_SAVE_CREATE ) {
			$errors[] = array(
				'msg' => 'toplists-error-title-exists',
				'params' => array( $listName, $listUrl )
			);
		} elseif ( !$this->mTitle->exists() && $mode == TOPLISTS_SAVE_UPDATE ) {
			$errors[] = array(
				'msg' => 'toplists-error-title-not-exists',
				'params' => array( $listName, $listUrl )
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
	 * @return a Title instance, null if none is set for this list
	 */
	public function getTitle() {
		return $this->mTitle;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Returns an Article instance for this list
	 *
	 * @return an Article instance, null if none is set for this list
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
	 * @return int the timestamp fot the article first edit, null if the article doesn't exst
	 */
	public function getCreationTimestamp() {
		return $this->mCreationTimestamp;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Gets the user that has originally created the article
	 *
	 * @return User a user object for the creator of the article, null if the article doesn't exist
	 */
	public function getAuthor() {
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
	public function save( $mode = TOPLISTS_SAVE_AUTODETECT ) { /*Abstract*/ }
}
