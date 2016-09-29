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

		return $this->hrefs[ $lang ][ $name ] ?? $this->hrefs[ 'default' ][ $name ];
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
			'fan-communities' => 'http://fandom.wikia.com/explore',
			'about' => 'http://www.wikia.com/about',
			'careers' => 'https://careers.wikia.com',
			'press' => 'http://fandom.wikia.com/press',
			'contact' => 'http://fandom.wikia.com/contact',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback',
			'terms-of-use' => 'http://www.wikia.com/Terms_of_use',
			'privacy-policy' => 'http://www.wikia.com/Privacy_Policy',
			'global-sitemap' => 'http://www.wikia.com/Sitemap',
			'local-sitemap' => '/wiki/Local_Sitemap',
			'local-sitemap-fandom' => 'http://fandom.wikia.com/local-sitemap',
			'community-central' => 'http://community.wikia.com/wiki/Community_Central',
			'support' => 'http://community.wikia.com/wiki/Special:Contact',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki',
			'fan-contributor' => null,
			'wam' => 'http://www.wikia.com/WAM',
			'help' => 'http://community.wikia.com/wiki/Help:Contents',
			'media-kit' => 'http://www.wikia.com/mediakit',
			'media-kit-contact' => 'http://www.wikia.com/mediakit/contact',
			'social-facebook' => 'https://www.facebook.com/getfandom',
			'social-twitter' => 'https://twitter.com/getfandom',
			'social-reddit' => 'https://www.reddit.com/r/wikia',
			'social-youtube' => 'https://www.youtube.com/channel/UC988qTQImTjO7lUdPfYabgQ',
			'social-instagram' => 'https://www.instagram.com/getfandom/',
			'app-store' => 'https://itunes.apple.com/developer/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.',
			'fandom-logo' => 'http://fandom.wikia.com',
			'games' => 'http://fandom.wikia.com/games',
			'movies' => 'http://fandom.wikia.com/movies',
			'tv' => 'http://fandom.wikia.com/tv',
			'fandom-university' => 'http://community.wikia.com/wiki/Wikia_University',
			'user-signin' => 'https://www.wikia.com/signin',
			'user-register' => 'https://www.wikia.com/register',
		],
		'de' => [
			'fan-communities' => 'http://de.wikia.com/Wikia',
			'fandom-logo' => 'http://de.wikia.com',
			'about' => 'http://de.wikia.com/Ueber_Wikia',
			'press' => 'http://de.wikia.com/Presse',
			'contact' => 'http://de.wikia.com/Spezial:Kontakt',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback?uselang=de',
			'terms-of-use' => 'http://de.wikia.com/Nutzungsbedingungen',
			'privacy-policy' => 'http://de.wikia.com/Datenschutz',
			'community-central' => 'http://de.community.wikia.com/wiki/Community_Deutschland',
			'support' => 'http://de.community.wikia.com/wiki/Spezial:Kontakt',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=de',
			'wam' => 'http://de.wikia.com/WAM?langCode=de',
			'help' => 'http://de.community.wikia.com/wiki/Hilfe:%C3%9Cbersicht',
			'media-kit' => 'http://www.wikia.com/mediakit?uselang=de',
			'app-store' => 'https://itunes.apple.com/de/artist/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.&hl=de',
			'user-signin' => 'https://www.wikia.com/signin?uselang=de',
			'user-register' => 'https://www.wikia.com/register?uselang=de',
		],
		'en' => [
			'fan-contributor' => 'http://fandom.wikia.com/fan-contributor',
		],
		'es' => [
			'fan-communities' => 'http://es.wikia.com/Wikia',
			'fandom-logo' => 'http://es.wikia.com',
			'about' => 'http://es.wikia.com/Sobre_nosotros',
			'press' => 'http://es.wikia.com/Prensa',
			'contact' => 'http://es.wikia.com/Especial:Contactar',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback?uselang=es',
			'terms-of-use' => 'http://es.wikia.com/T%C3%A9rminos_de_uso',
			'privacy-policy' => 'http://es.wikia.com/Pol%C3%ADtica_de_privacidad',
			'community-central' => 'http://comunidad.wikia.com/wiki/Wikia',
			'support' => 'http://comunidad.wikia.com/wiki/Especial:Contactar',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=es',
			'wam' => 'http://es.wikia.com/WAM?langCode=es',
			'help' => 'http://comunidad.wikia.com/wiki/Ayuda:Contenidos',
			'media-kit' => 'http://www.wikia.com/mediakit?uselang=es',
			'app-store' => 'https://itunes.apple.com/es/artist/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.&hl=es',
			'user-signin' => 'https://www.wikia.com/signin?uselang=es',
			'user-register' => 'https://www.wikia.com/register?uselang=es',
		],
		'fr' => [
			'fan-communities' => 'http://fr.wikia.com/Wikia',
			'fandom-logo' => 'http://fr.wikia.com',
			'about' => 'http://fr.wikia.com/%C3%80_propos',
			'contact' => 'http://fr.wikia.com/Sp%C3%A9cial:Contact',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback?uselang=fr',
			'terms-of-use' => 'http://fr.wikia.com/Conditions_d\'utilisation',
			'privacy-policy' => 'http://fr.wikia.com/Politique_de_confidentialit%C3%A9',
			'community-central' => 'http://communaute.wikia.com/wiki/Centre_des_communaut%C3%A9s',
			'support' => 'http://communaute.wikia.com/wiki/Sp%C3%A9cial:Contact',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=fr',
			'wam' => 'http://fr.wikia.com/WAM?langCode=fr',
			'help' => 'http://communaute.wikia.com/wiki/Aide:Contenu',
			'app-store' => 'https://itunes.apple.com/fr/artist/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.&hl=fr',
			'user-signin' => 'https://www.wikia.com/signin?uselang=fr',
			'user-register' => 'https://www.wikia.com/register?uselang=fr',
		],
		'it' => [
			'fan-communities' => 'http://it.community.wikia.com/wiki/Wiki_della_Community',
			'contact' => 'http://it.community.wikia.com/wiki/Speciale:Contatta',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback?uselang=it',
			'terms-of-use' => 'http://it.community.wikia.com/wiki/Wiki_della_Community:Termini_di_utilizzo',
			'privacy-policy' => 'http://it.community.wikia.com/wiki/Wiki_della_Community:Privacy',
			'community-central' => 'http://it.community.wikia.com/wiki/Wiki_della_Community',
			'support' => 'http://it.community.wikia.com/wiki/Speciale:Contatta',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=it',
			'wam' => 'http://www.wikia.com/WAM?langCode=it',
			'help' => 'http://it.community.wikia.com/wiki/Aiuto:Contenuti',
			'app-store' => 'https://itunes.apple.com/it/artist/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.&hl=it',
			'user-signin' => 'https://www.wikia.com/signin?uselang=it',
			'user-register' => 'https://www.wikia.com/register?uselang=it',
		],
		'ja' => [
			'fan-communities' => 'http://ja.wikia.com/',
			'fandom-logo' => 'http://ja.wikia.com',
			'about' => 'http://ja.wikia.com/companyinfo',
			'contact' => 'http://ja.wikia.com/%E7%89%B9%E5%88%A5:%E3%81%8A%E5%95%8F%E3%81%84%E5%90%88%E3%82%8F%E3%81%9B',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback?uselang=ja',
			'terms-of-use' => 'http://ja.wikia.com/%E5%88%A9%E7%94%A8%E8%A6%8F%E7%B4%84',
			'privacy-policy' => 'http://ja.wikia.com/%E3%83%97%E3%83%A9%E3%82%A4%E3%83%90%E3%82%B7%E3%83%BC%E3%83%9D%E3%83%AA%E3%82%B7%E3%83%BC',
			'community-central' => 'http://ja.community.wikia.com/wiki/%E3%83%A1%E3%82%A4%E3%83%B3%E3%83%9A%E3%83%BC%E3%82%B8',
			'support' => 'http://ja.community.wikia.com/wiki/%E7%89%B9%E5%88%A5:%E3%81%8A%E5%95%8F%E3%81%84%E5%90%88%E3%82%8F%E3%81%9B',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=ja',
			'wam' => 'http://ja.wikia.com/WAM?langCode=ja',
			'help' => 'http://ja.community.wikia.com/wiki/%E3%83%98%E3%83%AB%E3%83%97:%E3%82%B3%E3%83%B3%E3%83%86%E3%83%B3%E3%83%84',
			'media-kit' => 'http://www.wikia.com/mediakit?uselang=ja',
			'app-store' => 'https://itunes.apple.com/jp/artist/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.&hl=ja',
			'user-signin' => 'https://www.wikia.com/signin?uselang=ja',
			'user-register' => 'https://www.wikia.com/register?uselang=ja',
		],
		'pl' => [
			'fan-communities' => 'http://pl.wikia.com/Wikia',
			'fandom-logo' => 'http://pl.wikia.com',
			'about' => 'http://pl.wikia.com/O_nas',
			'contact' => 'http://pl.wikia.com/Specjalna:Kontakt',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback?uselang=pl',
			'terms-of-use' => 'http://pl.wikia.com/Zasady_U%C5%BCytkowania',
			'privacy-policy' => 'http://pl.wikia.com/Polityka_Prywatno%C5%9Bci',
			'community-central' => 'http://spolecznosc.wikia.com/wiki/Centrum_Spo%C5%82eczno%C5%9Bci',
			'support' => 'http://spolecznosc.wikia.com/wiki/Specjalna:Kontakt',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=pl',
			'wam' => 'http://pl.wikia.com/WAM?langCode=pl',
			'help' => 'http://spolecznosc.wikia.com/wiki/Pomoc:Zawarto%C5%9B%C4%87',
			'app-store' => 'https://itunes.apple.com/pl/artist/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.&hl=pl',
			'user-signin' => 'https://www.wikia.com/signin?uselang=pl',
			'user-register' => 'https://www.wikia.com/register?uselang=pl',
		],
		'pt-br' => [
			'fan-communities' => 'http://pt-br.wikia.com/wiki/Wikia_em_Portugu%C3%AAs',
			'fandom-logo' => 'http://pt-br.wikia.com',
			'contact' => 'http://pt-br.wikia.com/wiki/Especial:Contact',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback?uselang=pt-br',
			'terms-of-use' => 'http://pt-br.wikia.com/wiki/Termos_de_Uso',
			'privacy-policy' => 'http://pt-br.wikia.com/wiki/Pol%C3%ADtica_de_Privacidade',
			'community-central' => 'http://comunidade.wikia.com/wiki/Central_da_Comunidade',
			'support' => 'http://comunidade.wikia.com/wiki/Especial:Contact',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=pt-br',
			'wam' => 'http://www.wikia.com/WAM?langCode=pt-br',
			'help' => 'http://comunidade.wikia.com/wiki/Ajuda:Conte%C3%BAdos',
			'app-store' => 'https://itunes.apple.com/br/artist/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.&hl=pt-br',
			'user-signin' => 'https://www.wikia.com/signin?uselang=pt-br',
			'user-register' => 'https://www.wikia.com/register?uselang=pt-br',
		],
		'ru' => [
			'fan-communities' => 'http://ru.wikia.com/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D1%8F_%D0%BD%D0%B0_%D1%80%D1%83%D1%81%D1%81%D0%BA%D0%BE%D0%BC',
			'fandom-logo' => 'http://ru.wikia.com',
			'about' => 'http://ru.wikia.com/wiki/%D0%9E_%D0%BD%D0%B0%D1%81',
			'contact' => 'http://ru.wikia.com/wiki/%D0%A1%D0%BB%D1%83%D0%B6%D0%B5%D0%B1%D0%BD%D0%B0%D1%8F:Contact',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback?uselang=ru',
			'terms-of-use' => 'http://ru.community.wikia.com/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D1%8F:%D0%A3%D1%81%D0%BB%D0%BE%D0%B2%D0%B8%D1%8F_%D0%B8%D1%81%D0%BF%D0%BE%D0%BB%D1%8C%D0%B7%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D1%8F',
			'privacy-policy' => 'http://ru.community.wikia.com/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D1%8F:%D0%9A%D0%BE%D0%BD%D1%84%D0%B8%D0%B4%D0%B5%D0%BD%D1%86%D0%B8%D0%B0%D0%BB%D1%8C%D0%BD%D0%BE%D1%81%D1%82%D1%8C',
			'community-central' => 'http://ru.community.wikia.com/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D1%8F',
			'support' => 'http://ru.community.wikia.com/wiki/%D0%A1%D0%BB%D1%83%D0%B6%D0%B5%D0%B1%D0%BD%D0%B0%D1%8F:Contact',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=ru',
			'wam' => 'http://www.wikia.com/WAM?langCode=ru',
			'help' => 'http://ru.community.wikia.com/wiki/%D0%A1%D0%BF%D1%80%D0%B0%D0%B2%D0%BA%D0%B0:%D0%A1%D0%BE%D0%B4%D0%B5%D1%80%D0%B6%D0%B0%D0%BD%D0%B8%D0%B5',
			'app-store' => 'https://itunes.apple.com/ru/artist/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.&hl=ru',
			'user-signin' => 'https://www.wikia.com/signin?uselang=ru',
			'user-register' => 'https://www.wikia.com/register?uselang=ru',
		],
		'zh-hans' => [
			'fan-communities' => 'http://zh.wikia.com/wiki/Wikia%E4%B8%AD%E6%96%87',
			'fandom-logo' => 'http://zh.wikia.com',
			'terms-of-use' => 'http://zh.wikia.com/wiki/%E4%BD%BF%E7%94%A8%E6%9D%A1%E6%AC%BE',
			'privacy-policy' => 'http://zh.wikia.com/wiki/Privacy_Policy',
			'community-central' => 'http://zh.community.wikia.com/wiki/Wikia_%E4%B8%AD%E6%96%87',
			'support' => 'http://zh.community.wikia.com/wiki/Special:Contact',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=zh',
			'wam' => 'http://www.wikia.com/WAM?langCode=zh',
			'help' => 'http://zh.community.wikia.com/wiki/Help:%E5%86%85%E5%AE%B9',
			'app-store' => 'https://itunes.apple.com/cn/artist/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.&hl=zh',
			'user-signin' => 'https://www.wikia.com/signin?uselang=zh',
			'user-register' => 'https://www.wikia.com/register?uselang=zh',
		],
		'zh-hant' => [
			'fan-communities' => 'http://zh-tw.wikia.com/wiki/Wikia%E4%B8%AD%E6%96%87',
			'fandom-logo' => 'http://zh-tw.wikia.com',
			'contact' => 'http://zh-tw.wikia.com/wiki/%E7%89%B9%E6%AE%8A:Contact',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback?uselang=zh-tw',
			'terms-of-use' => 'http://zh-tw.wikia.com/wiki/%E4%BD%BF%E7%94%A8%E6%A2%9D%E6%AC%BE',
			'privacy-policy' => 'http://zh-tw.wikia.com/wiki/Privacy_Policy',
			'community-central' => 'http://zh.community.wikia.com/wiki/Fandom_%E4%B8%AD%E6%96%87',
			'support' => 'http://zh.community.wikia.com/wiki/Special:Contact',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=zh-tw',
			'wam' => 'http://www.wikia.com/WAM?langCode=zh-tw',
			'help' => 'http://zh.community.wikia.com/wiki/Help:%E5%86%85%E5%AE%B9',
			'app-store' => 'https://itunes.apple.com/tw/artist/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.&hl=zh-tw',
			'user-signin' => 'https://www.wikia.com/signin?uselang=zh-tw',
			'user-register' => 'https://www.wikia.com/register?uselang=zh-tw',
		],
		'vi' => [
			'community-central' => 'http://congdong.wikia.com/wiki/Trang_Ch%C3%ADnh',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=vi',
			'help' => 'http://congdong.wikia.com/wiki/Tr%E1%BB%A3_gi%C3%BAp:M%E1%BB%A5c_l%E1%BB%A5c',
		],
		'nl' => [
			'community-central' => 'http://nl.community.wikia.com/wiki/Centrale_Wikia_community',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=nl',
			'help' => 'http://nl.community.wikia.com/wiki/Help:Inhoud',
		],
		'fi' => [
			'community-central' => 'http://yhteiso.wikia.com/wiki/Yhteis%C3%B6wiki',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=fi',
			'help' => 'http://yhteiso.wikia.com/wiki/Ohje:Sis%C3%A4ll%C3%B6t',
		],
		'ko' => [
			'community-central' => 'http://ko.community.wikia.com/wiki/%EB%8C%80%EB%AC%B8',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=ko',
			'help' => 'http://ko.community.wikia.com/wiki/%EB%8F%84%EC%9B%80%EB%A7%90:%EC%BD%98%ED%85%90%EC%B8%A0',
		],
	];
}
