<?php

class DesignSystemSharedLinks {

	/** @var DesignSystemSharedLinks */
	private static $instance;

	private function __construct() {
	}

	public static function getInstance() {
		if ( !isset( static::$instance ) ) {
			static::$instance = new DesignSystemSharedLinks();
		}
		return static::$instance;
	}

	public function setHrefs( $hrefs ) {
		$this->hrefs = $hrefs;
		return $this;
	}

	/**
	 * @param $name string key for href
	 * @param $lang string two letter language code
	 * @return string full URL, in case of lang specific URL missing, default one is returned
	 */
	public function getHref( $name, $lang ) {
		$lang = $this->getLangWithFallback( $lang );

		$href = $this->hrefs[$lang][$name] ?? $this->hrefs['default'][$name];

		return WikiFactory::getLocalEnvURL( $href );
	}

	/**
	 * @param $name string key for href
	 * @param $lang string two letter language code
	 * @return string full URL without making it local to environment
	 *
	 * In case of lang specific URL missing, default one is returned.
	 */
	public function getProdHref( $name, $lang ) {
		$lang = $this->getLangWithFallback( $lang );

		return $this->hrefs[$lang][$name] ?? $this->hrefs['default'][$name];
	}

	/**
	 * @param $name string key for href
	 * @param $lang string two letter language code
	 * @param $cityId int
	 * @return string full URL, in case of lang specific URL missing, default one is returned
	 */
	public function getLocalHref( $name, $lang, $cityId) {
		$lang = $this->getLangWithFallback( $lang );

		$href = $this->hrefs[$lang][$name] ?? $this->hrefs['default'][$name];

		return WikiFactory::cityIdToLanguagePath( $cityId ) . $href;
	}

	/**
	 * @param $lang string two letter language code
	 * @return array list of social urls for given language. In case of no url is defined for given language, english urls are returned.
	 */
	public function getSocialHrefs( $lang ) {
		$lang = $this->getLangWithFallback( $lang );

		return $this->socialHrefs[ $lang ] ?? $this->socialHrefs[ 'en' ];
	}

	private function getLangWithFallback( $lang ) {
		if ( isset( $this->hrefs[ $lang ] ) ) {
			return $lang;
		}

		$fallbacks = Language::getFallbacksFor( $lang );
		foreach ( $fallbacks as $fallbackCode ) {
			// All languages fallback to en, but we use that for English-specific
			// URLs, so we want to fallback only to default, rather than en
			if ( $fallbackCode !== 'en' && isset( $this->hrefs[ $fallbackCode ] ) ) {
				return $fallbackCode;
			}
		}

		return 'default';
	}

