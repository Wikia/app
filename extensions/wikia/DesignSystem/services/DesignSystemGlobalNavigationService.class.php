<?php

class DesignSystemGlobalNavigationService extends WikiaService {

	private $logger;

	public function __construct() {
		parent::__construct();
		$this->logger = \Wikia\Logger\WikiaLogger::instance();
	}

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
				$href = ( new UserLoginHelper() )->getNewAuthUrl( $href );
				break;
			case 'global-navigation-anon-register':
				$classNames = 'wds-button wds-is-full-width wds-is-secondary';
				$href = ( new UserLoginHelper() )->getNewAuthUrl( $href );
				break;
			case 'global-navigation-user-sign-out':
				$classNames = 'wds-global-navigation__dropdown-link';
				$model['redirect'] = $this->getCurrentUrl();
		}

		$this->setVal( 'model', $model );
		$this->setVal( 'classNames', $classNames );
		$this->setVal( 'href', $href );
	}

	private function getCurrentUrl() {
		try {
			return $this->getContext()->getTitle()->getFullURL();
		}
		catch ( \Exception $e ) {
			// wfGetCurrentUrl does not play nicely with subdomains, that's why it's only a fallback
			$this->logger->error( 'Failed to get the URL from title, fallback to wfGetCurrentUrl',
				$e );

			return wfGetCurrentUrl( true );
		}
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
}
