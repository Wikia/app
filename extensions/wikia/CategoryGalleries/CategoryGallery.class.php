<?php

	/**
	 * Main Category Gallery class
	 */
	class CategoryGallery {

		const CACHE_TTL = 21600;

		const DEFAULT_WIDTH = 130;
		const DEFAULT_HEIGHT = 115;

		/**
		 * Maximum number of articles shown in the gallery
		 * Overriden by: $wgCategoryGalleryImagesCount
		 * @var int
		 */
		protected $confMaxArticles = 8;

		/**
		 * The predefined width
		 * Overriden by: $wgCategoryGalleryImageWidth
		 * @var int
		 */
		protected $confThumbWidth = self::DEFAULT_WIDTH;

		/**
		 * The predefined height
		 * Overriden by: $wgCategoryGalleryImageHeight
		 * @var int
		 */
		protected $confThumbHeight = self::DEFAULT_HEIGHT;

		/**
		 * The predefined thumbnail width to height ratio (in the format for ImageServing)
		 * @var array
		 */
		protected $confThumbProportion = array(
			'w' => self::DEFAULT_WIDTH,
			'h' => self::DEFAULT_HEIGHT,
		);

		/**
		 * Should category Gallery be injected in every category by default?
		 * Overriden by: $wgCategoryGalleryEnabledByDefault
		 * @var bool
		 */
		protected $confEnabledByDefault = true;

		/**
		 * Current config hash (used for memcached key)
		 * @var string
		 */
		protected $configHash = null;

		/**
		 * The CategoryPage object, which the gallery should be prepared for
		 * @var CategoryPage
		 */
		protected $categoryPage = null;

		/**
		 * Is gallery enabled for this specific gallery?
		 * @var bool
		 */
		protected $galleryActive = null;

		/**
		 * Holds the data in the array entries:
		 * 	array(
		 * 		'text' => target article title
		 * 		'article_url' => target article url
		 * 		'image_url' => image thumbnail url
		 *  )
		 * False if data has not been prepared yet.
		 *
		 * @var array
		 */
		protected $data = false;

		/**
		 * Creates new CategoryGallery object
		 * @param $categoryPage CategoryPage The category page object
		 */
		public function __construct( CategoryPage $categoryPage ) {
			$this->categoryPage = $categoryPage;

			global $wgCategoryGalleryEnabledByDefault, $wgCategoryGalleryImageWidth, $wgCategoryGalleryImagesCount;
			if (!is_null($wgCategoryGalleryEnabledByDefault)) { // allow false values to be catched
				$this->confEnabledByDefault = (bool)$wgCategoryGalleryEnabledByDefault;
			}
			if (!empty($wgCategoryGalleryImageWidth)) {
				$this->confThumbWidth = intval($wgCategoryGalleryImageWidth);
			}
			if (!empty($wgCategoryGalleryImageHeight)) {
				$this->confThumbHeight = intval($wgCategoryGalleryImageHeight);
			}
			$this->confThumbProportion = array(
				'w' => $this->confThumbWidth,
				'h' => $this->confThumbHeight,
			);
			if (!empty($wgCategoryGalleryImagesCount)) {
				$this->confMaxArticles = intval($wgCategoryGalleryImagesCount);
			}
			$this->configHash = md5(serialize(array(
				$this->confMaxArticles,$this->confThumbWidth,$this->confThumbHeight
			)));
		}

		/**
		 * Checks all the conditions and returns if the gallery should be embedded in current category
		 * @return bool
		 */
		public function isActive() {
			if ($this->galleryActive === null) {
				$rawText = $this->categoryPage->getRawText();
				$mw = MagicWord::get(CATGALLERY_DISABLED);
				$disabled = (0 < $mw->match($rawText));
				$mw = MagicWord::get(CATGALLERY_ENABLED);
				$enabled = !$disabled && (0 < $mw->match($rawText));

				$this->galleryActive = !$disabled && ($enabled || $this->confEnabledByDefault);
			}

			return $this->galleryActive;
		}

		/**
		 * Builds and returns the memcached key
		 */
		protected function getMemcKey() {
			return wfMemcKey('category-gallery',$this->categoryPage->mTitle->getDBkey(),$this->configHash);
		}

		/**
		 * Returns list of top articles (most viewed) in the category
		 * @return array
		 */
		protected function getArticles() {
			$service = new CategoryService($this->categoryPage->mTitle->getDBkey());
			return $service->getTopArticles($this->confMaxArticles);
		}

		/**
		 * Proxy function for fetching thumbnails from ImageServing.
		 *
		 * @param $articles array List of article ids
		 * @return array
		 */
		protected function findImages( $articles ) {
			$articleIds = array_keys($articles);

			$imageServing = new imageServing( $articleIds, $this->confThumbWidth, $this->confThumbProportion );

			return $imageServing->getImages(1);
		}

		/**
		 * Fetches short textual snippet for given article
		 * @param $articleId int Article id
		 * @param $length int Desired snippet length
		 * @return string
		 */
		protected function getArticleSnippet( $articleId, $length = 150 ) {
			global $wgTitle, $wgParser;

			$article = Article::newFromID( $articleId );

			if (empty($article)) {
				return '';
			}

			$content = $article->getContent();

			// Perl magic will happen! Beware! Perl 5.10 required!
			$re_magic = '#SSX(?<R>([^SE]++|S(?!S)|E(?!E)|SS(?&R))*EE)#i';

			// remove {{..}} tags
			$re = strtr( $re_magic, array( 'S' => "\\{", 'E' => "\\}", 'X' => '' ));
			$content = preg_replace($re, '', $content);

			// remove [[Image:...]] and [[File:...]] tags
			$re = strtr( $re_magic, array( 'S' => "\\[", 'E' => "\\]", 'X' => "(Image|File):" ));
			$content = preg_replace($re, '', $content);

			// skip "edit" sections
			$content .= "\n__NOEDITSECTION__ __NOTOC__";

			$tmpParser = new Parser();
			$content = $tmpParser->parse( $content, $wgTitle, new ParserOptions )->getText();

			// remove <script> tags (RT #46350)
			$content = preg_replace('#<script[^>]+>(.*)<\/script>#', '', $content);

			// experimental: remove <th> tags with content
			$content = preg_replace('#<th[^>]*>(.*?)<\/th>#s', '', $content);

			// experimental: remove <hX> tags with content
			$content = preg_replace('#<h(?<D>\d)[^>]*>(.*?)<\/h\g{D}>#s', '', $content);

			// remove HTML tags
			$content = trim(strip_tags($content));

			// compress white characters
			$content = mb_substr($content, 0, $length + 200);
			$content = strtr($content, array('&nbsp;' => ' ', '&amp;' => '&'));
			$content = preg_replace('/\s+/',' ',$content);

			// store first 150 characters of parsed content
			$content = mb_substr($content, 0, $length);

			return $content;
		}

		/**
		 * Merges the information about top articles, the thumbnails and prepares the final data.
		 * Optionally fetches the article snippets if no thumbnail if available.
		 *
		 * @param $articles array Array returned by getArticles()
		 * @param $images array Array returned by findImages()
		 * @return array
		 */
		protected function merge( $articles, $images ) {
			global $wgDevelEnvironment;
			$data = array();
			$n = 0;
			foreach ($articles as $id => $title) {
				$n++;
				$entry = array(
					'title' => $title->getText(),
					'article_url' => $title->getLocalURL(),
				);
				if (!empty($images[$id])) {
					$image = reset($images[$id]);
					if (!empty($wgDevelEnvironment)) {
						$image['url'] = str_replace('http://images.wladek.wikia-dev.com/', 'http://images.wikia.com/', $image['url']);
					}
					$entry['image_url'] = $image['url'];
				} else {
//					$entry['title'] .= ' asdaasd asdasdasd as dasdasd asdas dadas dad asdad';
					$entry['snippet'] = $this->getArticleSnippet($id,100);
				}
				$data[$id] = $entry;
			}
			return $data;
		}

		/**
		 * High-level function to fetch the data for current category.
		 * Uses memcached to speed up the process
		 * @return array
		 */
		protected function getData() {
			global $wgMemc;

			$cacheKey = $this->getMemcKey();
			$this->data = $wgMemc->get($cacheKey);
			if (!is_array($this->data)) {
				$articles = $this->getArticles();
				$images = $this->findImages($articles);
				$this->data = $this->merge($articles,$images);
				$wgMemc->set($cacheKey,$this->data,self::CACHE_TTL);
			}
			return $this->data;
		}

		/**
		 * Returns the HTML representation of category gallery
		 * @return string
		 */
		public function render() {
			$r = '';
			if ($this->isActive()) {
				$data = $this->getData();

				if ($data) {
					$template = new EasyTemplate(dirname(__FILE__).'/templates');
					$template->set_vars(array(
						'data' => $data,
					));
					$r .= $template->render('gallery');
				}
			}

			return $r;
		}

		/**
		 * Invalidates the cache for the current category and configuration
		 */
		public function invalidate() {
			global $wgMemc;

			$cacheKey = $this->getMemcKey();
			$wgMemc->delete($cacheKey);
		}

	}
