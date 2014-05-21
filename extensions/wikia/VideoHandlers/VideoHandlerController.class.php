<?php

/**
 * Class VideoHandlerController
 */
class VideoHandlerController extends WikiaController {

	const VIDEO_LIMIT = 100;
	const DEFAULT_THUMBNAIL_WIDTH = 250;
	const DEFAULT_THUMBNAIL_HEIGHT = 250;

	/**
	 * Get the embed code for the title given by fileTitle
	 *
 	 * @requestParam string|fileTitle The title of the video to find the embed code for
	 * @requestParam int|width The desired width of video playback to return with the embed code
	 * @requestParam boolean|autoplay Whether the video should play immediately on page load
	 * @responseParam string|videoId A unique identifier for the video title given
	 * @responseParam string|asset A URL for the video
	 * @responseParam string|embedCode The HTML to embed on the page to play the video given by fileTitle
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
				$file = ( $title instanceof Title ) ? wfFindFile( $title ) : false;
				if ( $file === false ) {
					$error = wfMessage( 'videohandler-error-video-no-exist' )->inContentLanguage()->text();
				} else {
					$videoId = $file->getVideoId();
					$assetUrl = $file->getPlayerAssetUrl();
					$embedCode = $file->getEmbedCode( $width, $autoplay, true );
					$this->setVal( 'videoId', $videoId );
					$this->setVal( 'asset', $assetUrl );
					$this->setVal( 'embedCode', $embedCode );
				}
			}
		}

		if ( !empty( $error ) ) {
			$this->setVal( 'error', $error );
		}
	}

	/**
	 * Get the embed code for the given title from the video wiki, rather than the local wiki.  This is
	 * useful when a video of the same name from youtube (or other non-premium provider) exists on the local wiki
	 * and we want to show the equivalent video from the video wiki.  See also getEmbedCode in this controller.
	 *
	 * @requestParam string|fileTitle The title of the video to find the embed code for
	 * @requestParam int|width The desired width of video playback to return with the embed code
	 * @requestParam boolean|autoplay Whether the video should play immediately on page load
	 * @responseParam string|videoId A unique identifier for the video title given
	 * @responseParam string|asset A URL for the video
	 * @responseParam string|embedCode The HTML to embed on the page to play the video given by fileTitle
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
	}

	public function getSanitizedOldVideoTitleString( ) {
		$sTitle = $this->getVal( 'videoText', '' );

		$prefix = '';
		if ( strpos( $sTitle, ':' ) === 0 ) {
			$sTitle = substr( $sTitle, 1 );
			$prefix = ':';
		}
		if ( empty( $sTitle ) ) {
			$this->setVal( 'error', 1 );
		}

		$sTitle = VideoFileUploader::sanitizeTitle( $sTitle, '_' );

		$this->setVal(
			'result',
			$prefix.$sTitle
		);
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
	 * Exposes the VideoHandlerHelper::getVideoDetail method from this controller
	 * @requestParam array|string fileTitle - The title of the file to get details for
	 * @requestParam array videoOptions
	 *   [ array( 'thumbWidth' => int, 'thumbHeight' => int, 'postedInArticles' => int, 'getThumbnail' => bool, 'thumbOptions' => array ) ]
	 * @requestParam int articleLimit - The number of "posted in" article detail records to return
	 * @responseParam array detail - The video details
	 */
	public function getVideoDetail() {
		wfProfileIn( __METHOD__ );

		$fileTitle = $this->getVal( 'fileTitle', array() );
		$videoOptions = $this->getVal( 'videoOptions', array() );

		if ( is_string( $fileTitle ) ) {
			$singleFile = true;
			$fileTitles = [ $fileTitle ];
		} else {
			$singleFile = false;
			$fileTitles = $fileTitle;
		}

		if ( !array_key_exists( 'thumbWidth', $videoOptions ) ) {
			$videoOptions['thumbWidth'] = self::DEFAULT_THUMBNAIL_WIDTH;
		}

		if ( !array_key_exists( 'thumbHeight', $videoOptions ) ) {
			$videoOptions['thumbHeight'] = self::DEFAULT_THUMBNAIL_HEIGHT;
		}

		$videos = [];
		$helper = new VideoHandlerHelper();
		foreach ( $fileTitles as $fileTitle ) {
			$detail = $helper->getVideoDetail( [ 'title' => $fileTitle ], $videoOptions );
			if ( !empty( $detail ) ) {
				$videos[] = $detail;
			}
		}

		$this->detail = ( !empty( $videos ) && $singleFile ) ? array_pop( $videos ) : $videos;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Get list of videos (controller that provides access to MediaQueryService::getVideoList method)
	 * @requestParam string sort [recent/popular/trend]
	 * @requestParam integer limit (maximum = 100)
	 * @requestParam integer page
	 * @requestParam string|array providers - Only videos hosted by these providers will be returned. Default: all providers.
	 * @requestParam string|array category - Only videos tagged with these categories will be returned. Default: any categories.
	 * @requestParam integer width - the width of the thumbnail to return
	 * @requestParam integer height - the height of the thumbnail to return
	 * @responseParam array $videos
	 *   [array('title'=>value, 'provider'=>value, 'addedAt'=>value,'addedBy'=>value, 'duration'=>value, 'viewsTotal'=>value)]
	 */
	public function getVideoList() {
		wfProfileIn( __METHOD__ );

		$sort = $this->getVal( 'sort', 'recent' );
		$limit = $this->getVal( 'limit', 1 );
		$page = $this->getVal( 'page', 1 );
		$providers = $this->getVal( 'providers', array() );
		$category = $this->getVal( 'category', '' );
		$width = $this->getVal( 'width', 0 );
		$height = $this->getVal( 'height', 0 );

		$filter = 'all';
		$isMobile = ( $providers == 'mobile' || $providers == 'mobileApp' );

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

		// set maximum limit
		if ( $limit > self::VIDEO_LIMIT ) {
			$limit = self::VIDEO_LIMIT;
		}

		$mediaService = new MediaQueryService();
		$videoList = $mediaService->getVideoList( $sort, $filter, $limit, $page, $providers, $category );

		// get video id and thumbnail url for mobile
		if ( $isMobile ) {
			foreach ( $videoList as &$videoInfo ) {
				$title = $videoInfo['title'];
				$file = WikiaFileHelper::getVideoFileFromTitle( $title );
				if ( $file ) {
					$videoInfo['videoId'] = $file->getVideoId();
					$videoInfo['videoName'] = $file->getTitle()->getText();

					if ( !empty( $width ) && !empty( $height ) ) {
						$thumb = $file->transform( [ 'width' => $width, 'height' => $height ] );
						$videoInfo['thumbUrl'] = $thumb->getUrl();
					} else {
						$videoInfo['thumbUrl'] = '';
					}
				} else {
					$videoInfo['videoId'] = '';
					$videoInfo['videoName'] = '';
					$videoInfo['thumbUrl'] = '';
				}
			}
		}

		$this->videos = $videoList;

		wfProfileOut( __METHOD__ );
	}

}
