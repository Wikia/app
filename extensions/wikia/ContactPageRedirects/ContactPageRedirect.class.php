<?php

class ContactPageRedirect extends UnlistedSpecialPage {
	private $redirectMap = [
		'en' => 'https://fandom.zendesk.com/',
		'es' => 'https://fandom.zendesk.com/hc/es',
		'ru' => 'https://fandom.zendesk.com/hc/ru',
	];

	public function  __construct() {
		parent::__construct( 'Contact' );
	}

	public function execute( $subpage ) {
		$langCode = $this->getLanguage()->getCode();
		$redirectURL = $this->redirectMap[$langCode] ?? $this->redirectMap['en'];
		$this->getOutput()->redirect( $redirectURL, '301' );
	}
}
