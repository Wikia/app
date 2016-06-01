<?php

use \Wikia\Logger\WikiaLogger;

/**
 * Class VideoHandlerController
 */
class VideoHandlerController extends WikiaController {
	use Wikia\Logger\Loggable;

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	const VIDEO_LIMIT = 100;
	const DEFAULT_THUMBNAIL_WIDTH = 250;
	const DEFAULT_THUMBNAIL_HEIGHT = 250;

	/**
	 * Get the embed code for the title given by fileTitle
	 *
 	 * @requestParam string fileTitle The title of the video to find the embed code for
	 * @requestParam int width The desired width of video playback to return with the embed code
	 * @requestParam boolean autoplay Whether the video should play immediately on page load
	 * @responseParam string videoId A unique identifier for the video title given
	 * @responseParam string asset A URL for the video
	 * @responseParam string embedCode The HTML to embed on the page to play the video given by fileTitle
	 */
	public function getEmbedCode( ) {
		$title = $this->getVal( 'fileTitle', '' );
		$width = $this->getVal( 'width', '' );
		$autoplay = $this->getVal( 'autoplay', false );

		$error = '';
		if ( empty( $title ) ) {
			$error = wfMessage( 'videohandler-error-missing-parameter', 'title' )->inContentLanguage()->text();
		} else {
			if ( empty( $width ) ) {
				$error = wfMessage( 'videohandler-error-missing-parameter', 'width' )->inContentLanguage()->text();
			} else {
				$title = Title::newFromText( $title, NS_FILE );

				/** @var LocalFile|WikiaLocalFileShared $file */
				$file = ( $title instanceof Title ) ? wfFindFile( $title ) : false;
				if ( $file === false ) {
					$error = wfMessage( 'videohandler-error-video-no-exist' )->inContentLanguage()->text();
				} else {
					$videoId = $file->getVideoId();
					$assetUrl = $file->getPlayerAssetUrl();
					$options = [
						'autoplay' => $autoplay,
						'isAjax' => true,
					];
					$embedCode = $file->getEmbedCode( $width, $options );
					$this->setVal( 'videoId', $videoId );
					$this->setVal( 'asset', $assetUrl );
					$this->setVal( 'embedCode', $embedCode );
					/**
					 * This data is being queried by GameGuides that store html in local storage
					 * Therefore we have to allow for accessing this API, from ie. file://
					 */
					(new CrossOriginResourceSharingHeaderHelper())
						->setAllowOrigin( [ '*' ] )
						->setAllowMethod( [ 'GET' ] )
						->setHeaders($this->response);
				}
			}
		}

		if ( !empty( $error ) ) {
			$this->setVal( 'error', $error );
		}

		$this->response->setFormat( 'json' );
	}

	/**
	 * Get the embed code for the given title from the video wiki, rather than the local wiki.  This is
	 * useful when a video of the same name from youtube (or other non-premium provider) exists on the local wiki
	 * and we want to show the equivalent video from the video wiki.  See also getEmbedCode in this controller.
	 *
	 * @requestParam string fileTitle The title of the video to find the embed code for
	 * @requestParam int width The desired width of video playback to return with the embed code
	 * @requestParam boolean autoplay Whether the video should play immediately on page load
	 * @responseParam string videoId A unique identifier for the video title given
	 * @responseParam string asset A URL for the video
	 * @responseParam string embedCode The HTML to embed on the page to play the video given by fileTitle
	 */
	public function getPremiumEmbedCode( ) {
		// Pass through all the same parameters
		$params = array(
			'controller' => __CLASS__,
			'method'     => 'getEmbedCode',
			'fileTitle'  => $this->getVal( 'fileTitle', '' ),
			'width'      => $this->getVal( 'width', '' ),
			'autoplay'   => $this->getVal( 'autoplay', false ),
		);

		// Call out to the getEmbedCode method in the context of the Video Wiki (WikiaVideoRepoDBName)
		$response = ApiService::foreignCall( F::app()->wg->WikiaVideoRepoDBName, $params, ApiService::WIKIA, true );

		// Map the foreign call response back to our response
		foreach ( $response as $key => $val ) {
			$this->setVal( $key, $val );
		}

		$this->response->setFormat( 'json' );
	}

