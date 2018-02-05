<?php
namespace Wikia\Service\Gateway;

class StaticUrlProvider implements UrlProvider {
	/** @var string $url */
	private $url;

	public function __construct( string $url ) {
		$this->url = $url;
	}

	public function getUrl( $serviceName ) {
		return $this->url;
	}
}
