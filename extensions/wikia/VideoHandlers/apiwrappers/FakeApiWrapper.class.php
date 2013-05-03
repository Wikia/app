<?php

class FakeApiWrapper extends ApiWrapper {
	public function __construct( $videoName ) {

		wfProfileIn( __METHOD__ );

		$app = F::app();
		
		$dbr = wfGetDB( DB_SLAVE );
		
		$meta = $dbr->selectField(
			'image',
			'img_metadata',
			array('img_name' => ':' . $videoName)
		);
		
		$videoId = '';
		if ( $meta ) {
			$metaArray = explode(',', $meta);
			$videoId = $metaArray[1];
		}

		$this->videoId		= $videoId;
		$this->videoName	= $videoName;

		wfProfileOut( __METHOD__ );
	}
	
	protected function getVideoTitle() {
		return $this->videoName;
	}
		
	public function getDescription() {
		return '';
	}
	
	public function getThumbnailUrl() {
		return '';
	}

	protected function getVideoPublished(){
		return '';
	}

	protected function getVideoCategory(){
		return '';
	}

	protected function canEmbed(){
		return true;
	}

	protected function getOriginalDescription(){
		return '';
	}

	protected function isHdAvailable(){
		return false;
	}

	protected function getVideoKeywords(){
		return '';
	}

	protected function getVideoDuration(){
		return '';
	}

	public function getAspectRatio(){
		return '';
	}

	protected function getAltVideoId() {
		return '';
	}

}