	/**
	 * Remove video
	 * @requestParam string title
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 */
	public function removeVideo( ) {
		wfProfileIn( __METHOD__ );

		$videoTitle = $this->getVal( 'title', '' );
		if ( empty($videoTitle) ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videos-error-empty-title' )->text();
			wfProfileOut( __METHOD__ );
			return;
		}

		// check if user is logged in
		if ( !$this->wg->User->isLoggedIn() ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videos-error-not-logged-in' )->text();
			wfProfileOut( __METHOD__ );
			return;
		}

		// check if user is blocked
		if ( $this->wg->User->isBlocked() ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videos-error-blocked-user' )->text();
			wfProfileOut( __METHOD__ );
			return;
		}

		// check if read-only
		if ( wfReadOnly() ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videos-error-readonly' )->text();
			wfProfileOut( __METHOD__ );
			return;
		}

		$error = '';

		$title = Title::newFromText( $videoTitle, NS_FILE );
		$file = ( $title instanceof Title ) ? wfFindfile( $title ) : false;
		if ( $file instanceof File && WikiaFileHelper::isFileTypeVideo($file) ) {
			// check permissions
			$permissionErrors = $title->getUserPermissionsErrors( 'delete', $this->wg->User );
			if ( count( $permissionErrors ) ) {
				$this->result = 'error';
				$this->msg = wfMessage( 'videos-error-permissions' )->text();
				wfProfileOut( __METHOD__ );
				return;
			}

			$reason = '';
			$suppress = false;
			if ( $file->isLocal() ) {
				$status = Status::newFatal( 'cannotdelete', wfEscapeWikiText( $title->getPrefixedText() ) );
				$page = WikiPage::factory( $title );
				$dbw = wfGetDB( DB_MASTER );
				try {
					// delete the associated article first
					if ( $page->doDeleteArticleReal( $reason, $suppress, 0, false ) >= WikiPage::DELETE_SUCCESS ) {
						$status = $file->delete( $reason, $suppress );
						if ( $status->isOK() ) {
							$dbw->commit();
						} else {
							$dbw->rollback();
						}
					}
				} catch ( MWException $e ) {
					// rollback before returning to prevent UI from displaying incorrect "View or restore N deleted edits?"
					$dbw->rollback();
					$error = $e->getMessage();
				}

				if ( $status->isOK() ) {
					$oldimage = null;
					$user = $this->wg->User;
					wfRunHooks( 'FileDeleteComplete', array( &$file, &$oldimage, &$page, &$user, &$reason ) );
				} else if ( !empty($error) ) {
					$error = $status->getMessage();
				}
			} else {
				$article = null;
				if ( $title->exists() ) {
					$article = Article::newFromID( $title->getArticleID() );
				} else {
					$botUser = User::newFromName( 'WikiaBot' );
					$flags = EDIT_NEW | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT;

					// @FIXME Set $article here after calling addCategoryVideos so that the doDeleteArticle call below works properly
					$videoHandlerHelper = new VideoHandlerHelper();
					$status = $videoHandlerHelper->addCategoryVideos( $title, $botUser, $flags );
				}

				if ( is_object($article) && !$article->doDeleteArticle( $reason, $suppress, 0, true, $error ) ) {
					if ( empty($error) ) {
						$error = wfMessage( 'videohandler-remove-error-unknown' )->text();
					}
				}
			}
		} else {
			$error = wfMessage( 'videohandler-error-video-no-exist' )->text();
		}

		if ( empty($error) ) {
			$this->result = 'ok';
			$this->msg = wfMessage( 'videohandler-remove-video-modal-success', $title )->text();
		} else {
			$this->result = 'error';
			$this->msg = $error;
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Check if the file exists
	 * @requestParam string fileTitle
	 * @responseParam boolean $fileExists
	 */
	public function fileExists() {
		wfProfileIn( __METHOD__ );

		$fileExists = false;

		$fileTitle = $this->getVal( 'fileTitle', '' );
		$title = Title::newFromText( $fileTitle, NS_FILE );
		if ( $title instanceof Title ) {
			$file = wfFindFile( $title );
			if ( $file instanceof File && $file->exists() ) {
				$fileExists = true;
			}
		}

		$this->fileExists = $fileExists;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Exposes the VideoHandlerHelper::getVideoDetail method from this controller. If fileTitle is passed
	 * to this method as a string, return a single associative array containing details for that video. Otherwise,
	 * return an indexed array containing one associative array per video.
	 * @requestParam array|string fileTitle - The title of the file to get details for
	 * @requestParam array videoOptions
	 *   [ array( 'thumbWidth' => int, 'thumbHeight' => int, 'postedInArticles' => int, 'getThumbnail' => bool, 'thumbOptions' => array ) ]
	 * @requestParam int articleLimit - The number of "posted in" article detail records to return
	 * @responseParam array detail - The video details
	 */
	public function getVideoDetail() {
		wfProfileIn( __METHOD__ );

		$fileTitle = $this->getVal( 'fileTitle', [] );
		$returnSingleVideo = is_string( $fileTitle );
		$fileTitleAsArray = wfReturnArray( $fileTitle );
		$videoOptions = $this->getVideoOptionsWithDefaults( $this->getVal( 'videoOptions', [] ) );

		// Key to cache the data under in memcache
		$memcKey = wfMemcKey( __FUNCTION__, md5( serialize( [ $fileTitleAsArray, $videoOptions ] ) ) );

		// How we'll get the data on a cache miss
		$dataGenerator = function() use ( $fileTitleAsArray, $videoOptions ) {
			$videos = $this->getDetailsForVideoTitles( $fileTitleAsArray, $videoOptions );

			// Take note when we are unable to get any details for a set of videos
			if ( empty( $videos ) ) {
				$log = WikiaLogger::instance();
				$log->info( __METHOD__.' empty details', [
					'titleCount' => count( $fileTitleAsArray ),
					'titleString' => implode( '|', $fileTitleAsArray ),
				] );
			}

			return $videos;
		};

		// Call the generator, caching the result, or not caching if we get null from the $dataGenerator
		$videos = WikiaDataAccess::cacheWithOptions( $memcKey, $dataGenerator, [
			'cacheTTL' => WikiaResponse::CACHE_STANDARD,
			'negativeCacheTTL' => 0,
		] );

		// If file title was passed in as a string, return single associative array.
		$this->detail = ( !empty( $videos ) && $returnSingleVideo ) ? array_pop( $videos ) : $videos;
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @param array $videoOptions
	 * @return array
	 */
	private function getVideoOptionsWithDefaults( array $videoOptions ) {
		if ( !array_key_exists( 'thumbWidth', $videoOptions ) ) {
			$videoOptions['thumbWidth'] = self::DEFAULT_THUMBNAIL_WIDTH;
		}
		if ( !array_key_exists( 'thumbHeight', $videoOptions ) ) {
			$videoOptions['thumbHeight'] = self::DEFAULT_THUMBNAIL_HEIGHT;
		}
		return $videoOptions;
	}

	/**
	 * Given an array of video titles, and an array of videoOptions (see getVideoDetails for more info)
	 * return a list of those videos with fleshed out details (eg thumbnail, videoKey, embedUrl, etc)
	 * @param array $fileTitles
	 * @param array $videoOptions
	 * @return array
	 */
	private function getDetailsForVideoTitles( array $fileTitles, array $videoOptions ) {
		$videos = [];
		$helper = new VideoHandlerHelper();
		foreach ( $fileTitles as $fileTitle ) {
			$detail = $helper->getVideoDetail( [ 'title' => $fileTitle ], $videoOptions );
			if ( !empty( $detail ) ) {
				$videos[] = $detail;
			}
		}
		return $videos;
	}

	/**
	 * Get list of videos (controller that provides access to MediaQueryService::getVideoList method)
	 * @requestParam integer limit (maximum = 100)
	 * @requestParam integer page
	 * @requestParam string|array providers - Only videos hosted by these providers will be returned. Default: all providers.
	 * @requestParam string|array category - Only videos tagged with these categories will be returned. Default: any categories.
	 * @requestParam integer width - the width of the thumbnail to return
	 * @requestParam integer height - the height of the thumbnail to return
	 * @requestParam integer detail [0/1] - check for getting video detail
	 * @responseParam array
	 *   [array('title'=>value, 'provider'=>value, 'addedAt'=>value,'addedBy'=>value, 'duration'=>value, 'viewsTotal'=>value)]
	 */
	public function getVideoList() {
		wfProfileIn( __METHOD__ );

		$params = $this->getVideoListParams();

		$mediaService = new \MediaQueryService();
		$videoList = $mediaService->getVideoList(
			$params['filter'],
			$params['limit'],
			$params['page'],
			$params['providers'],
			$params['category'],
			$params['sort']
		);

		// get video detail
		if ( !empty( $params['detail'] ) ) {
			$videoOptions = [
				'thumbWidth' => $params['width'],
				'thumbHeight' => $params['height'],
			];
			$helper = new \VideoHandlerHelper();
			foreach ( $videoList as &$videoInfo ) {
				$videoDetail = $helper->getVideoDetail( $videoInfo, $videoOptions );
				if ( !empty( $videoDetail ) ) {
					$videoInfo = array_merge( $videoInfo, $videoDetail );
				}
				else {
					/**
					 * SUS-80: because of the way videos upload was fixed before SUS-66 was applied,
					 * rows to "page" table were added, but the actual video was never uploaded (i.e. "image" table row was missing)
					 */
					$videoInfo = false;  // this entry will be removed by array_filter() below

					$this->error( __METHOD__ . ' - getVideoDetail returned no results', [
						'title' => $videoInfo['title'],
					] );
				}
			}
			unset( $videoInfo );
		}

		// filter out items that provide no details (see the comment above)
		// array_values helps us keep consecutive index values
		$videoList = array_values( array_filter( $videoList ) );

		$this->response->setVal( 'videos', $videoList );

		// SUS-291: This method is only called via ajax/internal requests expecting json data
		$this->response->setFormat( \WikiaResponse::FORMAT_JSON );

		/**
		 * SUS-81: let's rely on CDN cache only
		 *
		 * The surrogate key allows us to purge the whole range of getVideoList responses with a single PURGE request.
		 */
		$this->response->setCacheValidity( \WikiaResponse::CACHE_STANDARD );
		$this->wg->Out->tagWithSurrogateKeys( self::getVideoListSurrogateKey() );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * SUS-81: return a surrogate key to be used for purging various responses rendered by getVideoList method
	 *
	 * @return string
	 */
	public static function getVideoListSurrogateKey() {
		return Wikia::surrogateKey( __CLASS__, 'getVideoList' );
	}

	protected function getVideoListParams() {
		return [
			'limit' => $this->getVideoListLimit(),
			'page' => $this->getVal( 'page', 1 ),
			'providers' => $this->getVideoListProviders(),
			'category' => $this->getVal( 'category', '' ),
			'width' => $this->getVal( 'width', self::DEFAULT_THUMBNAIL_WIDTH ),
			'height' => $this->getVal( 'height', self::DEFAULT_THUMBNAIL_HEIGHT ),
			'detail' => $this->getVal( 'detail', 0 ),
			'filter' => 'all',
			'sort' => $this->getVal( 'sort', MediaQueryService::SORT_RECENT_FIRST )
		];
	}

	protected function getVideoListProviders() {
		$providers = $this->getVal( 'providers', [] );
		if ( is_string( $providers ) ) {
			// get providers for mobile
			if ( $providers == 'mobile' ) {
				$providers = $this->wg->WikiaMobileSupportedVideos;
			} elseif ( $providers == 'mobileApp' ) {
				$providers = $this->wg->WikiaMobileAppSupportedVideos;
			} else {
				$providers = [ $providers ];
			}
		}
		return $providers;
	}

	protected function getVideoListLimit() {
		// Considering the code that relies on this method, returning
		// values evaluating to zero implies no limit at all. Yet, we
		// have maximum limit defined in self::VIDEO_LIMIT which needs
		// to be respected.
		// In addition, queries with maximum limit are somewhat slow,
		// so it is much better to set limit to 1 when it evaluates to
		// zero.
		$limit = max( 1, $this->request->getInt( 'limit' ) );
		$limit = min( $limit, self::VIDEO_LIMIT );
		return $limit;
	}
}
