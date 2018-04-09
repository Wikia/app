<?php

class DesignSystemGlobalNavigationService extends WikiaService {

	public function index() {
		$this->setVal( 'model', $this->getData() );
	}

	public function linkBranded() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function links() {
		$this->response->setValues( [
			'model' => $this->getVal( 'model' ),
			'type' => $this->getVal( 'type' ),
			'dropdownRightAligned' => $this->request->getBool( 'dropdownRightAligned' ),
		] );
	}

	public function accountNavigation() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function logo() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function link() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function linkDropdown() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function partnerSlot() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function linkAuthentication() {
		$model = $this->getVal( 'model' );
		$messageKey = $model['title']['key'];
		$href = $model['href'];
		$classNames = '';

		switch ( $messageKey ) {
			case 'global-navigation-anon-sign-in':
				$classNames = 'wds-button wds-is-full-width';
				$href = $this->getNewAuthUrl( $href );
				break;
			case 'global-navigation-anon-register':
				$classNames = 'wds-button wds-is-full-width wds-is-secondary';
				$href = $this->getNewAuthUrl( $href );
				break;
			case 'global-navigation-user-sign-out':
				$classNames = 'wds-global-navigation__dropdown-link';
				$model['redirect'] = wfExpandUrl( $this->wg->request->getRequestURL() );
		}

		$this->setVal( 'model', $model );
		$this->setVal( 'classNames', $classNames );
		$this->setVal( 'href', $href );
	}

	public function search() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	private function getData() {
		return $this->sendRequest( 'DesignSystemApi', 'getNavigation', [
			'id' => $this->wg->CityId,
			'product' => 'wikis',
			'lang' => $this->wg->Lang->getCode()
		] )->getData();
	}

	private function getNewAuthUrl( string $baseMercuryUrl ): string {
		$redirect = urlencode( wfExpandUrl( $this->app->wg->request->getRequestURL() ) );

		return wfAppendQuery( $baseMercuryUrl, "redirect=$redirect" );
	}
}
