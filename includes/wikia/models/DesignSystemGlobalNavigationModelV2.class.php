<?php

class DesignSystemGlobalNavigationModelV2 extends WikiaModel {
	const DEFAULT_LANG = 'en';
	const PRODUCT_WIKIS = 'wikis';
	const PRODUCT_FANDOMS = 'fandoms';

	const COMMUNITY_CENTRAL_LABEL = 'global-navigation-wikis-community-central';
	const COMMUNITY_CENTRAL_TRACKING_LABEL = 'link.community-central';

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
			'search' => $this->getSearchData(),
			'create_wiki' => $this->getCreateWiki( 'start-a-wiki' ),
			'main_navigation' => $this->getMainNavigation(),
		];

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

	private function getMainNavigation() {
		if ( $this->isWikiaOrgCommunity() ) {
			return $this->getLink( self::COMMUNITY_CENTRAL_LABEL, $this->getHref('community-central'), self::COMMUNITY_CENTRAL_TRACKING_LABEL );
		} else {
			return array_merge(
				$this->getFandomLinks(),
				[ $this->getWikisMenu() ]
			);
		}
	}

	private function getWikisMenu() {
		return [
			'type' => 'group',
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-wikis-header',
			],
			'tracking_label' => 'link.wikis',
			'items' => [
				$this->getLink( 'global-navigation-wikis-explore', $this->getHref( 'explore-wikis' ), 'link.explore' ),
				$this->getLink( self::COMMUNITY_CENTRAL_LABEL, $this->getHref('community-central'), self::COMMUNITY_CENTRAL_TRACKING_LABEL ),
				$this->getLink( 'global-navigation-wikis-fandom-university', $this->getHref( 'fandom-university' ), 'link.fandom-university' ),
				$this->getCreateWiki( 'link.start-a-wiki' ),
			]
		];
	}

	private function getCreateWiki( string $trackingLabel ) {
		return [
			'type' => 'button',
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-create-wiki-link-start-wikia'
			],
			'href' => $this->getHref( 'create-new-wiki', true ),
			'tracking_label' => $trackingLabel,
		];
	}

	private function getHref( $hrefKey, $protocolRelative = false ) {
		$url = DesignSystemSharedLinks::getInstance()->getHref( $hrefKey, $this->lang );
		if ( $protocolRelative ) {
			$url = wfProtocolUrlToRelative( $url );
		}
		return $url;
	}

	private function getPageUrl( $pageTitle, $namespace, $query = '', $protocolRelative = false ) {
		$wikiId = $this->product === static::PRODUCT_WIKIS ?
			$this->productInstanceId :
			WikiFactory::COMMUNITY_CENTRAL;
		$url =  GlobalTitle::newFromText( $pageTitle, $namespace, $wikiId )->getFullURL( $query );
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
				'tracking_label' => 'search',
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
			$search['results']['url'] = 'http://fandom.wikia.com/';
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

			$suggestionsUrl = WikiFactory::cityIDtoUrl( $this->productInstanceId ) . '/index.php?action=ajax&rs=getLinkSuggest&format=json';
			$search['suggestions'] = [
				'url' => wfProtocolUrlToRelative( $suggestionsUrl ),
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
			'signin' => [
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-anon-sign-in',
				],
				'href' => $this->getHref( 'user-signin' ),
				'param-name' => 'redirect',
				'tracking_label' => 'account.sign-in',
			],
			'register' => [
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-anon-register',
				],
				'href' => $this->getHref( 'user-register' ),
				'param-name' => 'redirect',
				'tracking_label' => 'account.register',
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
			'type' => 'logout',
			'href' => $this->getHref( 'user-logout' ),
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-user-sign-out'
			],
			'param-name' => $this->product === static::PRODUCT_FANDOMS ? 'redirect' : 'returnto',
			'tracking_label' => 'account.sign-out',
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
			'avatar_url' => AvatarService::getAvatarUrl( $userName, 50 ),
			'username' => $userName,
			'tracking_label' => 'account',
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
					'name' => 'wds-icons-note',
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

	private function getPartnerSlot() {
		if ( $this->lang === 'de' ) {
			return [
				'type' => 'link-image',
				'href' => 'http://www.entertainweb.de/',
				'image-data' => [
					'type' => 'image-external',
					'url' => 'https://services.wikia.com/static-assets/image/5588e692-fae8-4dc3-8db6-5f62e37fed47',
				],
				'title' => [
					'type' => 'text',
					'value' => 'entertainweb'
				],
				'tracking_label' => 'entertainweb',
			];
		}
		return null;
	}

	private function getLogo() {
		if ( $this->isWikiaOrgCommunity() === true ) {
			return [
				'type' => 'link-image',
				'href' => $this->getHref( 'wikia-org-logo' ),
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-company-logo-wikia-org-white',
				],
				'tracking_label' => 'logo',
			];
		}

		return [
			'type' => 'link-image',
			'href' => $this->getHref( 'fandom-logo' ),
			'image-data' => [
				'type' => 'wds-svg',
				'name' => 'wds-company-logo-fandom-white',
			],
			'tracking_label' => 'logo',
		];
	}

	private function getLink(string $labelKey, string $href, string $trackingLabel) {
		return [
			'type' => 'link',
			'title' => [
				'type' => 'translatable-text',
				'key' => $labelKey
			],
			'href' => $href,
			'tracking_label' => $trackingLabel,
		];
	}
}
