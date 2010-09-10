<?php
class SpecialEditTopList extends SpecialPage {
	function __construct() {
		wfLoadExtensionMessages( 'TopLists' );
		parent::__construct( 'EditTopList', 'toplists-create-edit-list', true /* listed */ );
	}

	private function _redirectToCreateSP(){
		$specialPageTitle = Title::newFromText( 'CreateTopList', NS_SPECIAL );
		$wgOut->redirect( $specialPageTitle->getFullUrl() );
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
		$items = null;

		$list = TopList::newFromText( $editListName );

		if( empty( $list ) || !$list->exists() ) {
			$this->_redirectToCreateSP();
		} else {
			$listName = $list->getTitle()->getText();
			$listUrl = $list->getTitle()->getLocalUrl();

			foreach( $list->getItems() as $item ) {
				$items[] = array(
					'type' => 'existing',
					'value' => $item->getTitle()->getSubpageText()
				);
			}
		}
		
		//TODO: refactor in progress

		if( $wgRequest->wasPosted() ) {
			//TODO: refactor in progress
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
			)
		) );

		// render template
		$wgOut->addHTML( $template->render( 'form' ) );

		wfProfileOut( __METHOD__ );
	}
}