<?php
class BliptvApiWrapper extends ApiWrapper {
	
	protected static $API_URL = 'http://blip.tv/a/b-$1?skin=json';
	protected static $CACHE_KEY = 'bliptvapi';
	protected static $aspectRatio = 1.7777778;

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "blip.tv") ? true : false;
	}

	public static function newFromUrl( $url ) {

		wfProfileIn( __METHOD__ );
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$mdata = array_pop( $parsed );
			if ( '' != $mdata ) {
				$blip = $mdata;
			} else {
				$blip = array_pop( $parsed );
			}
			$last = explode( "?", $blip);
			$videoId = $last[0];
			wfProfileOut( __METHOD__ );
			return new static( $videoId );
		}
		wfProfileOut( __METHOD__ );
		return null;
	}


	protected function processResponse( $response ) {

		wfProfileIn( __METHOD__ );
		$replaced_count = 0;
		$response = str_replace( "blip_ws_results([[{", "[{", $response, $replaced_count );
		if($replaced_count > 0) {
			$response = str_replace( "]);", "", $response );
		}
		else
		{
			$response = str_replace( "blip_ws_results([{", "[{", $response, $replaced_count );
			$response = str_replace( "]);", "]", $response );
		}		 
		wfProfileOut( __METHOD__ );
		return parent::processResponse( $response );
	}

	protected function postProcess( $return ){
		return $return[0]['Post'];
	}	  
	
	public function getVideoTitle() {
		$title = $this->interfaceObj['title'];
		if ( !empty( $this->interfaceObj['showName'] ) ) {
			$title = $this->interfaceObj['showName'] . " - " . $title;
		}
		return $title;
	}
	
	public function getVideoPublished() {
		if ( !empty( $this->interfaceObj['datestamp'] ) ) {
			$d = date_create_from_format('m-d-y g:ia', $this->interfaceObj['datestamp']);
			return $d !== false ? $d->format("U") : '';
		}
		return '';
	}

	public function getVideoCategory(){
		return $this->interfaceObj['categoryName'];
	}	  
	
	public function getDescription() {
		wfProfileIn( __METHOD__ );
		$text = $this->interfaceObj['description'];
		if ( $this->getVideoKeywords() ) $text .= "\n\nKeywords: {$this->getVideoKeywords()}";
		wfProfileOut( __METHOD__ );
		return $text;
	}

	public function getThumbnailUrl() {
		return $this->interfaceObj['thumbnailUrl'];
	}
	
	protected function getAltVideoId() {
		return $this->interfaceObj['embedLookup'];
	}	 
	
	protected function getVideoKeywords() {
		
		if (is_array( $this->interfaceObj['tags'] )) {
			$keywords = array();
			foreach ( $this->interfaceObj['tags'] as $tag ) {
				$keywords[] = $tag['name'];
			}
			return implode( ', ', $keywords );
		}

		return '';
	}

}
