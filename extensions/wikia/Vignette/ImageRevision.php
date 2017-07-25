<?php

class ImageRevision {
	/** @var string $fileName */
	private $fileName;
	/** @var string $uploadDate */
	private $uploadDate;

	public function __construct( WebRequest $request ) {
		$this->fileName = $request->getVal( 'fileName' );
		$this->uploadDate = $request->getVal( 'uploadDate' );
	}

	/**
	 * @return string
	 */
	public function getFileName() {
		return $this->fileName;
	}

	/**
	 * @return string
	 */
	public function getUploadDate() {
		return $this->uploadDate;
	}

	public function isValid(): bool {
		return !empty( $this->fileName ) && !empty( $this->uploadDate );
	}
}
