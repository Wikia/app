<?php

declare( strict_types=1 );

namespace Wikia\Purger;

use VignetteUrlToUrlGenerator;
use Wikia\Tasks\Tasks\Image\FileInfo;

/**
 * Historically, Thumblr/Vignette was purged via URL, that was used by the purger to acquire surrogate key.
 * This surrogate key was used to purge the MW's Thumblr asset. This was troublesome if the asset got removed, because
 * fetching the surrogate key might have hit a CDN (Fastly or Wikia), that did not have the asset cached, so getting
 * the surrogate key was impossible.
 *
 * This iteration, uses the same algorithm to produce the surrogate key, based on the asset's URL
 * and uses this surrogate key to purge.
 *
 */
class ThumblrSurrogateKey {
	/** @var FileInfo */
	private $fileInfo;

	public function __construct( FileInfo $fileInfo ) {
		$this->fileInfo = $fileInfo;
	}

	public static function fromUrl( string $url ) {
		$config = ( new VignetteUrlToUrlGenerator( $url, true, true ) )->build()->config();

		return new ThumblrSurrogateKey(
			new FileInfo(
				$config->bucket(),
				$config->relativePath(),
				$config->isArchive() ? $config->timestamp() : 'latest',
				$config->pathPrefix()
			)
		);
	}

	public function value() {
		return sha1( $this->valueBeforeHashing() );
	}

	public function valueBeforeHashing() {
		$base = $this->fileInfo->getBucket();
		if ( !empty( $this->fileInfo->getPathPrefix() ) ) {
			$base .= '/' . $this->fileInfo->getPathPrefix();
		}
		if ( $this->fileInfo->getRevision() !== 'latest' ) {
			$path = explode( '/', $this->fileInfo->getRelativePath() );

			return $base . '/images/archive/' . $path[0] . '/' . $path[1] . '/'
				   . $this->fileInfo->getRevision() . '!' . $path[2];
		} else {
			return $base . '/images/' . $this->fileInfo->getRelativePath();
		}
	}
}
