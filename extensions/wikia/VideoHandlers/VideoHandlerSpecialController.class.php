<?php

/**
 * @author Jakub
 */
class VideoHandlerSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('VideoHandler');
	}

	public function index() {

		$url = 'http://img.youtube.com/vi/FRKUuSnEDkU/0.jpg';
		$data = array(
			'wpUpload' => 1,
			'wpSourceType' => 'web',
			'wpUploadFileURL' => $url
		);
		$upload = new UploadFromUrl();
		$upload->initializeFromRequest(new FauxRequest($data, true));
		$upload->fetchFile();
		$upload->verifyUpload();
		$upload->getLocalFile();
		$upload->getTempPath();

		$file = new WikiaLocalFile(
				Title::newFromText('videoTest4'.rand( 0,999999 ), NS_FILE),
				RepoGroup::singleton()->getLocalRepo()
		);

		$file->forceMime = 'video/prototype';

		var_dump(
			$file->upload(
				$upload->getTempPath(),
				'bujah!',
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