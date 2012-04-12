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

		if ( !Wikia::isWikiaMobile( $skin ) ) {
			$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/VideoHandlers/css/VideoHandlers.scss' ) );
		}

		wfProfileOut(__METHOD__);
		return true;
	}
	
	public function onSetupAfterCache() {
		global	$wgLocalFileRepo, $wgUploadDirectory, $wgUploadBaseUrl,
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

	public function onLinkerMakeThumbLink2FileOriginalSize ( $file, $width ){
		if ( WikiaVideoService::isVideoFile( $file ) ){
			$width = WikiaVideoService::maxWideoWidth;
		};
		return true;
	}

	public function initParserHook(&$parser) {
		$parser->setHook('videogallery', array($parser, 'renderImageGallery'));
		return true;
	}

	function convertOldInterwikiToNewInterwikiCB( $matches ) {

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

				return '[[File:' . $parts[0] . $paramsString . ']]';

			} else {

				return '[[File:' . $matches[1] . ']]';
			}

		}

		return false;
	}

	public function convertOldInterwikiToNewInterwiki(&$parser, &$text) {
		global $wgRTEParserEnabled;
		if($wgRTEParserEnabled) {
			return true;
		}

		$newtext = preg_replace_callback('/\{\{:wikiavideo:([^}]*)\}\}/', array($this, 'convertOldInterwikiToNewInterwikiCB'), $text);
		if(!empty($newtext)) {
			$text = $newtext;
		}

		return true;

	}
	
}
