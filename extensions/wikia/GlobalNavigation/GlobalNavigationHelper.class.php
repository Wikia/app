<?php

class GlobalNavigationHelper {

	const DEFAULT_LANG = 'en';
	const USE_LANG_PARAMETER = '?uselang=';
	const WAM_LANG_CODE_PARAMETER = '?langCode=';

	/**
	 * @var WikiaLogoHelper
	 */
	private $wikiaLogoHelper;


	public function __construct() {
		$this->wikiaLogoHelper = new WikiaLogoHelper();
	}

	/**
	 * @desc get CNW url from GlobalTitle and append uselang
	 * if language is different than default (english)
	 *
	 * @param String $lang - language
	 * @return string - CNW url with uselang appended if necessary
	 */
	public function getCreateNewWikiUrl( $lang ) {
		$createWikiUrl = $this->createCNWUrlFromGlobalTitle();

		if ( $lang != self::DEFAULT_LANG ) {
			$createWikiUrl .= self::USE_LANG_PARAMETER . $lang;
		}
		return $createWikiUrl;
	}

	protected function createCNWUrlFromGlobalTitle() {
		return GlobalTitle::newFromText(
			'CreateNewWiki',
			NS_SPECIAL,
			WikiService::WIKIAGLOBAL_CITY_ID
		)->getFullURL();
	}

	public function getMenuNodes() {
		global $wgLang;

		$exploreDropdownLinks = [];

		$WAMLinkLabel = wfMessage( 'global-navigation-wam-link-label' );
		$CommunityLinkLabel = wfMessage( 'global-navigation-community-link-label');
		$exploreWikiaLabel = wfMessage( 'global-navigation-explore-wikia-link-label');

		if ( $wgLang->getCode() === self::DEFAULT_LANG ) {
			$hubsNodes = (new NavigationModel(true /* useSharedMemcKey */))->getTree(
				NavigationModel::TYPE_MESSAGE,
				'global-navigation-menu-hubs',
				[3] // max 3 links
			);
		} else {
			$hubsNodes = [];
		}

		// Link to WAM - Top Communities
		$exploreDropdownLinks[] = [
			'text' => $WAMLinkLabel->plain(),
			'textEscaped' => $WAMLinkLabel->escaped(),
			'href' => $this->getWAMLinkForLang( $wgLang->getCode() ),
			'trackingLabel' => 'top-communities',
		];

		//Link to Community Central
		$exploreDropdownLinks[] = [
			'text' => $CommunityLinkLabel->plain(),
			'textEscaped' => $CommunityLinkLabel->escaped(),
			'href' => wfMessage('global-navigation-community-link')->plain(),
			'trackingLabel' => 'community-central',
		];

		return [
			'hubs' => $hubsNodes,
			'exploreDropdown' => $exploreDropdownLinks,
			'exploreWikia' => [
				'text' => $exploreWikiaLabel->plain(),
				'textEscaped' => $exploreWikiaLabel->escaped(),
				'href' => wfMessage('global-navigation-explore-wikia-link')->plain(),
				'trackingLabel' => 'explore-wikia',
			]
		];
	}

	public function getWAMLinkForLang( $lang ) {

		// Default/common case is 'en'
		$message = wfMessage('global-navigation-wam-link')->plain();

		if ( $lang !== self::DEFAULT_LANG ) {
			$wamService = new WAMService();
			$wamDates = $wamService->getWamIndexDates();
			if (in_array( $lang, $wamService->getWAMLanguages( $wamDates['max_date'] ) ) ) {
				$message = $message . self::WAM_LANG_CODE_PARAMETER . $lang;
			}
		}

		return $message;
	}
}
