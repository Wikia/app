<?php
/*
 * Helper service to maintain new video logic / old video logic
 */
class WikiaFileHelper extends Service {

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


	public static function getTitle( $mTitle ){

		if ( !( $mTitle instanceof Title ) ) {

			$mTitle = Title::newFromText( $mTitle );
			if ( !($mTitle instanceof Title) ) {
				return false;
			}
		}

		return $mTitle;
	}

	/*
	 * Looks up videos with same provider and videoId
	 * as specified inside currently uploaded videos on wiki
	 * (searches Image table)
	 */
	public static function findVideoDuplicates( $provider, $videoId ) {
		$dbr = wfGetDB(DB_SLAVE);

		$videoStr = (string)$videoId;
		$rows = $dbr->select(
			'image',
			'*',
			"img_media_type='VIDEO' AND img_minor_mime='$provider' " .
			"AND img_metadata LIKE '%s:7:\"videoId\";s:".strlen($videoStr).':"'.$videoStr."\";%'"
		);

		$result = array();

		while($row = $dbr->fetchRow($rows)) {
			$result[] = $row;
		}

		$dbr->freeResult($rows);

		return $result;
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

	public static function getMediaDetailConfig( $config = array() ) {

		$configDefaults = array(
			'contextWidth'          => false,
			'contextHeight'         => false,
			'imageMaxWidth'         => 1000,
			'userAvatarWidth'       => 16
		);

		foreach ( $configDefaults as $key => $val ) {

			if ( empty( $config[$key] ) ) {
				$config[$key] = $val;
			}
		}

		return $config;
	}

	/**
	 * @static
	 * @param Title $fileTitle
	 * @param array $config ( contextWidth, contextHeight, imageMaxWidth, userAvatarWidth )
	 */
	public static function getMediaDetail( $fileTitle, $config = array() ) {


		if ( $fileTitle->getNamespace() != NS_FILE ) {
			$fileTitle = F::build('Title', array($fileTitle->getDBKey(), NS_FILE), 'newFromText');
		}

		$config = self::getMediaDetailConfig( $config );

		$data = array(
			'mediaType' => '',
			'videoEmbedCode' => '',
			'playerAsset' => '',
			'imageUrl' => '',
			'fileUrl' => '',
			'rawImageUrl' => '',
			'description' => '',
			'userThumbUrl' => '',
			'userId' => '',
			'userName' => '',
			'userPageUrl' => '',
			'articles' => array(),
			'exists' => false
		);

		$file = wfFindFile($fileTitle);

		if ( !empty( $file ) ) {
			$data['exists'] = true;

			$data['mediaType'] = self::isFileTypeVideo( $file ) ? 'video' : 'image';

			$width = $file->getWidth();
			$height = $file->getHeight();

			if ( $data['mediaType'] == 'video' ) {

				$width  = $config['contextWidth']  ? $config['contextWidth']  : $width;
				$height = $config['contextHeight'] ? $config['contextHeight'] : $height;

				$data['videoEmbedCode'] = $file->getEmbedCode( $width, true, true);
				$data['playerAsset'] = $file->getPlayerAssetUrl();

				$mediaPage = F::build( 'WikiaVideoPage', array($fileTitle) );

			} else {

				$width = $width > $config['imageMaxWidth'] ? $config['imageMaxWidth'] : $width;
				$mediaPage = F::build( 'ImagePage', array($fileTitle) );
			}

			$thumb = $file->transform( array('width'=>$width, 'height'=>$height), 0 );
			$user = F::build('User', array( $file->getUser('id') ), 'newFromId' );

			$data['imageUrl'] = $thumb->getUrl();
			$data['fileUrl'] = $fileTitle->getLocalUrl();
			$data['rawImageUrl'] = $file->getUrl();
			$data['userId'] = $user->getId();
			$data['userName'] = $user->getName();
			$data['userThumbUrl'] = F::build( 'AvatarService', array($user->getId() , $config['userAvatarWidth'] ), 'getAvatarUrl' );
			$data['userPageUrl'] = $user->getUserPage()->getFullURL();
			$data['description']  = $mediaPage->getContent();

			$mediaQuery =  F::build( 'ArticlesUsingMediaQuery' , array( $fileTitle ) );
			$articlesData = $mediaQuery->getArticleList();

			if ( is_array($articlesData) ) {
				foreach ( $articlesData as $art ) {
					$data['articles'][] = array( 'articleUrl' => $art['url'], 'articleTitle' => $art['title'], 'articleNS' => $art['ns'] );
				}
			}

		}

		return $data;

	}

}
