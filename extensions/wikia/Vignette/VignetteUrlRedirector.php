<?php

class VignetteUrlRedirector {
	const HTTP_HEADER = 'HTTP/1.1 %d %s';
	const RESPONSE_CODE_FOUND = 302;
	const RESPONSE_CODE_NOT_FOUND = 404;

	/** @var ImageService $imageService */
	private $imageService;

	public function __construct( ImageService $service ) {
		$this->imageService = $service;
	}

	public function process( WebRequest $request ) {
		$response = $request->response();
		$imageRevision = new ImageRevision( $request );

		if ( !$imageRevision->isValid() ) {
			$this->notFound( $response );
			return;
		}

		$currentFileRevision = $this->imageService->getMostRecentRevision( $imageRevision );
		if ( $currentFileRevision instanceof File ) {
			$this->doRedirect( $response, $currentFileRevision );
			return;
		}

		$archivedFileRevision = $this->imageService->getArchivedRevision( $imageRevision );
		if ( $archivedFileRevision instanceof File ) {
			$this->doRedirect( $response, $archivedFileRevision );
			return;
		}

		$this->notFound( $response );
	}

	private function doRedirect( WebResponse $response, File $targetFile ) {
		$thumbUrl = $targetFile->getUrlGenerator();

		$httpStatus = HttpStatus::getMessage( static::RESPONSE_CODE_FOUND );
		$redirectHeader = sprintf( static::HTTP_HEADER, static::RESPONSE_CODE_FOUND, $httpStatus );

		$response->header( $redirectHeader );
		$response->header( "Location: $thumbUrl" );
	}

	private function notFound( WebResponse $response ) {
		$httpStatus = HttpStatus::getMessage( static::RESPONSE_CODE_NOT_FOUND );
		$notFoundHeader = sprintf( static::HTTP_HEADER, static::RESPONSE_CODE_NOT_FOUND, $httpStatus );

		$response->header( $notFoundHeader );
	}
}
