<?php
class VideoHandlerHooks {

	const VIDEO_WIKI = 298117;

	static public function WikiaVideo_isMovable( $result, $index ) {
		return true;
	}

	static public function WikiaVideoParserBeforeStrip( $parser, &$text, $strip_state ) {

		global $wgWikiaVideoGalleryId, $wgRTEParserEnabled;

		$wgWikiaVideoGalleryId = 0;

		// macbre: don't touch anything when parsing for RTE
		if ( !empty($wgRTEParserEnabled) ) {
			return true;
		}
		// fix for RT #22010
		$pattern1 = "/<videogallery[^>]+>/";
		$text = preg_replace( $pattern1, '<videogallery>', $text );

		$pattern2 = "/<videogallery/";
		$text = preg_replace_callback( $pattern2, 'VideoHandlerHooks::WikiaVideoPreRenderVideoGallery', $text );
		return true;
	}

	static public function WikiaVideoPreRenderVideoGallery( $matches ) {

		global $wgWikiaVideoGalleryId;
		$result = $matches[0] . ' id="' . $wgWikiaVideoGalleryId . '"';
		$wgWikiaVideoGalleryId++;
		return $result;
	}

	/**
	 * Preserves video mime types. Needed to fix MW 1.16 bug
	 *
	 * @param WikiaLocalFileShared $oFile
	 * @param WikiaLocalFileShared $oOldFile
	 * @return bool
	 */
	static public function onFileRevertFormBeforeUpload( $oFile, $oOldFile ) {

		if ( $oOldFile->isVideo() ) {
			$oFile->forceMime( $oOldFile->mime );
			$oFile->setVideoId( $oOldFile->getVideoId() );
		}
		return true;
	}

	static public function onSetupAfterCache( ) {
		global $wgUploadDirectory, $wgUploadBaseUrl,
			$wgUploadPath, $wgHashedUploadDirectory,
			$wgThumbnailScriptPath, $wgGenerateThumbnailOnParse,
			$wgLocalFileRepo, $wgDeletedDirectory;

		$wgLocalFileRepo = array(
			'class' => 'WikiaLocalRepo',
			'name' => 'local',
			'directory' => $wgUploadDirectory,
			'url' => $wgUploadBaseUrl ? $wgUploadBaseUrl . $wgUploadPath : $wgUploadPath,
			'hashLevels' => $wgHashedUploadDirectory ? 2 : 0,
			'thumbScriptUrl' => $wgThumbnailScriptPath,
			'transformVia404' => !$wgGenerateThumbnailOnParse,
			'deletedDir' => $wgDeletedDirectory, // TODO: check me
			'deletedHashLevels' => $wgLocalFileRepo['deletedHashLevels'], // TODO: check me,
			'backend' => 'local-backend',
		);

		wfRunHooks( 'AfterSetupLocalFileRepo', [&$wgLocalFileRepo] );
		return true;
	}

	static public function onLinkerMakeThumbLink2FileOriginalSize( $file, &$width ) {
		if ( WikiaFileHelper::isVideoFile( $file ) ) {
			$width = WikiaFileHelper::maxWideoWidth;
		};
		return true;
	}

	/**
	 * @param Parser $parser
	 * @return bool
	 */
	static public function initParserHook( &$parser ) {
		$parser->setHook('videogallery', array($parser, 'renderImageGallery'));
		return true;
	}

	/**
	 *  hack for old format interwiki videos
	 *  examples of input:
	 *  {{:wikiavideo:Titanic 3-D Re-Release (1997) - Theatrical Trailer for Titanic 3D/width=220px&align=}}
	 *  {{:wikiavideo:Titanic 3-D Re-Release (1997) - Theatrical Trailer for Titanic 3D}}
	 *
	 *  examples of output:
	 *  [[File:Titanic 3-D Re-Release (1997) - Theatrical Trailer for Titanic 3D]]
	 *  [[Titanic 3-D Re-Release (1997) - Theatrical Trailer for Titanic 3D|220px]]
	 */
	static function convertOldInterwikiToNewInterwikiCB( $matches ) {

		wfProfileIn( __METHOD__ );
		if ( !empty ( $matches[1] ) ) {

			$addtionalParams = array();

			$parts = explode( "/", $matches[1] );
			if ( count( $parts ) > 1 ) {

				$params = explode( "&", $parts[1] );
				foreach ( $params as $pv ) {

					$param = explode( "=", $pv );

					if ( $param[0] == "width" && !empty( $param[1] ) ) {

						$addtionalParams[] = $param[1];
					}

					if ( $param[0] == "align" && !empty( $param[1] ) ) {

						$addtionalParams[] = $param[1];
					}
				}

				$paramsString = '';
				if ( count( $addtionalParams ) > 0 ) {
					$paramsString .= '|' . implode( "|", $addtionalParams );
				}
				wfProfileOut( __METHOD__ );
				return '[[File:' . $parts[0] . $paramsString . ']]';

			} else {
				wfProfileOut( __METHOD__ );
				return '[[File:' . $matches[1] . ']]';
			}

		}
		wfProfileOut( __METHOD__ );
		return false;
	}

	static public function convertOldInterwikiToNewInterwiki( &$parser, &$text ) {
		global $wgRTEParserEnabled;
		if ( $wgRTEParserEnabled ) {
			return true;
		}

		$newtext = preg_replace_callback('/\{\{:wikiavideo:([^}]*)\}\}/', 'VideoHandlerHooks::convertOldInterwikiToNewInterwikiCB', $text);
		if ( !empty($newtext) ) {
			$text = $newtext;
		}

		return true;

	}

	static public function checkExtensionCompatibilityResult( &$result, &$file, &$oldMime, &$newExt ) {

		if ( WikiaFileHelper::isFileTypeVideo( $file ) && $newExt == "" ) {
			$result = true;
		}

		return true;
	}

	/**
	 * Hook: get redirected file from foreign repo
	 * @param RepoGroup $repos
	 * @param Title $title
	 * @param array $options
	 * @param boolean $useCache
	 * @param File|false $file
	 * @param File $cacheEntry
	 * @return true
	 */
	public static function onFindRedirectedFile( $repos, $title, $options, $useCache, &$file, &$cacheEntry ) {
		$redirect = RepoGroup::singleton()->getLocalRepo()->checkRedirect( $title );
		if ( $redirect instanceof Title && $redirect->getNamespace() == NS_FILE && $title->getDBKey() != $redirect->getDBKey() ) {
			foreach ( $repos as $repo ) {
				if ( $repo->allowRedirect) {
					$file = $repo->findfile( $redirect, $options );
					if ( $file && $useCache ) {
						$cacheEntry = $file;
					}
				}
			}
		}

		return true;
	}

	/**
	 * Hook: update options for Http request (uploading video only)
	 * @param array $options
	 * @return true
	 */
	public static function onUploadFromUrlReallyFetchFile( &$options ) {
		// check if proxy is disabled
		if ( !empty( F::app()->wg->DisableProxy ) ) {
			$options['noProxy'] = true;
			// reset to default
			F::app()->wg->DisableProxy = false;
		}

		return true;
	}

	/**
	 * SUS-81: bind to hooks that are triggered when clearing the video_info cache
	 *
	 * This allow us to purge the cached responses of getVideoList method when a video is added / re-uploaded / deleted.
	 *
	 * @param VideoInfo $video
	 * @return bool
	 */
	public static function clearVideoCache( VideoInfo $video ) {
		Wikia\Logger\WikiaLogger::instance()->info( __METHOD__ );
		Wikia::purgeSurrogateKey( VideoHandlerController::getVideoListSurrogateKey() );

		return true;
	}

}
