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

				/** @var $item MediaToolItem */
				$item = F::build('MediaToolItem');

				$item->setIsVideo(true);
				$item->setTitleText($wrapper->getTitle());
				$item->setUploader($this->wg->User);
				$item->setThumbUrl($wrapper->getThumbnailUrl());
				$item->setThumbHtml(false);
				$item->setRemoteUrl($videoUrl);
				$item->setDuration($this->helper->secToMMSS($metaData['duration']));

				$data = $item->toArray();
				$data['status'] = self::RESPONSE_STATUS_OK;
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

		foreach ( $mediaList as $sFileTitle ) {
			$item = F::build( 'MediaToolItem', array( 'title' => Title::newFromText( $sFileTitle, NS_FILE ) ) );
			if ( $item->hasFile() ) {
				$data[] = $item->toArray();
			}
		}
		$this->response->setData( $data );
	}

	public function getRecentMedia() {
		$this->response->setFormat('json');

		// @todo implement
		$data = array();
		$data[] = F::build('MediaToolItem', array( 'title' => Title::newFromText('Battlefield 3 Myth Busting Episode 2 by Fhrope (Battlefield 3 Gameplay Commentary)', NS_FILE) ))->toArray();
		$data[] = F::build('MediaToolItem', array( 'title' => Title::newFromText('256.jpeg', NS_FILE) ))->toArray();

		$this->response->setData( $data );
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