<?php

/**
 * @author Jakub
 */
class VideoHandlerSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('VideoHandler');
	}

	public function index() {

		$videoId = 123;
		$apiWrapper = F::build( 'PrototypeApiWrapper', array( $videoId ) );
		
		$url = $apiWrapper->getThumbnailUrl();
		$data = array(
			'wpUpload' => 1,
			'wpSourceType' => 'web',
			'wpUploadFileURL' => $url
		);
		$upload = F::build('UploadFromUrl');
		$upload->initializeFromRequest( F::build( 'FauxRequest', array( $data, true ) ) );
		$upload->fetchFile();
		$upload->verifyUpload();
//		$upload->getLocalFile();
//		$upload->getTempPath();

		$file = F::build('WikiaLocalFile',
				array(
					Title::newFromText( $apiWrapper->getTitle(), NS_FILE ),
					RepoGroup::singleton()->getLocalRepo()
				)
			);

		$file->forceMime( 'video/prototype' );
		$file->setVideoId( $videoId );

		var_dump(
			$file->upload(
				$upload->getTempPath(),
				$apiWrapper->getDescription(),
				'[[Category:New Video]] Victory at the sea!',
				File::DELETE_SOURCE
			)
		);

	}
	
//	Old code using API.
//	public function index(){
//
//		$api = new ApiMain(
//			new FauxRequest(
//				array(
//					'action' => 'upload',
//					'url' => 'http://img.youtube.com/vi/6dqkFw5Wlgo/2.jpg',
//					'filename' => 'aaaaa',
//					'token' => $this->wg->user->editToken()
//				)
//			),
//			true
//		);
//
//		$api->execute();
//		$res = $api->getResultData();
//	}
}