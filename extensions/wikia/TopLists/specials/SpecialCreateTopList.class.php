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
		$errors = array();
		$listName = $wgRequest->getText( 'wpListName', null );//handles redirects form edit specialpage for non-existing lists
		$relatedArticleName = null;
		$selectedPictureName = null;
		$items = null;
		
		if( $wgRequest->wasPosted() ) {
			$listName = $wgRequest->getText( 'list_name' );
			$relatedArticleName = $wgRequest->getText( 'related_article_name' );
			$selectedPictureName = $wgRequest->getText( 'selected_picture_name' );
			$itemsNames = array_filter( $wgRequest->getArray( 'items_names', array() ) );

			$list = TopList::newFromText( $listName );
			$listUrl = null;

			if ( !( $list ) ) {
				$errors[] = wfMsg('toplists-error-invalid-title');
			} else {
				$title = $list->getTitle();
				$listName = $title->getText();
				$listUrl = $title->getFullUrl();

				if( !empty( $relatedArticleName ) ) {
					$list->setRelatedArticle( Title::newFromText( $relatedArticleName ) );
				}

				if( !empty( $selectedPictureName ) ) {
					$list->setPicture( Title::newFromText( $selectedPictureName ) );
				}

				$checkResult = $list->checkForProcessing( TOPLISTS_SAVE_CREATE );

				if( $checkResult !== true ) {
					foreach ( $checkResult as $errorTuple ) {
						$errors[] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
					}
				} else {
					//first check all the items and then save the list, saving items happens only after this

					//TODO: refactor in progress

					$saveResult = $list->save();

					if( $saveResult !== true ) {
						foreach ( $saveResult as $errorTuple ) {
							$errors[] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
						}
					} else {
						//save items, in this case errors go in session and are displayed in the redirected edit specialpage

						//TODO: refactor in progress
						/*foreach( $itemsNames as $index => $itemName ) {
							$itemErrors = array();
							$itemTitle = Title::newFromText( "{$listName}/{$itemName}", NS_TOPLIST );
							$itemName = $title->getText();

							if ( !( $itemTitle instanceof Title ) ) {
								$itemErrors[] = wfMsg('toplists-error-invalid-item-title', $index );
							}
							else {
								if ( $itemTitle->exists() && ( empty( $editListName ) ) ) {
									$itemErrors[] = wfMsg('toplists-error-item-title-exists', $index );
								}
								else {
									if ( !wfRunHooks( 'TopLists::CreateListTitleCheck', array( $itemTitle ) ) ) {
										$itemErrors[] = wfMsg('toplists-error-item-title-spam', $index );
									}

									if ( $title->getNamespace() == -1 ) {
										$itemErrors[] = wfMsg('toplists-error-invalid-item-title', $index );
									}

									if ( $wgUser->isBlockedFrom( $itemTitle, false ) ) {
										$itemErrors[] = wfMsg('toplists-error-article-item-blocked', $index );
									}
								}
							}

							if( empty( $itemErrors ) ) {
								$itemsTitles[] = $itemTitle;
							}
							else {
								$errors = array_merge($errors, $itemErrors);
							}
						}*/

						if( empty( $errors ) ) {
							$wgOut->redirect( $listUrl );
						} else {
							//redirect to edit form

							//TODO: implement
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

		if ( empty( $items ) ) {
			//show 3 empty items by default
			for ( $x = 0; $x < 3; $x++ ) {
				$items[] = array(
					'type' => 'new',
					'value' => null
				);
			}
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