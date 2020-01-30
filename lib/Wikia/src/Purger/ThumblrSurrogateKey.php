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
		return $this->config->bucket() . '/' . $this->config->baseUrl();
	}
}
