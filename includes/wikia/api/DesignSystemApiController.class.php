<?php

class DesignSystemApiController extends WikiaApiController {
	const PARAM_PRODUCT = 'product';
	const PARAM_ID = 'id';
	const PARAM_LANG = 'lang';
	const PRODUCT_WIKIS = 'wikis';

	public function getFooter() {
		$params = $this->getRequestParameters();
		$footerModel = new DesignSystemGlobalFooterModel(
			$params[static::PARAM_PRODUCT], $params[static::PARAM_ID], $params[static::PARAM_LANG]
		);

		$this->setResponseData( $footerModel->getData() );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}

	public function getNavigation() {
		$params = $this->getRequestParameters();

		$this->setResponseData(
			( new DesignSystemGlobalNavigationModel(
				$params[static::PARAM_PRODUCT], $params[static::PARAM_ID], $params[static::PARAM_LANG]
			) )->getData()
		);

		$this->addCachingHeaders();
	}

	public function getCommunityHeader() {
		$params = $this->getRequestParameters();

		//TODO: think about refactoring ThemeSettings class to have cityId as constructor param
		$globalStateWrapper = new \Wikia\Util\GlobalStateWrapper(
			[
				// used in ThemeSettings
				'wgSitename' => WikiFactory::getVarValueByName( 'wgSitename', intval( $params[static::PARAM_ID] ) ),
				'wgAdminSkin' => WikiFactory::getVarValueByName( 'wgAdminSkin', intval( $params[static::PARAM_ID] ) ),
				'wgOasisThemeSettings' => WikiFactory::getVarValueByName(
					'wgOasisThemeSettings',
					intval( $params[static::PARAM_ID] )
				),
				'wgOasisThemeSettingsHistory' => WikiFactory::getVarValueByName(
					'wgOasisThemeSettingsHistory',
					intval( $params[static::PARAM_ID] )
				),
				'wgUploadPath' => WikiFactory::getVarValueByName( 'wgUploadPath', intval( $params[static::PARAM_ID] ) ),
			]
		);

		$globalStateWrapper->wrap(
			function () use ( $params ) {
				$this->setResponseData(
					( new DesignSystemCommunityHeaderModel(
						$params[static::PARAM_ID]
					) )->getData()
				);
			}
		);

		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}

	/**
	 * return all possible elements of Design System API
	 *
	 * @throws \NotFoundApiException
	 */
	public function getAllElements() {
		$params = $this->getRequestParameters();
		$footerModel = new DesignSystemGlobalFooterModel(
			$params[static::PARAM_PRODUCT], $params[static::PARAM_ID], $params[static::PARAM_LANG]
		);
		$navigationModel = new DesignSystemGlobalNavigationModel(
			$params[static::PARAM_PRODUCT], $params[static::PARAM_ID], $params[static::PARAM_LANG]
		);

		$globalStateWrapper = new \Wikia\Util\GlobalStateWrapper(
			[
				// used in ThemeSettings
				'wgSitename' => WikiFactory::getVarValueByName( 'wgSitename', intval( $params[static::PARAM_ID] ) ),
				'wgAdminSkin' => WikiFactory::getVarValueByName( 'wgAdminSkin', intval( $params[static::PARAM_ID] ) ),
				'wgOasisThemeSettings' => WikiFactory::getVarValueByName(
					'wgOasisThemeSettings',
					intval( $params[static::PARAM_ID] )
				),
				'wgOasisThemeSettingsHistory' => WikiFactory::getVarValueByName(
					'wgOasisThemeSettingsHistory',
					intval( $params[static::PARAM_ID] )
				),
				'wgUploadPath' => WikiFactory::getVarValueByName( 'wgUploadPath', intval( $params[static::PARAM_ID] ) ),
			]
		);

		$globalStateWrapper->wrap(
			function () use ( $params ) {
				$this->communityHeaderModel = new DesignSystemCommunityHeaderModel(
					$params[static::PARAM_ID]
				);
			}
		);

		$this->setResponseData(
			[
				'global-footer' => $footerModel->getData(),
				'global-navigation' => $navigationModel->getData(),
				'community-header' => $this->communityHeaderModel->getData()
			]
		);

		$this->addCachingHeaders();
	}

	private function getRequestParameters() {
		$id = $this->getRequiredParam( static::PARAM_ID );
		$product = $this->getRequiredParam( static::PARAM_PRODUCT );
		$lang = $this->getRequiredParam( static::PARAM_LANG );

		if ( $product === static::PRODUCT_WIKIS && WikiFactory::IDtoDB( $id ) === false ) {
			throw new NotFoundApiException( "Unable to find wiki with ID {$id}" );
		}

		return [
			static::PARAM_PRODUCT => $product,
			static::PARAM_ID => $id,
			static::PARAM_LANG => $lang
		];
	}

	/**
	 * add response headers for requests that require differing for anons
	 * and logged in users
	 */
	private function addCachingHeaders() {
		global $wgUser;

		$this->response->setHeader( 'Vary', 'Accept-Encoding,Cookie' );

		if ( $wgUser->isLoggedIn() ) {
			$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
			$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
		} else {
			$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		}
	}
}
