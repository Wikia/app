<?php

class DSDataApiController extends WikiaApiController {

	private $data = [
		'fandom' => [
			'header' => [
				'type' => 'link-image',
				'image' => 'company/logo-fandom',
				'href' => 'http://fandom.wikia.com',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'fandom-header'
				]
			]
		],
		'fandom_overview' => [
			'links' => [
				[
					'type' => 'link-branded',
					'brand' => 'tv',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'fandom-link-vertical-tv'
					],
					'href' => 'http://fandom.wikia.com/tv'
				],
				[
					'type' => 'link-branded',
					'brand' => 'games',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'fandom-link-vertical-games'
					],
					'href' => 'http://fandom.wikia.com/games'
				],
				[
					'type' => 'link-branded',
					'brand' => 'movies',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'fandom-link-vertical-movies'
					],
					'href' => 'http://fandom.wikia.com/movies'
				],
				[
					'type' => 'link-branded',
					'brand' => 'fan-communities',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'fandom-link-fan-communities'
					],
					'href' => 'http://fandom.wikia.com/explore'
				],
			]
		],
		'follow_us' => [
			'header' => [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'fandom-follow-us-header'
				]
			],
			'links' => [
				[
					'type' => 'link-image',
					'image' => 'icons/facebook-default',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'fandom-follow-us-link-facebook'
					],
					'href' => 'https://www.facebook.com/getfandom'
				],
				[
					'type' => 'link-image',
					'image' => 'icons/twitter-default',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'fandom-follow-us-link-twitter'
					],
					'href' => 'https://twitter.com/getfandom'
				],
				[
					'type' => 'link-image',
					'image' => 'icons/reddit-default',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'fandom-follow-us-link-reddit'
					],
					'href' => 'https://www.reddit.com/r/wikia'
				],
				[
					'type' => 'link-image',
					'image' => 'icons/youtube-default',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'fandom-follow-us-link-youtube'
					],
					'href' => 'https://www.youtube.com/channel/UC988qTQImTjO7lUdPfYabgQ'
				],
				[
					'type' => 'link-image',
					'image' => 'icons/instagram-default',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'fandom-follow-us-link-instagram'
					],
					'href' => 'https://www.instagram.com/getfandom/'
				]
			]
		],
		'wikia' => [
			'header' => [
				'type' => 'line-image',
				'image' => 'company/logo-wikia',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'wikia-header'
				]
			]
		],
		'company_overview' => [
			'header' => [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'wikia-overview-header'
				]
			],
			'links' => [
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-company-overview-link-about'
					],
					'href' => 'http://www.wikia.com/About'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-company-overview-link-careers'
					],
					'href' => 'https://careers.wikia.com/'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-company-overview-link-press'
					],
					'href' => 'http://fandom.wikia.com/press'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-company-overview-link-contact'
					],
					'href' => 'http://fandom.wikia.com/contact'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-company-overview-link-gives-back'
					],
					'href' => 'http://www.wikia.com/wikiagivesback'
				]
			]
		],
		'site_overview' => [
			'links' => [
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-site-overview-link-terms-of-use'
					],
					'href' => 'http://www.wikia.com/Terms_of_Use'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-site-overview-link-privacy-policy'
					],
					'href' => 'http://www.wikia.com/Privacy_Policy'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-site-overview-link-global-sitemap'
					],
					'href' => 'http://www.wikia.com/Sitemap'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-site-overview-link-api'
					],
					'href' => 'http://api.wikia.com/'
				]
			]
		],
		'community' => [
			'header' => [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'wikia-community-header'
				]
			],
			'links' => [
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-community-link-community-central'
					],
					'href' => 'http://community.wikia.com/'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-community-link-support'
					],
					'href' => 'http://community.wikia.com/wiki/Special:Contact'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-community-link-fan-contributor-program'
					],
					'href' => 'http://fandom.wikia.com/fan-contributor'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-community-link-wam-score'
					],
					'href' => 'http://www.wikia.com/WAM'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-community-link-help'
					],
					'href' => 'http://community.wikia.com/wiki/Help:Contents'
				]
			]
		],
		'create_wiki' => [
			'description' => [
				'type' => 'translatable-text',
				'key' => 'wikia-create-wiki-description'
			],
			'links' => [
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-create-wiki-link-start-wikia'
					],
					'href' => 'http://www.wikia.com/Special:CreateNewWiki'
				]
			]
		],
		'community_apps' => [
			'header' => [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'wikia-community-apps-header'
				]
			],
			'description' => [
				'type' => 'translatable-text',
				'key' => 'wikia-community-apps-description'
			],
			'links' => [
				[
					'type' => 'link-image',
					'image' => 'company/store-appstore',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-community-apps-link-app-store'
					],
					'href' => 'https://itunes.apple.com/pl/developer/wikia-inc./id422467077'
				],
				[
					'type' => 'link-image',
					'image' => 'company/store-googleplay',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-community-apps-link-google-play'
					],
					'href' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.'
				]
			]
		],
		'advertise' => [
			'header' => [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'wikia-advertise-header'
				]
			],
			'links' => [
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-advertise-link-media-kit'
					],
					'href' => 'http://www.wikia.com/mediakit'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-advertise-link-contact'
					],
					'href' => 'http://www.wikia.com/mediakit#contacts'
				]
			]
		],
		'licensing_and_vertical' => [
			'description' => [
				'type' => 'translatable-text',
				'key' => 'wikia-licensing-and-vertical-description',
				'params' => [
					'vertical' => [
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'wikia-licensing-and-vertical-link-games'
						],
						'href' => 'http://fandom.wikia.com/games'
					],
					'license' => [
						'type' => 'link-text',
						'title' => [
							'type' => 'text',
							'value' => 'CC-BY-SA'
						],
						'href' => 'http://www.wikia.com/Licensing'
					]
				]
			],
		]
	];

	public function getFooter() {
		$this->setResponseData( $this->data );
	}
}
