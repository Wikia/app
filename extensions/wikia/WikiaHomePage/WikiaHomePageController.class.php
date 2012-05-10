<?php

/**
 * WikiaHomePage Controller
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Hyun Lim
 * @author Marcin Maciejewski
 * @author Saipetch Kongkatong
 * @author Sebastian Marzjan
 *
 */
class WikiaHomePageController extends WikiaController {
	static $mwMsgWikiList = 'VisualizationWikisList';
	static $verticalIndicator = '*';
	static $wikiIndicator = '**';
	static $dataSeparator = '|';
	/**
	 * How many wiki data we want for SEO?
	 * @var int
	 */
	static $seoSamplesNo = 17;
	static $seoMemcKeyVer = '1.2';
	
	//images sizes
	static $remixImgSmallWidth = 155;
	static $remixImgSmallHeight = 100;
	static $remixImgMediumWidth = 320;
	static $remixImgMediumHeight = 210;
	static $remixImgBigWidth = 320;
	static $remixImgBigHeight = 320;
	const hubsImgWidth = 320;
	const hubsImgHeight = 160;

	//failsafe
        const FAILSAFE_ARTICLE_TITLE = 'Failsafe';
	
	protected $source = null;
	protected $verticalsPercentage = array();
	protected $verticalsWikis = array();
	protected $currentPercentage = 0;
	
	private $imageSmallServing = null;
	private $imageMediumServing = null;
	
	// list of hubs
	protected static $wikiaHubs = array(
		'Entertainment',
		'Video_Games',
		'Lifestyle',
	);

	public function __construct() {
		parent::__construct();
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaHomePage/css/WikiaHomePage.scss'));
	}
	
	public function index() {
		//cache response on varnish for 1h to enable rolling of stats
		$this->response->setCacheValidity(3600, 3600, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));

		$this->response->addAsset('extensions/wikia/WikiaHomePage/js/WikiaHomePage.js');
		$this->response->addAsset('skins/oasis/css/wikiagrid.scss');