	private $hrefs = [
		'default' => [
			'explore-wikis' => 'https://www.fandom.com/explore',
			'about' => 'https://www.fandom.com/about',
			'careers' => 'https://www.fandom.com/careers',
			'press' => 'https://www.fandom.com/press',
			'contact' => 'https://www.fandom.com/about#contact',
			'terms-of-use' => 'https://www.fandom.com/terms-of-use',
			'privacy-policy' => 'https://www.fandom.com/privacy-policy',
			'global-sitemap' => 'https://community.fandom.com/Sitemap',
			'local-sitemap' => '/wiki/Local_Sitemap',
			'local-sitemap-fandom' => 'https://www.fandom.com/local-sitemap',
			'community-central' => '//community.fandom.com/wiki/Community_Central',
			'support' => 'https://fandom.zendesk.com/',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki',
			'wam' => '//community.fandom.com/wiki/WAM',
			'help' => '//community.fandom.com/wiki/Help:Contents',
			'media-kit' => 'https://www.fandom.com/mediakit',
			'media-kit-contact' => null,
			'app-store' => 'https://itunes.apple.com/us/app/fandom-videos-news-reviews/id1230063803?ls=1&mt=8',
			'google-play' => 'https://play.google.com/store/apps/details?id=com.fandom.app',
			'ddb-app-store' => 'https://apps.apple.com/us/app/id1501810129',
			'ddb-google-play' => 'https://play.google.com/store/apps/details?id=com.fandom.playercompanion',
			'fandom-logo' => 'https://www.fandom.com/',
			'wikia-org-logo' => 'https://www.wikia.org/',
			'games' => 'https://www.fandom.com/topics/games',
			'movies' => 'https://www.fandom.com/topics/movies',
			'tv' => 'https://www.fandom.com/topics/tv',
			'video' => 'https://www.fandom.com/video',
			'user-signin' => 'https://www.wikia.com/signin',
			'user-logout' => 'https://www.wikia.com/logout',
			'user-register' => 'https://www.wikia.com/register',
			'user-author-profile' => 'https://www.fandom.com/u/',
			'usp-do-not-sell-fandom' => 'https://www.fandom.com/do-not-sell-my-info',
			'usp-do-not-sell-wikiaorg' => 'https://www.wikia.org/do-not-sell-my-info',
		],
		'de' => [
			'explore-wikis' => 'https://www.fandom.com/explore-de?uselang=de',
			'fandom-logo' => 'https://www.fandom.com/explore-de?uselang=de',
			'about' => 'https://www.fandom.com/about?uselang=de',
			'press' => 'https://www.fandom.com/press?uselang=de',
			'contact' => 'https://www.fandom.com/about?uselang=de',
			'terms-of-use' => 'https://www.fandom.com/de/terms-of-use-de',
			'privacy-policy' => 'https://www.fandom.com/de/privacy-policy-de',
			'community-central' => 'https://community.fandom.com/de/wiki/Community_Deutschland',
			'support' => 'https://fandom.zendesk.com/',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=de',
			'wam' => '//community.fandom.com/wiki/WAM?langCode=de',
			'help' => 'https://community.fandom.com/de/wiki/Hilfe:%C3%9Cbersicht',
			'media-kit' => 'https://www.fandom.com/mediakit?uselang=de',
			'app-store' => 'https://itunes.apple.com/de/developer/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=FANDOM+powered+by+Wikia&hl=de',
			'user-signin' => 'https://www.wikia.com/signin?uselang=de',
			'user-register' => 'https://www.wikia.com/register?uselang=de',
			'games' => 'https://www.fandom.com/explore-de?uselang=de#Videospiele',
			'movies' => 'https://www.fandom.com/explore-de?uselang=de#Filme',
			'tv' => 'https://www.fandom.com/explore-de?uselang=de#TV',
		],
		'en' => [
			'media-kit-contact' => 'https://www.fandom.com/mediakit#contact',
		],
		'es' => [
			'explore-wikis' => 'https://www.fandom.com/explore-es?uselang=es',
			'fandom-logo' => 'https://www.fandom.com/explore-es?uselang=es',
			'about' => 'https://www.fandom.com/about?uselang=es',
			'press' => 'https://www.fandom.com/press?uselang=es',
			'contact' => 'https://www.fandom.com/about?uselang=es',
			'terms-of-use' => 'https://www.fandom.com/es/terms-of-use-es',
			'privacy-policy' => 'https://www.fandom.com/es/privacy-policy-es',
			'community-central' => 'https://comunidad.fandom.com/wiki/Wikia',
			'support' => 'https://fandom.zendesk.com/hc/es',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=es',
			'wam' => '//community.fandom.com/wiki/WAM?langCode=es',
			'help' => 'https://comunidad.fandom.com/wiki/Ayuda:Contenidos',
			'media-kit' => 'https://www.fandom.com/mediakit?uselang=es',
			'app-store' => 'https://itunes.apple.com/es/developer/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=FANDOM+powered+by+Wikia&hl=es',
			'user-signin' => 'https://www.wikia.com/signin?uselang=es',
			'user-register' => 'https://www.wikia.com/register?uselang=es',
			'games' => 'https://www.fandom.com/explore-es?uselang=es#Juegos',
			'movies' => 'https://www.fandom.com/explore-es?uselang=es#Películas',
			'tv' => 'https://www.fandom.com/explore-es?uselang=es#TV',
		],
		'fr' => [
			'explore-wikis' => 'https://www.fandom.com/explore-fr?uselang=fe',
			'fandom-logo' => 'https://www.fandom.com/explore-fr?uselang=fr',
			'about' => 'https://www.fandom.com/about?uselang=fr',
			'press' => 'https://www.fandom.com/press?uselang=fr',
			'contact' => 'https://www.fandom.com/about?uselang=fr',
			'terms-of-use' => 'https://www.fandom.com/fr/terms-of-use-fr',
			'privacy-policy' => 'https://www.fandom.com/fr/privacy-policy-fr',
			'community-central' => 'https://communaute.fandom.com/wiki/Centre_des_communaut%C3%A9s',
			'support' => 'https://fandom.zendesk.com/',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=fr',
			'wam' => '//community.fandom.com/wiki/WAM?langCode=fr',
			'help' => 'https://communaute.fandom.com/wiki/Aide:Contenu',
			'app-store' => 'https://itunes.apple.com/fr/developer/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=FANDOM+powered+by+Wikia&hl=fr',
			'user-signin' => 'https://www.wikia.com/signin?uselang=fr',
			'user-register' => 'https://www.wikia.com/register?uselang=fr',
			'games' => 'https://www.fandom.com/explore-fr?uselang=fr#Jeux_vidéo',
			'movies' => 'https://www.fandom.com/explore-fr?uselang=fr#Cinéma',
			'tv' => 'https://www.fandom.com/explore-fr?uselang=fr#Télévision',
		],
		'it' => [
			'explore-wikis' => 'https://www.fandom.com/explore-it?uselang=it',
			'fandom-logo' => 'https://www.fandom.com/explore-it?uselang=it',
			'about' => 'https://www.fandom.com/about?uselang=it',
			'press' => 'https://www.fandom.com/press?uselang=it',
			'contact' => 'https://www.fandom.com/about?uselang=it',
			'terms-of-use' => 'https://www.fandom.com/it/terms-of-use-it',
			'privacy-policy' => 'https://www.fandom.com/it/privacy-policy-it',
			'community-central' => 'https://community.fandom.com/it/wiki/Wiki_della_Community',
			'support' => 'https://fandom.zendesk.com/',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=it',
			'wam' => '//community.fandom.com/wiki/WAM?langCode=it',
			'help' => 'https://community.fandom.com/it/wiki/Aiuto:Contenuti',
			'app-store' => 'https://itunes.apple.com/it/developer/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=FANDOM+powered+by+Wikia&hl=it',
			'user-signin' => 'https://www.wikia.com/signin?uselang=it',
			'user-register' => 'https://www.wikia.com/register?uselang=it',
			'games' => 'https://www.fandom.com/explore-it?uselang=it#Giochi',
			'movies' => 'https://www.fandom.com/explore-it?uselang=it#Cinema',
			'tv' => 'https://www.fandom.com/explore-it?uselang=it#TV',
		],
		'ja' => [
			'explore-wikis' => 'https://www.fandom.com/explore-ja?uselang=ja',
			'fandom-logo' => 'https://www.fandom.com/explore-ja?uselang=ja',
			'about' => 'https://www.fandom.com/about?uselang=ja',
			'press' => 'https://www.fandom.com/press?uselang=ja',
			'contact' => 'https://www.fandom.com/about?uselang=ja',
			'terms-of-use' => 'https://www.fandom.com/ja/terms-of-use-ja',
			'privacy-policy' => 'https://www.fandom.com/ja/privacy-policy-ja',
			'community-central' => 'https://community.fandom.com/ja/wiki/%E3%83%A1%E3%82%A4%E3%83%B3%E3%83%9A%E3%83%BC%E3%82%B8',
			'support' => 'https://fandom.zendesk.com/',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=ja',
			'wam' => '//community.fandom.com/wiki/WAM?langCode=ja',
			'help' => 'https://community.fandom.com/ja/wiki/%E3%83%98%E3%83%AB%E3%83%97:%E3%82%B3%E3%83%B3%E3%83%86%E3%83%B3%E3%83%84',
			'media-kit' => 'https://www.fandom.com/mediakit',
			'app-store' => 'https://itunes.apple.com/jp/developer/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=FANDOM+powered+by+Wikia&hl=ja',
			'user-signin' => 'https://www.wikia.com/signin?uselang=ja',
			'user-register' => 'https://www.wikia.com/register?uselang=ja',
			'games' => 'https://www.fandom.com/explore-ja?uselang=ja#ゲーム',
			'movies' => 'https://www.fandom.com/explore-ja?uselang=ja#映画',
			'tv' => 'https://www.fandom.com/explore-ja?uselang=ja#TV',
		],
		'pl' => [
			'explore-wikis' => 'https://www.fandom.com/explore-pl?uselang=pl',
			'fandom-logo' => 'https://www.fandom.com/explore-pl?uselang=pl',
			'about' => 'https://www.fandom.com/about?uselang=pl',
			'press' => 'https://www.fandom.com/press?uselang=pl',
			'contact' => 'https://www.fandom.com/about?uselang=pl',
			'terms-of-use' => 'https://www.fandom.com/pl/terms-of-use-pl',
			'privacy-policy' => 'https://www.fandom.com/pl/privacy-policy-pl',
			'community-central' => 'https://spolecznosc.fandom.com/wiki/Centrum_Spo%C5%82eczno%C5%9Bci',
			'support' => 'https://fandom.zendesk.com/',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=pl',
			'wam' => '//community.fandom.com/wiki/WAM?langCode=pl',
			'help' => 'https://spolecznosc.fandom.com/wiki/Pomoc:Zawarto%C5%9B%C4%87',
			'app-store' => 'https://itunes.apple.com/pl/developer/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=FANDOM+powered+by+Wikia&hl=pl',
			'user-signin' => 'https://www.wikia.com/signin?uselang=pl',
			'user-register' => 'https://www.wikia.com/register?uselang=pl',
			'games' => 'https://www.fandom.com/explore-pl?uselang=pl#Gry',
			'movies' => 'https://www.fandom.com/explore-pl?uselang=pl#Filmy',
			'tv' => 'https://www.fandom.com/explore-pl?uselang=pl#TV',
		],
		'pt-br' => [
			'explore-wikis' => 'https://www.fandom.com/explore-pt-br?uselang=pt-br',
			'fandom-logo' => 'https://www.fandom.com/explore-pt-br?uselang=pt-br',
			'about' => 'https://www.fandom.com/about?uselang=pt-br',
			'press' => 'https://www.fandom.com/press?uselang=pt-br',
			'contact' => 'https://www.fandom.com/about?uselang=pt-br',
			'terms-of-use' => 'https://www.fandom.com/pt-br/terms-of-use-pt-br',
			'privacy-policy' => 'https://www.fandom.com/pt-br/privacy-policy-pt-br',
			'community-central' => 'https://comunidade.fandom.com/wiki/Central_da_Comunidade',
			'support' => 'https://fandom.zendesk.com/',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=pt-br',
			'wam' => '//community.fandom.com/wiki/WAM?langCode=pt-br',
			'help' => 'https://comunidade.fandom.com/wiki/Ajuda:Conte%C3%BAdos',
			'app-store' => 'https://itunes.apple.com/br/developer/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=FANDOM+powered+by+Wikia&hl=pt-br',
			'user-signin' => 'https://www.wikia.com/signin?uselang=pt-br',
			'user-register' => 'https://www.wikia.com/register?uselang=pt-br',
			'games' => 'https://www.fandom.com/explore-pt-br?uselang=pt-br#Jogos',
			'movies' => 'https://www.fandom.com/explore-pt-br?uselang=pt-br#Filmes',
			'tv' => 'https://www.fandom.com/explore-pt-br?uselang=pt-br#TV',
		],
		'ru' => [
			'explore-wikis' => 'https://www.fandom.com/explore-ru?uselang=ru',
			'fandom-logo' => 'https://www.fandom.com/explore-ru?uselang=ru',
			'about' => 'https://www.fandom.com/about?uselang=ru',
			'press' => 'https://www.fandom.com/press?uselang=ru',
			'contact' => 'https://www.fandom.com/about?uselang=ru',
			'terms-of-use' => 'https://www.fandom.com/ru/terms-of-use-ru',
			'privacy-policy' => 'https://www.fandom.com/ru/privacy-policy-ru',
			'community-central' => 'https://community.fandom.com/ru/',
			'support' => 'https://fandom.zendesk.com/hc/ru',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=ru',
			'wam' => '//community.fandom.com/wiki/WAM?langCode=ru',
			'help' => 'https://community.fandom.com/ru/wiki/%D0%A1%D0%BF%D1%80%D0%B0%D0%B2%D0%BA%D0%B0:%D0%A1%D0%BE%D0%B4%D0%B5%D1%80%D0%B6%D0%B0%D0%BD%D0%B8%D0%B5',
			'app-store' => 'https://itunes.apple.com/ru/developer/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=FANDOM+powered+by+Wikia&hl=ru',
			'user-signin' => 'https://www.wikia.com/signin?uselang=ru',
			'user-register' => 'https://www.wikia.com/register?uselang=ru',
			'games' => 'https://www.fandom.com/explore-ru?uselang=ru#Видеоигры',
			'movies' => 'https://www.fandom.com/explore-ru?uselang=ru#Кино',
			'tv' => 'https://www.fandom.com/explore-ru?uselang=ru#ТВ',
		],
		'zh-hans' => [
			'explore-wikis' => 'https://www.fandom.com/explore-zh?uselang=zh',
			'fandom-logo' => 'https://www.fandom.com/explore-zh?uselang=zh',
			'about' => 'https://www.fandom.com/about?uselang=zh',
			'press' => 'https://www.fandom.com/press?uselang=zh',
			'contact' => 'https://www.fandom.com/about?uselang=zh',
			'terms-of-use' => 'https://www.fandom.com/zh/terms-of-use-zh',
			'privacy-policy' => 'https://www.fandom.com/zh/privacy-policy-zh',
			'community-central' => 'https://community.fandom.com/zh/',
			'support' => 'https://fandom.zendesk.com/',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=zh',
			'wam' => '//community.fandom.com/wiki/WAM?langCode=zh',
			'help' => 'https://community.fandom.com/zh/wiki/Help:%E5%86%85%E5%AE%B9',
			'app-store' => 'https://itunes.apple.com/cn/developer/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=FANDOM+powered+by+Wikia&hl=zh',
			'user-signin' => 'https://www.wikia.com/signin?uselang=zh',
			'user-register' => 'https://www.wikia.com/register?uselang=zh',
			'games' => 'https://www.fandom.com/explore-zh?uselang=zh#游戏',
			'movies' => 'https://www.fandom.com/explore-zh?uselang=zh#电影',
			'tv' => 'https://www.fandom.com/explore-zh?uselang=zh#电视',
		],
		'zh-hant' => [
			'explore-wikis' => 'https://www.fandom.com/explore-zh-tw?uselang=zh-tw',
			'fandom-logo' => 'https://www.fandom.com/explore-zh-tw?uselang=zh-tw',
			'about' => 'https://www.fandom.com/about?uselang=zh-tw',
			'press' => 'https://www.fandom.com/press?uselang=zh-tw',
			'contact' => 'https://www.fandom.com/about?uselang=zh-tw',
			'terms-of-use' => 'https://www.fandom.com/zh-tw/terms-of-use-zh-tw',
			'privacy-policy' => 'https://www.fandom.com/zh-tw/privacy-policy-zh-tw',
			'community-central' => 'https://community.fandom.com/zh/',
			'support' => 'https://fandom.zendesk.com/',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=zh-tw',
			'wam' => '//community.fandom.com/wiki/WAM?langCode=zh-tw',
			'help' => 'https://community.fandom.com/zh/wiki/Help:%E5%86%85%E5%AE%B9',
			'app-store' => 'https://itunes.apple.com/tw/developer/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=FANDOM+powered+by+Wikia&hl=zh-tw',
			'user-signin' => 'https://www.wikia.com/signin?uselang=zh-tw',
			'user-register' => 'https://www.wikia.com/register?uselang=zh-tw',
			'games' => 'https://www.fandom.com/explore-zh-tw?uselang=zh-tw#遊戲',
			'movies' => 'https://www.fandom.com/explore-zh-tw?uselang=zh-tw#電影',
			'tv' => 'https://www.fandom.com/explore-zh-tw?uselang=zh-tw#電視',
		],
		'vi' => [
			'community-central' => 'https://congdong.fandom.com/wiki/Trang_Ch%C3%ADnh',
			'support' => 'https://fandom.zendesk.com/',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=vi',
			'help' => 'https://congdong.fandom.com/wiki/%C4%90%E1%BA%B7c_bi%E1%BB%87t:Li%C3%AAn_h%E1%BB%87',
		],
		'nl' => [
			'community-central' => 'https://community.fandom.com/nl/wiki/Centrale_Wikia_community',
			'support' => 'https://fandom.zendesk.com/',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=nl',
			'help' => 'https://community.fandom.com/nl/wiki/Speciaal:Contact',
		],
		'fi' => [
			'community-central' => 'https://yhteiso.fandom.com/wiki/Yhteis%C3%B6wiki',
			'support' => 'https://fandom.zendesk.com/',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=fi',
			'help' => 'https://yhteiso.fandom.com/wiki/Toiminnot:Contact',
		],
		'ko' => [
			'community-central' => 'https://community.fandom.com/ko/wiki/%EB%8C%80%EB%AC%B8',
			'support' => 'https://fandom.zendesk.com/',
			'create-new-wiki' => '//community.fandom.com/wiki/Special:CreateNewWiki?uselang=ko',
			'help' => 'https://community.fandom.com/ko/wiki/%ED%8A%B9%EC%88%98%EA%B8%B0%EB%8A%A5:%EB%AC%B8%EC%9D%98',
		],
	];

