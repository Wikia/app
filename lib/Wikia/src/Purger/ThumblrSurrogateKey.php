<?php

declare( strict_types=1 );

namespace Wikia\Purger;

use VignetteUrlToUrlGenerator;
use Wikia\Vignette\UrlConfig;

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
	/** @var UrlConfig */
	private $config;

	public function __construct( string $url ) {
		$this->config = ( new VignetteUrlToUrlGenerator( $url, true ) )->build()->config();
	}

	public function value() {
		return sha1( $this->valueBeforeHashing() );
	}

	public function valueBeforeHashing() {
		$base = $this->config->bucket();
		if ( !empty( $this->config->pathPrefix() ) ) {
			$base .= '/' . $this->config->pathPrefix();
		}
		if ( $this->config->isArchive() ) {
			$path = explode( '/', $this->config->relativePath() );

			return $base . '/images/archive/' . $path[0] . '/' . $path[1] . '/'
				   . $this->config->timestamp() . '!' . $path[2];
		} else {
			return $base . '/images/' . $this->config->relativePath();
		}
	}
}
