<?php

class PortableInfoboxBuilderController extends WikiaController {

	const INFOBOX_BUILDER_PARAM = 'portableInfoboxBuilder';

	public function getAssets() {
		$response = $this->getResponse();
		$response->setFormat( WikiaResponse::FORMAT_JSON );
		$response->setVal( 'css', AssetsManager::getInstance()->getURL( 'portable_infobox_scss' ) );

		$params = $this->getRequest()->getParams();
		if ( isset( $params['title'] ) ) {
			$infoboxes = PortableInfoboxDataService::newFromTitle(
				Title::newFromText($params['title'],NS_TEMPLATE)
			)->getInfoboxes();

			$builderService = new PortableInfoboxBuilderService();
			if ( $builderService->isValidInfoboxArray( $infoboxes ) ) {
				$response->setVal( 'data', $builderService->translateMarkupToData( $infoboxes[0] ) );
			}
		} else {
			$status = new Status();
			$status->warning( 'no-title-provided' );
			$response->setVal( 'warnings', $status->getWarningsArray() );
		}
	}

	public function publish() {
		$response = $this->getResponse();
		$response->setFormat( WikiaResponse::FORMAT_JSON );

		$status = $this->attemptSave( $this->getRequest()->getParams() );

		$response->setVal( 'success', $status->isOK() );
		$response->setVal( 'errors', $status->getErrorsArray() );
		$response->setVal( 'warnings', $status->getWarningsArray() );
	}

	private function attemptSave( $params ) {
		$status = new Status();
		// check for title
		if ( !$params[ 'title' ] ) {
			$status->fatal( 'no-title-provided' );
		}
		$title = $status->isGood() ? Title::newFromText( $params[ 'title' ], NS_TEMPLATE ) : false;
		// check if title object created
		if ( $status->isGood() && !$title ) {
			$status->fatal( 'no-title-object' );
		}
		// user permissions check
		if ( $status->isGood() && !$title->userCan( 'edit' ) ) {
			$status->fatal( 'user-cant-edit' );
		}

		//check if there is no write conflict
		$infoboxDataService = PortableInfoboxDataService::newFromTitle($title);
		$infoboxes = $infoboxDataService->getInfoboxes();

		if ( $status->isGood() && count($infoboxes) > 1 ) {
			$status->fatal( 'article-modified' );
		}

		return $status->isGood() ? $this->save( $title, $params[ 'data' ], $infoboxes[0] ) : $status;
	}

	private function save( Title $title, $data, $oldInfobox) {
		$article = new Article($title);
		$editPage = new EditPage( $article );
		$editPage->initialiseForm();
		$editPage->edittime = $article->getTimestamp();

		$infoboxBuilderService = new PortableInfoboxBuilderService() ;
		$infoboxMarkup = $infoboxBuilderService->translateDataToMarkup( $data );
		$infoboxDocumentation = $infoboxBuilderService->getDocumentation( $infoboxMarkup, $title );

		$oldContent = $article->fetchContent();
		if (empty($oldInfobox)) {
			$editPage->textbox1 = implode( "\n", [ $infoboxMarkup, $infoboxDocumentation, $oldContent ] );
		} else {
			$oldDocumentation = $infoboxBuilderService->getDocumentation($oldInfobox, $title);
			$content = $infoboxBuilderService->updateInfobox($oldInfobox, $infoboxMarkup, $oldContent);
			$editPage->textbox1 = $infoboxBuilderService->updateDocumentation($oldDocumentation, $infoboxDocumentation, $content);
		}

		$status = $editPage->internalAttemptSave( $result );
		return $status;
	}
}
