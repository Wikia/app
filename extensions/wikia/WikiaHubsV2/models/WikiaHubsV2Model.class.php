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
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
					'anchor' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
					'anchor' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
					'anchor' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
					'anchor' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
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
							'anchor' => 'WoWwiki',
							'href' => 'http://www.wowwiki.com'
						),
						array(
							'anchor' => 'WoWwiki',
							'href' => 'http://www.wowwiki.com'
						),
						array(
							'anchor' => 'WoWwiki',
							'href' => 'http://www.wowwiki.com'
						),
					),
				),
				array(
					'headline' => 'Group2',
					'links' =>
					array(
						array(
							'anchor' => 'WoWwiki',
							'href' => 'http://www.wowwiki.com'
						),
						array(
							'anchor' => 'WoWwiki',
							'href' => 'http://www.wowwiki.com'
						),
						array(
							'anchor' => 'WoWwiki',
							'href' => 'http://www.wowwiki.com'
						),
					)
				)
			),
			'link' => array(
				'title' => 'WoWwiki',
				'href' => 'http://www.wowwiki.com'
			),
		);
	}

	public function getDataForModulePulse() {
		//mock data
		return array(
			'title' => array(
				'anchor' => 'WoWwiki',
				'href' => 'http://www.wowwiki.com'
			),
			'socialmedia' => array(
				'facebook' => 'link to facebook',
				'googleplus' => 'link to G+',
				'twitter' => 'link to twitter',
			),
			'boxes' => array(
				array(
					'headline' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'number' => 10000,
					'link' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
				),
				array(
					'headline' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'number' => 10000,
					'link' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
				),
				array(
					'headline' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'number' => 10000,
					'link' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
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
					'anchor' => 'WoWwiki',
					'href' => 'http://www.wowwiki.com'
				)
			)
		);
	}

	public function getDataForModulePopularVideos() {
		//mock data
		return array(
			'headline' => 'Popular videos',
			'sponsor' => 'FVSponsor.jpg',
			'videos' => array(
				array(
					'title' => 'WWE_13_(VG)_(2012)_-_Live_trailer',
					'headline' => 'Resident Evil 6',
					'submitter' => 'Bschwood',
					'wiki' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WWE_13_(VG)_(2012)_-_Live_trailer',
					'headline' => 'Resident Evil 6',
					'submitter' => 'Bschwood',
					'wiki' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WWE_13_(VG)_(2012)_-_Live_trailer',
					'headline' => 'Resident Evil 6',
					'submitter' => 'Bschwood',
					'wiki' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WWE_13_(VG)_(2012)_-_Live_trailer',
					'headline' => 'Resident Evil 6',
					'submitter' => 'Bschwood',
					'wiki' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WWE_13_(VG)_(2012)_-_Live_trailer',
					'headline' => 'Resident Evil 6',
					'submitter' => 'Bschwood',
					'wiki' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WWE_13_(VG)_(2012)_-_Live_trailer',
					'headline' => 'Resident Evil 6',
					'submitter' => 'Bschwood',
					'wiki' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WWE_13_(VG)_(2012)_-_Live_trailer',
					'headline' => 'Resident Evil 6',
					'submitter' => 'Bschwood',
					'wiki' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WWE_13_(VG)_(2012)_-_Live_trailer',
					'headline' => 'Resident Evil 6',
					'submitter' => 'Bschwood',
					'wiki' => 'http://www.wowwiki.com'
				),
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
					'href' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'href' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'href' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'href' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'href' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'href' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'href' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'href' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'href' => 'http://www.wowwiki.com'
				),
				array(
					'title' => 'WoWwiki',
					'href' => 'http://www.wowwiki.com'
				),
			)
		);
	}

	public function getDataForModuleTabber() {
		//mock data
		return array(
			'headline' => 'Wikia\'s Picks',
			'sponsor' => 'FVSponsor.jpg',
			'tabs' => array(
				array(
					'title' => 'Tab title',
					'image' => 'Image.jpg',
					'link' => array(
						'title' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'content' => 'Tab content'
				),
				array(
					'title' => 'Tab title',
					'image' => 'Image.jpg',
					'link' => array(
						'title' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'content' => 'Tab content'
				),
				array(
					'title' => 'Tab title',
					'image' => 'Image.jpg',
					'link' => array(
						'title' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'content' => 'Tab content'
				)
			)
		);
	}

	public function getDataForModuleWikitext() {
		//mock data
		return array(
			'headline' => 'The Big Question',
			'wikitext' => '<poll>
Should the older, original Call of Duty games be <html> <a href=http://callofduty.wikia.com/wiki/User_blog:Flamesword300/OLD_COD_GAMES-_SHOULD_THEY_BE_REMADE%3F_:YES_OR_NO>remade</a></html> with modern 3D engine tech?
Yes
No
</poll>'
		);
	}

	public function getDataForModuleFromTheCommunity() {
		//mock data
		return array(
			'headline' => 'From the Community',
			'entries' => array(
				array(
					'article' => array(
						'title' => 'Assassins Creed Film News',
						'href' => 'http://www.wowwiki.com'
					),
					'contributor' => 'Master Sima Yi',
					'image' => 'Michael-Fassbender-cast-in-Assassins-Creed-Movie.jpg',
					'content' => 'Today, several news sites have reported that actor Michael Fassbender (known for his roles in Inglourious Basterds, Shame, X-Men: First Class and Prometheus) has signed on for the planned Assassin\'s Creed film.',
					'wikilink' => array(
						'title' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
				),
				array(
					'article' => array(
						'title' => 'Assassins Creed Film News',
						'href' => 'http://www.wowwiki.com'
					),
					'contributor' => 'Master Sima Yi',
					'image' => 'Michael-Fassbender-cast-in-Assassins-Creed-Movie.jpg',
					'content' => 'Today, several news sites have reported that actor Michael Fassbender (known for his roles in Inglourious Basterds, Shame, X-Men: First Class and Prometheus) has signed on for the planned Assassin\'s Creed film.',
					'wikilink' => array(
						'title' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
				),
				array(
					'article' => array(
						'title' => 'Assassins Creed Film News',
						'href' => 'http://www.wowwiki.com'
					),
					'contributor' => 'Master Sima Yi',
					'image' => 'Michael-Fassbender-cast-in-Assassins-Creed-Movie.jpg',
					'content' => 'Today, several news sites have reported that actor Michael Fassbender (known for his roles in Inglourious Basterds, Shame, X-Men: First Class and Prometheus) has signed on for the planned Assassin\'s Creed film.',
					'wikilink' => array(
						'title' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
				),
				array(
					'article' => array(
						'title' => 'Assassins Creed Film News',
						'href' => 'http://www.wowwiki.com'
					),
					'contributor' => 'Master Sima Yi',
					'image' => 'Michael-Fassbender-cast-in-Assassins-Creed-Movie.jpg',
					'content' => 'Today, several news sites have reported that actor Michael Fassbender (known for his roles in Inglourious Basterds, Shame, X-Men: First Class and Prometheus) has signed on for the planned Assassin\'s Creed film.',
					'wikilink' => array(
						'title' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
				)
			)
		);
	}

}