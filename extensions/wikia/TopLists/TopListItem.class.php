<?php
/**
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * TopListItem object implementation
 */

class TopListItem extends TopListBase {
	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Factory method
	 *
	 * @param string $name a string representation of the article title
	 *
	 * @return mixed a TopListItem instance, false in case $name represents a title not in the NS_TOPLIST namespace
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
	 * @return mixed a TopListItem instance, false in case $title is not in the NS_TOPLIST namespace
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
	 * Add a vote for the item
	 */
	public function vote() {
		//TODO: implement
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Gets the total number of votes for the item
	 *
	 * @return integer a number representing the total amount of votes for this item
	 */
	public function getVotesCount() {
		//TODO: implement
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Checks if the user has already casted a vote
	 *
	 * @param User $user a User instance, it will default to $wgUser if none is given
	 *
	 * @return boolean true if no vote has been recorded for the user, false otherwise
	 */
	public function userCanVote( User $user = null ) {
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
	 * overrides TopListBase::checkForProcessing
	 */
	public function checkForProcessing( $mode = TOPLISTS_SAVE_AUTODETECT, User $user = null, $listMode = TOPLISTS_SAVE_UPDATE ) {
		$errors = parent::checkForProcessing( $mode, $user );

		if( $errors === true ) {
			$errors = array();
		}
		
		$title = Title::newFromText( $this->mTitle->getBaseText(), NS_TOPLIST );

		if( !( ( $title instanceof Title ) && $title->exists() ) && $listMode == TOPLISTS_SAVE_UPDATE ) {
			$errors [] = array(
				'msg' => 'toplists-error-article-not-exists',
				'params' => array(
					$title->getSubpageText(),
					$title->getEditURL()
				)
			);
		}

		return ( empty( $errors ) ) ? true : $errors;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * overrides TopListBase::save
	 */
	public function save( $mode = TOPLISTS_SAVE_AUTODETECT ) {
		$errors = array();
		$mode = $this->_detectProcessingMode( $mode );
		$checkResult = $this->checkForProcessing( $mode );

		if ( $checkResult === true ) {
			$summaryMsg = null;
			$editMode = null;

			if ( $mode == TOPLISTS_SAVE_CREATE ) {
				$summaryMsg = 'toplists-item-creation-summary';
				$editMode = EDIT_NEW;
			} else {
				$summaryMsg = 'toplists-item-update-summary';
				$editMode = EDIT_UPDATE;
			}

			wfLoadExtensionMessages( 'TopLists' );
			$article = $this->getArticle();

			$status = $article->doEdit( '', wfMsgForContent( $summaryMsg, $this->mTitle ), $editMode );

			if ( !$status->isOK() ) {
				foreach ( $status->getErrorsArray() as $msg ) {
					$errors[] = $errors[] = array(
						'msg' => $msg,
						'params' => null
					);
				}
			} else {
				//purge parent article's cache
				$listTitle = Title::newFromText( $this->mTitle->getBaseText() );
				$listTitle->invalidateCache();
			}
		} else {
			$errors = array_merge( $errors, $checkResult );
		}

		return ( empty( $errors ) ) ? true : $errors;
	}
}