<?php


class ImageUploadController extends WikiaApiController {

	public function upload() {
		global $wgContLang, $wgDisableAnonymousEditing;

		$this->checkWriteRequest();
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$request = RequestContext::getMain()->getRequest();
		$user = RequestContext::getMain()->getUser();

		// Check whether upload is enabled
		if ( !UploadBase::isEnabled() ) {
			throw new \BadRequestException('Uploads are disabled for this wiki');
		}
		$upload = new UploadFromFile();
		$upload->initialize(
			$request->getFileName( 'file' ),
			$request->getUpload( 'file' )
		);

		$this->verifyUpload( $upload );

		$warnings = $upload->checkWarnings();
		if ( !empty( $warnings['duplicate'] ) ) {
			$duplicate = $warnings['duplicate'][0];
			$this->response->setData( [ 'data' => [
				'url' => $duplicate->getUrl(),
				'article_id' => $duplicate->getTitle()->getArticleID()
			] ] );
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_OK );

			return;
		}

		if ( $wgContLang->getCode() != 'ja' || $wgDisableAnonymousEditing ) {
			$this->checkPermissions( $upload, $user );
		}

		$status = $upload->performUpload('', '', false, $user );

		if ( !$status->isGood() ) {
			throw new \WikiaException("Unknown error occurred", 500 );
		}

		$file = $upload->getLocalFile();
		$this->response->setData( [ 'data' => [
			'title' => $file->getTitle()->getDBkey(),
			'url' => $file->getUrl(),
		] ] );
		$this->response->setCode( WikiaResponse::RESPONSE_CODE_OK );
	}

	public function getImageId() {
		$titleParam = $this->getRequiredParam('title');

		$dbr = wfGetDB( DB_SLAVE );
		$id = $dbr->selectField(
			'page',
			'page_id',
			[ 'page_namespace' => NS_FILE, 'page_title' => $titleParam ]
		);

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setVal( 'id', $id );
	}

	private function checkPermissions( UploadFromFile $upload, User $user ) {
		if ( $upload->verifyTitlePermissions( $user ) !== true ) {
			throw new \PermissionsException( 'upload' );
		}
	}

	private function verifyUpload( UploadFromFile $upload ) {
		$verification = $upload->verifyUpload( );
		if ( $verification['status'] === UploadBase::OK ) {
			return;
		}

		throw new \WikiaException("Unknown error occurred", 500 );
	}
}
