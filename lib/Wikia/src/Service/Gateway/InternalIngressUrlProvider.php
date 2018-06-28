<?php
namespace Wikia\Service\Gateway;

class InternalIngressUrlProvider implements UrlProvider {

	public function getUrl( $serviceName ) {
		return $serviceName;
	}
}
