<?php
class VideoHandlerHooks extends WikiaObject{

	const VIDEO_WIKI = 298117;

	function __construct(){
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}

	public function  WikiaVideoNewImagesBeforeQuery( &$where ) {
		$where[] = 'img_media_type != \'VIDEO\'';
		$where[] = 'img_major_mime != \'video\'';
		$where[] = 'img_media_type != \'swf\'';
		return true;
	}

	public function WikiaVideo_isMovable($result, $index) {
		return true;
	}

	/**
	 * @param Title $oTitle
	 *
	 * @return WikiaVideoPage if file is video
	 */
	public function onArticleFromTitle( &$oTitle, &$oArticle ){

		if ( ( $oTitle instanceof Title ) && ( $oTitle->getNamespace() == NS_FILE ) ){
			$oFile = wfFindFile( $oTitle );
			if ( WikiaFileHelper::isVideoFile( $oFile ) ){
				$oArticle = new WikiaVideoPage( $oTitle );
			} else {
				$oArticle = new WikiaImagePage( $oTitle );
			}
		}

		return true;
	}

	public function WikiaVideoFetchTemplateAndTitle( &$text, $finalTitle ) {

		global $wgContLang, $wgWikiaVideosFoundInTemplates;

		$vid_tag = $wgContLang->getFormattedNsText( NS_VIDEO ) . ":Placeholder";

		// replace text and give Video:Template_Placeholder: text everywhere
		if ($text !== false) {
			$count = 0;
			$text = str_replace( $vid_tag, 'Video:Template_Placeholder', $text, $count );
			$wgWikiaVideosFoundInTemplates += $count;
		}
		return true;
	}

	public function WikiaVideoParserBeforeStrip($parser, &$text, $strip_state) {

		global $wgWikiaVideoGalleryId, $wgRTEParserEnabled;

		$wgWikiaVideoGalleryId = 0;

		// macbre: don't touch anything when parsing for RTE
		if (!empty($wgRTEParserEnabled)) {
			return true;
		}
		// fix for RT #22010
		$pattern1 = "/<videogallery[^>]+>/";
		$text = preg_replace( $pattern1, '<videogallery>', $text );

		$pattern2 = "/<videogallery/";
		$text = preg_replace_callback( $pattern2, array($this, 'WikiaVideoPreRenderVideoGallery'), $text );
		return true;
	}

