<?php

/**
 * Hubs V2 Model
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

class WikiaHubsV2Model extends WikiaModel {
	protected $lang;

	public function setLang($lang) {
		$this->lang = $lang;
	}

	public function getLang() {
		return $this->lang;
	}

	public function getDataForModuleSlider() {
		return array(
			'images' => array(
				array(
					'image' => 'VG_Olympics_slider.jpg',
					'anchor' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'VG_Olympics_slider.jpg',
					'anchor' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'VG_Olympics_slider.jpg',
					'anchor' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'VG_Olympics_slider.jpg',
					'anchor' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'VG_Olympics_slider.jpg',
					'anchor' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
			)
		);
	}

	public function getDataForModuleExplore() {
		// mock data
		return array(
			'headline' => 'Explore',
			'article' => 'Article content',
			'image' => 'Marvel320.jpg',
			'linkgroups' =>
			array(
				array(
					'headline' => 'Group1',
					'links' =>
					array(
						array(
							'anchor' => 'http://www.wikia.com',
							'title' => 'Wikia'
						),
						array(
							'anchor' => 'http://www.wikia.com',
							'title' => 'Wikia'
						),
						array(
							'anchor' => 'http://www.wikia.com',
							'title' => 'Wikia'
						),
					),
				),
				array(
					'headline' => 'Group2',
					'links' =>
					array(
						array(
							'anchor' => 'http://www.wikia.com',
							'title' => 'Wikia'
						),
						array(
							'anchor' => 'http://www.wikia.com',
							'title' => 'Wikia'
						),
						array(
							'anchor' => 'http://www.wikia.com',
							'title' => 'Wikia'
						),
					)
				)
			),
			'link' => array(
				'title' => 'WoWwiki',
				'anchor' => 'http://www.wowwiki.com'
			),
		);
	}

	public function getDataForModulePulse() {
		//mock data
		return array(
			'title' => array(
				'title' => 'WoWwiki',
				'anchor' => 'http://www.wowwiki.com'
			),
			'socialmedia' => array(
				'facebook' => 'link to facebook',
				'googleplus' => 'link to G+',
				'twitter' => 'link to twitter',
			),
			'boxes' => array(
				array(
					'headline' => array(
						'title' => 'WoWwiki',
						'anchor' => 'http://www.wowwiki.com'
					),
					'number' => 10000,
					'link' => array(
						'title' => 'WoWwiki',
						'anchor' => 'http://www.wowwiki.com'
					),
				),
				array(
					'headline' => array(
						'title' => 'WoWwiki',
						'anchor' => 'http://www.wowwiki.com'
					),
					'number' => 10000,
					'link' => array(
						'title' => 'WoWwiki',
						'anchor' => 'http://www.wowwiki.com'
					),
				),
				array(
					'headline' => array(
						'title' => 'WoWwiki',
						'anchor' => 'http://www.wowwiki.com'
					),
					'number' => 10000,
					'link' => array(
						'title' => 'WoWwiki',
						'anchor' => 'http://www.wowwiki.com'
					),
				)
			)
		);
	}

	public function getDataForModuleFeaturedVideo() {
		//mock data
		return array(
			'headline' => 'Featured video',
			'sponsor' => 'FVSponsor.jpg',
			'video' => array(
				'title' => 'WWE_13_(VG)_(2012)_-_Live_trailer'
			),
			'description' => array(
				'main title' => 'Resident Evil 6',
				'subtitle' => 'More evil awaits you on the',
				'link' => array(
					'title' => 'WoWwiki',
					'anchor' => 'http://www.wowwiki.com'
				)
			)
		);
	}

	public function getDataForModuleTopWikis() {
		//mock data
		return array(
			'headline' => 'Top Gaming Wikis',
			'wikis' => array(
				array(
					'title' => 'WoWwiki',
					'anchor' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'anchor' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'anchor' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'anchor' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'anchor' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'anchor' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'anchor' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'anchor' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'anchor' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'anchor' => 'http://www.wowwiki.com'
				),
			)
		);
	}
}