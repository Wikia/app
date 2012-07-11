<?php

/**
 * MediaTool controller
 * @author mech
 */
class MediaToolController extends WikiaController {
	const RESPONSE_STATUS_OK = 'ok';
	const RESPONSE_STATUS_ERROR  = 'error';
	const MEDIA_SIZE_SMALL = 250;
	const MEDIA_SIZE_LARGE = 300;

	/**
	 * @var MediaToolhelper
	 */
	protected $helper = null;

	public function __construct() {
		$this->helper = F::build('MediaToolHelper');
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
				$data['isVideo'] = true;
				$data['title'] = $wrapper->getTitle();
				$data['hash'] = md5($wrapper->getTitle());
				$data['thumbUrl'] = $wrapper->getThumbnailUrl();
				$data['thumbHtml'] = false;
				$data['remoteUrl'] = $videoUrl;
				$data['duration'] = $this->helper->secToMMSS($metaData['duration']);
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
							"isVideo" => WikiaFileHelper::isFileTypeVideo( $oFile ),
							"title" => $oFileTitle->getPrefixedDBkey(),
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
			'isVideo' => true,
			'hash' => md5('File:Battlefield_3_Myth_Busting_Episode_2_by_Fhrope_(Battlefield_3_Gameplay_Commentary)'),
			'title' => 'File:Battlefield_3_Myth_Busting_Episode_2_by_Fhrope_(Battlefield_3_Gameplay_Commentary)',
			'thumbHtml' => $this->getMediaThumb('Battlefield_3_Myth_Busting_Episode_2_by_Fhrope_(Battlefield_3_Gameplay_Commentary)'),
			'thumbUrl' => '',
		);
		$data[] = array(
			'isVideo' => false,
			'hash' => md5('File:256.jpeg'),
			'title' => 'File:256.jpeg',
			'thumbHtml' => $this->getMediaThumb('256.jpeg'),
			'thumbUrl' => '',
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
			$mediaThumbObj = $mediaFile->transform( array('width'=>400 ) );
			return $mediaThumbObj->getUrl();
		}
		return '';
	}

	public function uploadVideo() {
		$this->response->setFormat('json');

		$videoUrl = $this->request->getVal('url');
		$response = array( 'status' => self::RESPONSE_STATUS_ERROR );

		if(!empty($videoUrl)) {
			$videoMetadataResponse = $this->sendSelfRequest( 'getVideoMetadata', array( 'videoUrl' => $videoUrl ) );
			$videoMetaData = $videoMetadataResponse->getData();
			if($videoMetaData['status'] == self::RESPONSE_STATUS_OK) {
				/** @var $result Title */
				$result = VideoFileUploader::URLtoTitle( $videoUrl, $videoMetaData['title'] );
				if( $result instanceof Title ) {
					$response['status'] = self::RESPONSE_STATUS_OK;
					$response['title'] = $result->getPrefixedDBkey();
				}
				else {
					$response['msg'] = wfMsg('mediatool-error-upload-failed');
				}
			}
			else {
				$response['msg'] = $videoMetaData['msg'];
			}
		}
		else {
			$response['msg'] = wfMsg('mediatool-error-missing-video-url');
		}
		$this->response->setData( $response );
	}

	public function uploadVideos() {
		$this->response->setFormat('json');
		$videoUrls = $this->request->getVal('urls');

		$results = array();
		if(is_array($videoUrls)) {
			foreach($videoUrls as $videoUrl) {
				$response = $this->sendSelfRequest('uploadVideo', array( 'url' => $videoUrl ));
				$result = array();
				$result['url'] = $videoUrl;
				$result['status'] = $response->getVal('status');
				if($response->getVal('status') == self::RESPONSE_STATUS_OK) {
					$result['title'] = $response->getVal('title');
				}
				else {
					$result['msg'] = $response->getVal('msg');
				}
				$results[] = $result;
			}
		}

		$this->response->setData($results);
	}

	public function getModalContent() {}
	public function getBasket() {}
	public function getItemsList() {}
	public function itemPreview() {}
	public function itemPreviewBorder() {}

	public function getTemplates() {

		$this->response->setFormat('json');
		$this->response->setVal('dialog', $this->app->renderView( 'MediaTool', 'getModalContent' ) );
		$this->response->setVal('cart', $this->app->renderView( 'MediaTool', 'getBasket' ) );
		$this->response->setVal('itemsList', $this->app->renderView( 'MediaTool', 'getItemsList' ) );
		$this->response->setVal('itemPreviewTpl', $this->app->renderView( 'MediaTool', 'itemPreview' ) );
		$this->response->setVal('itemPreviewBorderTpl', $this->app->renderView( 'MediaTool', 'itemPreviewBorder' ) );
	}


}