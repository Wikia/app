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

	const HUB_CANONICAL_LANG = 'en';

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
	
	public function getTimestamp() {
		$datetime = new DateTime($this->date);

		$timestamp = $datetime->getTimestamp();
		if( $datetime->format('H') != 0 || $datetime->format('i') != 0 || $datetime->format('s') != 0) {
			$datetime->setTime(0, 0, 0);
			$timestamp = $datetime->getTimestamp();
		}
		
		return $timestamp;
	}

	public function setVertical($vertical) {
		$this->vertical = $vertical;
	}

	public function getVertical() {
		return $this->vertical;
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



	public function getVerticalName($verticalId) {
		/** @var WikiFactoryHub $wikiFactoryHub */
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$wikiaHub = $wikiFactoryHub->getCategory($verticalId);
		return $this->wf->Message('hub-' . $wikiaHub['name'])->inContentLanguage()->text();
	}

	public function getCanonicalVerticalName($verticalId) {
		/** @var WikiFactoryHub $wikiFactoryHub */
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$wikiaHub = $wikiFactoryHub->getCategory($verticalId);
		return $this->wf->Message('hub-' . $wikiaHub['name'])->inLanguage(self::HUB_CANONICAL_LANG)->text();
	}
}