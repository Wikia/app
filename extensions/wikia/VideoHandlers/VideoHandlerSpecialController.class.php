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
		$undercover = $this->getVal( 'undercover', false );
		
		if ( $videoId && $provider ) {
			$result = VideoHandlersUploader::uploadVideo($provider, $videoId, $title, null, $undercover);
        
			$this->setVal( 'uploadStatus', $result->ok );
			$this->setVal( 'isNewFile', empty( $result->value ) );
			$this->setVal( 'title', $title->getText() );
			$this->setVal( 'url', $title->getFullURL() );
		}
	}
	
}