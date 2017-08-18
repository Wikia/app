<?php

namespace Email\Controller\FandomCreator;


use Wikia\Util\GlobalStateWrapper;

class MagicWordWrapper {
	private $siteName;

	private $domain;

	public function __construct(string $siteName, string $domain) {
		$this->siteName = $siteName;
		$this->domain = $domain;
	}

	public function wrap(callable $func, array $additionalOverrides = []) {
		return (new GlobalStateWrapper(array_merge([
				'wgSitename' => $this->siteName, // {{SITENAME}}
				'wgServer' => $this->domain, // {{SERVER}}
		], $additionalOverrides)))->wrap($func);
	}
}
