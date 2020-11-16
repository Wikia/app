<?php

class DesignSystemGlobalNavigationModelV2 extends WikiaModel {
	const DEFAULT_LANG = 'en';
	const PRODUCT_WIKIS = 'wikis';
	const PRODUCT_FANDOMS = 'fandoms';

	const HOMEPAGE_URL = 'https://www.fandom.com';

	const COMMUNITY_CENTRAL_LABEL = 'global-navigation-wikis-community-central';
	const COMMUNITY_CENTRAL_TRACKING_LABEL = 'link.community-central';

	private $product;
	private $productInstanceId;
	private $lang;
	private $isWikiaOrgCommunity;

	/**
	 * constructor
	 *
	 * @param string $product Name of product, ex: fandoms, wikis
	 * @param int $productInstanceId Identifier for given product, ex: wiki id
	 * @param boolean $isWikiaOrgCommunity
	 * @param string $lang
	 */
	public function __construct( $product, $productInstanceId, $isWikiaOrgCommunity, $lang = self::DEFAULT_LANG ) {
		parent::__construct();

		$this->product = $product;
		$this->productInstanceId = $productInstanceId;
		$this->lang = $lang;
		$this->isWikiaOrgCommunity = $isWikiaOrgCommunity;
	}

	public function getData() {
		global $wgUser, $wgServicesExternalDomain;

		$data = [
			'logo' => $this->getLogo(),
			'search' => $this->getSearchData(),
			'create-wiki' => $this->getCreateWiki( 'start-a-wiki' ),
			'main-navigation' => $this->getMainNavigation(),
			'content-recommendations' => $this->getContentRecommendations(),
			'is-wikia-org' => $this->isWikiaOrgCommunity,
		];

		if ( $wgUser->isLoggedIn() ) {
			$data[ 'user' ] = $this->getLoggedInUserData( $wgUser );

			if ( $this->product !== static::PRODUCT_FANDOMS ) {
				$data[ 'notifications' ] = $this->getNotifications( $wgUser );
			}
		} else {
			$data[ 'anon' ] = $this->getAnonUserData();
		}

		$data['services-domain'] = $wgServicesExternalDomain;

		return $data;
	}

	private function getMainNavigation() {
		return $this->isWikiaOrgCommunity ? [
			$this->getLink(
				self::COMMUNITY_CENTRAL_LABEL,
				$this->getHref('community-central'),
				self::COMMUNITY_CENTRAL_TRACKING_LABEL
			)
		] : array_merge(
			$this->getFandomLinks(),
			[ $this->getWikisMenu() ]
		);
	}

	private function getContentRecommendations() {
		$url = RecirculationApiController::getFullUrl( 'getTrendingFandomArticles' );

		if ( wfHttpsAllowedForURL( $url ) ) {
			$url = wfProtocolUrlToRelative( $url );
		}

		return [
			'url' => $url
		];
	}

