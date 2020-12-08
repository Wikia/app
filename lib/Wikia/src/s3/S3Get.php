<?php

namespace Wikia\S3;

/**
 * Fetches objects from AWS S3.
 * Usage:
 *   $s3get = new S3Get();
 *   $s3get->execute( 'my-bucket', 'my/object/path', '/tmp/newfile' );
 */
class S3Get {
	/** @var bool */
	private $force = false;

	/**
	 * Override existing file instead of showing error message
	 */
	public function setForce() {
		$this->force = true;
	}

	/**
	 * Performs the S3 download
	 *
	 * @param string $bucket
	 * @param string $remotePath path within the bucket
	 * @param string $localPath local path to save the file (use setForce to override existing files)
	 * @throws S3Exception
	 */
	public function execute( string $bucket, string $remotePath, string $localPath ) {
		global $wgAWSAccessKey, $wgAWSSecretKey;

		if ( empty( $wgAWSAccessKey ) || empty( $wgAWSSecretKey ) ) {
			throw new S3Exception( 'Missing AWS credentials' );
		}

		$result = null;
		$cmd = implode( ' ', [
				's4cmd',
				'get',
				wfEscapeShellArg( "s3://{$bucket}/{$remotePath}" ),
				wfEscapeShellArg( $localPath ),
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
			throw new S3Exception( 'Error while getting file from s3: ' . $out );
		}
	}
}
