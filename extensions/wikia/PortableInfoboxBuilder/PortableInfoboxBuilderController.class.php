<?php

class PortableInfoboxBuilderController extends WikiaController {

	const INFOBOX_BUILDER_PARAM = 'portableInfoboxBuilder';

	const USER_EDIT_ACTION = 'edit';
	const USER_MOVE_ACTION = 'move';

	public function getAssets() {
		global $wgEnablePortableInfoboxEuropaTheme;

		$response = $this->getResponse();
		$response->setFormat( WikiaResponse::FORMAT_JSON );
		if ( !empty( $wgEnablePortableInfoboxEuropaTheme ) ) {
			$response->setVal( 'css', array_merge(
				AssetsManager::getInstance()->getURL( 'portable_infobox_builder_preview_scss' ),
				AssetsManager::getInstance()->getURL( 'portable_infobox_europa_theme_scss' )
			) );
		} else {
			$response->setVal( 'css', AssetsManager::getInstance()->getURL( 'portable_infobox_builder_preview_scss' ) );
		}
	}

	public function getData() {
		$response = $this->getResponse();
		$params = $this->getRequest()->getParams();
		$isNew = true;
		$data = new stdClass();

		if ( isset( $params[ 'title' ] ) ) {
			$infoboxes = PortableInfoboxDataService::newFromTitle(
				Title::newFromText( $params[ 'title' ], NS_TEMPLATE )
			)->getInfoboxes();

			$builderService = new PortableInfoboxBuilderService();
			if ( !empty( $infoboxes ) && $builderService->isValidInfoboxArray( $infoboxes ) ) {
				$data = $builderService->translateMarkupToData( $infoboxes[ 0 ] );
				$isNew = false;
			}
		}

		$response->setVal( 'data', json_encode( $data ) );
		$response->setVal( 'isNew', $isNew );
	}

	public function publish() {
		$requestParams = $this->getRequest()->getParams();
		$status = $this->attemptSave( $requestParams );

		$urls = PortableInfoboxBuilderHelper::createRedirectUrls( $requestParams[ 'title' ] );

		$response = $this->getResponse();
		$response->setFormat( WikiaResponse::FORMAT_JSON );
		$response->setVal( 'conflict', $status->hasMessage( 'articleexists' ) );
		$response->setVal( 'urls', $urls );
		$response->setVal( 'success', $status->isOK() );
		$response->setVal( 'errors', $status->getErrorsArray() );
		$response->setVal( 'warnings', $status->getWarningsArray() );
	}

	public function getRedirectUrls() {
		$response = $this->getResponse();
		$response->setFormat( WikiaResponse::FORMAT_JSON );

		$requestParams = $this->getRequest()->getParams();
		$urls = PortableInfoboxBuilderHelper::createRedirectUrls( $requestParams[ 'title' ] );

		if ( !empty( $urls ) ) {
			$response->setVal( 'urls', $urls );
			$response->setVal( 'success', true );
		} else {
			$response->setCode( 400 );
			$response->setVal( 'errors', [ 'Could not create URLs from given string' ] );
		}
	}

	public function getTemplateExists() {
		$title = PortableInfoboxBuilderHelper::getTitle( $this->getRequest()->getVal( 'title' ), new Status() );

		$response = $this->getResponse();
		$response->setFormat( WikiaResponse::FORMAT_JSON );

		if ( $title ) {
			$response->setVal( 'exists', $title->isKnown() );
			$response->setVal( 'success', true );
		} else {
			$response->setCode( 400 );
			$response->setVal( 'errors', [ 'Invalid title string passed' ] );
		}
	}

	private function attemptSave( $params ) {
		$status = new Status();

		$title = PortableInfoboxBuilderHelper::getTitle( $params[ 'title' ], $status );
		$oldTitle = PortableInfoboxBuilderHelper::getTitle( $params[ 'oldTitle' ], $status );
		$renamed = $status->isGood() ? Title::compare( $oldTitle, $title ) !== 0 : false;

		$status = $this->checkRequestValidity( $status );
		$status = $this->checkUserPermissions( $title, $status, self::USER_EDIT_ACTION );
		if ( $renamed ) {
			$status = $this->checkUserPermissions( $oldTitle, $status, self::USER_MOVE_ACTION );
			$status = $this->checkMoveEligibility( $oldTitle, $title, $status );
		}

		$infoboxDataService = PortableInfoboxDataService::newFromTitle( $oldTitle );
		$infoboxes = $infoboxDataService->getInfoboxes();
		$status = $this->checkSaveEligibility( $infoboxes, $status );

		$status = $status->isGood() && $renamed ? $this->move( $oldTitle, $title ) : $status;
		return $status->isGood() ? $this->save( $title, $params[ 'data' ], $infoboxes[ 0 ] ) : $status;
	}

