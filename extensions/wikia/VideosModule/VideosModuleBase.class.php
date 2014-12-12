<?php

namespace VideosModule;
use Wikia\Cache\AsyncCache;
use Wikia\Logger\WikiaLogger;

/**
 * Class VideosModuleBase
 */
abstract class Base extends \WikiaModel {

	const THUMBNAIL_WIDTH = 268;
	const THUMBNAIL_HEIGHT = 150;

	const CACHE_TTL = 43200; // 12 hours
	const NEGATIVE_CACHE_TTL = 300; // 5 minutes
	const CACHE_VERSION = 5;

	const LIMIT = 20;
	const SOURCE = '';
	const SORT = 'recent';

	protected $source = '';
	protected $limit;
	protected $blacklist = [];          // black listed videos we never want to show in videos module
	protected $blacklistCount = null;   // number of blacklist videos
	protected $existingVideos = [];     // list of titles of existing videos (those which have been added already)
	protected $userRegion;
	protected $sort = '';
	protected $categories = [];

	// Options used when calling the getVideoDetail* methods in VideoHandlerHelper
	protected static $videoOptions = [
		'thumbWidth'   => self::THUMBNAIL_WIDTH,
		'thumbHeight'  => self::THUMBNAIL_HEIGHT,
		'getThumbnail' => true,
		'thumbOptions' => [
			'fluid'       => true,
			'forceSize'   => 'small',
		],
	];

	public function __construct( $userRegion, $sort = '' ) {
		parent::__construct();

		$this->initializeBlacklist();

		$this->userRegion = $userRegion;
		$this->limit = static::LIMIT;
		$this->source = static::SOURCE;
		$this->sort = empty( $sort ) ? static::SORT : $sort;
	}

	protected function initializeBlacklist() {
		// All black listed videos are stored in WikiFactory in the wgVideosModuleBlackList variable
		// on Community wiki.
		$communityBlacklist = \WikiFactory::getVarByName( "wgVideosModuleBlackList", \WikiFactory::COMMUNITY_CENTRAL );

		if ( is_object( $communityBlacklist ) && !empty( $communityBlacklist->cv_value ) ) {
			$this->blacklist = unserialize( $communityBlacklist->cv_value );
		}
	}

	/**
	 * This is an entry point for the AsyncCache class to call the getModuleVideos method on a specific VideosModule
	 * class.
	 *
	 * @param $class
	 * @param $region
	 * @param $sort
	 *
	 * @return mixed
	 */
	public static function getVideosCallback( $class, $region, $sort ) {
		/** @var Base $module */
		$module = new $class( $region, $sort );
		$videos = $module->getModuleVideos();
		return $videos;
	}

	/**
	 * Get a list of videos for the source defined by this class
	 *
	 * @return array
	 */
	public function getVideos() {
		$cacheKey = $this->getCacheKey();

		$asyncCache = $this->getCache();
		$asyncCache
			->key( $cacheKey )
			->ttl( self::CACHE_TTL )
			->negativeResponseTTL( self::NEGATIVE_CACHE_TTL )
			->callback( 'VideosModule\Base::getVideosCallback' )
			->callbackParams( [ get_class( $this ), $this->userRegion, $this->sort ] );

		if ( $asyncCache->foundInCache() ) {
			$this->logInfo( 'Cache HIT');
		} else {
			$this->logInfo( 'Cache MISS');
		}

		$videos = $asyncCache->value();

		if ( empty( $videos ) ) {
			$this->logInfo( 'Zero videos' );
			return [];
		} else {
			return $videos;
		}
	}

	/**
	 * This method should be overridden to return a unique key to use to cache videos found
	 * @return mixed
	 */
	protected function getCacheKey() {
		$cacheKey = wfSharedMemcKey(
			self::CACHE_VERSION,
			__CLASS__,
			$this->userRegion,
			$this->source
		);
		return $cacheKey;
	}

	/**
	 * Returns a caching client for this class
	 * @return AsyncCache
	 */
	public function getCache() {
		return new AsyncCache();
	}

	/**
	 * This method should be overridden to do the actual work of getting videos for the source of the implementing class
	 * @return mixed
	 */
	abstract public function getModuleVideos();

	/**
	 * Method to clear all caches related to this video module
	 *
	 * @return bool
	 */
	public function clearCache() {
		$cacheKey = $this->getCacheKey();
		$this->getCache()->purge( $cacheKey );
		return true;
	}

	/**
	 * Can be used by subclasses to clear the external video list (from the video wiki) if they require it
	 *
	 * @return bool
	 */
	protected function clearExternalVideoListCache() {
		$params = [
			'controller' => 'VideoHandler',
			'method'     => 'clearVideoListCache',
			'sort'       => $this->sort,
			'limit'      => $this->getPaddedVideoLimit(),
			'category'   => $this->categories,
		];

		$response = \ApiService::foreignCall( $this->wg->WikiaVideoRepoDBName, $params, \ApiService::WIKIA );
		return !empty( $response ) && $response['status'] == 'ok';
	}

	/**
	 * General logging method
	 * @param $message
	 */
	protected function logInfo( $message ) {
		$log = WikiaLogger::instance();
		$log->info( __METHOD__ . ' : ' . $message, $this->getLogParams() );
	}

