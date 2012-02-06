<?php
/*
 * Helper service to maintain new video logic / old video logic
 */
class WikiaVideoService extends Service {

	/*
	 * Checks if videos on the wiki are converted to new format (File namespace)
	 * @return boolean
	 */
	public function isVideoAsFile() {
		
		$convertedVar = F::app()->wg->videoHandlersVideosMigrated;
		return !empty( $convertedVar );
	}	
	
	/*
	 * Checks if given File is video
	 * @param $file WikiaLocalFile object or Title object eventually
	 * @return boolean
	 */
	public function isFileTypeVideo($file) {
		
		if ( $file instanceof Title && $file->exists() ) {
			$file = wfFindFile($file);
		}
		
		if ( $file instanceof WikiaLocalFile && $file->isVideo() ) {
			return true;
		}
		
		return false;
	}
	
	/*
	 * Checks if given Title is video 
	 * @return boolean
	 */
	public function isTitleVideo($title) {
		
		if ( !($title instanceof Title) ) {

			$title = Title::newFromText( $title );
			if ( !($title instanceof Title) ) {
				return false;
			}
		}

		if ( $this->isVideoAsFile() ) { 

			// video-as-file logic
			if ( $this->isFileTypeVideo($title) ) {
			
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
	public function preserveOldImageBehaviour() {
		
		return false;
	}
	
}