<?php

class AuthPageRedirectHelper {

	private $out;

	function __construct( OutputPage $out ) {
		$this->out = $out;
	}

	public function redirectToPiggyback( string $target ) {
		$redirectUrl = '/piggyback';
		if ( !empty( $target ) ) {
			$redirectUrl .= sprintf( "?target=%s", $target );
		}
		$this->out->redirect( $redirectUrl );
		$this->clearBodyAndSetMaxCache();
	}

	private function clearBodyAndSetMaxCache( ) {
		$this->out->setArticleBodyOnly( true );
		$this->out->setSquidMaxage( WikiaResponse::CACHE_LONG );
	}

}
