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
	
	protected $source = null;
	protected $verticalsPercentage = array();
	protected $verticalsWikis = array();
	protected $currentPercentage = 0;
	protected $blankImgUrl = '';
	
	private $imageSmallServing = null;
	private $imageMediumServing = null;
	
	// list of hubs
	protected static $wikiaHubs = array(
		'Entertainment',
		'Video_Games',
		'Lifestyle',
	);

	public function __construct() {
		$this->blankImgUrl = F::app()->wg->BlankImgUrl;
	}
	
	public function index() {
		//cache response on varnish for 1h to enable rolling of stats
		$this->response->setCacheValidity(3600, 3600, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));

		$this->response->addAsset('extensions/wikia/WikiaHomePage/css/WikiaHomePage.scss');
		$this->response->addAsset('extensions/wikia/WikiaHomePage/js/WikiaHomePage.js');
		$this->response->addAsset('skins/oasis/css/wikiagrid.scss');

		$response = $this->app->sendRequest( 'WikiaHomePageController', 'getHubImages' );
		$this->hubImages = $response->getVal( 'hubImages' , '' );
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
			$stats['communities'] = $this->getStatsFromArticle( 'StatsCommunities' );
			$stats['totalPages'] = $this->getTotalPages();
			
			$this->wg->Memc->set( $memKey, $stats, 60*60*1 );
		}

		foreach( $stats as $key => $value ) {
			$this->$key = $this->wg->Lang->formatNum( $value );
		}

		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * get unique visitors last 30 days
	 * @return integer edits 
	 */
	protected function getVisitors() {
		$this->wf->ProfileIn( __METHOD__ );

		$visitors = 0;
		if ( !empty( $this->wg->StatsDBEnabled ) ) {
			$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->StatsDB);

			// for testing
			if ( $this->wg->DevelEnvironment ) {
				// include today
				$row = $db->selectRow( 
					array( 'page_views' ), 
					array( 'sum(pv_views) cnt' ),
					array( "pv_use_date > date_format(curdate() - interval 31 day,'%Y%m%d')" ),
					__METHOD__
				);
			} else {
				// exclude today
				$row = $db->selectRow( 
					array( 'google_analytics.pageviews' ), 
					array( 'sum(pageviews) cnt' ),
					array( "date > curdate() - interval 31 day" ),
					__METHOD__
				);
			}

			if ( $row ) {
				$visitors = $row->cnt;
			}
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $visitors;
	}

	/**
	 * get number of edits made in the last 24 hours
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
				array( 'event_date > now() - interval 1 day' ),
				__METHOD__
			);

			if ( $row ) {
				$edits = $row->cnt;
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
	 * get total number of pages across Wikia
	 * @return integer totalPages 
	 */
	protected function getTotalPages() {
		$this->wf->ProfileIn( __METHOD__ );

		$totalPages = 0;
		if ( !empty( $this->wg->StatsDBEnabled ) ) {
			$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->StatsDB);

			$row = $db->selectRow( 
				array( 'wikia_monthly_stats' ), 
				array( 'sum(articles) cnt' ),
				array( "stats_date = date_format(curdate(),'%Y%m')" ),
				__METHOD__
			);

			if ( $row ) {
				$totalPages = $row->cnt;
			}
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $totalPages;
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
			$wikiImgSmall = ($wikiImg !== false) ? $this->imageSmallServing->getUrl($wikiImg, $wikiImg->getWidth(), $wikiImg->getHeight()) : $this->blankImgUrl;
			$wikiImgMedium = ($wikiImg !== false) ? $this->imageMediumServing->getUrl($wikiImg, $wikiImg->getWidth(), $wikiImg->getHeight()) : $this->blankImgUrl;
			$wikiImgBig = ($wikiImg !== false) ? $wikiImg->transform(array('width' => self::$remixImgBigWidth, 'height' => self::$remixImgBigHeight))->getUrl() : $this->blankImgUrl;
			
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
		$memKey = $this->wf->SharedMemcKey( 'wikiahomepage', 'hubimages' );
		$hubImages = $this->wg->Memc->get( $memKey );
		if ( empty($hubImages) ) {
			$hubImages = array();
			$imageServing = F::build('ImageServing', array(null, self::hubsImgWidth, array(
				'w' => self::hubsImgWidth,
				'h' => self::hubsImgHeight,
			)));
			foreach( self::$wikiaHubs as $hubname ) {
				$hubImages[$hubname] = '';

				$title = F::build( 'Title', array($hubname), 'newFromText' );
				$article = F::build( 'Article', array($title) );
				$content = $article->getRawText();

				$lines = array();
				if (preg_match('/\<gallery.+mosaic.+\>([\s\S]+)\<\/gallery\>/', $content,$matches)) {
					$lines = StringUtils::explode("\n", $matches[1]);
				} else {
					// no gallery tag found directly in hub, so there is possibility of transclusion
					$pattern = '%\{\{:(' . str_replace('_', '[ _]',$hubname) . '/[_a-zA-Z0-9]*)\}\}%';
					if (preg_match($pattern, $content, $transclusionmatches)) {
						$transcludedArticleName = $transclusionmatches[1];
						$transcludedTitle = F::build( 'Title', array($transcludedArticleName), 'newFromText' );
						$transcludedArticle = F::build( 'Article', array($transcludedTitle) );
						$transcludedContent = $transcludedArticle->getRawText();
						if (preg_match('/\<gallery.+mosaic.+\>([\s\S]+)\<\/gallery\>/', $transcludedContent, $matches)) {
							$lines = StringUtils::explode("\n", $matches[1]);
						}
					}
				}
				
				// either we have the gallery content in $lines or that an empty array
				foreach ( $lines as $line ) {
					$line = trim( $line );
					if ( $line == '' ) {
						continue;
					}

					$parts = (array) StringUtils::explode( '|', $line );
					$imageName = array_shift($parts);
					if ( strpos($line, '%') !== false ) {
						$imageName = urldecode($imageName);
					}

					if ( !empty($imageName) ) {
						$title =  F::build( 'Title', array($imageName, NS_IMAGE), 'newFromText' );
						$file = $this->wf->FindFile( $title );
						if ( $file instanceof File && $file->exists() ) {
							$imageUrl = $imageServing->getUrl($file, max(self::hubsImgWidth, $file->getWidth()), max(self::hubsImgHeight, $file->getHeight()));
							$hubImages[$hubname] = $imageUrl;
						}
						break;
					}
				}
				
			}
			$this->wg->Memc->set( $memKey, $hubImages, 60*60*24 );
		}
		
		$this->hubImages = $hubImages;
	}
	
	/**
	 * draw visualization
	 */
	public function visualization() {
		$this->wgBlankImgUrl = $this->blankImgUrl;
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
}
