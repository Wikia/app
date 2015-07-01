<?php
/**
 * WikiaMobile Naviagation
 *
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class  WikiaMobileNavigationService extends WikiaService {
	/**
	 * @var $navModel NavigationModel
	 */
	private $navModel = null;
	static $skipRendering = false;

	function init(){
		$this->navModel = new NavigationModel();
	}

	static function setSkipRendering( $value = false ){
		self::$skipRendering = $value;
	}

	public function index() {

		if ( self::$skipRendering ) {
			return false;
		}

		$this->setupLoginLink();

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->response->setVal( 'wordmarkText', $settings["wordmark-text"] );
		$this->response->setVal( 'wordmarkType', $settings["wordmark-type"] );
		$this->response->setVal( 'wordmarkFont', $settings["wordmark-font"] );

		if ( $settings["wordmark-type"] == "graphic" ) {
			$this->response->setVal( 'wordmarkUrl', $themeSettings->getWordmarkUrl() );
		} else {
			$this->response->setVal( 'wikiName', ( !empty( $settings['wordmark-text'] ) ) ? $settings['wordmark-text'] : $this->wg->SiteName );
		}
	}

	/**
	 * Returns string with uselang param to append to login url if Wikia language is different than default
	 * @return string
	 */
	private function getUselangParam() {
		$lang = $this->wg->ContLang->mCode;
		return $lang == 'en' ? '' : '&uselang=' . $lang;
	}

	/**
	 * If WikiFactory wgEnableNewAuth variable is set to true, then this method sets login url for the New Auth Flow login page.
	 * Also new class is set for the login button.
	 * Otherwise it sets url to the old Special:Login page.
	 */
	private function setupLoginLink() {
		if ( $this->app->wg->EnableNewAuth ) {
			$this->loginUrl = '/join?redirect='
				.urlencode ( wfExpandUrl( $this->app->wg->request->getRequestURL() ) )
				.$this->getUselangParam();
			$this->loginButtonClass = 'new-login';
		}
		else {
			$this->loginUrl = SpecialPage::getTitleFor( 'UserLogin' )->getLocalURL();
			$this->loginButtonClass = '';
		}
	}

	public function navMenu(){

		$mobileNav =  $this->navModel->parse(
			NavigationModel::TYPE_VARIABLE,
			'wgWikiaMobileGlobalNavigationMenu',
			array(
				$this->wg->maxLevelOneNavElements,
				$this->wg->maxLevelTwoNavElements,
				$this->wg->maxLevelThreeNavElements
			),
			NavigationModel::CACHE_TTL,
			true
		);

		$wikiNav = $this->navModel->getWiki();

		$this->response->setVal( 'wikiNav', array(
			$mobileNav,
			$wikiNav['wiki']
		));

		$blacklist = array();

		foreach ( $this->wg->WikiaMobileNavigationBlacklist as $item ) {
			$title = SpecialPage::getTitleFor( $item );
			$blacklist[] = $title->getLocalURL();
			$blacklist[] = $title->getFullURL();
		}

		$this->response->setVal( 'blacklist', $blacklist );

		// report wiki nav parse errors (BugId:15240)
		$this->response->setVal( 'parseErrors', $this->navModel->getErrors() );

		$showVideoLink = false;
		if( $this->app->wg->EnableSpecialVideosExt ) {
			$showVideoLink = true;
			$this->specialVideosUrl = SpecialPage::getTitleFor("Videos")->escapeLocalUrl();
		}
		$this->showVideoLink = $showVideoLink;
	}
}
