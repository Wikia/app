<?php
namespace Wikia\Service\Gateway;

class InternalIngressUrlProvider implements UrlProvider {

	/** @var string $envName */
	private $envName;

	public function __construct( string $envName ) {
		$this->envName = $envName;
	}

	public function getUrl( $serviceName ) {
		return "$serviceName.{$this->envName}";
	}
}
