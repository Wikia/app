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
	protected $date;
	protected $vertical;

	public function setLang($lang) {
		$this->lang = $lang;
	}

	public function getLang() {
		return $this->lang;
	}

	public function setDate($date) {
		$this->date = $date;
	}

	public function getDate() {
		return $this->date;
	}

	public function setVertical($vertical) {
		$this->vertical = $vertical;
	}

	public function getVertical() {
		return $this->vertical;
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
			'videos' => array( //temporary change before we finish refactoring (case43633)
				unserialize('a:17:{s:8:"external";i:0;s:2:"id";s:54:"The Twilight Saga: Eclipse (2010) - Clip: Battle recut";s:7:"fullUrl";s:106:"http://wikiaglobal.federico.wikia-dev.com/wiki/File:The_Twilight_Saga:_Eclipse_(2010)_-_Clip:_Battle_recut";s:11:"prefixedUrl";s:59:"File:The_Twilight_Saga:_Eclipse_(2010)_-_Clip:_Battle_recut";s:11:"description";s:0:"";s:8:"duration";s:2:"31";s:9:"embedCode";N;s:9:"embedJSON";N;s:8:"provider";s:10:"screenplay";s:13:"thumbnailData";a:3:{s:5:"width";d:160;s:6:"height";d:90;s:5:"thumb";s:218:"http://images.federico.wikia-dev.com/__cb20120402170240/video151/images/thumb/e/e3/The_Twilight_Saga%3A_Eclipse_%282010%29_-_Clip%3A_Battle_recut/160px-The_Twilight_Saga%3A_Eclipse_%282010%29_-_Clip%3A_Battle_recut.jpg";}s:5:"title";s:54:"The Twilight Saga: Eclipse (2010) - Clip: Battle recut";s:9:"timestamp";s:14:"20120402170238";s:8:"uniqueId";s:16:"screenplaye69245";s:5:"owner";s:0:"";s:8:"ownerUrl";s:0:"";s:5:"isNew";i:0;s:4:"date";s:14:"20120402170238";}'),
				unserialize('a:17:{s:8:"external";i:0;s:2:"id";s:54:"The Twilight Saga: Eclipse (2010) - Clip: Battle recut";s:7:"fullUrl";s:106:"http://wikiaglobal.federico.wikia-dev.com/wiki/File:The_Twilight_Saga:_Eclipse_(2010)_-_Clip:_Battle_recut";s:11:"prefixedUrl";s:59:"File:The_Twilight_Saga:_Eclipse_(2010)_-_Clip:_Battle_recut";s:11:"description";s:0:"";s:8:"duration";s:2:"31";s:9:"embedCode";N;s:9:"embedJSON";N;s:8:"provider";s:10:"screenplay";s:13:"thumbnailData";a:3:{s:5:"width";d:160;s:6:"height";d:90;s:5:"thumb";s:218:"http://images.federico.wikia-dev.com/__cb20120402170240/video151/images/thumb/e/e3/The_Twilight_Saga%3A_Eclipse_%282010%29_-_Clip%3A_Battle_recut/160px-The_Twilight_Saga%3A_Eclipse_%282010%29_-_Clip%3A_Battle_recut.jpg";}s:5:"title";s:54:"The Twilight Saga: Eclipse (2010) - Clip: Battle recut";s:9:"timestamp";s:14:"20120402170238";s:8:"uniqueId";s:16:"screenplaye69245";s:5:"owner";s:0:"";s:8:"ownerUrl";s:0:"";s:5:"isNew";i:0;s:4:"date";s:14:"20120402170238";}'),
				unserialize('a:17:{s:8:"external";i:0;s:2:"id";s:54:"The Twilight Saga: Eclipse (2010) - Clip: Battle recut";s:7:"fullUrl";s:106:"http://wikiaglobal.federico.wikia-dev.com/wiki/File:The_Twilight_Saga:_Eclipse_(2010)_-_Clip:_Battle_recut";s:11:"prefixedUrl";s:59:"File:The_Twilight_Saga:_Eclipse_(2010)_-_Clip:_Battle_recut";s:11:"description";s:0:"";s:8:"duration";s:2:"31";s:9:"embedCode";N;s:9:"embedJSON";N;s:8:"provider";s:10:"screenplay";s:13:"thumbnailData";a:3:{s:5:"width";d:160;s:6:"height";d:90;s:5:"thumb";s:218:"http://images.federico.wikia-dev.com/__cb20120402170240/video151/images/thumb/e/e3/The_Twilight_Saga%3A_Eclipse_%282010%29_-_Clip%3A_Battle_recut/160px-The_Twilight_Saga%3A_Eclipse_%282010%29_-_Clip%3A_Battle_recut.jpg";}s:5:"title";s:54:"The Twilight Saga: Eclipse (2010) - Clip: Battle recut";s:9:"timestamp";s:14:"20120402170238";s:8:"uniqueId";s:16:"screenplaye69245";s:5:"owner";s:0:"";s:8:"ownerUrl";s:0:"";s:5:"isNew";i:0;s:4:"date";s:14:"20120402170238";}'),
				unserialize('a:17:{s:8:"external";i:0;s:2:"id";s:54:"The Twilight Saga: Eclipse (2010) - Clip: Battle recut";s:7:"fullUrl";s:106:"http://wikiaglobal.federico.wikia-dev.com/wiki/File:The_Twilight_Saga:_Eclipse_(2010)_-_Clip:_Battle_recut";s:11:"prefixedUrl";s:59:"File:The_Twilight_Saga:_Eclipse_(2010)_-_Clip:_Battle_recut";s:11:"description";s:0:"";s:8:"duration";s:2:"31";s:9:"embedCode";N;s:9:"embedJSON";N;s:8:"provider";s:10:"screenplay";s:13:"thumbnailData";a:3:{s:5:"width";d:160;s:6:"height";d:90;s:5:"thumb";s:218:"http://images.federico.wikia-dev.com/__cb20120402170240/video151/images/thumb/e/e3/The_Twilight_Saga%3A_Eclipse_%282010%29_-_Clip%3A_Battle_recut/160px-The_Twilight_Saga%3A_Eclipse_%282010%29_-_Clip%3A_Battle_recut.jpg";}s:5:"title";s:54:"The Twilight Saga: Eclipse (2010) - Clip: Battle recut";s:9:"timestamp";s:14:"20120402170238";s:8:"uniqueId";s:16:"screenplaye69245";s:5:"owner";s:0:"";s:8:"ownerUrl";s:0:"";s:5:"isNew";i:0;s:4:"date";s:14:"20120402170238";}'),
				unserialize('a:17:{s:8:"external";i:0;s:2:"id";s:54:"The Twilight Saga: Eclipse (2010) - Clip: Battle recut";s:7:"fullUrl";s:106:"http://wikiaglobal.federico.wikia-dev.com/wiki/File:The_Twilight_Saga:_Eclipse_(2010)_-_Clip:_Battle_recut";s:11:"prefixedUrl";s:59:"File:The_Twilight_Saga:_Eclipse_(2010)_-_Clip:_Battle_recut";s:11:"description";s:0:"";s:8:"duration";s:2:"31";s:9:"embedCode";N;s:9:"embedJSON";N;s:8:"provider";s:10:"screenplay";s:13:"thumbnailData";a:3:{s:5:"width";d:160;s:6:"height";d:90;s:5:"thumb";s:218:"http://images.federico.wikia-dev.com/__cb20120402170240/video151/images/thumb/e/e3/The_Twilight_Saga%3A_Eclipse_%282010%29_-_Clip%3A_Battle_recut/160px-The_Twilight_Saga%3A_Eclipse_%282010%29_-_Clip%3A_Battle_recut.jpg";}s:5:"title";s:54:"The Twilight Saga: Eclipse (2010) - Clip: Battle recut";s:9:"timestamp";s:14:"20120402170238";s:8:"uniqueId";s:16:"screenplaye69245";s:5:"owner";s:0:"";s:8:"ownerUrl";s:0:"";s:5:"isNew";i:0;s:4:"date";s:14:"20120402170238";}'),
				unserialize('a:17:{s:8:"external";i:0;s:2:"id";s:54:"The Twilight Saga: Eclipse (2010) - Clip: Battle recut";s:7:"fullUrl";s:106:"http://wikiaglobal.federico.wikia-dev.com/wiki/File:The_Twilight_Saga:_Eclipse_(2010)_-_Clip:_Battle_recut";s:11:"prefixedUrl";s:59:"File:The_Twilight_Saga:_Eclipse_(2010)_-_Clip:_Battle_recut";s:11:"description";s:0:"";s:8:"duration";s:2:"31";s:9:"embedCode";N;s:9:"embedJSON";N;s:8:"provider";s:10:"screenplay";s:13:"thumbnailData";a:3:{s:5:"width";d:160;s:6:"height";d:90;s:5:"thumb";s:218:"http://images.federico.wikia-dev.com/__cb20120402170240/video151/images/thumb/e/e3/The_Twilight_Saga%3A_Eclipse_%282010%29_-_Clip%3A_Battle_recut/160px-The_Twilight_Saga%3A_Eclipse_%282010%29_-_Clip%3A_Battle_recut.jpg";}s:5:"title";s:54:"The Twilight Saga: Eclipse (2010) - Clip: Battle recut";s:9:"timestamp";s:14:"20120402170238";s:8:"uniqueId";s:16:"screenplaye69245";s:5:"owner";s:0:"";s:8:"ownerUrl";s:0:"";s:5:"isNew";i:0;s:4:"date";s:14:"20120402170238";}'),
				/*array(
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
				),*/
			)
		);
	}

	public function getDataForModuleTopWikis() {
		//mock data
		return array(
			'headline' => 'Top Gaming Wikis',
			'description' => 'Here are the top 10 Video Game wikis based on wiki activity, breadth of content and awesomeness.',
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

	public function getHubName() {
		// mock data
		return 'Video Games';
	}

}