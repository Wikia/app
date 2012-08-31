<?php
class SpecialEditTopList extends SpecialPage {
	function __construct() {
		parent::__construct( 'EditTopList', 'toplists-create-edit-list', false /* not listed */ );
	}

	private function _redirectToCreateSP( $listName = null ){
		global $wgOut;

		$specialPageTitle = Title::newFromText( 'CreateTopList', NS_SPECIAL );
		$url = $specialPageTitle->getFullUrl();

		if( !empty( $listName ) ) {
			$url .= '/' . wfUrlencode( $listName );
		}

		$wgOut->redirect( $url );
	}

	function execute( $editListName ) {
		global $wgExtensionsPath, $wgJsMimeType, $wgSupressPageSubtitle, $wgRequest, $wgOut, $wgUser;
		wfProfileIn( __METHOD__ );

		// set basic headers
		$this->setHeaders();

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			wfProfileOut( __METHOD__ );
			return;
		}

		//Check blocks
		if( $wgUser->isBlocked() ) {
			wfProfileOut( __METHOD__ );
			throw new UserBlockedError( $wgUser->getBlock() );
		}

		if ( !( F::app()->checkSkin( 'oasis' ) ) ) {
			$this->getOutput()->showErrorPage( 'error', 'toplists-oasis-only' );
			wfProfileOut( __METHOD__ );
			return;
		}

		if( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}

		if( empty( $editListName ) ) {
			$this->_redirectToCreateSP();
		}

