<?php

declare( strict_types=1 );

namespace Wikia\Purger;

use VignetteUrlToUrlGenerator;
use Wikia\Vignette\UrlConfig;

class ThumblrSurrogateKey {
	/** @var UrlConfig */
	private $config;

	public function __construct( string $url ) {
		$this->config = ( new VignetteUrlToUrlGenerator( $url ) )->build()->config();
	}

	public function hashedValue() {
		return sha1( $this->value() );
	}

	public function value() {
		$base = $this->config->bucket();
		if ( !empty( $this->config->pathPrefix() ) ) {
			$base = '/' . $this->config->pathPrefix();
		}
		if ( $this->config->isArchive() ) {
			$path = explode( '/', $this->config->relativePath() );

			return $base . '/images/archive/' . $path[0] . $path[1] . $this->config->timestamp() . $path[2];
		} else {
			return $base . '/images/' . $this->config->relativePath();
		}
	}
}
