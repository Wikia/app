<?php

abstract class AbstractAuthPageRedirect extends SpecialPage {

	final protected function redirect( string $baseRedirectUrl ) {
		$returnToUrl = urlencode( $this->getReturnUrl() );
		$redirect = wfAppendQuery( $baseRedirectUrl, "redirect=$returnToUrl" );

		$langCode = $this->getLanguage()->getCode();
		if ( $langCode !== 'en' ) {
			$redirect = wfAppendQuery( $redirect, "uselang=$langCode" );
		}

		$this->getOutput()->redirect( $redirect );
	}

	/**
	 * Determine the URL that should be redirected to after the current login action.  If
	 * there is a returnto URL and it's valid then send them there.  Otherwise send the
	 * user to the wiki's main page.
	 *
	 * @return string
	 * @throws MWException
	 */
	private function getReturnUrl(): string {
		$titleObj = $this->getReturnToTitle() ?? Title::newMainPage();

		$cbParam = 'cb=' . rand( 1, 10000 );
		$returnParams = $cbParam . '&' . $this->getRequest()->getVal( 'returntoquery', '' );

		return $titleObj->getFullURL( $returnParams );
	}

	private function getReturnToTitle() {
		$returnUrl = $this->getRequest()->getVal( 'returnto', '' );

		if ( !empty( $returnUrl ) ) {
			return Title::newFromText( $returnUrl );
		}

		return null;
	}
}
