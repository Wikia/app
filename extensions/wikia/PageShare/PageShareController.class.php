<?php

class PageShareController extends WikiaController {

	const MEMC_KEY_SOCIAL_ICONS_EN = 'mShareIconsEN';
	const MEMC_KEY_SOCIAL_ICONS_VERSION = 2;
	const MEMC_EXPIRY = 3600;

	public function index() {
		Wikia::addAssetsToOutput( 'page_share_scss' );
		Wikia::addAssetsToOutput( 'page_share_js' );

		$this->skipRendering();
	}

	public function getShareIcons() {
		global $wgMemc;

		$browserLang = $this->getVal( 'browserLang' );
		$useLang = $this->getVal( 'useLang' );
		$title = $this->getVal( 'title' );
		$url = $this->getVal( 'url' );
		$shareLang = PageShareHelper::getLangForPageShare( $browserLang, $useLang );

		$memcKey = $this->getMemcKey( $shareLang );
		$socialIcons = $wgMemc->get( $memcKey );
		if ( !empty( $socialIcons ) ) {
			$this->setVal( 'socialIcons', $socialIcons );
		} else {
			$renderedSocialIcons = \MustacheService::getInstance()->render(
				__DIR__ . '/templates/PageShare_index.mustache',
				['services' => $this->prepareShareServicesData( $shareLang, $title, $url )]
			);

			$wgMemc->set( $memcKey, $renderedSocialIcons, self::MEMC_EXPIRY );
			$this->setVal( 'socialIcons', $renderedSocialIcons );
		}
	}

	/**
	 * Prepare and normalize data from $wgPageShareServices
	 *
	 * @param String $shareLang
	 * @param String $title
	 * @param String $url
	 * @return Array
	 */
	private function prepareShareServicesData( $shareLang, $title, $url ) {
		global $wgPageShareServices;
		$isTouchScreen = $this->getVal( 'isTouchScreen' );

		$services = [];

		foreach ( $wgPageShareServices as $service ) {
			if ( PageShareHelper::isValidShareService( $service, $shareLang, $isTouchScreen ) ) {
				$service['href'] = str_replace(
					[ '$url', '$title' ],
					[ urlencode( $url ), urlencode( $title ) ],
					$service['url']
				);
				$service['icon'] = PageShareHelper::getIcon( $service['name'] );

				$services[] = $service;
			}
		}
		return $services;
	}

	private function getMemcKey($lang) {
		return wfSharedMemcKey(
			$lang,
			self::MEMC_KEY_SOCIAL_ICONS_VERSION
		);
	}
}
