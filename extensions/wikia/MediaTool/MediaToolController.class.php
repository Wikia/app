<?php

/**
 * MediaTool controller
 * @author mech
 */
class MediaToolController extends WikiaController {
	const RESPONSE_STATUS_OK = 'ok';
	const RESPONSE_STATUS_ERROR  = 'error';

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
				$data['status'] = self::RESPONSE_STATUS_OK;
				$data['title'] = $wrapper->getTitle();
				$data['thumbnailUrl'] = $wrapper->getThumbnailUrl();
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

	public function getRecentMedia() {
		$this->response->setFormat('json');

		// @todo implement
		$data = array();
		$data[] = array(
			'video' => true,
			'file' => 'File:Battlefield_3_Myth_Busting_Episode_2_by_Fhrope_(Battlefield_3_Gameplay_Commentary)',
			'thumbHtml' => $this->getMediaThumb('Battlefield_3_Myth_Busting_Episode_2_by_Fhrope_(Battlefield_3_Gameplay_Commentary)')
		);
		$data[] = array(
			'video' => false,
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

			wyvlog($mediaThumb);

			return $mediaThumb;
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