<?php

/**
 * @author Jakub
 */
class VideoHandlerSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'VideoHandler' );
	}

	public function index() {

		if ( $this->wg->user->isBlocked() ) {
			$this->wg->out->blockedPage();
			return false;	// skip rendering
		}
		if ( !$this->wg->user->isAllowed( 'specialvideohandler' ) ) {
			$this->displayRestrictionError();
			return false;
		}
		if ( wfReadOnly() && !wfAutomaticReadOnly() ) {
			$this->wg->out->readOnlyPage();
			return false;
		}

		$videoId = $this->getVal( 'videoid', null );
		$provider = strtolower( $this->getVal( 'provider', null ) );
		
		if ( $videoId && $provider ) {
			$apiWrapper = F::build( ucfirst( $provider ) . 'ApiWrapper', array( $videoId ) );

			$url = $apiWrapper->getThumbnailUrl();
			$data = array(
				'wpUpload' => 1,
				'wpSourceType' => 'web',
				'wpUploadFileURL' => $url
			);
			$upload = F::build( 'UploadFromUrl' );
			$upload->initializeFromRequest( F::build( 'FauxRequest', array( $data, true ) ) );
			$upload->fetchFile();
			$upload->verifyUpload();

			$file = F::build( 'WikiaLocalFile',
					array(
						Title::newFromText( $apiWrapper->getTitle(), NS_FILE ),
						RepoGroup::singleton()->getLocalRepo()
					)
				);

			$file->forceMime( 'video/'.$provider );
			$file->setVideoId( $videoId );

			$result = $file->upload(
					$upload->getTempPath(),
					'created video',
					'[[Category:New Video]]'.$apiWrapper->getDescription(),
					File::DELETE_SOURCE
				);
			var_dump( $result );
		}
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