<?php

class PageShareController extends WikiaController {

	public function index() {
		Wikia::addAssetsToOutput( 'page_share_scss' );
		Wikia::addAssetsToOutput( 'page_share_js' );

		$this->skipRendering();
	}

	public function getShareIcons() {
		$requestlang = $this->getVal( 'lang' );
		$title = $this->getVal( 'title' );
		$titleObject = Title::newFromText( $title );

		// Fail silently on bad titles to avoid floods of exceptions
		// from requests to cached pages (PLATFORM-2391)
		$modalTitle = '';
		if ( $titleObject instanceof Title ) {
			$modalTitle = $titleObject->getText();
		}

		$lang = PageShareHelper::getLangForPageShare( $requestlang );

		$renderedSocialIcons = \MustacheService::getInstance()->render(
			__DIR__ . '/templates/PageShare_index.mustache',
			['services' => $this->prepareShareServicesData( $lang )]
		);

		$this->setVal( 'socialIcons', $renderedSocialIcons );
		$this->setVal( 'modalTitle', wfMessage( 'page-share-modal-title' )->params( $modalTitle )->text() );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	/**
	 * Prepare and normalize data from $wgPageShareServices
	 *
	 * @param String $lang
	 * @return Array
	 */
	private function prepareShareServicesData( $lang ) {
		global $wgPageShareServices;
		$isTouchScreen = $this->getVal( 'isTouchScreen' );

		$services = [];

		foreach ( $wgPageShareServices as $service ) {
			if ( PageShareHelper::isValidShareService( $service, $lang, $isTouchScreen ) ) {
				$service['icon'] = DesignSystemHelper::renderSvg(
					'wds-icons-' . $service['name'],
					'wds-icon',
					$service['name']
				);
				$services[] = $service;
			}
		}
		return $services;
	}
}