	public function WikiaVideoPreRenderVideoGallery( $matches ) {

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
	 */
	public function onFileRevertFormBeforeUpload( $oFile, $oOldFile ){

		if ( $oOldFile->isVideo() ){
			$oFile->forceMime( $oOldFile->mime );
			$oFile->setVideoId( $oOldFile->getVideoId() );
		}
		return true;
	}

	/**
	 * @param OutputPage $out
	 * @param $skin
	 * @return bool
	 */
	public function onBeforePageDisplay( $out, $skin ) {
		wfProfileIn(__METHOD__);

		if ( $this->app->checkSkin( 'monobook', $skin ) ) {
			// not used on mobileskin
			// part of oasis skin so not needed there
			$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/VideoHandlers/css/VideoHandlers.scss' ) );
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public function onSetupAfterCache() {
		global $wgUploadDirectory, $wgUploadBaseUrl,
			$wgUploadPath, $wgHashedUploadDirectory,
			$wgThumbnailScriptPath, $wgGenerateThumbnailOnParse,
			$wgLocalFileRepo, $wgDeletedDirectory;

		$wgLocalFileRepo = array(
			'class' => 'WikiaLocalRepo',
			'name' => 'local',
			'directory' => $wgUploadDirectory,
			//'scriptDirUrl' => $wgScriptPath,
			//'scriptExtension' => $wgScriptExtension,
			'url' => $wgUploadBaseUrl ? $wgUploadBaseUrl . $wgUploadPath : $wgUploadPath,
			'hashLevels' => $wgHashedUploadDirectory ? 2 : 0,
			'thumbScriptUrl' => $wgThumbnailScriptPath,
			'transformVia404' => !$wgGenerateThumbnailOnParse,
			'deletedDir' => $wgDeletedDirectory, // TODO: check me
			'deletedHashLevels' => $wgLocalFileRepo['deletedHashLevels'], // TODO: check me,
			'backend' => 'local-backend'
		);

		return true;
	}

	public function onLinkerMakeThumbLink2FileOriginalSize ( $file, &$width ){
		if ( WikiaFileHelper::isVideoFile( $file ) ){
			$width = WikiaFileHelper::maxWideoWidth;
		};
		return true;
	}

	/**
	 * @param Parser $parser
	 * @return bool
	 */
	public function initParserHook(&$parser) {
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
	function convertOldInterwikiToNewInterwikiCB( $matches ) {

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

	public function checkExtensionCompatibilityResult( &$result, &$file, &$oldMime, &$newExt ) {

		if ( WikiaFileHelper::isFileTypeVideo( $file ) && $newExt == "" ) {
			$result = true;
		}

		return true;
	}

	/*
	 * Add "replace" button to File pages
	 * Add "remove" action to MenuButtons on premium video file pages
	 * This button will remove a video from a wiki but keep it on the Video Wiki.
	 */
	public function onSkinTemplateNavigation($skin, &$tabs) {
		global $wgUser;

		$app = F::app();

		$title = $app->wg->Title;

		if ( ( $title instanceof Title ) && ( $title->getNamespace() == NS_FILE ) && $title->exists() ) {
			$file = $app->wf->FindFile( $title );
			if ( ( $file instanceof File ) && UploadBase::userCanReUpload( $wgUser, $file->getName() ) ) {
				if ( WikiaFileHelper::isTitleVideo( $title ) ) {
					$uploadTitle = SpecialPage::getTitleFor( 'WikiaVideoAdd' );
					$href = $uploadTitle->getFullURL( array(
						'name' => $file->getName()
					 ) );
				} else {
					$uploadTitle = SpecialPage::getTitleFor( 'Upload' );
					$href = $uploadTitle->getFullURL( array(
						'wpDestFile' => $file->getName(),
						'wpForReUpload' => 1
					 ) );
				}
				$tabs['actions']['replace-file'] = array(
					'class' => 'replace-file',
					'text' => wfMessage('wikia-file-page-replace-button'),
					'href' => $href,
				);
			}
		}

		// Ignore Video Wiki videos beyond this point
		if( $app->wg->CityId == self::VIDEO_WIKI ) {
			return true;
		}

		if ( WikiaFileHelper::isTitleVideo( $title ) ) {
			$file = $app->wf->FindFile( $title );
			if( !$file->isLocal() ) {
				// Prevent move tab being shown.
				unset( $tabs['actions']['move'] );
			}
		}

		return true;
	}

	/**
	 * Hook: get wiki link for SpecialGlobalUsage::formatItem()
	 * @param array $item
	 * @param string $page
	 * @param string|false $link
	 * @return true
	 */
	public function onGlobalUsageFormatItemWikiLink( $item, $page, &$link ) {
		$link = WikiFactory::DBtoUrl( $item['wiki'] );
		if ( $link ) {
			$link .= 'wiki/'.$page;
			$link = Xml::element( 'a', array( 'href' => $link ), str_replace( '_',' ', $page ) );
		}

		return true;
	}

	/**
	 * Hook: get wiki link for GlobalUsage
	 * @param string $wikiName
	 * @return true
	 */
	public function onGlobalUsageImagePageWikiLink( &$wikiName ) {
		$wiki = WikiFactory::getWikiByDB( $wikiName );
		if ( $wiki ) {
			$wikiName = '['.$wiki->city_url.' '.$wiki->city_title.']';
		}

		return true;
	}
}
