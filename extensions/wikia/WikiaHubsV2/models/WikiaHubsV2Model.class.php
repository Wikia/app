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
	const GRID_0_5_MINIATURE_SIZE = 75;
	const GRID_1_MINIATURE_SIZE = 155;
	const GRID_2_MINIATURE_SIZE = 320;

	const FEATURED_VIDEO_WIDTH = 300;
	const FEATURED_VIDEO_HEIGHT = 225;

	const SPONSORED_IMAGE_WIDTH = 91;
	const SPONSORED_IMAGE_HEIGHT = 27;

	protected $lang;
	protected $date;
	protected $vertical;

	/* @var $imageThumb ThumbnailImage */
	protected $imageThumb = null;

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
					'href' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
					'href' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
					'href' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
					'href' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
					'href' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
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
		$data = array(
			'headline' => 'Explore',
			'article' => 'Article content which is very long because it is so long that it is too long',
			'image' => 'Marvel320.jpg',
			'linkgroups' =>
			array(
				array(
					'headline' => 'Group 1',
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
					'headline' => 'Group 2',
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
				),
				array(
					'headline' => 'Group 3',
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
				),
				array(
					'headline' => 'Group 4',
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
				'anchor' => 'See more...',
				'href' => 'http://www.wowwiki.com'
			),
		);

		$data['imagelink'] = $this->getMiniThumbnailUrl($data['image']);

		return $data;
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
		$results = array(
			'headline' => 'Featured video',
			'sponsor' => 'Sponsored_by_xbox.png',
			'sponsorthumb' => array(),
			'videoTitle' => 'Dishonored_(VG)_()_-_Debut_trailer',
			'description' => array(
				'maintitle' => 'Resident Evil 6',
				'subtitle' => 'More evil awaits you on the',
				'link' => array(
					'anchor' => 'WoWwiki',
					'href' => 'http://www.wowwiki.com'
				)
			)
		);

		$results['sponsorthumb']['src'] = $this->getThumbnailUrl($results['sponsor'], self::SPONSORED_IMAGE_WIDTH, self::SPONSORED_IMAGE_HEIGHT);
		$sponsorThumbSizes = $this->getImageThumbSize();
		$results['sponsorthumb']['width'] = $sponsorThumbSizes['width'];
		$results['sponsorthumb']['height'] = $sponsorThumbSizes['height'];

		return $results;
	}

	public function getDataForModulePopularVideos() {
		//mock data
		return array(
			'headline' => 'Popular videos',
			'sponsor' => 'Sponsored_by_xbox.png',
			'sponsorthumb' => $this->getStandardThumbnailUrl('Sponsored_by_xbox.png'),
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
				array(
					'anchor' => 'WoWwiki',
					'href' => 'http://www.wowwiki.com'
				),
			)
		);
	}

	public function getDataForModuleTabber() {
		//mock data
		return array(
			'headline' => 'Wikia\'s Picks',
			'sponsor' => 'Sponsored_by_xbox.png',
			'sponsorthumb' => $this->getStandardThumbnailUrl('Sponsored_by_xbox.png'),
			'tabs' => array(
				array(
					'title' => 'Tab 1 title',
					'image' => 'Wikia-Visualization-Add-5,glee.png',
					'imagethumb' => $this->getStandardThumbnailUrl('Wikia-Visualization-Add-5,glee.png'),
					'imagelink' => 'http://assassinscreed.wikia.com/wiki/User_blog:Master_Sima_Yi/Assassinews_07/09_-_Assassin%27s_Creed_film_news',
					'content' => 'Tab 1 content'
				),
				array(
					'title' => 'Tab 2 title',
					'image' => 'Wikia-Visualization-Add-5,glee.png',
					'imagethumb' => $this->getStandardThumbnailUrl('Wikia-Visualization-Add-5,glee.png'),
					'imagelink' => 'http://assassinscreed.wikia.com/wiki/User_blog:Master_Sima_Yi/Assassinews_07/09_-_Assassin%27s_Creed_film_news',
					'content' => 'Tab 2 content'
				),
				array(
					'title' => 'Tab 3 title',
					'image' => 'Wikia-Visualization-Add-5,glee.png',
					'imagethumb' => $this->getStandardThumbnailUrl('Wikia-Visualization-Add-5,glee.png'),
					'imagelink' => 'http://assassinscreed.wikia.com/wiki/User_blog:Master_Sima_Yi/Assassinews_07/09_-_Assassin%27s_Creed_film_news',
					'content' => 'Tab 3 content'
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
						'anchor' => 'Assassins Creed Film News',
						'href' => 'http://www.wowwiki.com'
					),
					'contributor' => array(
						'name' => 'Master Sima Yi',
						'href' => 'http://assassinscreed.wikia.com/wiki/User:Master_Sima_Yi'
					),
					'image' => 'Wikia-Visualization-Add-5,glee.png',
					'imagethumb' => $this->getSmallThumbnailUrl('Wikia-Visualization-Add-5,glee.png'),
					'subtitle' => 'Master Sima Yi Says:',
					'content' => 'Today, several news sites have reported that actor Michael Fassbender (known for his roles in Inglourious Basterds, Shame, X-Men: First Class and Prometheus) has signed on for the planned Assassin\'s Creed film.',
					'wikilink' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'blogurl' => 'http://assassinscreed.wikia.com/wiki/User_blog:Master_Sima_Yi/Assassinews_07/09_-_Assassin%27s_Creed_film_news',
				),
				array(
					'article' => array(
						'anchor' => 'Assassins Creed Film News',
						'href' => 'http://www.wowwiki.com'
					),
					'contributor' => array(
						'name' => 'Master Sima Yi',
						'href' => 'http://assassinscreed.wikia.com/wiki/User:Master_Sima_Yi'
					),
					'image' => 'Wikia-Visualization-Add-5,glee.png',
					'imagethumb' => $this->getSmallThumbnailUrl('Wikia-Visualization-Add-5,glee.png'),
					'subtitle' => 'Master Sima Yi Says:',
					'content' => 'Today, several news sites have reported that actor Michael Fassbender (known for his roles in Inglourious Basterds, Shame, X-Men: First Class and Prometheus) has signed on for the planned Assassin\'s Creed film.',
					'wikilink' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'blogurl' => 'http://assassinscreed.wikia.com/wiki/User_blog:Master_Sima_Yi/Assassinews_07/09_-_Assassin%27s_Creed_film_news',
				),
				array(
					'article' => array(
						'anchor' => 'Assassins Creed Film News',
						'href' => 'http://www.wowwiki.com'
					),
					'contributor' => array(
						'name' => 'Master Sima Yi',
						'href' => 'http://assassinscreed.wikia.com/wiki/User:Master_Sima_Yi'
					),
					'image' => 'Wikia-Visualization-Add-5,glee.png',
					'imagethumb' => $this->getSmallThumbnailUrl('Wikia-Visualization-Add-5,glee.png'),
					'subtitle' => 'Master Sima Yi Says:',
					'content' => 'Today, several news sites have reported that actor Michael Fassbender (known for his roles in Inglourious Basterds, Shame, X-Men: First Class and Prometheus) has signed on for the planned Assassin\'s Creed film.',
					'wikilink' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'blogurl' => 'http://assassinscreed.wikia.com/wiki/User_blog:Master_Sima_Yi/Assassinews_07/09_-_Assassin%27s_Creed_film_news',
				),
				array(
					'article' => array(
						'anchor' => 'Assassins Creed Film News',
						'href' => 'http://www.wowwiki.com'
					),
					'contributor' => array(
						'name' => 'Master Sima Yi',
						'href' => 'http://assassinscreed.wikia.com/wiki/User:Master_Sima_Yi'
					),
					'image' => 'Wikia-Visualization-Add-5,glee.png',
					'imagethumb' => $this->getSmallThumbnailUrl('Wikia-Visualization-Add-5,glee.png'),
					'subtitle' => 'Master Sima Yi Says:',
					'content' => 'Today, several news sites have reported that actor Michael Fassbender (known for his roles in Inglourious Basterds, Shame, X-Men: First Class and Prometheus) has signed on for the planned Assassin\'s Creed film.',
					'wikilink' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'blogurl' => 'http://assassinscreed.wikia.com/wiki/User_blog:Master_Sima_Yi/Assassinews_07/09_-_Assassin%27s_Creed_film_news',
				)
			)
		);
	}

	protected function getStandardThumbnailUrl($imageName) {
		return $this->getThumbnailUrl($imageName, self::GRID_2_MINIATURE_SIZE);
	}

	protected function getSmallThumbnailUrl($imageName) {
		return $this->getThumbnailUrl($imageName, self::GRID_1_MINIATURE_SIZE);
	}

	protected function getMiniThumbnailUrl($imageName) {
		return $this->getThumbnailUrl($imageName, self::GRID_0_5_MINIATURE_SIZE);
	}

	/**
	 * @param string $imageName
	 *
	 * @return bool|Title
	 */
	protected function getImageTitle($imageName) {
		$title = F::build('Title', array($imageName, NS_FILE), 'newFromText');
		if (!($title instanceof Title)) {
			return false;
		}

		return $title;
	}

	/**
	 * @param Title $imageTitle Title instance of an image
	 *
	 * @return bool|File
	 */
	protected function getImageFile(Title $imageTitle) {
		$file = F::app()->wf->FindFile($imageTitle);
		if (!($file instanceof File)) {
			return false;
		}

		return $file;
	}

	/**
	 * @desc Returns false if failed or string with thumbnail url
	 *
	 * @param String $imageName image name
	 * @param Integer $width optional parameter
	 * @param Integer $height optional parameter
	 *
	 * @return bool|string
	 */
	protected function getThumbnailUrl($imageName, $width = -1, $height = -1) {
		$result = false;
		$this->imageThumb = null;

		$title = $this->getImageTitle($imageName);
		$file = $this->getImageFile($title);

		if ($file) {
			$width = ($width === -1) ? self::GRID_2_MINIATURE_SIZE : $width;

			$thumbParams = array('width' => $width, 'height' => $height);
			$this->imageThumb = $file->transform($thumbParams);

			$result = $this->imageThumb->getUrl();
		}

		return $result;
	}

	/**
	 * @return array
	 */
	protected function getImageThumbSize() {
		$result = array();

		if (!is_null($this->imageThumb)) {
			$result = array(
				'width' => $this->imageThumb->getWidth(),
				'height' => $this->imageThumb->getHeight(),
			);
		}

		return $result;
	}

    public function generateImageXml($image) {
		return Xml::element('img', array(
			'src' => $image['src'],
			'width' => $image['width'],
			'height' => $image['height'],
		), '', true);
	}

	public function parseVideoData($videoData) {
		/** @var Title $videoTitle */
		$videoTitle = F::build('Title', array($videoData['videoTitle'], NS_FILE), 'newFromText');
		/** @var File $videoFile */
		$videoFile = ($videoTitle) ? wfFindFile($videoTitle) : false;
		if ($videoFile) {
			/** @var MediaTransformOutput $videoThumbObj */
			$videoThumbObj = $videoFile->transform(array('width' => self::FEATURED_VIDEO_WIDTH, 'height' => self::FEATURED_VIDEO_HEIGHT));
			$video = array(
				'title' => $videoData['videoTitle'],
				'href' => $videoTitle->getFullUrl(),
				'thumbSrc' => $videoThumbObj->getUrl()
			);
		} else {
			$video = false;
		}
		return $video;
	}

	public function getVideoElementData($video) {
		$videoTitle = ($video) ? F::build('Title', array($video['title'], NS_FILE), 'newFromText') : false;
		$videoFile = ($videoTitle) ? wfFindFile($videoTitle) : false;

		if ($videoFile) {
			$thumbWidth = $video['thumbnailData']['width'];
			$thumbHeight = $video['thumbnailData']['height'];
			$videoThumbObj = $videoFile->transform(array('width' => $thumbWidth, 'height' => $thumbHeight));
			return $this->extractDataForCaruselTemplate($video, $videoThumbObj);
		} else {
			Wikia::log(__METHOD__, false, 'A video file not found. ID: ' . $video['title']);
			return false;
		}
	}

	/**
	 * @param Array $videoArr
	 * @param MediaTransformOutput $videoThumbObj
	 *
	 * @return stdClass
	 */
	protected function extractDataForCaruselTemplate($videoArr, $videoThumbObj) {
		/** @var File $videoFile */
		$videoFile = $videoThumbObj->getFile();
		/** @var Title $videoTitle */
		$videoTitle = $videoFile->getTitle();
		$wikiUrl = WikiFactory::getVarValueByName('wgServer', $videoArr['wikiId']);

		$videoItem = new stdClass();
		$videoItem->duration = $videoFile->getHandler()->getFormattedDuration();
		$videoItem->data = array(
			'wiki' => $wikiUrl,
			'video-name' => $videoArr['title'],
			'ref' => $videoTitle->getNsText() . ':' . $videoTitle->getDBkey(),
		);
		$videoItem->href = $videoTitle->getFullUrl();
		$videoItem->imgUrl = $videoThumbObj->getUrl();
		$videoItem->description = $videoArr['headline'];

		if (empty($videoArr['profile'])) {
			$videoItem->info = wfMsgExt('wikiahubs-popular-videos-suggested-by', array('parseinline'), array($videoArr['submitter']));
		} else {
			$videoItem->info = wfMsgExt('wikiahubs-popular-videos-suggested-by-profile', array('parseinline'), array($videoArr['submitter'], $videoArr['profile']));
		}

		return $videoItem;
	}

	public function generateTabberWikiText($tabData) {
		$tabberSource = '{{#tag:tabber|';
		foreach ($tabData['tabs'] as $tab) {
			$tabberSource .= $tab['title'] . '=
					[[File:' . $tab['image'] . '|200px|right|link=' . $tab['imagelink'] . ']]
					' . $tab['content'] . '
				{{!}}-{{!}}';
		}
		$tabberSource .= '}}';
		return $tabberSource;
	}

	public function generateSliderWikiText($sliderImages) {
		$galleryText = '<gallery type="slider" orientation="mosaic">';
		foreach($sliderImages as $image) {
			$galleryText .= "\n" . implode('|',array(
					$image['image'],
					$image['headline'],
					'link=' . $image['href'],
					'linktext=' . $image['description'],
					'shorttext=' . $image['title']
				)
			);
		}
		$galleryText .= "\n</gallery>";
		return $galleryText;
	}

	public function getVerticalName($verticalId) {
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		/** @var WikiFactoryHub $wikiFactoryHub */
		$wikiaHub = $wikiFactoryHub->getCategory($verticalId);
		return wfMsgForContent('hub-' . $wikiaHub['name']);
	}
}