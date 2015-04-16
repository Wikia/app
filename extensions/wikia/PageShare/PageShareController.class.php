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
		global $wgMemc, $wgEnablePageShareWorldwide;

		$browserLang = $this->getVal( 'browserLang' );
		$useLang = $this->getVal( 'useLang' );
		$title = $this->getVal( 'title' );
		$shareLang = PageShareHelper::getLangForPageShare( $browserLang, $useLang );

		// If social icons should be enabled for EN users, and language is different than EN return false
		if ( empty( $wgEnablePageShareWorldwide ) && ( $shareLang !== PageShareHelper::SHARE_DEFAULT_LANGUAGE ) ) {
			$this->setVal( 'socialIcons', false );
		} else {
			$memcKey = $this->getMemcKey();
			$socialIcons = $wgMemc->get( $memcKey );
			if ( !empty( $socialIcons ) ) {
				$this->setVal( 'socialIcons', $socialIcons );
			} else {
				$renderedSocialIcons = \MustacheService::getInstance()->render(
					__DIR__ . '/templates/PageShare_index.mustache',
					['services' => $this->prepareShareServicesData( $shareLang, $title )]
				);

				$wgMemc->set( $memcKey, $renderedSocialIcons, self::MEMC_EXPIRY );
				$this->setVal( 'socialIcons', $renderedSocialIcons );
			}
		}
	}

	/**
	 * Prepare and normalize data from $wgPageShareServices
	 *
	 * @param String $shareLang
	 * @param String $title
	 * @return Array
	 */
	private function prepareShareServicesData( $shareLang, $title ) {
		global $wgPageShareServices;

		$protocol = ( !empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ) ? 'https://' : 'http://';
		$location = $protocol . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$services = [];

		foreach ( $wgPageShareServices as $service ) {
			if ( PageShareHelper::isValidShareService( $service, $shareLang ) ) {
				$service['href'] = str_replace(
					[ '$url', '$title' ],
					[ urlencode( $location ), urlencode( $title ) ],
					$service['url']
				);
				$service['icon'] = PageShareHelper::getIcon( $service['name'] );

				$services[] = $service;
			}
		}
		return $services;
	}

	private function getMemcKey() {
		return wfSharedMemcKey(
			self::MEMC_KEY_SOCIAL_ICONS_EN,
			self::MEMC_KEY_SOCIAL_ICONS_VERSION
		);
	}
}