		// include resources (css and js)
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/TopLists/css/editor.scss'));
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/TopLists/js/editor.js\"></script>\n" );

		//hide specialpage subtitle in Oasis
		$wgSupressPageSubtitle = true;

		$errors = array();
		$listName = null;
		$listUrl = null;
		$relatedArticleName = null;
		$description = null;
		$selectedPictureName = null;
		$items = array();
		$removedItems = array();

		$list = TopList::newFromText( $editListName ); /** @var $list TopList */

		if ( empty( $list ) || !$list->exists() ) {
			$this->_redirectToCreateSP( $editListName );
		} else {
			$title = $list->getTitle();
			$listName = $title->getText();
			$description = $list->getDescription();
			$listUrl = $title->getFullURL();
			$listItems = $list->getItems();
			$userCanEditItems = $list->checkUserItemsRight( 'edit' );
			$userCanDeleteItems = $list->checkUserItemsRight( 'delete' );

			if ( $wgRequest->wasPosted() ) {
				TopListHelper::clearSessionItemsErrors();

				$relatedArticleName = $wgRequest->getText( 'related_article_name' );
				$selectedDescription = $wgRequest->getText( 'description' );
				$selectedPictureName = $wgRequest->getText( 'selected_picture_name' );
				$itemsNames = $wgRequest->getArray( 'items_names', array() );
				$removedItems = ( $userCanDeleteItems ) ? $wgRequest->getArray( 'removed_items', array() ) : array();

				//handle related article
				$title = $list->getRelatedArticle();
				$curValue = null;

				if ( !empty( $title ) ) {
					$curValue = $title->getText();
				}

				$relatedArticleChanged = ( $curValue != $relatedArticleName );

				if ( $relatedArticleChanged ) {
					if ( !empty( $relatedArticleName ) ) {
						$title = Title::newFromText( $relatedArticleName );

						if ( empty( $title ) ) {
							$errors[ 'related_article_name' ] = array( wfMsg( 'toplists-error-invalid-title' )  );
						} else {
							$setResult = $list->setRelatedArticle( $title );

							if ( $setResult !== true ) {
								foreach ( $setResult as $errorTuple ) {
									$errors[ 'related_article_name' ][] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
								}
							}
						}
					} else {
						$list->setRelatedArticle( null );
					}
				}

				//handle picture
				$title = $list->getPicture();
				$curValue = null;

				if ( !empty( $title ) ) {
					$curValue = $title->getText();
				}

				$selectedPictureChanged = ( $curValue != $selectedPictureName );

				if ( $selectedPictureChanged ) {
					if ( !empty( $selectedPictureName ) ) {
						$title = Title::newFromText( $selectedPictureName, NS_FILE );

						if ( empty( $title ) ) {
							$errors[ 'selected_picture_name' ][] = wfMsg( 'toplists-error-invalid-picture' );
						} else {
							$setResult = $list->setPicture( $title );

							if ( $setResult !== true ) {
								foreach ( $setResult as $errorTuple ) {
									$errors[ 'selected_picture_name' ][] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
								}
							}
						}
					} else {
						$list->setPicture( null );
					}
				}

				//handle description
				$curValue = null;
				if ( !empty($description) ) {
					$curValue = $description;
				}

				$selectedDescriptionChanged = ( $curValue != $selectedDescription );

				if ( $selectedDescriptionChanged ) {
					$list->setDescription($selectedDescription);
				}

				//check the list for processability
				$checkResult = $list->checkForProcessing( TOPLISTS_SAVE_UPDATE );

				if ( $checkResult !== true ) {
					foreach ( $checkResult as $errorTuple ) {
						$errors[ 'list_name' ][] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
					}
				}

				//filter input
				foreach ( $itemsNames as $index => $item ) {
					$itemsNames[ $index ] = trim( $item );
				}

				//collect existing items and related updates, filter out the removed ones (processed separately)
				$counter = 0;
				foreach ( $listItems as $index => $item ) {
					if ( !in_array( $index, $removedItems ) ) {
						$items[] = array(
							'type' => 'existing',
							'value' => $itemsNames[ $counter ],
							'index' => $index,
							'changed' => false,
							'object' => null
						);

						if ( empty( $itemsNames[ $counter ] ) ) {
							$errors[ 'item_' . ( $counter + 1 ) ][] = wfMsg( 'toplists-error-empty-item-name' );
						} elseif (
							$userCanEditItems &&
							$listItems[ $index ]->getArticle()->getContent() != $itemsNames[ $counter ]
						) {
							$listItems[ $index ]->setNewContent( $itemsNames[ $counter ] );
							$items[ $counter ][ 'object' ] = $listItems[ $index ];
							$items[ $counter ][ 'changed' ] = true;
						}

						$counter++;
					}
				}

				//collect new items, filter out the empty ones
				$splitAt = count( $listItems ) - count( $removedItems );
				$newItemsNames = array_filter( array_slice( $itemsNames, $splitAt ) );

				foreach ( $newItemsNames as $index => $item ) {
					$items[] = array(
						'type' => 'new' ,
						'value' => $item,
						'changed' => true
					);

					$newItem = $list->createItem();
					$newItem->setNewContent( $newItemsNames[ $index ] );

					$items[ $counter ][ 'object' ] = $newItem;
					$counter++;
				}

				//check items for processing
				$usedNames = array();

				foreach ( $items as $index => $item ) {
					$lcName = strtolower( $item[ 'value' ] );

					if( in_array( $lcName, $usedNames) ) {
						$errors[ 'item_' . ++$index ][] =  wfMsg( 'toplists-error-duplicated-entry' );
					} else {
						$usedNames[] = $lcName;
					}

					if ( $item[ 'changed' ] && !empty( $item[ 'object' ] ) ) {
						if ( $item['type'] == 'new' ) {
							$checkResult = $item[ 'object' ]->checkForProcessing(TOPLISTS_SAVE_AUTODETECT, null, TOPLISTS_SAVE_CREATE );
						} else {
							$checkResult = $item[ 'object' ]->checkForProcessing();
						}

						if ( $checkResult !== true ) {
							foreach ( $checkResult as $errorTuple ) {
								$errors[ 'item_' . ++$index ][] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
							}
						}
					}
				}

					//with no errors or no save required, proceed with items
					$itemTouched = 0;
					if ( empty( $errors ) ) {
						foreach ( $items as $index => $item ) {
							if ( $item[ 'changed' ] && !empty( $item[ 'object' ] ) ) {
								$saveResult = $item[ 'object' ]->save();

								if ( $saveResult !== true ) {
									foreach ( $saveResult as $errorTuple ) {
										$errors[ 'item_' . ++$index ][] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
									}
								} else {
									$item[ 'object' ]->getTitle()->invalidateCache();
									$itemTouched++;
								}
							}
						}

						//purge items removed from the list
						foreach ( $removedItems as $index ) {
							$item = $listItems[ $index ];
							if ( is_object( $item ) && ( $item instanceof TopListItem ) ){
								$removeResult = $item->remove();
							} else {
								// if item does not exist it means that it's deleted anyway
								$removeResult = true;
							}

							if ( $removeResult !== true ) {
								$items[] = array(
									'type' => 'existing',
									'value' => $item->getArticle()->getContent(),
									'index' => $counter,
									'changed' => false,
									'object' => $item
								);

								$counter++;

								foreach ( $removeResult as $errorTuple ) {
									$errors[ 'item_' . $counter ][] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
								}
							}
							else {
								$itemTouched++;
							}
						}
					}

				//if no errors proceed with saving, list comes first
				if ( empty( $errors ) || $itemTouched ) {
					if ( $relatedArticleChanged || $selectedPictureChanged || $selectedDescriptionChanged || $itemTouched ) {
						$saveResult = $list->save();

						if ( $saveResult !== true ) {
							foreach ( $saveResult as $errorTuple ) {
								$errors[  'list_name'  ] = array( wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] ) );
							}
						}
					}

					//invalidate caches
					$list->invalidateCache();

					if ( empty( $errors ) ) {
						$wgOut->redirect( $listUrl );
					}
				}
			} else {
				$title = $list->getRelatedArticle();

				if ( !empty( $title ) ) {
					$relatedArticleName = $title->getText();
				}

				$title = $list->getPicture();

				if ( !empty( $title ) ) {
					$selectedPictureName = $title->getText();
				}

				foreach ( $listItems as $index => $item ) {
					$items[] = array(
						'type' => 'existing',
						'value' => $item->getArticle()->getContent(),
						'index' => $index
					);
				}

				list( $sessionListName, $failedItemsNames, $sessionErrors ) = TopListHelper::getSessionItemsErrors();

				if ( $listName == $sessionListName && !empty( $failedItemsNames ) ) {
					$counter = count( $items );

					foreach ( $failedItemsNames as $index => $itemName ) {
						$items[] = array(
							'type' => 'new',
							'value' => $itemName
						);

						$errors[ 'item_' . $counter++ ] = $sessionErrors[ $index ];
					}
				}

				TopListHelper::clearSessionItemsErrors();
			}

			$selectedImage = null;

			if( !empty( $selectedPictureName ) ) {
				$source = new ImageServing(
						null,
						120,
						array(
							"w" => 3,
							"h" => 2
						)
					);

				$result = $source->getThumbnails( array( $selectedPictureName ) );

				if( !empty( $result[ $selectedPictureName ] ) ) {
					$selectedImage = $result[ $selectedPictureName ];
				}
			}

			//show at least 3 items by default, if not enough fill in with empty ones
			for ( $x = ( !empty( $items ) ) ? count( $items ) : 0; $x < 3; $x++ ) {
				$items[] = array(
					'type' => 'new',
					'value' => null
				);
			}

			// pass data to template
			$template = new EasyTemplate( dirname( __FILE__ ) . '/../templates' );
			$template->set_vars( array(
				'mode' => 'update',
				'listName' => $listName,
				'listUrl' => $listUrl,
				'relatedArticleName' => $relatedArticleName,
				'description' => $description,
				'selectedImage' => $selectedImage,
				'errors' => $errors,
				//always add an empty item at the beginning to create the clonable template
				'items' => array_merge(
					array( array(
						'type' => 'template',
						'value' => null
					) ),
					$items
				),
				'removedItems' => $removedItems,
				'userCanEditItems' => $userCanEditItems,
				'userCanDeleteItems' => $userCanDeleteItems
			) );

			// render template
			$wgOut->addHTML( $template->render( 'editor' ) );

		}
		wfProfileOut( __METHOD__ );
	}
}
