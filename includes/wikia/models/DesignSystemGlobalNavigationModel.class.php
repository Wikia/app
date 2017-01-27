<?php

class DesignSystemGlobalNavigationModel extends WikiaModel {
	const DEFAULT_LANG = 'en';
	const PRODUCT_WIKIS = 'wikis';
	const PRODUCT_FANDOMS = 'fandoms';

	private $product;
	private $productInstanceId;
	private $lang;

	/**
	 * constructor
	 *
	 * @param string $product Name of product, ex: fandoms, wikis
	 * @param int $productInstanceId Identifier for given product, ex: wiki id
	 * @param string $lang
	 */
	public function __construct( $product, $productInstanceId, $lang = self::DEFAULT_LANG ) {
		parent::__construct();

		$this->product = $product;
		$this->productInstanceId = $productInstanceId;
		$this->lang = $lang;
	}

	public function getData() {
		global $wgUser;

		$data = [
			'logo' => $this->getLogo(),
			'search' => [
				'module' => $this->getSearchData()
			],
			'create_wiki' => [
				'header' => (new WdsLinkText())
					->setTranslatableTitle( 'global-navigation-create-wiki-link-start-wikia' )
					->setHref( $this->getHref( 'create-new-wiki' ) )
					->setTrackingLabel( 'start-a-wiki' )
					->get()
			]
		];

		if ( $this->lang === static::DEFAULT_LANG && !$this->isWikiaOrgCommunity() ) {
			$data[ 'fandom_overview' ] = $this->getVerticalsSection();
			$data[ 'wikis' ] = [
				'header' => (new WdsLineText())
						->setTranslatableTitle( 'global-navigation-wikis-header' )
						->setTrackingLabel( 'link.wikis' )
						->get(),
				'links' => [
					(new WdsLinkText())->setTranslatableTitle( 'global-navigation-wikis-explore' )
						->setHref( $this->getHref( 'explore-wikis' ) )
						->setTrackingLabel( 'link.explore' )
						->get(),
					$this->getCommunityCentralLink(),
					(new WdsLinkText())->setTranslatableTitle( 'global-navigation-wikis-fandom-university' )
						->setHref( $this->getHref( 'fandom-university' ) )
						->setTrackingLabel( 'link.fandom-university' )
						->get()
				]
			];
		} else {
			$data[ 'wikis' ] = [
				'links' => [
					$this->getCommunityCentralLink()
				]
			];
		}

		if ( $wgUser->isLoggedIn() ) {
			$data[ 'user' ] = $this->getLoggedInUserData( $wgUser );

			if ( $this->product !== static::PRODUCT_FANDOMS ) {
				$data[ 'notifications' ] = $this->getNotifications( $wgUser );
			}
		} else {
			$data[ 'anon' ] = $this->getAnonUserData();
		}

		$partnerSlot = $this->getPartnerSlot();
		if ( !empty( $partnerSlot ) ) {
			$data[ 'partner_slot' ] = $partnerSlot;
		}

		return $data;
	}

	private function getHref( $hrefKey ) {
		return DesignSystemSharedLinks::getInstance()->getHref( $hrefKey, $this->lang );
	}

	private function getPageUrl( $pageTitle, $namespace, $query = '' ) {
		$wikiId = $this->product === static::PRODUCT_WIKIS ?
			$this->productInstanceId :
			WikiFactory::COMMUNITY_CENTRAL;
		return GlobalTitle::newFromText( $pageTitle, $namespace, $wikiId )->getFullURL( $query );
	}

	private function getSearchData() {
		$isCorporatePage = WikiaPageType::isCorporatePage( $this->productInstanceId );

		if ( $this->product === static::PRODUCT_FANDOMS && $this->lang === static::DEFAULT_LANG ) {
			$searchUrl = '/';
			$searchPlaceholderKey = 'global-navigation-search-placeholder-fandom';
			$searchParamName = 's';
		} else {
			if ( $isCorporatePage || $this->product === static::PRODUCT_FANDOMS ) {
				$searchUrl = $this->getCorporatePageSearchUrl();
				$searchPlaceholderKey = 'global-navigation-search-placeholder-wikis';
			} else {
				$searchUrl = $this->getPageUrl( 'Search', NS_SPECIAL, [ 'fulltext' => 'Search' ] );
				$searchPlaceholderKey = 'global-navigation-search-placeholder-in-wiki';
			}
			$searchParamName = 'query';
		}

		$search = [
			'type' => 'search',
			'results' => [
				'url' => $searchUrl,
				'param-name' => $searchParamName,
				'tracking_label' => 'search',
			],
			'placeholder-inactive' => (new WdsTranslatableText( 'global-navigation-search-placeholder-inactive' ))->get(),
			'placeholder-active' => (new WdsTranslatableText( $searchPlaceholderKey ))->get()
		];

		if ( $this->product !== static::PRODUCT_FANDOMS && !$isCorporatePage ) {
			$search['suggestions'] = [
				'url' => WikiFactory::getHostById( $this->productInstanceId ) . '/index.php?action=ajax&rs=getLinkSuggest&format=json',
				'param-name' => 'query',
				'tracking_label' => 'search-suggestion',
			];
			$search['placeholder-active']['params'] = [
				'sitename' => $this->getSitenameData(),
			];
		}

		return $search;
	}

