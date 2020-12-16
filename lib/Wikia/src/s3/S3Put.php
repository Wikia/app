<?php

namespace Wikia\S3;

/**
 * Uploads objects to AWS S3.
 * Usage:
 *   $s3put = new S3Put();
 *   $s3put->setContentDisposition( 'attachment' );
 *   $s3put->execute( '/tmp/local.file', 's3_bucket_name', 'object/path/file.txt' );
 *
 * @package Fandom\Includes\S3
 */
class S3Put {
	const ACL_PRIVATE = 'private';
	const ACL_PUBLIC_READ = 'public-read';

	/** @var bool */
	private $public = false;
	/** @var ?string */
	private $contentType = null;
	/** @var ?string */
	private $contentDisposition = null;
	/** @var bool */
	private $force = false;

	/**
	 * Makes the upcoming upload public
	 *
	 * @return $this
	 */
	public function setPublic() {
		$this->public = true;
		return $this;
	}

	/**
	 * Sets the Content-Type header for the upcoming upload.
	 *
	 * @param string $contentType
	 * @return $this
	 */
	public function  setContentType( string $contentType ) {
		$this->contentType = $contentType;
		return $this;
	}

	/**
	 * Sets the Content-Disposition header for the upcoming upload.
	 *
	 * @param string $contentDisposition
	 * @return $this
	 */
	public function setContentDisposition( string $contentDisposition ) {
		$this->contentDisposition = $contentDisposition;
		return $this;
	}

	/**
	 * Override existing objects instead of showing error message
	 */
	public function setForce() {
		$this->force = true;
	}

	/**
	 * Performs the S3 upload
	 *
	 * @param string $localPath existing local file to upload
	 * @param string $bucket
	 * @param string $remotePath path within the AWS bucket (use setForce to override existing objects)
	 * @throws S3Exception
	 */
	public function execute( string $localPath, string $bucket, string $remotePath ) {
		global $wgAWSAccessKey, $wgAWSSecretKey;

		if ( empty( $wgAWSAccessKey ) || empty( $wgAWSSecretKey ) ) {
			throw new S3Exception( 'Missing AWS credentials' );
		}

		$result = null;
		$cmd = implode( ' ', [
				's4cmd',
				'put',
				wfEscapeShellArg( $localPath ),
				wfEscapeShellArg( "s3://{$bucket}/{$remotePath}" ),
				wfEscapeShellArg( '--API-ACL=' . ( $this->public ? self::ACL_PUBLIC_READ : self::ACL_PRIVATE ) ),
				( !is_null( $this->contentType ) ? '--API-ContentType=' . $this->contentType : '' ),
				( !is_null( $this->contentDisposition ) ? '--API-ContentDisposition=' . $this->contentDisposition : '' ),
				( $this->force ? wfEscapeShellArg( '--force' ) : '' ),
			]
		);

		try {
			$out = wfShellExec( $cmd, $result, [
				'S3_ACCESS_KEY' => $wgAWSAccessKey,
				'S3_SECRET_KEY' => $wgAWSSecretKey
			] );
		} catch ( \Exception $e ) {
			throw new S3Exception( 'Error while executing s4cmd:' . $e->getMessage() );
		}
		if ( $result !== 0 ) {
			throw new S3Exception( 'Error while uploading file to s3: ' . $out );
		}
	}
}
