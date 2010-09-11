<?php
class SpecialEditTopList extends SpecialPage {
	function __construct() {
		wfLoadExtensionMessages( 'TopLists' );
		parent::__construct( 'EditTopList', 'toplists-create-edit-list', true /* listed */ );
	}

	private function _redirectToCreateSP( $listName = null ){
		$specialPageTitle = Title::newFromText( 'CreateTopList', NS_SPECIAL );
		$url = $specialPageTitle->getFullUrl();

		if( !empty( $listName ) ) {
			$url .= '/' . wfUrlencode( $listName );
		}
		
		$wgOut->redirect( $url );
	}

	function execute( $editListName ) {
		wfProfileIn( __METHOD__ );

		global $wgExtensionsPath, $wgStyleVersion, $wgStylePath , $wgJsMimeType, $wgSupressPageSubtitle, $wgRequest, $wgOut, $wgUser;

		if( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		if( empty( $editListName ) ) {
			$this->_redirectToCreateSP();
		}
		
		// set basic headers
		$this->setHeaders();

		// include resources (css and js)
		//$wgOut->addExtensionStyle( "{$wgExtensionsPath}/wikia/TopLists/css/editor.css?{$wgStyleVersion}\n" );
		$wgOut->addStyle(wfGetSassUrl("$wgExtensionsPath/wikia/TopLists/css/editor.scss"));
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/TopLists/js/editor.js?{$wgStyleVersion}\"></script>\n" );
		
		//hide specialpage subtitle in Oasis
		$wgSupressPageSubtitle = true;
		$errors = array();
		$listName = null;
		$listUrl = null;
		$relatedArticleName = null;
		$selectedPictureName = null;
		$items = array();
		$listItems = array();
		$existingItems = array();
		$removedItems = array();

		$list = TopList::newFromText( $editListName );

		if ( empty( $list ) || !$list->exists() ) {
			$this->_redirectToCreateSP( $editListName );
		}

		$title = $list->getTitle();
		$listName = $title->getText();
		$listUrl = $title->getLocalUrl();
		$listItems = $list->getItems();

		

		if ( $wgRequest->wasPosted() ) {
			TopListHelper::clearSessionItemsErrors();

			$relatedArticleName = $wgRequest->getText( 'related_article_name' );
			$selectedPictureName = $wgRequest->getText( 'selected_picture_name' );
			$itemsNames = $wgRequest->getArray( 'items_names', array() );
			$removedItems = $wgRequest->getArray( 'removed_items', array() );
			$splitAt = count( $listItems ) - count( $removedItems );
			
			$counter = 0;
			foreach ( $listItems as $index => &$item ) {
				if ( !in_array( $index, $removedItems ) ) {
					$items[] = array(
						'type' => 'existing',
						'value' => $itemsNames[ $index ],
						'index' => $index
					);

					if ( empty( $itemsNames[ $index ] ) ) {
						$errors[ 'item_' . ( $counter + 1 ) ] = wfMsg( 'toplists-error-empty-item-name' );
					} elseif ( $item->getArticle()->getContent() != $itemsNames[ $index ] ) {
						$item->setNewContent( $itemsNames[ $index ] );
						$items[ $counter ][ 'object' ] = $item;
					}
					
					$counter++;
				}
			}

			
			$newItemsNames = array_filter( array_slice( $itemsNames, $splitAt ) );
			$itemsToSave = array();

			foreach( $newItemsNames as $index => $item ) {
				$items[] = array(
					'type' => 'new' ,
					'value' => $item,
					'index' => $index
				);

				$newItem = $list->createItem();
				$newItem->setNewContent( $itemsNames[ $index ] );
				$items[ $counter ][ 'object' ] = $newItem;

				$counter++;
			}

			//TODO: iterate through $items and check objects for processing

			$relatedArticleChanged = false;

			if ( !empty( $relatedArticleName ) ) {
				$article = Title::newFromText( $relatedArticleName );

				if ( empty( $article ) ) {
					$errors[ 'related_article_name' ] = array( wfMsg( 'toplists-error-invalid-title' )  );
				} else {
					$setResult = $list->setRelatedArticle( $article );

					if ( $setResult !== true ) {
						foreach ( $setResult as $errorTuple ) {
							$errors[ 'related_article_name' ][] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
						}
					} else {
						$relatedArticleChanged = true;
					}
				}
			}

			$selectedPictureChanged = false;

			if ( !empty( $selectedPictureName ) ) {
				$article = Title::newFromText( $selectedPictureName );

				if ( empty( $article ) ) {
					$errors[ 'selected_picture_name' ] = array( wfMsg( 'toplists-error-invalid-picture' ) );
				} else {
					$setResult = $list->setPicture( $article );

					if ( empty( $article ) || $setResult !== true ) {
						foreach ( $setResult as $errorTuple ) {
							$errors[ 'selected_picture_name' ][] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
						}
					} else {
						$selectedPictureChanged = true;
					}
				}
			}

			$checkResult = $list->checkForProcessing( TOPLISTS_SAVE_UPDATE );

			if ( $checkResult !== true ) {
				foreach ( $checkResult as $errorTuple ) {
					$errors[ 'list_name' ][] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
				}
			}

			if ( empty( $errors ) ) {
				if ( $relatedArticleChanged || $selectedPictureChanged) {
					$saveResult = $list->save();

					if ( $saveResult !== true ) {
						foreach ( $saveResult as $errorTuple ) {
							$errors[  'list_name'  ] = array( wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] ) );
						}
					} else {
						$wgOut->redirect( $listUrl );
					}
				}

				//update page's cache
				$list->getTitle()->invalidateCache();
			}
		} else {
			foreach ( $listItems as $index => $item ) {
				$existingItems[] = array(
					'type' => 'existing',
					'value' => $item->getArticle()->getContent(),
					'index' => $index
				);
			}

			$items += $existingItems;
			
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
			'selectedPictureName' => $selectedPictureName,
			'errors' => $errors,
			//always add an empty item at the beginning to create the clonable template
			'items' => array_merge(
				array( array(
					'type' => 'template',
					'value' => null
				) ),
				$items
			),
			'removedItems' => $removedItems
		) );

		// render template
		$wgOut->addHTML( $template->render( 'form' ) );

		wfProfileOut( __METHOD__ );
	}
}