<?php

/**
 * MediaTool controller
 * @author mech
 */
class MediaToolController extends WikiaController {
	const RESPONSE_STATUS_OK = 'ok';
	const RESPONSE_STATUS_ERROR  = 'error';

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
				$item->setDescription("fake description for online media");
				$item->setUploader($this->wg->User);
				$item->setThumbUrl($wrapper->getThumbnailUrl());
				$item->setThumbHtml(false);

				$item->setRemoteUrl($videoUrl);
				$item->setDuration($this->helper->secToMMSS($metaData['duration']));

				$data = $item->toArray();
				$data['status'] = self::RESPONSE_STATUS_OK;
			}
			elseif( $file = $this->helper->getFileFromUrl( $videoUrl ) ) {
				// local file or premium video

				/** @var $item MediaToolItem */
				$item = F::build('MediaToolItem');

				$item->setIsVideo(true);
				$item->setTitle($file->getTitle());
				$item->setRemoteUrl($videoUrl);

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

	public function getEmbedCode() {


		$this->response->setFormat('json');

		$imgTitle = $this->request->getVal('imgTitle');
		$remoteUrl = $this->request->getVal('remoteUrl');

		$oTitle = Title::newFromText($imgTitle, NS_FILE);

		if ( !empty($remoteUrl) ) {

			$awf = ApiWrapperFactory::getInstance(); /* @var $awf ApiWrapperFactory */
			$apiwrapper = $awf->getApiWrapper( $remoteUrl );

			if( !empty($apiwrapper) ) { // try ApiWrapper first - is it from partners?

				$provider = $apiwrapper->getMimeType();
				$image = new WikiaLocalFile( $oTitle, RepoGroup::singleton()->getLocalRepo() );
				$image->forceMime( $provider );
				$image->setVideoId( $apiwrapper->getVideoId() );
				$image->setProps(array('mime'=>$provider ));
			}

		} else {

			$image = wfFindFile($oTitle);
		}


		$maxWidth = $this->request->getInt('maxwidth', 500);
		$embedCode = $image->getEmbedCode( $maxWidth, true, true );
		$asset = $image->getPlayerAssetUrl();
		if ( empty($asset) ) {
			$html = $embedCode;
			$jsonData = '';
		} else {
			$html = ''; // You can still add here some code, it will be displayed under the video
			$jsonData = $embedCode;
		}

		$res = array(
			'html' => $html,
			'jsonData' => $jsonData,
			'width' => $maxWidth,
			'asset' => $asset
		);
		$this->response->setData( $res );
	}

	public function getRecentMedia() {
		$this->response->setFormat('json');

		// @todo implement
		$data = array();
		$data[] = F::build('MediaToolItem', array( 'title' => Title::newFromText('Battlefield 3 Myth Busting Episode 2 by Fhrope (Battlefield 3 Gameplay Commentary)', NS_FILE) ))->toArray();
		$data[] = F::build('MediaToolItem', array( 'title' => Title::newFromText('256.jpeg', NS_FILE) ))->toArray();
		//$data[] = F::build('MediaToolItem', array( 'title' => Title::newFromText('Aunt Bam\'s Place (2012) - Home Video Trailer for Aunt Bam\'s Place', NS_FILE) ))->toArray();
		//$data[] = F::build('MediaToolItem', array( 'title' => Title::newFromText('Dream_Theater_-_Octavarium', NS_FILE) ))->toArray();
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
	public function itemPreviewInputs() {}

	public function getTemplates() {
		//TODO: this should be cachable in browser, use cb in request
		$this->response->setFormat('json');

		$this->response->setVal('dialog', $this->app->renderView( 'MediaTool', 'getModalContent' ) );
		$this->response->setVal('cart', $this->app->renderView( 'MediaTool', 'getBasket' ) );
		$this->response->setVal('itemsList', $this->app->renderView( 'MediaTool', 'getItemsList' ) );
		$this->response->setVal('itemPreviewTpl', $this->app->renderView( 'MediaTool', 'itemPreview' ) );
		$this->response->setVal('itemPreviewBorderTpl', $this->app->renderView( 'MediaTool', 'itemPreviewBorder' ) );
		$this->response->setVal('itemPreviewInputsTpl', $this->app->renderView( 'MediaTool', 'itemPreviewInputs' ) );
	}

	public function getData() {
		//TODO: this shouldn't be cached in browser
		$this->response->setFormat('json');

		$this->response->setVal('watchCreations', F::app()->wg->User->getOption( 'watchcreations' ) );
	}


}