	private function getAnonUserData() {
		return [
			'header' => [
				'type' => 'line-image',
				// 'image' is deprecated, use 'image-data' instead
				'image' => 'wds-icons-user',
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-icons-user',
				],
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-anon-my-account',
				],
				'subtitle' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-anon-my-account',
				],
				'tracking_label' => 'account',
			],
			'links' => [
				[
					'type' => 'link-authentication',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-anon-sign-in',
					],
					'href' => $this->getHref( 'user-signin' ),
					'param-name' => 'redirect',
					'tracking_label' => 'account.sign-in',
				],
				[
					'type' => 'link-authentication',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-anon-register',
					],
					'subtitle' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-anon-register-description',
					],
					'href' => $this->getHref( 'user-register' ),
					'param-name' => 'redirect',
					'tracking_label' => 'account.register',
				],
			],
		];
	}

	private function hasAuthorProfile( $user ) {
		return sizeof( preg_grep( "/^fancontributor-/", $user->getGroups() ) ) > 0;
	}

	private function getLoggedInUserData( $user ) {
		global $wgEnableAuthorProfileLinks;

		$isMessageWallEnabled = $this->isMessageWallEnabled();
		$userName = $user->getName();

		$viewProfileLinks[] = (new WdsLinkText())
			->setTranslatableTitle( 'global-navigation-user-view-profile' )
			->setHref( $this->getPageUrl( $userName, NS_USER ) )
			->setTrackingLabel( 'account.profile' )
			->get();

		$logOutLink = [
			'type' => 'link-authentication',
			'href' => $this->getHref( 'user-logout' ),
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-user-sign-out'
			],
			'param-name' => $this->product === static::PRODUCT_FANDOMS ? 'redirect' : 'returnto',
			'tracking_label' => 'account.sign-out',
		];

		if ( !empty( $wgEnableAuthorProfileLinks ) && $this->hasAuthorProfile( $user ) ) {
			$viewProfileLinks[] = (new WdsLinkText())
				->setTranslatableTitle( 'global-navigation-user-view-author-profile' )
				->setHref( $this->getHref( 'user-author-profile' ) . $userName )
				->setTrackingLabel( 'account.profile-author' )
				->get();
		}

		$links = [
			static::PRODUCT_WIKIS => array_merge(
				$viewProfileLinks,
				[
					(new WdsLinkText())
						->setTranslatableTitle( $isMessageWallEnabled ? 'global-navigation-user-message-wall' : 'global-navigation-user-my-talk' )
						->setHref( $isMessageWallEnabled ? $this->getPageUrl( $userName, NS_USER_WALL ) : $this->getPageUrl( $userName, NS_USER_TALK ) )
						->setTrackingLabel( $isMessageWallEnabled ? 'account.message-wall' : 'account.talk' )
						->get(),
					(new WdsLinkText())
						->setTranslatableTitle( 'global-navigation-user-my-preferences' )
						->setHref( $this->getPageUrl( 'Preferences', NS_SPECIAL ) )
						->setTrackingLabel( 'account.preferences' )
						->get(),
					(new WdsLinkText())
						->setTranslatableTitle( 'global-navigation-user-help' )
						->setHref( $this->getHref( 'help' ) )
						->setTrackingLabel( 'account.help' )
						->get(),
					$logOutLink
				]
			),
			static::PRODUCT_FANDOMS => array_merge(
				$viewProfileLinks,
				[
					$logOutLink
				]
			),
		];

		return [
			'header' => [
				'type' => 'avatar',
				'username' => [
					'type' => 'text',
					'value' => $userName
				],
				'url' => AvatarService::getAvatarUrl( $userName, 50 ),
				'tracking_label' => 'account',
			],
			'links' => $links[$this->product]
		];
	}

	private function getNotifications( $user ) {
		$userName = $user->getName();

		return [
			'header' => [
				'type' => 'line-image',
				// 'image' is deprecated, use 'image-data' instead
				'image' => 'wds-icons-bell',
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-icons-bell',
				],
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-notifications-title'
				],
				'tracking_label' => 'notifications',
			],
			'module' => [
				'type' => 'notifications',
				'url' => $this->isMessageWallEnabled()
					? $this->getPageUrl( $userName, NS_USER_WALL )
					: $this->getPageUrl( $userName, NS_USER_TALK )
			]
		];
	}

	private function getVerticalsSection() {
		return [
			'links' => [
				(new WdsLinkBranded())->setBrand( 'games' )
					->setTranslatableTitle( 'global-navigation-fandom-overview-link-vertical-games' )
					->setHref( $this->getHref( 'games' ) )
					->setTrackingLabel( 'link.games' )
					->get(),
				(new WdsLinkBranded())->setBrand( 'movies' )
					->setTranslatableTitle( 'global-navigation-fandom-overview-link-vertical-movies' )
					->setHref( $this->getHref( 'movies' ) )
					->setTrackingLabel( 'link.movies' )
					->get(),
				(new WdsLinkBranded())->setBrand( 'tv' )
					->setTranslatableTitle( 'global-navigation-fandom-overview-link-vertical-tv' )
					->setHref( $this->getHref( 'tv' ) )
					->setTrackingLabel( 'link.tv' )
					->get(),
			]
		];
	}

	private function isMessageWallEnabled() {
		return WikiFactory::getVarValueByName( 'wgEnableWallExt', $this->productInstanceId );
	}

	private function isWikiaOrgCommunity() {
		return $this->product === self::PRODUCT_WIKIS &&
			WikiFactory::getVarValueByName( 'wgIsInWikiaOrgProgram', $this->productInstanceId );
	}

	private function getCorporatePageSearchUrl() {
		return GlobalTitle::newFromText( 'Search', NS_SPECIAL, WikiService::WIKIAGLOBAL_CITY_ID )->getFullURL( [
			'fulltext' => 'Search',
			'resultsLang' => $this->lang
		] );
	}

	private function getCommunityCentralLink() {
		return (new WdsLinkText())->setTranslatableTitle( 'global-navigation-wikis-community-central' )
			->setHref( $this->getHref( 'community-central' ) )
			->setTrackingLabel( 'link.community-central' )
			->get();
	}

	private function getSitenameData() {
		return (new WdsText( WikiFactory::getVarValueByName( 'wgSitename', $this->productInstanceId, false, $this->wg->Sitename ) ))->get();
	}

	private function getPartnerSlot() {
		if ( $this->lang === 'de' ) {
			return (new WdsLinkImage())->setExternalImageData( 'https://services.wikia.com/static-assets/image/5588e692-fae8-4dc3-8db6-5f62e37fed47' )
				->setHref( 'http://www.entertainweb.de/' )
				->setTitle( 'entertainweb' )
				->setTrackingLabel( 'entertainweb' )
				->get();
		}
		return null;
	}

	private function getLogo() {
		$logo = [
			// Deprecated
			'header' => (new WdsLinkImage())->setHref( $this->getHref( 'fandom-logo' ) )
				->setSvgImageData( 'wds-company-logo-fandom-powered-by-wikia')
				->setTitle( 'Fandom powered by Wikia' )
				->setTrackingLabel( 'logo' )
				->get(),
			'module' => [
				'type' => 'logo',
				'main' => $this->getLogoMain(),
			]
		];


		$tagline = $this->getLogoTagline();
		if ( !empty( $tagline ) ) {
			$logo['module'][ 'tagline' ] = $tagline;
		}

		return $logo;
	}

	private function getLogoMain() {
		if ( $this->isWikiaOrgCommunity() === true ) {
			return (new WdsLinkImage())->setHref(  $this->getHref( 'wikia-org-logo' ) )
				->setSvgImageData( 'wds-company-logo-wikia-org' )
				->setTitle( 'Wikia.org' )
				->setTrackingLabel( 'logo' )
				->get();
		}

		return (new WdsLinkImage())->setHref( $this->getHref( 'fandom-logo' ) )
			->setSvgImageData( 'wds-company-logo-fandom' )
			->setTitle( 'Fandom powered by Wikia' )
			->setTrackingLabel( 'logo' )
			->get();
	}

	private function getLogoTagline() {
		if ( $this->isWikiaOrgCommunity() === true ) {
			return null;
		}

		return (new WdsLinkImage())->setHref( $this->getHref( 'fandom-logo' ) )
			->setSvgImageData( 'wds-company-logo-powered-by-wikia' )
			->setTitle( 'Fandom powered by Wikia' )
			->setTrackingLabel( 'logo-tagline' )
			->get();
	}
}