	private $socialHrefs = [
		'en' => [
			'facebook' => 'https://www.facebook.com/getfandom',
			'twitter' => 'https://twitter.com/getfandom',
			'youtube' => 'https://www.youtube.com/fandomentertainment',
			'instagram' => 'https://www.instagram.com/getfandom/',
			'linkedin' => 'https://www.linkedin.com/company/157252',
		],
		'de' => [
			'facebook' => 'https://www.facebook.com/de.fandom',
			'twitter' => 'https://twitter.com/fandom_deutsch',
			'instagram' => 'https://www.instagram.com/de_fandom',
		],
		'es' => [
			'facebook' => 'https://www.facebook.com/Fandom.espanol/',
			'twitter' => 'https://twitter.com/es_fandom',
		],
		'fr' => [
			'facebook' => 'https://www.facebook.com/fandom.fr',
			'twitter' => 'https://twitter.com/fandom_fr',
		],
		'it' => [
			'facebook' => 'https://www.facebook.com/fandom.italy',
			'twitter' => 'https://twitter.com/fandom_italy',
		],
		'ja' => [
			'facebook' => 'https://www.facebook.com/FandomJP',
			'twitter' => 'https://twitter.com/FandomJP',
		],
		'pl' => [
			'facebook' => 'https://www.facebook.com/pl.fandom',
			'twitter' => 'https://twitter.com/pl_fandom',
		],
		'pt-br' => [
			'facebook' => 'https://www.facebook.com/getfandom.br',
			'twitter' => 'https://twitter.com/getfandom_br',
		],
		'ru' => [
			'facebook' => 'https://www.facebook.com/ru.fandom',
			'twitter' => 'https://twitter.com/ru_fandom',
			'vkontakte' => 'https://vk.com/ru_fandom',
		],
		'zh-hans' => [
			'facebook' => 'https://www.facebook.com/fandom.zh',
		],
		'zh-hant' => [
			'facebook' => 'https://www.facebook.com/fandom.zh',
		],
	];
}
