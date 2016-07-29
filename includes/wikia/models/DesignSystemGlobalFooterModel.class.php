<?php

class DesignSystemGlobalFooterModel extends WikiaModel {
	const DEFAULT_LANG = 'en';

	private $hrefs = [
		'default' => [
			'vertical-games' => null,
			'vertical-movies' => null,
			'vertical-tv' => null,
			'fan-communities' => 'http://www.wikia.com/explore',
			'about' => 'http://www.wikia.com/about',
			'careers' => 'https://careers.wikia.com',
			'press' => 'http://fandom.wikia.com/press',
			'contact' => 'http://fandom.wikia.com/contact',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback',
			'terms-of-use' => 'http://www.wikia.com/Terms_of_use',
			'privacy-policy' => 'http://www.wikia.com/Privacy_Policy',
			'global-sitemap' => 'http://www.wikia.com/Sitemap',
			'api' => 'http://api.wikia.com/wiki/Wikia_API_Wiki',
			'community-central' => 'http://community.wikia.com/wiki/Community_Central',
			'support' => 'http://community.wikia.com/wiki/Special:Contact',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki',
			'fan-contributor' => null,
			'wam' => 'http://www.wikia.com/WAM',
			'help' => 'http://community.wikia.com/wiki/Help:Contents',
			'app-store' => 'https://itunes.apple.com/developer/wikia-inc./id422467077',
			'google-play' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.',
			'media-kit' => 'http://www.wikia.com/mediakit',
			'media-kit-contact' => 'http://www.wikia.com/mediakit#contacts',
			'social-facebook' => 'https://www.facebook.com/wikia',
			'social-twitter' => 'https://twitter.com/wikia',
			'social-reddit' => null,
			'social-youtube' => 'https://www.youtube.com/user/wikia',
			'social-instagram' => null
		],
		'de' => [
			'fan-communities' => 'http://de.wikia.com/Wikia',
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
			'social-facebook' => 'https://www.facebook.com/wikia.de',
			'social-twitter' => 'https://twitter.com/wikia_de',
			'social-youtube' => 'https://www.youtube.com/user/WikiaDE',
			'social-instagram' => 'https://www.instagram.com/wikia_de/'
		],
		'en' => [
			'vertical-games' => 'http://fandom.wikia.com/games',
			'vertical-movies' => 'http://fandom.wikia.com/movies',
			'vertical-tv' => 'http://fandom.wikia.com/tv',
			'fan-contributor' => 'http://fandom.wikia.com/fan-contributor',
			'social-facebook' => 'https://www.facebook.com/getfandom',
			'social-twitter' => 'https://twitter.com/getfandom',
			'social-reddit' => 'https://www.reddit.com/r/wikia',
			'social-youtube' => 'https://www.youtube.com/channel/UC988qTQImTjO7lUdPfYabgQ',
			'social-instagram' => 'https://www.instagram.com/getfandom/'
		],
		'es' => [
			'fan-communities' => 'http://es.wikia.com/Wikia',
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
			'social-facebook' => 'https://www.facebook.com/wikia.es',
			'social-twitter' => 'https://twitter.com/wikia_es',
			'social-youtube' => 'https://www.youtube.com/channel/UCjwNzRwdDqpmELNZsJv3PSg',
			'social-instagram' => 'https://www.instagram.com/wikiaes/'
		],
		'fr' => [
			'fan-communities' => 'http://fr.wikia.com/Wikia',
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
			'social-facebook' => 'https://www.facebook.com/wikia.fr',
			'social-twitter' => 'https://twitter.com/wikia_fr',
			'social-youtube' => 'https://www.youtube.com/channel/UClzAEgYaMs0SyDnXS4cyefg',
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
			'help' => 'http://it.community.wikia.com/wiki/Aiuto:Aiuto_Wiki',
			'social-facebook' => 'https://www.facebook.com/wikia.it',
			'social-twitter' => 'https://twitter.com/wikia_it',
		],
		'ja' => [
			'fan-communities' => 'http://ja.wikia.com/',
			'about' => 'http://ja.wikia.com/%E3%82%A6%E3%82%A3%E3%82%AD%E3%82%A2%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6',
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
			'social-twitter' => 'https://twitter.com/wikiajapan',
		],
		'pl' => [
			'fan-communities' => 'http://pl.wikia.com/Wikia',
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
			'social-facebook' => 'https://www.facebook.com/wikiapl',
			'social-twitter' => 'https://twitter.com/wikia_pl',
		],
		'pt-br' => [
			'fan-communities' => 'http://pt-br.wikia.com/wiki/Wikia_em_Portugu%C3%AAs',
			'contact' => 'http://pt-br.wikia.com/wiki/Especial:Contact',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback?uselang=pt-br',
			'terms-of-use' => 'http://pt-br.wikia.com/wiki/Termos_de_Uso',
			'privacy-policy' => 'http://pt-br.wikia.com/wiki/Pol%C3%ADtica_de_Privacidade',
			'community-central' => 'http://comunidade.wikia.com/wiki/Central_da_Comunidade',
			'support' => 'http://comunidade.wikia.com/wiki/Especial:Contact',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=pt-br',
			'wam' => 'http://www.wikia.com/WAM?langCode=pt-br',
			'help' => 'http://comunidade.wikia.com/wiki/Ajuda:Conte%C3%BAdos',
			'social-facebook' => 'https://www.facebook.com/WikiaemPT',
			'social-twitter' => 'https://twitter.com/ComunidadeWikia',
			'social-youtube' => 'https://www.youtube.com/channel/UCi8B4eUGFLU7SjHWFIjt3WQ',
		],
		'ru' => [
			'fan-communities' => 'http://ru.wikia.com/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D1%8F_%D0%BD%D0%B0_%D1%80%D1%83%D1%81%D1%81%D0%BA%D0%BE%D0%BC',
			'contact' => 'http://ru.wikia.com/wiki/%D0%A1%D0%BB%D1%83%D0%B6%D0%B5%D0%B1%D0%BD%D0%B0%D1%8F:Contact',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback?uselang=ru',
			'terms-of-use' => 'http://ru.community.wikia.com/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D1%8F:%D0%A3%D1%81%D0%BB%D0%BE%D0%B2%D0%B8%D1%8F_%D0%B8%D1%81%D0%BF%D0%BE%D0%BB%D1%8C%D0%B7%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D1%8F',
			'privacy-policy' => 'http://ru.community.wikia.com/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D1%8F:%D0%9A%D0%BE%D0%BD%D1%84%D0%B8%D0%B4%D0%B5%D0%BD%D1%86%D0%B8%D0%B0%D0%BB%D1%8C%D0%BD%D0%BE%D1%81%D1%82%D1%8C',
			'community-central' => 'http://ru.community.wikia.com/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D1%8F',
			'support' => 'http://ru.community.wikia.com/wiki/%D0%A1%D0%BB%D1%83%D0%B6%D0%B5%D0%B1%D0%BD%D0%B0%D1%8F:Contact',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=ru',
			'wam' => 'http://www.wikia.com/WAM?langCode=ru',
			'help' => 'http://ru.community.wikia.com/wiki/%D0%A1%D0%BF%D1%80%D0%B0%D0%B2%D0%BA%D0%B0:%D0%A1%D0%BE%D0%B4%D0%B5%D1%80%D0%B6%D0%B0%D0%BD%D0%B8%D0%B5',
			'social-facebook' => 'https://www.facebook.com/wikia.ru',
			'social-twitter' => 'https://twitter.com/wikia_ru',
		],
		'zh' => [
			'fan-communities' => 'http://zh.wikia.com/wiki/Wikia%E4%B8%AD%E6%96%87',
			'terms-of-use' => 'http://zh.wikia.com/wiki/%E4%BD%BF%E7%94%A8%E6%9D%A1%E6%AC%BE',
			'community-central' => 'http://zh.community.wikia.com/wiki/Wikia_%E4%B8%AD%E6%96%87',
			'support' => 'http://zh.community.wikia.com/wiki/Special:Contact',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=zh',
			'wam' => 'http://www.wikia.com/WAM?langCode=zh',
			'help' => 'http://zh.community.wikia.com/wiki/Help:%E5%86%85%E5%AE%B9',
			'social-facebook' => 'https://www.facebook.com/ChineseWikia',
		],
		'zh-tw' => [
			'fan-communities' => 'http://zh-tw.wikia.com/wiki/Wikia%E4%B8%AD%E6%96%87',
			'contact' => 'http://zh-tw.wikia.com/wiki/%E7%89%B9%E6%AE%8A:Contact',
			'wikia-gives-back' => 'http://www.wikia.com/wikiagivesback?uselang=zh-tw',
			'terms-of-use' => 'http://zh-tw.wikia.com/wiki/%E4%BD%BF%E7%94%A8%E6%A2%9D%E6%AC%BE',
			'community-central' => 'http://zh.community.wikia.com/wiki/Wikia_%E4%B8%AD%E6%96%88',
			'support' => 'http://zh.community.wikia.com/wiki/Special:Contact',
			'create-new-wiki' => 'http://www.wikia.com/Special:CreateNewWiki?uselang=zh-tw',
			'wam' => 'http://www.wikia.com/WAM?langCode=zh-tw',
			'help' => 'http://zh.community.wikia.com/wiki/Help:%E5%86%85%E5%AE%B9',
			'social-facebook' => 'https://www.facebook.com/ChineseWikia',
		]
	];