	private function getWikisMenu() {
		return [
			'type' => 'link-group',
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-wikis-header',
			],
			'tracking-label' => 'link.wikis',
			'items' => [
				$this->getLink( 'global-navigation-wikis-explore', $this->getHref( 'explore-wikis' ), 'link.explore' ),
				$this->getLink( self::COMMUNITY_CENTRAL_LABEL, $this->getHref('community-central'), self::COMMUNITY_CENTRAL_TRACKING_LABEL ),
				$this->getCreateWiki( 'link.start-a-wiki' ),
			]
		];
	}

	private function getCreateWiki( string $trackingLabel ) {
		global $wgUCPCommunityCNWAddress;

		return [
			'type' => 'link-button',
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-create-wiki-link-start-wikia'
			],
			'href' => WikiFactory::getLocalEnvURL( $wgUCPCommunityCNWAddress ),
			'tracking-label' => $trackingLabel,
		];
	}

	private function getHref( $hrefKey, $protocolRelative = false, $useWikiBaseDomain = false ) {
		global $wgServer;
		$url = DesignSystemSharedLinks::getInstance()->getHref( $hrefKey, $this->lang );
		if ( $protocolRelative ) {
			$url = wfProtocolUrlToRelative( $url );
		}

		$server = $this->product === static::PRODUCT_FANDOMS ? static::HOMEPAGE_URL : $wgServer;
		if ( $useWikiBaseDomain ) {
			$url = wfForceBaseDomain( $url, $server );
		}
		return $url;
	}

	private function getPageUrl( $pageTitle, $namespace, $query = '', $protocolRelative = false ) {
		global $wgCityId;

		if ( $this->product === static::PRODUCT_WIKIS && $this->productInstanceId == $wgCityId) {
			$url = Title::newFromText($pageTitle, $namespace)->getFullURL();
		} else {
			$wikiId = $this->product === static::PRODUCT_WIKIS ?
				$this->productInstanceId :
				WikiFactory::COMMUNITY_CENTRAL;
			$url =  GlobalTitle::newFromText( $pageTitle, $namespace, $wikiId )->getFullURL( $query );
		}

		if ( $protocolRelative ) {
			$url = wfProtocolUrlToRelative( $url );
		}

		return $url;
	}

	private function getSearchData() {
		// We treat corporate pages and fandom the same way
		$isCorporatePageOrFandom = WikiaPageType::isCorporatePage( $this->productInstanceId );
		$isCorporatePageOrFandom = $isCorporatePageOrFandom || $this->product === static::PRODUCT_FANDOMS;

		$search = [
			'type' => 'search',
			'results' => [
				'tracking-label' => 'search',
			],
			'placeholder-inactive' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-search-placeholder-inactive'
			],
			'placeholder-active' => [
				'type' => 'translatable-text',
			]
		];

		if ( $isCorporatePageOrFandom && $this->lang === static::DEFAULT_LANG ) {
			$search['results']['param-name'] = 's';
			$search['results']['url'] = 'https://www.fandom.com/';
			$search['placeholder-active']['key'] = 'global-navigation-search-placeholder-fandom';
		} elseif ( $isCorporatePageOrFandom ) {
			// Non-English Fandom or non-English corporate pages
			$search['results']['param-name'] = 'query';
			$search['results']['url'] = $this->getCorporatePageSearchUrl();
			$search['placeholder-active']['key'] = 'global-navigation-search-placeholder-wikis';
			$search['hiddenFields'] = [
				'resultsLang' => $this->lang,
				'uselang' => $this->lang,
			];
		} else {
			// Regular wikis
			$search['results']['param-name'] = 'query';
			$search['results']['url'] = $this->getPageUrl( 'Search', NS_SPECIAL, '', true );
			$search['placeholder-active']['key'] = 'global-navigation-search-placeholder-in-wiki';

			$suggestionsUrl = WikiFactory::cityIDtoUrl( $this->productInstanceId ) . '/wikia.php?controller=LinkSuggest&method=getLinkSuggestions&format=json';
			$search['suggestions'] = [
				'url' => wfProtocolUrlToRelative( $suggestionsUrl ),
				'param-name' => 'query',
				'tracking-label' => 'search-suggestion',
			];
			$search['placeholder-active']['params'] = [
				'sitename' => $this->getSitenameData(),
			];
		}

		return $search;
	}

	private function getAnonUserData() {
		return [
			'signin' => [
				'type' => 'link-authentication',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-anon-sign-in',
				],
				'href' => $this->getHref( 'user-signin', false, true ),
				'param-name' => 'redirect',
				'tracking-label' => 'account.sign-in',
			],
			'register' => [
				'type' => 'link-authentication',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-anon-register',
				],
				'href' => $this->getHref( 'user-register', false, true ),
				'param-name' => 'redirect',
				'tracking-label' => 'account.register',
			]
		];
	}

	private function hasAuthorProfile( $user ) {
		return intval( $user->getGlobalAttribute( 'wordpressId', 0 ), 10 ) > 0;
	}

	private function getLoggedInUserData( $user ) {
		global $wgEnableAuthorProfileLinks;

		$isMessageWallEnabled = $this->isMessageWallEnabled();
		$userName = $user->getName();
		$viewProfileLinks = [];

		$viewProfileLinks[] = $this->getLink( 'global-navigation-user-view-profile', $this->getPageUrl( $userName, NS_USER, '', true ), 'account.profile');

		if ( !empty( $wgEnableAuthorProfileLinks ) && $this->hasAuthorProfile( $user ) ) {
			$viewProfileLinks[] = $this->getLink( 'global-navigation-user-view-author-profile', $this->getHref( 'user-author-profile' ) . $userName, 'account.profile-author' );
		}

		$logOutLink = [
			'id' => strval( $user->getId() ),
			'type' => 'link-logout',
			'href' => $this->getHref( 'user-logout', false, true ),
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-user-sign-out'
			],
			'param-name' => 'redirect',
			'tracking-label' => 'account.sign-out',
		];

		$links = [
			static::PRODUCT_WIKIS => array_merge(
				$viewProfileLinks,
				[
					$this->getLink(
						$isMessageWallEnabled ? 'global-navigation-user-message-wall' : 'global-navigation-user-my-talk',
						$isMessageWallEnabled ? $this->getPageUrl( $userName, NS_USER_WALL, '', true ) : $this->getPageUrl( $userName, NS_USER_TALK, '', true ),
						$isMessageWallEnabled ? 'account.message-wall' : 'account.talk'
					),
					$this->getLink( 'global-navigation-user-my-preferences', $this->getPageUrl( 'Preferences', NS_SPECIAL, '', true ), 'account.preferences'),
					$this->getLink( 'global-navigation-user-help', $this->getHref( 'help' ), 'account.help'),
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
			'avatar_url' => AvatarService::isEmptyOrFirstDefault( $userName ) ? null : AvatarService::getAvatarUrl( $userName, 50 ),
			'username' => $userName,
			'tracking-label' => 'account',
			'items' => $links[$this->product],
		];
	}

	private function getNotifications( $user ) {
		$userName = $user->getName();

		return [
			'header' => [
				'type' => 'line-image',
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-icons-message',
				],
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-notifications-title'
				],
				'tracking-label' => 'notifications',
			],
			'module' => [
				'type' => 'notifications',
				'url' => $this->isMessageWallEnabled()
					? $this->getPageUrl( $userName, NS_USER_WALL, '', true )
					: $this->getPageUrl( $userName, NS_USER_TALK, '', true )
			]
		];
	}

	private function getFandomLinks() {
		$verticals = [
			$this->getLink( 'global-navigation-fandom-overview-link-vertical-games', $this->getHref( 'games' ), 'link.games' ),
			$this->getLink( 'global-navigation-fandom-overview-link-vertical-movies', $this->getHref( 'movies' ), 'link.movies' ),
			$this->getLink( 'global-navigation-fandom-overview-link-vertical-tv', $this->getHref( 'tv' ), 'link.tv'),
		];

		if ( $this->lang === self::DEFAULT_LANG ) {
			$verticals[] = $this->getLink( 'global-navigation-fandom-overview-link-video', $this->getHref( 'video' ), 'link.video') ;
		}

		return $verticals;
	}

	private function isMessageWallEnabled() {
		return WikiFactory::getVarValueByName( 'wgEnableWallExt', $this->productInstanceId );
	}

	private function isWikiaOrgCommunity() {
		return $this->product === self::PRODUCT_WIKIS &&
			WikiFactory::getVarValueByName( 'wgIsInWikiaOrgProgram', $this->productInstanceId );
	}

	private function getCorporatePageSearchUrl() {
		$url = GlobalTitle::newFromText( 'Search', NS_SPECIAL, Wikia::CORPORATE_WIKI_ID )->getFullURL();
		return wfProtocolUrlToRelative( $url );
	}

	private function getSitenameData() {
		return [
			'type' => 'text',
			'value' => WikiFactory::getVarValueByName( 'wgSitename', $this->productInstanceId, false, $this->wg->Sitename ),
		];
	}

	private function getLogo() {
		if ( $this->isWikiaOrgCommunity === true ) {
			return [
				'type' => 'link-image',
				'href' => $this->getHref( 'wikia-org-logo' ),
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-company-logo-wikia-org',
				],
				'tracking-label' => 'logo',
			];
		}

		return [
			'type' => 'link-image',
			'href' => $this->getHref( 'fandom-logo' ),
			'image-data' => [
				'type' => 'wds-svg',
				'name' => 'wds-company-logo-fandom-white',
			],
			'tracking-label' => 'logo',
		];
	}

	private function getLink(string $labelKey, string $href, string $trackingLabel) {
		return [
			'type' => 'link-text',
			'title' => [
				'type' => 'translatable-text',
				'key' => $labelKey
			],
			'href' => $href,
			'tracking-label' => $trackingLabel,
		];
	}
}
