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
	const MINIATURE_SIZE = 300;

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
		$data = array(
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

		foreach ($data['images'] as &$image) {
			$image['imagethumb'] = $this->getStandardThumbnailUrl($image['image']);
		}
		return $data;
	}

	public function getDataForModuleExplore() {
		// mock data
		return array(
			'headline' => 'Explore',
			'article' => 'Article content',
			'image' => 'Marvel320.jpg',
			'imagethumb' => $this->getStandardThumbnailUrl('Marvel320.jpg'),
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
					'unit' => 'editors',
					'link' => array(
						'anchor' => 'see more',
						'href' => 'http://www.wowwiki.com'
					),
				),
				array(
					'headline' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'number' => 10000,
					'unit' => 'pages',
					'link' => array(
						'anchor' => 'see more',
						'href' => 'http://www.wowwiki.com'
					),
				),
				array(
					'headline' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'number' => 10000,
					'unit' => 'videos',
					'link' => array(
						'anchor' => 'see more',
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
			'sponsorthumb' => $this->getStandardThumbnailUrl('FVSponsor.jpg'),
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
			'sponsorthumb' => $this->getStandardThumbnailUrl('FVSponsor.jpg'),
			'videos' => array(
				array(
					'title' => 'The Twilight Saga: Eclipse (2010) - Clip: Battle recut',
					'thumbnailData' => array(
						'width' => 160,
						'height' => 90,
					),
					'headline' => 'The Twilight Saga',
					'submitter' => 'Bschwood',
					'profile' => 'http://community.wikia.com/wiki/User:Bchwood',
					'wikiId' => 5687,
				),
				array(
					'title' => 'The Twilight Saga: Eclipse (2010) - Clip: Battle recut',
					'thumbnailData' => array(
						'width' => 160,
						'height' => 90,
					),
					'headline' => 'The Twilight Saga',
					'submitter' => 'Andrzej Łukaszewski',
					'profile' => 'http://poznan.wikia.com/wiki/U%C5%BCytkownik:Andrzej_%C5%81ukaszewski',
					'wikiId' => 5687,
				),
				array(
					'title' => 'The Twilight Saga: Eclipse (2010) - Clip: Battle recut',
					'thumbnailData' => array(
						'width' => 160,
						'height' => 90,
					),
					'headline' => 'The Twilight Saga',
					'submitter' => 'Bschwood',
					'profile' => '',
					'wikiId' => 5687,
				),
				array(
					'title' => 'The Twilight Saga: Eclipse (2010) - Clip: Battle recut',
					'thumbnailData' => array(
						'width' => 160,
						'height' => 90,
					),
					'headline' => 'The Twilight Saga',
					'submitter' => 'Bschwood',
					'profile' => 'http://community.wikia.com/wiki/User:Bchwood',
					'wikiId' => 5687,
				),
				array(
					'title' => 'The Twilight Saga: Eclipse (2010) - Clip: Battle recut',
					'thumbnailData' => array(
						'width' => 160,
						'height' => 90,
					),
					'headline' => 'The Twilight Saga',
					'submitter' => 'Bschwood',
					'profile' => 'http://community.wikia.com/wiki/User:Bchwood',
					'wikiId' => 5687,
				),
				array(
					'title' => 'The Twilight Saga: Eclipse (2010) - Clip: Battle recut',
					'thumbnailData' => array(
						'width' => 160,
						'height' => 90,
					),
					'headline' => 'The Twilight Saga',
					'submitter' => 'Bschwood',
					'profile' => 'http://community.wikia.com/wiki/User:Bchwood',
					'wikiId' => 5687,
				),
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
			'sponsorthumb' => $this->getStandardThumbnailUrl('FVSponsor.jpg'),
			'tabs' => array(
				array(
					'title' => 'Tab title',
					'image' => 'Image.jpg',
					'imagethumb' => $this->getStandardThumbnailUrl('Image.jpg'),
					'link' => array(
						'title' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'content' => 'Tab content'
				),
				array(
					'title' => 'Tab title',
					'image' => 'Image.jpg',
					'imagethumb' => $this->getStandardThumbnailUrl('Image.jpg'),
					'link' => array(
						'title' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'content' => 'Tab content'
				),
				array(
					'title' => 'Tab title',
					'image' => 'Image.jpg',
					'imagethumb' => $this->getStandardThumbnailUrl('Image.jpg'),
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
					'contributor' => array(
						'name' => 'Master Sima Yi',
						'href' => 'http://assassinscreed.wikia.com/wiki/User:Master_Sima_Yi'
					),
					'image' => 'Wikia-Visualization-Add-5,glee.png',
					'imagethumb' => $this->getStandardThumbnailUrl('Wikia-Visualization-Add-5,glee.png'),
					'subtitle' => 'Master Sima Yi Says:',
					'content' => 'Today, several news sites have reported that actor Michael Fassbender (known for his roles in Inglourious Basterds, Shame, X-Men: First Class and Prometheus) has signed on for the planned Assassin\'s Creed film.',
					'wikilink' => array(
						'title' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'blogurl' => 'http://assassinscreed.wikia.com/wiki/User_blog:Master_Sima_Yi/Assassinews_07/09_-_Assassin%27s_Creed_film_news',
				),
				array(
					'article' => array(
						'title' => 'Assassins Creed Film News',
						'href' => 'http://www.wowwiki.com'
					),
					'contributor' => array(
						'name' => 'Master Sima Yi',
						'href' => 'http://assassinscreed.wikia.com/wiki/User:Master_Sima_Yi'
					),
					'image' => 'Wikia-Visualization-Add-5,glee.png',
					'imagethumb' => $this->getStandardThumbnailUrl('Wikia-Visualization-Add-5,glee.png'),
					'subtitle' => 'Master Sima Yi Says:',
					'content' => 'Today, several news sites have reported that actor Michael Fassbender (known for his roles in Inglourious Basterds, Shame, X-Men: First Class and Prometheus) has signed on for the planned Assassin\'s Creed film.',
					'wikilink' => array(
						'title' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'blogurl' => 'http://assassinscreed.wikia.com/wiki/User_blog:Master_Sima_Yi/Assassinews_07/09_-_Assassin%27s_Creed_film_news',
				),
				array(
					'article' => array(
						'title' => 'Assassins Creed Film News',
						'href' => 'http://www.wowwiki.com'
					),
					'contributor' => array(
						'name' => 'Master Sima Yi',
						'href' => 'http://assassinscreed.wikia.com/wiki/User:Master_Sima_Yi'
					),
					'image' => 'Wikia-Visualization-Add-5,glee.png',
					'imagethumb' => $this->getStandardThumbnailUrl('Wikia-Visualization-Add-5,glee.png'),
					'subtitle' => 'Master Sima Yi Says:',
					'content' => 'Today, several news sites have reported that actor Michael Fassbender (known for his roles in Inglourious Basterds, Shame, X-Men: First Class and Prometheus) has signed on for the planned Assassin\'s Creed film.',
					'wikilink' => array(
						'title' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'blogurl' => 'http://assassinscreed.wikia.com/wiki/User_blog:Master_Sima_Yi/Assassinews_07/09_-_Assassin%27s_Creed_film_news',
				),
				array(
					'article' => array(
						'title' => 'Assassins Creed Film News',
						'href' => 'http://www.wowwiki.com'
					),
					'contributor' => array(
						'name' => 'Master Sima Yi',
						'href' => 'http://assassinscreed.wikia.com/wiki/User:Master_Sima_Yi'
					),
					'image' => 'Wikia-Visualization-Add-5,glee.png',
					'imagethumb' => $this->getStandardThumbnailUrl('Wikia-Visualization-Add-5,glee.png'),
					'subtitle' => 'Master Sima Yi Says:',
					'content' => 'Today, several news sites have reported that actor Michael Fassbender (known for his roles in Inglourious Basterds, Shame, X-Men: First Class and Prometheus) has signed on for the planned Assassin\'s Creed film.',
					'wikilink' => array(
						'title' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'blogurl' => 'http://assassinscreed.wikia.com/wiki/User_blog:Master_Sima_Yi/Assassinews_07/09_-_Assassin%27s_Creed_film_news',
				)
			)
		);
	}

	public function getHubName($name) {
		if (empty($name)) {
			// mock data
			return 'Video Games';
		} else {
			return $name;
		}
	}

	protected function getStandardThumbnailUrl($imageName) {
		$title = F::build('Title', array($imageName, NS_FILE), 'newFromText');
		if (!($title instanceof Title)) {
			return false;
		}

		$file = F::app()->wf->FindFile($title);
		if (!($file instanceof File)) {
			return false;
		}

		$thumbParams = array('width' => self::MINIATURE_SIZE);
		/* @var $thumb ThumbnailImage */
		$thumb = $file->transform($thumbParams);
		return $thumb->getUrl();
	}

}