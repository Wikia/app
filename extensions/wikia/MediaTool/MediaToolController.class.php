<?php

/**
 * MediaTool controller
 * @author mech
 */
class MediaToolController extends WikiaController {
	const RESPONSE_STATUS_OK = 'ok';
	const RESPONSE_STATUS_ERROR  = 'error';
	const THUMBNAIL_SIZE_SMALL = 250;
	const THUMBNAIL_SIZE_LARGE = 300;

	public function __construct() {
	}

	public function getVideoMetadata() {
		$this->response->setFormat('json');

		$videoUrl = $this->getVal( 'videoUrl' );

		$data = array();
		if(!empty($videoUrl)) {
			try {
				$wrapper = ApiWrapperFactory::getApiWrapper( $videoUrl );
			}
			catch(Exception $exception) {
				// catch any response errors from providers here
				$data['status'] = self::RESPONSE_STATUS_ERROR;
				$data['msg'] = wfMsg('mediatool-error-invalid-video');

				$this->response->setData( $data );
				return;
			}

			if($wrapper instanceof ApiWrapper) {
				$metaData = $wrapper->getMetadata();

				$data['status'] = self::RESPONSE_STATUS_OK;
				$data['title'] = $wrapper->getTitle();
				$data['hash'] = md5($wrapper->getTitle());
				$data['thumbUrl'] = $wrapper->getThumbnailUrl();
				$data['duration'] = floor($metaData['duration'] / 60) . ':' . ( $metaData['duration'] - (floor($metaData['duration'] / 60) * 60) );
			}
			else {
				$data['status'] = self::RESPONSE_STATUS_ERROR;
				$data['msg'] = wfMsg('mediatool-error-unknown-video-provider');
			}
		}
		else {
			$data['status'] = self::RESPONSE_STATUS_ERROR;
			$data['msg'] = wfMsg('mediatool-error-missing-video-url');
		}

		$this->response->setData( $data );
	}

	public function getMediaItems() {

		$mediaList = $this->request->getVal("mediaList", array());
		$data = array();

		if ( count($mediaList) > 0 ) {

			foreach ( $mediaList as $sFileTitle ) {

				$oFileTitle = Title::newFromText( $sFileTitle, NS_FILE );
				if ( !empty($oFileTitle) ) {
					$oFile = wfFindFile($oFileTitle);
					if ( !empty($oFile) ) {
						$data[] = array(
							"video" => WikiaFileHelper::isFileTypeVideo( $oFile ),
							"title" => $oFileTitle->getFullText(),
							"hash" => md5($oFileTitle->getFullText()),
							"status" => self::RESPONSE_STATUS_OK,
							"thumbHtml" => $this->getMediaThumb( $sFileTitle ),
							"thumbUrl" => $this->getThumbnailUrl( $sFileTitle )
						);
					}
				}
			}
		}
		$this->response->setData( $data );
	}

	public function getRecentMedia() {
		$this->response->setFormat('json');

		// @todo implement
		$data = array();
		$data[] = array(
			'video' => true,
			'hash' => md5('File:Battlefield_3_Myth_Busting_Episode_2_by_Fhrope_(Battlefield_3_Gameplay_Commentary)'),
			'file' => 'File:Battlefield_3_Myth_Busting_Episode_2_by_Fhrope_(Battlefield_3_Gameplay_Commentary)',
			'thumbHtml' => $this->getMediaThumb('Battlefield_3_Myth_Busting_Episode_2_by_Fhrope_(Battlefield_3_Gameplay_Commentary)')
		);
		$data[] = array(
			'video' => false,
			'hash' => md5('File:256.jpeg'),
			'file' => 'File:256.jpeg',
			'thumbHtml' => $this->getMediaThumb('256.jpeg')
		);

		$this->response->setData( $data );
	}

	public function getMediaThumb($sTitle) {
		$mediaTitle = F::build('Title', array($sTitle, NS_FILE), 'newFromText'); /* @var $mediaTitle Title */
		$mediaFile = wfFindFile($mediaTitle);

		if( $mediaFile ) {
			$mediaThumbObj = $mediaFile->transform( array('width'=>96, 'height'=>72 ) );
			$mediaThumb = $mediaThumbObj->toHtml(
				array(
					'custom-url-link' => '',
					'linkAttribs' => array(
						'class' => '',
						'data-ref' => $mediaTitle->getPrefixedDbKey()
					),
					'duration' => true,
					'src' => false,
					'constHeight' => 72,
					'usePreloading' => false
				)
			);

			return $mediaThumb;
		}
		return '';
	}

	public function getThumbnailUrl($sTitle) {
		$mediaTitle = F::build('Title', array($sTitle, NS_FILE), 'newFromText'); /* @var $mediaTitle Title */
		$mediaFile = wfFindFile($mediaTitle);

		if( $mediaFile ) {
			$mediaThumbObj = $mediaFile->transform( array('width'=>96, 'height'=>72 ) );
			return $mediaThumbObj->getUrl();
		}
		return '';
	}

	public function getModalContent() {}
	public function getBasket() {}
	public function getItemsList() {}

	public function getTemplates() {
		$this->response->setFormat('json');
		$this->response->setVal('dialog', $this->app->renderView( 'MediaTool', 'getModalContent' ) );
		$this->response->setVal('cart', $this->app->renderView( 'MediaTool', 'getBasket' ) );
		$this->response->setVal('itemsList', $this->app->renderView( 'MediaTool', 'getItemsList' ) );
	}


}