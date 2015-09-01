<?php

class PortableInfoboxBuilderController extends WikiaController {

	const INFOBOX_BUILDER_PARAM = 'portableInfoboxBuilder';

	public function getAssets() {
		$response = $this->getResponse();
		$response->setFormat( WikiaResponse::FORMAT_JSON );
		$response->setVal( "css", AssetsManager::getInstance()->getURL( "portable_infobox_scss" ) );
	}

	public function publish() {
		$status = new Status();
		$response = $this->getResponse();
		$response->setFormat( WikiaResponse::FORMAT_JSON );

		$params = $this->getRequest()->getParams();

		if ( $params[ 'title' ] ) {
			$pageTitleObj = Title::newFromText( $params[ 'title' ] );
			if ( $pageTitleObj->userCan( 'edit' ) ) {
				$pageArticleObj = new Article( $pageTitleObj );
				$editPage = new EditPage( $pageArticleObj );
				$editPage->initialiseForm();
				$editPage->edittime = $pageArticleObj->getTimestamp();
				$editPage->textbox1 = ( new PortableInfoboxBuilderService() )->translate( $params[ 'data' ] );
				$status = $editPage->internalAttemptSave( $result );
			} else {
				$status->fatal( 'user-cant-edit' );
			}
		} else {
			$status->fatal( 'no-title-provided' );
		}

		$response->setVal( "success", $status->isOK() );
		$response->setVal( "errors", $status->getErrorsArray() );
		$response->setVal( "warnings", $status->getWarningsArray() );
	}
}