	private $baseData = [
		'fandom_overview' => [
			'links' => [
				[
					'type' => 'link-branded',
					'brand' => 'games',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-link-vertical-games'
					],
					'href-key' => 'vertical-games'
				],
				[
					'type' => 'link-branded',
					'brand' => 'movies',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-link-vertical-movies'
					],
					'href-key' => 'vertical-movies'
				],
				[
					'type' => 'link-branded',
					'brand' => 'tv',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-link-vertical-tv'
					],
					'href-key' => 'vertical-tv'
				],
				[
					'type' => 'link-branded',
					'brand' => 'fan-communities',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-link-fan-communities'
					],
					'href-key' => 'fan-communities'
				]
			]
		],
		'follow_us' => [
			'header' => [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-fandom-follow-us-header'
				]
			],
			'links' => [
				[
					'type' => 'link-image',
					'image' => 'wds-icons-facebook',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-follow-us-link-facebook'
					],
					'href-key' => 'social-facebook'
				],
				[
					'type' => 'link-image',
					'image' => 'wds-icons-twitter',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-follow-us-link-twitter'
					],
					'href-key' => 'social-twitter'
				],
				[
					'type' => 'link-image',
					'image' => 'wds-icons-reddit',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-follow-us-link-reddit'
					],
					'href-key' => 'social-reddit'
				],
				[
					'type' => 'link-image',
					'image' => 'wds-icons-youtube',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-follow-us-link-youtube'
					],
					'href-key' => 'social-youtube'
				],
				[
					'type' => 'link-image',
					'image' => 'wds-icons-instagram',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-follow-us-link-instagram'
					],
					'href-key' => 'social-instagram'
				]
			]
		],
		'company_overview' => [
			'header' => [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-wikia-company-overview-header'
				]
			],
			'links' => [
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-company-overview-link-about'
					],
					'href-key' => 'about'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-company-overview-link-careers'
					],
					'href-key' => 'careers'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-company-overview-link-press'
					],
					'href-key' => 'press'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-company-overview-link-contact'
					],
					'href-key' => 'contact'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-company-overview-link-wikia-gives-back'
					],
					'href-key' => 'wikia-gives-back'
				]
			]
		],
		'site_overview' => [
			'links' => [
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-site-overview-link-terms-of-use'
					],
					'href-key' => 'terms-of-use'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-site-overview-link-privacy-policy'
					],
					'href-key' => 'privacy-policy'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-site-overview-link-global-sitemap'
					],
					'href-key' => 'global-sitemap'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-site-overview-link-api'
					],
					'href-key' => 'api'
				]
			]
		],
		'community' => [
			'header' => [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-wikia-community-header'
				]
			],
			'links' => [
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-community-link-community-central'
					],
					'href-key' => 'community-central'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-community-link-support'
					],
					'href-key' => 'support'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-community-link-fan-contributor-program'
					],
					'href-key' => 'fan-contributor'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-community-link-wam-score'
					],
					'href-key' => 'wam'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-community-link-help'
					],
					'href-key' => 'help'
				]
			]
		],
		'create_wiki' => [
			'description' => [
				'type' => 'translatable-text',
				'key' => 'global-footer-wikia-create-wiki-description'
			],
			'links' => [
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-create-wiki-link-start-wikia'
					],
					'href-key' => 'create-new-wiki'
				]
			]
		],
		'community_apps' => [
			'header' => [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-wikia-community-apps-header'
				]
			],
			'description' => [
				'type' => 'translatable-text',
				'key' => 'global-footer-wikia-community-apps-description'
			],
			'links' => [
				[
					'type' => 'link-image',
					'image' => 'wds-company-store-appstore',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-community-apps-link-app-store'
					],
					'href-key' => 'app-store'
				],
				[
					'type' => 'link-image',
					'image' => 'wds-company-store-googleplay',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-community-apps-link-google-play'
					],
					'href-key' => 'google-play'
				]
			]
		],
		'advertise' => [
			'header' => [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-wikia-advertise-header'
				]
			],
			'links' => [
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-advertise-link-media-kit'
					],
					'href-key' => 'media-kit'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-advertise-link-contact'
					],
					'href-key' => 'media-kit-contact'
				]
			]
		],
	];

	private $data = [ ];

	private $wikiId;
	private $lang;

	public function __construct( $wikiId, $lang = self::DEFAULT_LANG ) {
		parent::__construct();

		$this->wikiId = $wikiId;
		$this->lang = $lang;
	}

	public function setHrefs( $hrefs ) {
		$this->hrefs = $hrefs;
	}

	public function setBaseData( $baseData ) {
		$this->baseData = $baseData;
	}

	/**
	 * Get prepared/parsed data.
	 *
	 * @return array
	 */
	public function getData() {
		$this->setHeaderData();
		$this->setSectionsData();
		$this->setLicenseData();

		return $this->data;
	}

	/**
	 * Add footer headers to $this->data property depending on the chosen language.
	 */
	private function setHeaderData() {
		if ( $this->lang === self::DEFAULT_LANG ) {
			$this->data['fandom'] = [
				'header' => [
					'type' => 'link-image',
					'image' => 'wds-company-logo-fandom',
					'href' => 'http://fandom.wikia.com',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-header'
					]
				]
			];
			$this->data['wikia'] = [
				'header' => [
					'type' => 'line-image',
					'image' => 'wds-company-logo-wikia',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-header'
					]
				]
			];
		} else {
			$this->data['international_header'] = [
				'header' => [
					'type' => 'line-image',
					'image' => 'wds-company-logo-wikia',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-header'
					],
					'subtitle' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-international-logo-home-of-fandom'
					]
				]
			];
		}
	}

	/**
	 * Add footer sections to $this->data property by reading $this->baseData property.
	 */
	private function setSectionsData() {
		foreach ( $this->baseData as $sectionName => $sectionBaseData ) {
			$this->setSectionData( $sectionName, $sectionBaseData );
		}
	}

	/**
	 * Add single footer section to $this->data property.
	 *
	 * @param string $sectionName
	 * @param array $sectionBaseData
	 */
	private function setSectionData( $sectionName, $sectionBaseData ) {
		$sectionData = $this->getSectionData( $sectionBaseData );

		if ( !empty( $sectionData ) ) {
			$this->data[$sectionName] = $sectionData;
		}
	}

	/**
	 * Get data for a single footer section.
	 * Returned data has link href keys parsed to hrefs, making it ready to be added to the response.
	 *
	 * @param array $sectionBaseData
	 *
	 * @return array
	 */
	private function getSectionData( $sectionBaseData ) {
		if ( !empty( $sectionBaseData['links'] ) ) {
			$linksData = $this->getLinksData( $sectionBaseData['links'] );

			if ( !empty( $linksData ) ) {
				$sectionBaseData['links'] = $linksData;
			} else {
				unset( $sectionBaseData['links'] );
			}
		}

		return $sectionBaseData;
	}

	/**
	 * Get list of links data entries with parsed href keys to hrefs.
	 *
	 * @param array $linksBaseList
	 *
	 * @return array
	 */
	private function getLinksData( $linksBaseList ) {
		$linksList = [ ];

		foreach ( $linksBaseList as $linkBaseData ) {
			$href = $this->getHref( $linkBaseData['href-key'] );
			unset( $linkBaseData['href-key'] );

			if ( $href ) {
				$linkBaseData['href'] = $href;
				$linksList[] = $linkBaseData;
			}
		}

		return $linksList;
	}

	/**
	 * Get the href value for a particular href key.
	 * If there's no href key defined for the selected language, fallback to a default value.
	 *
	 * @param string $hrefKey
	 *
	 * @return string|null
	 */
	private function getHref( $hrefKey ) {
		return $this->hrefs[$this->lang][$hrefKey] ?? $this->hrefs['default'][$hrefKey];
	}

	/**
	 * Add license data to $this->data property.
	 */
	private function setLicenseData() {
		$this->data['licensing_and_vertical'] = [
			'description' => [
				'type' => 'translatable-text',
				'key' => 'global-footer-licensing-description',
				'params' => [
					'license' => $this->getLicenseData(),
				]
			],
		];
	}

	/**
	 * Get detailed license data.
	 *
	 * @return array
	 */
	private function getLicenseData() {
		$licenseText = WikiFactory::getVarByName( 'wgRightsText', $this->wikiId )->cv_value ?: $this->wg->RightsText;

		return [
			'type' => 'link-text',
			'title' => [
				'type' => 'text',
				'value' => $licenseText
			],
			'href' => $this->getLicenseUrl()
		];
	}

	/**
	 * Get the URL of the license assigned to the particular wiki.
	 *
	 * @return mixed|null|string
	 */
	private function getLicenseUrl() {
		$licenseUrl = WikiFactory::getVarByName( 'wgRightsUrl', $this->wikiId )->cv_value ?: $this->wg->RightsUrl;
		$licensePage = WikiFactory::getVarByName( 'wgRightsPage', $this->wikiId )->cv_value ?: $this->wg->RightsPage;

		if ( $licensePage ) {
			$title = GlobalTitle::newFromText( $licensePage, NS_MAIN, $this->wikiId );
			$licenseUrl = $title->getFullURL();
		}

		return $licenseUrl;
	}
}