		$response = $this->app->sendRequest( 'WikiaHomePageController', 'getHubImages' );
		$this->hubImages = $response->getVal( 'hubImages' , '' );
	}
	
	public function wikiaMobileIndex() {
		//$this->response->addAsset('extensions/wikia/WikiaHomePage/css/WikiaHomePageMobile.scss');
		$response = $this->app->sendRequest( 'WikiaHomePageController', 'getHubImages' );
		$this->hubImages = $response->getVal( 'hubImages' , '' );
	}

	public function footer() {
	}
	
	/**
	 * get stats
	 * @responseParam integer visitors
	 * @responseParam integer edits
	 * @responseParam integer communities
	 * @responseParam integer totalPages
	 */
	public function getStats() {
		$this->wf->ProfileIn( __METHOD__ );

		$memKey = $this->wf->SharedMemcKey( 'wikiahomepage', 'stats' );
		$stats = $this->wg->Memc->get( $memKey );
		if ( empty($stats) ) {
			$stats['visitors'] =  $this->getStatsFromArticle( 'StatsVisitors' );

			$stats['edits'] = $this->getEdits();
			if ( empty($stats['edits']) ) {
				$stats['editsDefault'] = $this->getStatsFromArticle( 'StatsEdits' );
			}

			$stats['communities'] = $this->getStatsFromArticle( 'StatsCommunities' );

			$defaultTotalPages = $this->getStatsFromArticle( 'StatsTotalPages' );
			$totalPages = intval( Wikia::get_content_pages() );
			$stats['totalPages'] = ( $totalPages > $defaultTotalPages ) ? $totalPages : $defaultTotalPages ;
			
			$this->wg->Memc->set( $memKey, $stats, 60*60*1 );
		}

		foreach( $stats as $key => $value ) {
			$this->$key = $this->wg->Lang->formatNum( $value );
		}

		$this->communities = $this->communities.'+';
		if ( empty($stats['edits']) && in_array('editsDefault', $stats) ) {
			$this->edits = $this->editsDefault.'+';
		}

		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * get unique visitors last 30 days (exclude today)
	 * @return integer edits 
	 */
	protected function getVisitors() {
		$this->wf->ProfileIn( __METHOD__ );

		$visitors = 0;
		if ( !empty( $this->wg->StatsDBEnabled ) ) {
			$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->StatsDB);

			// for testing
			if ( $this->wg->DevelEnvironment ) {
				$row = $db->selectRow( 
					array( 'page_views' ), 
					array( 'sum(pv_views) cnt' ),
					array( "pv_use_date between date_format(curdate() - interval 30 day,'%Y%m%d') and date_format(curdate(),'%Y%m%d')" ),
					__METHOD__
				);
			} else {
				$row = $db->selectRow( 
					array( 'google_analytics.pageviews' ), 
					array( 'sum(pageviews) cnt' ),
					array( "date between curdate() - interval 30 day and curdate()" ),
					__METHOD__
				);
			}

			if ( $row ) {
				$visitors = intval( $row->cnt );
			}
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $visitors;
	}

	/**
	 * get number of edits made the day before yesterday
	 * @return integer edits 
	 */
	protected function getEdits() {
		$this->wf->ProfileIn( __METHOD__ );

		$edits = 0;
		if ( !empty( $this->wg->StatsDBEnabled ) ) {
			$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->StatsDB);

			$row = $db->selectRow( 
				array( 'events' ), 
				array( 'count(*) cnt' ),
				array( 'event_date between curdate() - interval 2 day and curdate() - interval 1 day' ),
				__METHOD__
			);

			if ( $row ) {
				$edits = intval( $row->cnt );
			}
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $edits;
	}
	
	/**
	 * get stats from article
	 * @param string articleName
	 * @return integer stats
	 */
	protected function getStatsFromArticle( $articleName ) {
		$this->wf->ProfileIn( __METHOD__ );

		$title = Title::newFromText( $articleName );
		$article = new Article( $title );
		$content = $article->getRawText();
		$stats = ( empty($content) ) ? 0 : $content ;

		$this->wf->ProfileOut( __METHOD__ );

		return intval($stats);
	}

	/**
	 * get list of wikis
	 */
	public function getList() {
		$this->source = $this->getMediaWikiMessage();
		$this->imageSmallServing = F::build('ImageServing', array(null, self::$remixImgSmallWidth, self::$remixImgSmallHeight));
		$this->imageMediumServing = F::build('ImageServing', array(null, self::$remixImgMediumWidth, self::$remixImgMediumHeight));
		
		try {
			$status = true;
			$this->response->setVal(
				'data',
				json_encode($this->parseSourceMessage())
			);
		} catch(Exception $e) {
			$status = false;
			$this->response->setVal('exception', $e->getMessage());
		}
		$this->response->setVal('failoverData',$this->getFailoverWikiList());
		$this->response->setVal('status', intval($status));
	}
	
	public function getMediaWikiMessage() {
		return wfMsgForContent(self::$mwMsgWikiList);
	}
	
	/**
	 * @desc Gets a random list of wiki name and url for SEO (if the data is small for a vertical the amount of returned wikis here can be lower than self::$seoSamplesNo)
	 * @return array
	 */
	public function getSeoList() {
		$list = $this->app->wg->Memc->get('wikia-home-page-seo-samples'.self::$seoMemcKeyVer);
		if( empty($list) && !empty($this->verticalsWikis) ) {
			$list = array();
			$verticals = array_keys($this->verticalsWikis);
			foreach($verticals as $verticalName) {
				$wikisInVertical = $this->verticalsWikis[$verticalName];
				$wikiNoPerVertical = ceil($this->verticalsPercentage[$verticalName]/100 * self::$seoSamplesNo);
				for($wikiNoPerVertical; $wikiNoPerVertical > 0; $wikiNoPerVertical--) {
					shuffle($wikisInVertical);
					$wiki = array_shift($wikisInVertical);
					if( !is_null($wiki) ) {
						$list[] = array(
							'title' => $wiki['wikiname'],
							'url' => $wiki['wikiurl'],
						);
					} else {
						$list[] = array(
								'title' => $wiki['wikiname'],
								'url' => '#',
						);
					}
				}
			}
			
			$this->app->wg->Memc->set('wikia-home-page-seo-samples'.self::$seoMemcKeyVer, $list, 48 * 60 * 60);
		}
		
		return $list;
	}
	
	/**
	 * @desc Explodes source per line and delegate parsing verticals/wikis data, validates and at the end returns final array
	 * 
	 * @throws Exception
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function parseSourceMessage() {
		if( !empty($this->source) ) {
			$lines = explode("\n", $this->source);
			$currentVertical = null;
			
			foreach($lines as $line) {
				$line = trim($line);
				if( strpos($line, self::$wikiIndicator) === 0 ) {
					$wikiData = $this->parseWikiData($line);
					if( $wikiData !== false ) {
						$this->verticalsWikis[$currentVertical][] = $wikiData;
					}
				} else {
					$currentVertical = $this->parseVerticalData($line);
				}
			}
			
			if( $this->currentPercentage === 100 ) {
				$data = array();
				foreach($this->verticalsWikis as $verticalName => $wikis) {
					$data[] = array(
						'vertical' => $verticalName,
						'percentage' => $this->verticalsPercentage[$verticalName],
						'wikilist' => $this->verticalsWikis[$verticalName],
					);
				}
				
				return $data;
			} else {
				throw new Exception( wfMsg('wikia-home-parse-source-invalid-percentage') );
			}
		} else {
			throw new Exception( wfMsg('wikia-home-parse-source-empty-exception') );
		}
	}
	
	/**
	 * @desc Parses vertical data increments/decrements percentages and returns vertical's name
	 * 
	 * @param String $data line from the media wiki message
	 * 
	 * @throws Exception
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function parseVerticalData($data) {
		$data = explode(self::$dataSeparator, $data);
		
		if( !empty($data[0]) && !empty($data[1]) ) {
			$verticalName = trim(strtolower(str_replace(self::$verticalIndicator, '', $data[0])));
			$percentage = intval($data[1]);
			
			if( isset($this->verticalsPercentage[$verticalName]) ) {
				$prevPercentage = $this->verticalsPercentage[$verticalName];
				$this->currentPercentage -= $prevPercentage;
				
				$this->verticalsPercentage[$verticalName] = $percentage;
			} else {
				$this->verticalsPercentage[$verticalName] = $percentage;
			}
			$this->currentPercentage += $percentage;
			
			return $verticalName;
		} else {
			throw new Exception( wfMsg('wikia-home-parse-vertical-invalid-data') );
		}
	}
	
	/**
	 * @desc Parses wiki data validate and returns an array
	 * 
	 * @param String $data line from the media wiki message
	 * 
	 * @throws Exception
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function parseWikiData($data) {
		$data = explode(self::$dataSeparator, $data);
		
		if( count($data) >= 3 ) {
			$wikiName = trim(str_replace(self::$wikiIndicator, '', $data[0]));
			$wikiUrl = trim($data[1]);
			$wikiDesc = !empty($data[3]) ? trim($data[3]) : '';
			$wikiNew = !empty($data[4]) ? trim($data[4]) : false;
			$wikiHot = !empty($data[5]) ? trim($data[5]) : false;
			
			$wikiImg = trim($data[2]);
			$wikiImg = wfFindFile($wikiImg);
			$wikiImgSmall = ($wikiImg !== false) ? $this->imageSmallServing->getUrl($wikiImg, $wikiImg->getWidth(), $wikiImg->getHeight()) : $this->wg->BlankImgUrl;
			$wikiImgMedium = ($wikiImg !== false) ? $this->imageMediumServing->getUrl($wikiImg, $wikiImg->getWidth(), $wikiImg->getHeight()) : $this->wg->BlankImgUrl;
			$wikiImgBig = ($wikiImg !== false) ? $wikiImg->transform(array('width' => self::$remixImgBigWidth, 'height' => self::$remixImgBigHeight))->getUrl() : $this->wg->BlankImgUrl;
			
			return array(
				'wikiname' => $wikiName,
				'wikiurl' => $wikiUrl,
				'wikidesc' => $wikiDesc,
				'wikinew' => $wikiNew,
				'wikihot' => $wikiHot,
				'imagesmall' => $wikiImgSmall,
				'imagemedium' => $wikiImgMedium,
				'imagebig' => $wikiImgBig,
			);
		} else {
			throw new Exception( wfMsg('wikia-home-parse-wiki-too-few-parameters') );
		}
	}

	/**
         * get list of images for Hub
         * @responseParam array hubImages
         */
        public function getHubImages() {
                $memKey = $this->wf->SharedMemcKey('wikiahomepage', 'hubimages');
                $hubImages = $this->wg->Memc->get($memKey);

                if (empty($hubImages)) {
                        $hubImages = $this->getHubImageUrls();
                        $this->wg->Memc->set($memKey, $hubImages, 60 * 60 * 24);
                }

                $this->hubImages = $hubImages;
        }

        protected function getHubImageUrls() {
                $hubImages = array();
                $this->imageServing = F::build('ImageServing', array(null, self::hubsImgWidth, array(
                        'w' => self::hubsImgWidth,
                        'h' => self::hubsImgHeight,
                )));

                foreach (self::$wikiaHubs as $hubName) {
                        $hubImages[$hubName] = $this->getImageUrlForHub($hubName);
                }
                return $hubImages;
        }

        protected function getImageUrlForHub($hubName) {
                $hubImage = '';

                $lines = $this->getLinesFromHubGallerySlider($hubName);

                // either we have the gallery content in $lines or that an empty array
                foreach ($lines as $line) {
                        $hubImage = $this->getHubImageFromGalleryTagLine($line);
                        if (!empty($hubImage)) {
                                break;
                        }
                }
                return $hubImage;
        }

        protected function getLinesFromHubGallerySlider($hubName) {
                $content = $this->getRawArticleContent($hubName);
                $lines = $this->extractMosaicGalleryImages($content);
                if (empty($lines)) {
                        // no gallery tag found directly in hub, so there is possibility of transclusion
                        $transcludedContent = $this->getTranscludedArticleForTodaysHub($hubName);
                        $lines = $this->extractMosaicGalleryImages($transcludedContent);
                }
                if (empty($lines)) {
                        // no gallery tag found in hub nor transcluded article, trying failsafe page
                        $transcludedContent = $this->getFailsafeArticleForTodaysHub($hubName);
                        $lines = $this->extractMosaicGalleryImages($transcludedContent);
                }
                return $lines;
        }

        protected function getHubImageFromGalleryTagLine($line) {
                $hubImage = '';
                $imageName = $this->getImageNameFromGalleryTagLine($line);

                if (!empty($imageName)) {
                        $hubImage = $this->getImageUrlFromString($imageName);
                }
                return $hubImage;
        }

        protected function getImageUrlFromString($imageName) {
                $imageUrl = false;
                $title = F::build('Title', array($imageName, NS_IMAGE), 'newFromText');

                $file = $this->wf->FindFile($title);
                if ($file instanceof File && $file->exists()) {
			$imageUrl = $this->imageServing->getUrl($file, max(self::hubsImgWidth, $file->getWidth()), max(self::hubsImgHeight, $file->getHeight()));
                }
                return $imageUrl;
        }

        protected function getImageNameFromGalleryTagLine($line) {
                $line = trim($line);
                if ($line == '') {
                        return false;
                }

                $parts = (array)StringUtils::explode('|', $line);
                $imageName = array_shift($parts);
                if (strpos($line, '%') !== false) {
                        $imageName = urldecode($imageName);
                        return $imageName;
                }
                return $imageName;
        }

        protected function getRawArticleContent($hubname) {
                $title = F::build('Title', array($hubname), 'newFromText');
                $article = F::build('Article', array($title));
                $content = $article->getRawText();
                return $content;
        }

        protected function getTranscludedArticleForTodaysHub($hubname) {
                $today = date('j_F_Y');
                $transcludedArticleName = $hubname . "/" . $today;
                return $this->getRawArticleContent($transcludedArticleName);
        }

        protected function getFailsafeArticleForTodaysHub($hubname) {
                $failsafe = self::FAILSAFE_ARTICLE_TITLE;
                $failsafeArticleName = $hubname . "/" . $failsafe;
                return $this->getRawArticleContent($failsafeArticleName);
        }

	/**
	 * draw visualization
	 */
	public function visualization() {
		$this->response->setVal(
				'seoSample',
				$this->getSeoList()
		);
		
	}

	/**
	 * renders a single hub section
	 */
	public function renderHubSection() {
		// biz logic here
		$this->classname = $this->request->getVal('classname');
		$this->heading = $this->request->getVal('heading');
		$this->heroimageurl = $this->request->getVal('heroimageurl');
		$this->herourl = $this->request->getVal('herourl');
		$this->creative = $this->request->getVal('creative');
		$this->moreheading = $this->request->getVal('moreheading');
		$this->morelist = $this->request->getVal('morelist');
	}
	
	/**
	 * @desc get hardcoded failover data from file
	 * @return String
	 * @todo After moving to production database rewrite returned string so it has links to production's images' urls
	 */
	final private function getFailoverWikiList() {
		return file_get_contents(dirname(__FILE__) . '/text_files/FailOverWikiList.txt');
	}
	
	public static function onGetHTMLAfterBody($skin, &$html) {
		if (Wikia::isWikiaMobile() && F::app()->wg->EnableWikiaHomePageExt && ArticleAdLogic::isMainPage()) {
			$html .= F::app()->sendRequest( 'WikiaHomePage', 'wikiaMobileIndex' )->toString();
		}
		return true;
	}
	
	public static function onOutputPageBeforeHTML(&$out, &$text) {
		if ( ArticleAdLogic::isMainPage() && (!Wikia::isWikiaMobile()) ) {
			$text = '';
			$out->clearHTML();
			$out->addHTML( F::app()->sendRequest( 'WikiaHomePageController', 'index' )->toString() );
		}
		return $out;
	}
	
	public static function onArticleCommentCheck($title) {
		if ( ArticleAdLogic::isMainPage() ) return false;
		return true;	
	}
	
	public static function onWikiaMobileAssetsPackages( Array &$jsPackages, Array &$scssPackages ) {
		//this hook is fired only by the WikiaMobile skin, no need to check for what skin is being used
		if ( F::app()->wg->EnableWikiaHomePageExt && ArticleAdLogic::isMainPage() ) {
			$scssPackages[] = 'wikiahomepage_scss_wikiamobile';
		}

		return true;
	}

	/**
	 * Returns lines of text contained inside mosaic slider gallery tag
	 * @param $articleText
	 * @return array
	 */
	protected function extractMosaicGalleryImages($articleText) {
		$lines = array();

		if (preg_match('/\<gallery.+mosaic.+\>([\s\S]+)\<\/gallery\>/', $articleText, $matches)) {
			$lines = StringUtils::explode("\n", $matches[1]);
		}
		return $lines;
	}
}
