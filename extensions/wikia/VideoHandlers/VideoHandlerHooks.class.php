<?php
class VideoHandlerHooks extends WikiaObject{

	function __construct(){
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}

	/**
	 * returns VideoPage if file is video
	 */
	public function onArticleFromTitle( &$oTitle, &$oArticle ){

		if ( ( $oTitle instanceof Title ) && ( $oTitle->getNamespace() == NS_FILE ) ){
			$oFile = wfFindFile( $oTitle );
			if ( WikiaVideoService::isVideoFile( $oFile ) ){
				$oArticle = new WikiaVideoPage( $oTitle );
			}
		}

		return true;
	}

	/*
	 * Preserves video mime types. Needed to fix MW 1.16 bug
	 */
	public function onFileRevertFormBeforeUpload( $oFile, $oOldFile ){

		if ( $oOldFile->isVideo() ){
			$oFile->forceMime( $oOldFile->mime );
			$oFile->setVideoId( $oOldFile->getVideoId() );
		}
		return true;
	}

	public function onBeforePageDisplay( $out, $skin ) {
		wfProfileIn(__METHOD__);
		
		$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/VideoHandlers/css/VideoHandlers.scss' ) );

		wfProfileOut(__METHOD__);
		return true;
	}
	
	public function onSetupAfterCache() {
		global $wgLocalFileRepo, $wgUploadDirectory, $wgUploadBaseUrl,
			$wgUploadPath, $wgHashedUploadDirectory, 
			$wgThumbnailScriptPath, $wgGenerateThumbnailOnParse,
			$wgFileStore;
		
		$wgLocalFileRepo = array(
			'class' => 'WikiaLocalRepo',
			'name' => 'local',
			'directory' => $wgUploadDirectory,
			'url' => $wgUploadBaseUrl ? $wgUploadBaseUrl . $wgUploadPath : $wgUploadPath,
			'hashLevels' => $wgHashedUploadDirectory ? 2 : 0,
			'thumbScriptUrl' => $wgThumbnailScriptPath,
			'transformVia404' => !$wgGenerateThumbnailOnParse,
			'deletedDir' => $wgFileStore['deleted']['directory'],
			'deletedHashLevels' => $wgFileStore['deleted']['hash']
		);
		
		return true;
	}
}