	/**
	 * Wraps WikiaDispatchableObject::checkWriteRequest
	 * @param $status
	 * @return Status
	 */
	private function checkRequestValidity( &$status ) {
		try {
			$this->checkWriteRequest();
		} catch ( BadRequestException $e ) {
			$status->fatal( 'invalid-write-request' );
		}
		return $status;
	}

	/**
	 * checks if user can make an action
	 * @param Title $title
	 * @param $status
	 * @param string $action
	 * @return mixed
	 */
	private function checkUserPermissions( $title, $status, $action ) {
		if ( $status->isGood() && !$title->userCan( $action ) ) {
			$status->fatal( "user-cant-{$action}" );
		}
		return $status;
	}

	/**
	 * checks if article is movable
	 *
	 * @param Title $oldTitle
	 * @param Title $title
	 * @param Status $status
	 * @return Status
	 */
	private function checkMoveEligibility( $oldTitle, $title, $status ) {
		if ( $status->isGood() && ( !$oldTitle->isMovable() || $title->isKnown() ) ) {
			$status->fatal( !$oldTitle->isMovable() ? 'not-movable' : 'articleexists' );
		}
		return $status;
	}

	/**
	 * checks if there are more infoboxes within template.
	 * @param $infoboxes
	 * @param $status
	 * @return mixed
	 */
	private function checkSaveEligibility( $infoboxes, $status ) {
		//if there are more than one infobox in template it means that someone else added it manually.
		if ( $status->isGood() && count( $infoboxes ) > 1 ) {
			$status->fatal( 'article-unsupported' );
		}
		return $status;
	}

	private function move( Title $old, Title $new ) {
		$status = new Status();
		$moved = $old->moveTo( $new, false,
			wfMessage( 'portable-infobox-builder-move-message' )->inContentLanguage()->text() );
		if ( $moved !== true ) {
			foreach ( $moved as $error ) {
				$status->fatal( $error );
			}
		}
		return $status;
	}

	private function save( Title $title, $data, $oldInfobox ) {
		$article = new Article( $title );
		$editPage = new EditPage( $article );
		$editPage->initialiseForm();
		$editPage->edittime = $article->getTimestamp();

		$infoboxBuilderService = new PortableInfoboxBuilderService();
		$infoboxMarkup = $infoboxBuilderService->translateDataToMarkup( $data );
		$infoboxDocumentation = $infoboxBuilderService->getDocumentation( $infoboxMarkup, $title );

		$oldContent = $article->fetchContent();
		if ( empty( $oldInfobox ) ) {
			$editPage->textbox1 = implode( "\n", [ $infoboxMarkup, $infoboxDocumentation, $oldContent ] );
		} else {
			$oldDocumentation = $infoboxBuilderService->getDocumentation( $oldInfobox, $title );
			$content = $infoboxBuilderService->updateInfobox( $oldInfobox, $infoboxMarkup, $oldContent );
			$editPage->textbox1 = $infoboxBuilderService->updateDocumentation( $oldDocumentation, $infoboxDocumentation, $content );
		}

		$status = $editPage->internalAttemptSave( $result );

		if ( $status->isGood() ) {
			$this->classifyAsInfobox( $title );
		}

		return $status;
	}

	/**
	 * @param Title $title
	 * @return int
	 */
	private function classifyAsInfobox( Title $title ) {
		( new TemplateClassificationService() )->classifyTemplate(
			$this->wg->cityId,
			$title->getArticleID(),
			TemplateClassificationService::TEMPLATE_INFOBOX,
			UserTemplateClassificationService::USER_PROVIDER,
			$this->wg->user->getName()
		);
	}
}