	/**
	 * Parameters to send when logging
	 * @return array
	 */
	protected function getLogParams() {
		return [
			'method' => __METHOD__,
			'region' => $this->userRegion,
			'limit' => $this->limit,
			'source' => $this->source,
		];
	}

	/**
	 * Get video list from Video wiki
	 *
	 * @return array
	 */
	public function getVideoListFromVideoWiki() {
		$params = [
			'controller' => 'VideoHandler',
			'method'     => 'getVideoList',
			'sort'       => $this->sort,
			'limit'      => $this->getPaddedVideoLimit(),
			'category'   => $this->categories,
		];

		$response = \ApiService::foreignCall( $this->wg->WikiaVideoRepoDBName, $params, \ApiService::WIKIA );
		$videosWithDetails = $this->getVideoDetailFromVideoWiki( $this->getVideoTitles( $response['videos'] ) );

		$videos = [];
		foreach ( $videosWithDetails as $video ) {
			if ( count( $videos ) >= $this->limit ) {
				break;
			}
			$this->addToList( $videos, $video );
		}

		return $videos;
	}

	/**
	 * Return a list of just titles given a list of videos.
	 * @param $videos
	 * @return array
	 */
	protected function getVideoTitles( $videos ) {
		$videoTitles = [];
		foreach( $videos as $video ) {
			$videoTitles[] = $video['title'];
		}
		return $videoTitles;
	}

	/**
	 * Call 'VideoHandlerHelper::getVideoDetail' on the video wiki for each of a list of video titles
	 * @param array $videos A list of video titles
	 * @return array - A list of video details for each title passed
	 */
	public function getVideoDetailFromVideoWiki( $videos ) {
		$videoDetails = [];
		if ( !empty( $videos ) ) {
			$helper = new \VideoHandlerHelper();
			$videoDetails = $helper->getVideoDetailFromWiki(
				$this->wg->WikiaVideoRepoDBName,
				$videos,
				self::$videoOptions
			);
		}

		return $videoDetails;
	}

	/**
	 * Get the video details (things like videoId, provider, description, regional restrictions, etc)
	 * for video from the local wiki.
	 * @param $videos
	 * @return array
	 */
	public function getVideoDetailFromLocalWiki( $videos ) {
		$videoDetails = [];
		$helper = new \VideoHandlerHelper();
		foreach ( $videos as $video ) {
			$details = $helper->getVideoDetail( $video, self::$videoOptions );
			if ( !empty( $details ) ) {
				$videoDetails[] = $details;
			}
		}
		return $videoDetails;
	}

	/**
	 * Get video limit (include the number of blacklisted videos)
	 *
	 * @return integer
	 */
	protected function getPaddedVideoLimit( ) {
		if ( is_null( $this->blacklistCount ) ) {
			$this->blacklistCount = count( $this->blacklist );
		}

		$limit = $this->limit + $this->blacklistCount;

		return $limit;
	}

	/**
	 * Checks if a video is able to be added to the current list being collected (eg, staffPicks, videosByCategory,
	 * wikiRelated), and adds it to that list. Adding the source of that video to it's detail, as well as appending
	 * it to the list of existingVideos which includes all videos added from all lists. We use this existingVideos
	 * list to filter as we're adding videos to ensure we don't include duplicates.
	 * @param $videos
	 * @param $video
	 * @return bool
	 */
	protected function addToList( &$videos, $video ) {
		if ( $this->canAddToList( $video ) ) {
			$this->existingVideos[$video['title']] = true;
			$videos[] = $this->normalizeVideoDetail( $video );
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Return whether the video can be added to the current list of videos being
	 * collected (eg, staffPicks, videosByCategory, wikiRelated).
	 * @param $video
	 * @return bool
	 */
	protected function canAddToList( $video ) {
		return !( $this->isRegionallyRestricted( $video )
			|| $this->isBlackListed( $video )
			|| $this->isAlreadyAdded( $video ) );
	}

	/**
	 * Return whether the video is regionally restricted in the user's country.
	 * @param \LocalFile $video
	 * @return bool
	 */
	public function isRegionallyRestricted( $video ) {
		return !empty( $video['regionalRestrictions'] )
			&& !empty( $this->userRegion )
			&& !preg_match( "/$this->userRegion/", $video['regionalRestrictions'] );
	}

	/**
	 * Return whether the video is blacklisted or not.
	 * @param $video
	 * @return bool
	 */
	public function isBlackListed( $video ) {
		return in_array( $video['title'], $this->blacklist );
	}

	/**
	 * Return whether a video has already been added to a list of videos
	 * to send out to the user (eg, staffPicks, videosByCategory, wikiRelated).
	 * Any video which we're going to send out we add to the existingVideos list.
	 * @param $video
	 * @return bool
	 */
	protected function isAlreadyAdded( $video ) {
		return array_key_exists( $video['title'], $this->existingVideos );
	}

	/**
	 * Normalize video details to a set of keys understood by this module
	 * @param array $video
	 * @return array
	 */
	protected function normalizeVideoDetail( Array $video ) {
		return [
			'title'       => $video['fileTitle'],
			'url'         => $video['fileUrl'],
			'thumbnail'   => $video['thumbnail'],
			'thumbUrl'    => $video['thumbUrl'],
			'description' => wfShortenText( $video['description'], 50 ),
			'videoKey'    => $video['title'],
			'duration'    => $video['duration'],
			'source'      => $this->source,
		];
	}
}

