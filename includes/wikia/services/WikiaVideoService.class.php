<?php
/*
 * Helper service to maintain new video logic / old video logic
 */
class WikiaVideoService extends Service {

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
			if ( $file instanceof Title && $file->exists() ) {
				$file = wfFindFile( $file );
			}
			return self::isVideoFile();
		}
		return false;
	}

	public static function isVideoFile( $file ) {
		return ( method_exists( $file, 'isVideo' ) && $file->isVideo() );
	}

	/*
	 * Checks if given Title is video 
	 * @return boolean
	 */
	public static function isTitleVideo( $title, $allowOld = true ) {
		
		if ( !($title instanceof Title) ) {

			$title = Title::newFromText( $title );
			if ( !($title instanceof Title) ) {
				return false;
			}
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
		return !empty(F::app()->wg->ingestVideosUseVideoHandlersExt);
	}

	/**
	 * Can VideoHandlers extension be used to embed video
	 * @return boolean
	 */
	public static function useWikiaVideoExtForEmbed() {
		return !empty(F::app()->wg->embedVideosUseWikiaVideoExt) && !self::isVideoStoredAsFile();		
	}

	/**
	 * Can VideoHandlers extension be used to embed video
	 * @return boolean
	 */
	public static function useVideoHandlersExtForEmbed() {
		return !empty(F::app()->wg->embedVideosUseVideoHandlersExt);		
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
