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
			'logo' => $this->getLogo()
		];

		$search = new WdsSearch();
		$search->setModule( $this->getSearchData() );
		$data[ 'search' ] = $search;

		$data[ 'create_wiki' ] = (new WdsCreateWiki())->setHeader( (new WdsLinkText())
			->setTranslatableTitle( 'global-navigation-create-wiki-link-start-wikia' )
			->setHref( $this->getHref( 'create-new-wiki' ) )
			->setTrackingLabel( 'start-a-wiki' ) );


		$wikis = new WdsWikis();

		if ( $this->lang === static::DEFAULT_LANG && !$this->isWikiaOrgCommunity() ) {
			$data[ 'fandom_overview' ] = $this->getFandomOverview();

			$wikis->setHeader( (new WdsLineTextTrackable())
				->setTranslatableTitle( 'global-navigation-wikis-header' )
				->setTrackingLabel( 'link.wikis' ) );
			$wikis->setLinks( [
				(new WdsLinkText())->setTranslatableTitle( 'global-navigation-wikis-explore' )
					->setHref( $this->getHref( 'explore-wikis' ) )
					->setTrackingLabel( 'link.explore' ),
				$this->getCommunityCentralLink(),
				(new WdsLinkText())->setTranslatableTitle( 'global-navigation-wikis-fandom-university' )
					->setHref( $this->getHref( 'fandom-university' ) )
					->setTrackingLabel( 'link.fandom-university' )
			] );
		} else {
			$wikis->setLinks( [ $this->getCommunityCentralLink() ] );
		}

		$data[ 'wikis' ] = $wikis;

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

		$searchModule = new WdsSearchModule();

		$searchModule
			// TODO
			->setResults( [
				'url' => $searchUrl,
				'param-name' => $searchParamName,
				'tracking_label' => 'search',
			] )
			->setActivePlaceholder( new WdsTranslatableText( $searchPlaceholderKey ) )
			->setInactivePlaceholder( new WdsTranslatableText( 'global-navigation-search-placeholder-inactive' ) );

		if ( $this->product !== static::PRODUCT_FANDOMS && !$isCorporatePage ) {
			// TODO
			$search['placeholder-active']['params'] = [
				'sitename' => $this->getSitenameData(),
			];

			// TODO
			$searchModule->setSuggestions( [
				'url' => WikiFactory::getHostById( $this->productInstanceId ) . '/index.php?action=ajax&rs=getLinkSuggest&format=json',
				'param-name' => 'query',
				'tracking_label' => 'search-suggestion',
			] );
		}

		return $searchModule;
	}

	private function getAnonUserData() {
		$anonUser = new WdsAnon();
		$anonUser->setHeader( (new WdsLineImageWithSubtitle())
			->setSvgImageData( 'wds-icons-user' )
			->setTranslatableTitle( 'global-navigation-anon-my-account' )
			->setTranslatableSubtitle( 'global-navigation-anon-my-account' )
			->setTrackingLabel( 'account' ) );
		$anonUser->setLinks( [
			( new WdsLinkAuthentication() )->setTranslatableTitle( 'global-navigation-anon-sign-in' )
				->setHref( $this->getHref( 'user-signin' ) )
				->setParamName( 'redirect' )
				->setTrackingLabel( 'account.sign-in' ),
			( new WdsLinkAuthenticationWithSubtitle() )->setTranslatableTitle( 'global-navigation-anon-register' )
				->setTranslatableSubtitle( 'global-navigation-anon-register-description' )
				->setHref( $this->getHref( 'user-register' ) )
				->setParamName( 'redirect' )
				->setTrackingLabel( 'account.register' ),
		] );

		return $anonUser;
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
			->setTrackingLabel( 'account.profile' );

		$logOutLink = ( new WdsLinkAuthentication() )->setTranslatableTitle( 'global-navigation-user-sign-out' )
			->setHref( $this->getHref( 'user-logout' ) )
			->setParamName( $this->product === static::PRODUCT_FANDOMS ? 'redirect' : 'returnto' )
			->setTrackingLabel( 'account.sign-out' );

		if ( !empty( $wgEnableAuthorProfileLinks ) && $this->hasAuthorProfile( $user ) ) {
			$viewProfileLinks[] = (new WdsLinkText())
				->setTranslatableTitle( 'global-navigation-user-view-author-profile' )
				->setHref( $this->getHref( 'user-author-profile' ) . $userName )
				->setTrackingLabel( 'account.profile-author' );
		}

		$links = [
			static::PRODUCT_WIKIS => array_merge(
				$viewProfileLinks,
				[
					(new WdsLinkText())
						->setTranslatableTitle( $isMessageWallEnabled ? 'global-navigation-user-message-wall' : 'global-navigation-user-my-talk' )
						->setHref( $isMessageWallEnabled ? $this->getPageUrl( $userName, NS_USER_WALL ) : $this->getPageUrl( $userName, NS_USER_TALK ) )
						->setTrackingLabel( $isMessageWallEnabled ? 'account.message-wall' : 'account.talk' ),
					(new WdsLinkText())
						->setTranslatableTitle( 'global-navigation-user-my-preferences' )
						->setHref( $this->getPageUrl( 'Preferences', NS_SPECIAL ) )
						->setTrackingLabel( 'account.preferences' ),
					(new WdsLinkText())
						->setTranslatableTitle( 'global-navigation-user-help' )
						->setHref( $this->getHref( 'help' ) )
						->setTrackingLabel( 'account.help' ),
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

		$notificationsModule = new WdsNotificationsModule();
		$notificationsModule->setUrl( $this->isMessageWallEnabled()
			? $this->getPageUrl( $userName, NS_USER_WALL )
			: $this->getPageUrl( $userName, NS_USER_TALK ) );


		$notifications = new WdsNotifications();
		$notifications->setHeader( (new WdsLineImage())
			->setSvgImageData( 'wds-icons-bell' )
			->setTranslatableTitle( 'global-navigation-notifications-title' )
			->setTrackingLabel( 'notifications' ) );
		$notifications->setModule( $notificationsModule );
		return $notifications;
	}

	private function getFandomOverview() {
		$fandomOverview = new WdsFandomOverview();
		$fandomOverview->setLinks( [
			(new WdsLinkBranded())->setBrand( 'games' )
				->setTranslatableTitle( 'global-navigation-fandom-overview-link-vertical-games' )
				->setHref( $this->getHref( 'games' ) )
				->setTrackingLabel( 'link.games' ),
			(new WdsLinkBranded())->setBrand( 'movies' )
				->setTranslatableTitle( 'global-navigation-fandom-overview-link-vertical-movies' )
				->setHref( $this->getHref( 'movies' ) )
				->setTrackingLabel( 'link.movies' ),
			(new WdsLinkBranded())->setBrand( 'tv' )
				->setTranslatableTitle( 'global-navigation-fandom-overview-link-vertical-tv' )
				->setHref( $this->getHref( 'tv' ) )
				->setTrackingLabel( 'link.tv' ),
		] );

		return $fandomOverview;
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
			->setTrackingLabel( 'link.community-central' );
	}

	private function getSitenameData() {
		return new WdsText( WikiFactory::getVarValueByName( 'wgSitename', $this->productInstanceId, false, $this->wg->Sitename ) );
	}

	private function getPartnerSlot() {
		if ( $this->lang === 'de' ) {
			return (new WdsLinkImage())->setExternalImageData( 'https://services.wikia.com/static-assets/image/5588e692-fae8-4dc3-8db6-5f62e37fed47' )
				->setHref( 'http://www.entertainweb.de/' )
				->setTitle( 'entertainweb' )
				->setTrackingLabel( 'entertainweb' );
		}
		return null;
	}

	private function getLogo() {
		$logoModule = (new WdsLogoModule())->setMain( $this->getLogoMain() );

		$tagline = $this->getLogoTagline();
		if ( !empty( $tagline ) ) {
			$logoModule->setTagLine( $tagline );
		}

		$logo = (new WdsLogo());
		$logo->setHeader( (new WdsLinkImage())->setHref( $this->getHref( 'fandom-logo' ) )
			->setSvgImageData( 'wds-company-logo-fandom-powered-by-wikia')
			->setTitle( 'Fandom powered by Wikia' )
			->setTrackingLabel( 'logo' ) );
		$logo->setModule( $logoModule );

		return $logo;
	}

	/**
	 * @return WdsLinkImage
	 */
	private function getLogoMain() {
		if ( $this->isWikiaOrgCommunity() === true ) {
			return (new WdsLinkImage())->setHref(  $this->getHref( 'wikia-org-logo' ) )
				->setSvgImageData( 'wds-company-logo-wikia-org' )
				->setTitle( 'Wikia.org' )
				->setTrackingLabel( 'logo' );
		}

		return (new WdsLinkImage())->setHref( $this->getHref( 'fandom-logo' ) )
			->setSvgImageData( 'wds-company-logo-fandom' )
			->setTitle( 'Fandom powered by Wikia' )
			->setTrackingLabel( 'logo' );
	}

	/**
	 * @return WdsLinkImage|null
	 */
	private function getLogoTagline() {
		if ( $this->isWikiaOrgCommunity() === true ) {
			return null;
		}

		return (new WdsLinkImage())->setHref( $this->getHref( 'fandom-logo' ) )
			->setSvgImageData( 'wds-company-logo-powered-by-wikia' )
			->setTitle( 'Fandom powered by Wikia' )
			->setTrackingLabel( 'logo-tagline' );
	}
}
