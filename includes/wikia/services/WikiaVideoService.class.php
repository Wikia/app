<?php
/*
 * Helper service to maintain new video logic / old video logic
 */
class WikiaVideoService extends Service {

	const maxWideoWidth = 1200;

	/*
	 * Checks if videos on the wiki are converted to new format (File namespace)
	 * @return boolean
	 */
	public static function isVideoStoredAsFile() {
		
		$convertedVar = F::app()->wg->videoHandlersVideosMigrated;
		return !empty( $convertedVar );
	}	

	/*
	 * Checks if given File is video
	 * @param $file WikiaLocalFile object or Title object eventually
	 * @return boolean
	 */
	public static function isFileTypeVideo( $file ) {
		
		if ( self::isVideoStoredAsFile() ) {
			// File can be video only when new video logic is enabled for the wiki
			if ( $file instanceof Title ) {
				$file = wfFindFile( $file );
			}
			return self::isVideoFile( $file );
		}
		return false;
	}

	public static function isVideoFile( $file ) {
		return ( $file instanceof LocalFile && $file->getHandler() instanceof VideoHandler);
	}

	/*
	 * Checks if given Title is video 
	 * @return boolean
	 */
	public static function isTitleVideo( $title, $allowOld = true ) {
		
		$title = self::getTitle( $title );
		
		if ( empty($title) ) {
			return false;
		}
		
		if ( self::isVideoStoredAsFile() ) {

			// video-as-file logic
			if ( self::isFileTypeVideo($title) ) {
			
				return true;
			}
			return false;

		} elseif ( ( $title->getNamespace() == NS_VIDEO ) && $allowOld ) {

			return true;
		}
		
		return false;
	}

	/*
	 * Checks if given Title is video
	 * @return boolean
	 */
	public static function getEmbedCodefromTitle( $title, $width, $allowOld = true ) {

		$title = self::getTitle( $title );
		if ( self::isVideoStoredAsFile() ) {

			// video-as-file logic
			if ( self::isFileTypeVideo( $title ) ) {
				$oVideoTitle = Title::newFromText( $videoName, NS_VIDEO );
				if ( !empty( $oVideoTitle ) ) {
					$oVideoPage = new VideoPage( $oVideoTitle );
					$oVideoPage->load();
					if ( $videoPage->checkIfVideoExists() ){
						$videoEmbedCode = $oVideoPage->getEmbedCode( $width, false, true );
					}
				}
			}
			return false;

		} elseif ( ( $title->getNamespace() == NS_VIDEO ) && $allowOld ) {

			return true;
		}

		return false;
	}

	public static function getTitle( $mTitle ){

		if ( !( $mTitle instanceof Title ) ) {

			$mTitle = Title::newFromText( $mTitle );
			if ( !($mTitle instanceof Title) ) {
				return false;
			}
		}

		return $mTitle;
	}

	public static function videoPlayButtonOverlay( $width, $height ) {
		$playButton = array(
			"class"		=> "Wikia-video-play-button",
			"style"		=> "width: {$width}px; height: {$height}px;"
		);
		return  Xml::element( 'span', $playButton, '', false );
	}
	
	/*
	 * Checks if user wants to have old image bahaviour
	 * @return boolean
	 */
	public static function preserveOldImageBehaviour() {
		
		return false;
	}

	/**
	 * Can WikiaVideo extension be used to ingest video
	 * @return boolean 
	 */
	public static function useWikiaVideoExtForIngestion() {
		return !empty(F::app()->wg->ingestVideosUseWikiaVideoExt);
	}

	/**
	 * Can VideoHandlers extensions be used to ingest video
	 * @return boolean
	 */
	public static function useVideoHandlersExtForIngestion() {
		return static::isVideoStoredAsFile() || !empty(F::app()->wg->ingestVideosUseVideoHandlersExt);
	}

	/**
	 * Can VideoHandlers extension be used to embed video
	 * @return boolean
	 */
	public static function useWikiaVideoExtForEmbed() {
		return !static::isVideoStoredAsFile() && !empty(F::app()->wg->embedVideosUseWikiaVideoExt);		
	}

	/**
	 * Can VideoHandlers extension be used to embed video
	 * @return boolean
	 */
	public static function useVideoHandlersExtForEmbed() {
		return static::isVideoStoredAsFile() || !empty(F::app()->wg->embedVideosUseVideoHandlersExt);
	}

	/**
	 * Could the given URL exist on this wiki? Does not actually check if
	 * video exists.
	 * @param string $url
	 * @return boolean
	 */
	public static function isUrlMatchThisWiki($url) {
		return stripos( $url, F::app()->wg->server ) !== false;
	}

	/**
	 * Could the given URL exist on the Wikia video repository? Does not
	 * actually check if video exists.
	 * @param string $url
	 * @return boolean
	 */
	public static function isUrlMatchWikiaVideoRepo($url) {
		return stripos( $url, F::app()->wg->wikiaVideoRepoPath ) !== false;
	}
}
