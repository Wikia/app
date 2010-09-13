<?php
class SpecialCreateTopList extends SpecialPage {
	function __construct() {
		wfLoadExtensionMessages( 'TopLists' );
		parent::__construct( 'CreateTopList', 'toplists-create-edit-list', true /* listed */ );
	}

	function execute( $par ) {
		wfProfileIn( __METHOD__ );

		global $wgExtensionsPath, $wgStyleVersion, $wgStylePath , $wgJsMimeType, $wgSupressPageSubtitle, $wgRequest, $wgOut, $wgUser;

		if( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}
		
		// set basic headers
		$this->setHeaders();

		// include resources (css and js)
		//$wgOut->addExtensionStyle( "{$wgExtensionsPath}/wikia/TopLists/css/editor.css?{$wgStyleVersion}\n" );
		$wgOut->addStyle(wfGetSassUrl("$wgExtensionsPath/wikia/TopLists/css/editor.scss"));
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/TopLists/js/editor.js?{$wgStyleVersion}\"></script>\n" );
		
		//hide specialpage subtitle in Oasis
		$wgSupressPageSubtitle = true;

		TopListHelper::clearSessionItemsErrors();
		
		//handles redirects form edit specialpage for non-existing lists
		$listName = $wgRequest->getText( 'wpListName', null );
		
		$errors = array();
		$relatedArticleName = null;
		$selectedPictureName = null;
		$items = null;
		
		if( $wgRequest->wasPosted() ) {
			$listName = $wgRequest->getText( 'list_name' );
			$relatedArticleName = $wgRequest->getText( 'related_article_name' );
			$selectedPictureName = $wgRequest->getText( 'selected_picture_name' );
			$itemsNames = array_filter( $wgRequest->getArray( 'items_names', array() ) );
			$listItems = array();

			$list = TopList::newFromText( $listName );
			$listUrl = null;

			if ( !( $list ) ) {
				$errors[ 'list_name' ] = array( wfMsg( 'toplists-error-invalid-title' ) );
			} else {
				$title = $list->getTitle();
				$listName = $title->getText();
				$listUrl = $title->getFullUrl();

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
						}
					}
				}

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
						}
					}
				}

				$checkResult = $list->checkForProcessing( TOPLISTS_SAVE_CREATE );

				if ( $checkResult !== true ) {
					foreach ( $checkResult as $errorTuple ) {
						$errors[ 'list_name' ][] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
					}
				} else {
					//first check all the items and then save the list, saving items happens only after this

					$alreadyProcessed = array();

					foreach ( $itemsNames as $index => $itemName ) {
						$lcName = strtolower( $itemName );
						$index++;//index 0 refers to the empty template item in the form

						if ( in_array( $lcName, $alreadyProcessed) ) {
							$errors[ "item_{$index}" ] = array( wfMsg( 'toplists-error-duplicated-entry' ) );
						} else {
							$alreadyProcessed[] = $lcName;
							
							$listItem = $list->createItem();
							
							if ( empty( $listItem ) ) {
								$errors[ "item_{$index}" ] = array( wfMsg( 'toplists-error-invalid-title' ) );
							} else {
								$listItem->setNewContent( $itemName );
								$checkResult = $listItem->checkForProcessing( TOPLISTS_SAVE_CREATE, null, TOPLISTS_SAVE_CREATE );

								if ( $checkResult !== true ) {
									foreach ( $checkResult as $errorTuple ) {
										$errors[ "item_{$index}" ][] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
									}
								} else {
									$listItems[] = $listItem;
								}
							}
						}
					}

					if ( empty( $errors ) ) {
						$saveResult = $list->save();
						
						if ( $saveResult !== true ) {
							foreach ( $saveResult as $errorTuple ) {
								$errors[  'list_name'  ] = array( wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] ) );
							}
						} else {
							//save items, in this case errors go in session and are displayed in the redirected edit specialpage
							$unsavedItemNames = array();
							$itemsErrors = array();

							foreach( $listItems as $item ) {
								$saveResult = $item->save();
								
								if ( $saveResult !== true ) {
									$unsavedItemNames[] = $item->getNewContent();
									$counter = 0;
									
									foreach ( $saveResult as $errorTuple ) {
										$itemsErrors[] = array( wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] ) );
										$counter++;
									}
								}
							}

							if( count( $listItems ) ) {
								//update page's cache, items where added
								$list->getTitle()->invalidateCache();

								//TODO: for more stable behaviour create a memcache bool key and use it in the parser function
								//to detect if the page is being viewed for the first time, if it is the force connection to master
								//and set the key to false
							}

							if( empty( $itemsErrors ) ) {
								$wgOut->redirect( $listUrl );
							} else {
								TopListHelper::setSessionItemsErrors( $listName, $unsavedItemNames, $itemsErrors );

								$specialPageTitle = Title::newFromText( 'EditTopList', NS_SPECIAL );

								$wgOut->redirect( $specialPageTitle->getFullUrl() . '/' . $list->getTitle()->getPrefixedURL() );
							}
						}
					}
				}
			}

			foreach ( $itemsNames as $item ) {
				$items[] = array(
					'type' => 'new',
					'value' => $item
				);
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
			'mode' => 'create',
			'listName' => $listName,
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
			)
		) );

		// render template
		$wgOut->addHTML( $template->render( 'form' ) );

		wfProfileOut( __METHOD__ );
	}
}