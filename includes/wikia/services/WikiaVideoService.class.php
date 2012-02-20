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
	public static function isFileTypeVideo($file) {
		
		if ( self::isVideoStoredAsFile() ) {
			// File can be video only when new video logic is enabled for the wiki
			if ( $file instanceof Title && $file->exists() ) {
				$file = wfFindFile( $file );
			}

			if ( $file instanceof WikiaLocalFile && $file->isVideo() ) {
				return true;
			}
		}
		return false;
	}
	
	/*
	 * Checks if given Title is video 
	 * @return boolean
	 */
	public static function isTitleVideo($title) {
		
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

		} else { 

			// video-namespace logic
			if ( $title->getNamespace() == NS_VIDEO ) {

				return true;
			}			
			return false;
		}
		
		return false;
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
		return !empty(F::app()->wg->embedVideosUseWikiaVideoExt);		
	}
	
	/**
	 * Can VideoHandlers extension be used to embed video
	 * @return boolean
	 */
	public static function useVideoHandlersExtForEmbed() {
		return !empty(F::app()->wg->embedVideosUseVideoHandlersExt);		
	}
}