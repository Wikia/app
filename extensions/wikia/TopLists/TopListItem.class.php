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
	 * overrides TopListBase::save
	 */
	public function save( $mode = TOPLISTS_SAVE_AUTODETECT ) {
		$errors = array();
		$mode = $this->_detectProcessingMode( $mode );
		$checkResult = $this->checkForProcessing( $mode );

		if( $checkResult === true ) {
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
			}

		} else {
			$errors = array_merge( $errors, $checkResult);
		}

		return ( empty( $errors ) ) ? true : $errors;
	}
}