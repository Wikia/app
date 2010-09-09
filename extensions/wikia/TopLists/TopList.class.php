<?php
/**
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * TopList object implementation
 */

class TopList extends TopListBase {
	protected $mRelatedArticle = null;
	protected $mPicture = null;
	protected $mUnsavedItems = null;

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * overrides TopListBase::_loadData
	 */
	protected function _loadData( $forceReload = false ) {
		parent::_loadData( $forceReload );
		
		if( !$this->mDataLoaded || $forceReload ) {
			if( $this->exists() ) {
				TopListParser::parse( $this );

				$relatedArticle = TopListParser::getAttribute( TOPLIST_ATTRIBUTE_RELATED );
				
				if( !empty( $relatedArticle ) ) {
					$relatedArticle =  Title::newFromText( $relatedArticle );
				}

				$this->setRelatedArticle( $relatedArticle );

				$picture = TopListParser::getAttribute( TOPLIST_ATTRIBUTE_PICTURE );

				if( !empty( $picture ) ) {
					$picture =  Title::newFromText( $picture );
				}

				$this->setRelatedArticle( $picture );
			}

			$this->mDataLoaded = true;
		}
	}
	
	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * overrides TopListBase::checkForProcessing
	 */
	public function checkForProcessing( $mode = TOPLISTS_SAVE_AUTODETECT, User $user = null ) {
		$errors = parent::checkForProcessing( $mode, $user );

		if( $errors === true ) {
			$errors = array();
		}
		
		if( !empty( $this->mRelatedArticle ) ) {
			if( !$this->mRelatedArticle->exists() ) {
				$errors[] = array(
					'msg' => 'toplists-error-related-article-not-exists',
					'params' => array(
						$this->mRelatedArticle->getText(),
						$this->mRelatedArticle->getEditURL()
					)
				);
			}
		}
		
		if( !empty( $this->mPicture ) ) {
			if( !$this->mPicture->exists() || $this->mPicture->getNamespace() != NS_FILE ) {
				$pictureName = $this->mPicture->getText();
				$errors[] = array(
					'msg' => 'toplists-error-selected-picture-not-exists',
					'params' => array(
						$pictureName,
						Skin::makeSpecialUrl( "Upload", array( 'wpDestFile' => $pictureName ) )
					)
				);
			}
		}

		return ( empty( $errors ) ) ? true : $errors;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Returns a Title instance referencing an article related to this list's contents
	 *
	 * @param bool $forceReload if set to true the local cache will be refreshed
	 *
	 * @return a Title instance, null if none is set for this list
	 */
	public function getRelatedArticle( $forceReload = false ) {
		$this->_loadData( $forceReload );
		return $this->mRelatedArticle;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Adds a reference to an article related to this list's contents
	 *
	 * @param Title $relatedArticle a Title instance for the article to reference
	 *
	 * @return true in case of success, false if the article doesn't exist
	 */
	public function setRelatedArticle( Title $relatedArticle = null ) {
		$this->mRelatedArticle = $relatedArticle;
		return true;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Returns a Title instance referencing an image file in the NS_FILE namespace related to this list
	 *
	 * @param bool $forceReload if set to true the local cache will be refreshed
	 *
	 * @return a Title instance, null if none is set for this list
	 */
	public function getPicture( $forceReload = false ) {
		$this->_loadData( $forceReload );
		return $this->mPicture;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Adds a reference to an article related to this list's contents
	 *
	 * @param Title $relatedArticle a Title instance for the article to reference
	 *
	 * @return true in case of success, false if the article doesn't exist
	 */
	public function setPicture( Title $picture = null ) {
		$this->mPicture = $picture;
		return true;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Adds an item to the TopList article in the form of a subpage
	 *
	 * @param Title $title a Title class instance for the list item subpage
	 */
	public function addItem( Title $title ) {
		//TODO: refactoring in progress
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Removes an item/subpage from the TopList article
	 *
	 * @param string $itemName the subpage title
	 */
	public function removeItem( $itemName ) {
		//TODO: refactoring in progress
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Fetches lists's items
	 *
	 * @return array an array of TopListItem instances
	 */
	public function getItems() {
		$result = array();
		//TODO: refactoring in progress
		return $result;
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
			$contentText = '';

			if ( !empty( $this->mRelatedArticle ) ) {
				$contentText .= ' ' . TOPLIST_ATTRIBUTE_RELATED . '="' . htmlspecialchars( $this->mRelatedArticle->getText() ) . '"';
			}

			if ( !empty( $this->mPicture ) ) {
				$contentText .= ' ' . TOPLIST_ATTRIBUTE_PICTURE . '="' . htmlspecialchars( $this->mPicture->getText() ) . '"';
			}

			$summaryMsg = null;
			$editMode = null;

			if ( $mode == TOPLISTS_SAVE_CREATE ) {
				$summaryMsg = 'toplists-list-creation-summary';
				$editMode = EDIT_NEW;
			} else {
				$summaryMsg = 'toplists-list-update-summary';
				$editMode = EDIT_UPDATE;
			}

			wfLoadExtensionMessages( 'TopLists' );
			$article = $this->getArticle();

			$status = $article->doEdit( '<' . TOPLIST_TAG . "{$contentText} />", wfMsgForContent( $summaryMsg, $this->mTitle ), $editMode );

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