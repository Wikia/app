<?php

namespace FandomCreatorEmail;

use Wikia\Util\GlobalStateWrapper;

class MagicWordWrapper {
	private $siteName;

	private $siteUrl;

	public function __construct( string $siteName, string $siteUrl ) {
		$this->siteName = $siteName;
		$this->siteUrl = $siteUrl;
	}

	public function wrap( callable $func, array $additionalOverrides = [] ) {
		return ( new GlobalStateWrapper( array_merge( [
				'wgSitename' => $this->siteName, // {{SITENAME}}
				'wgServer' => $this->siteUrl, // {{SERVER}}
		], $additionalOverrides ) ) )->wrap( $func );
	}
}
