<?php

class ApiWrapperFactory {
	protected $videoId;
	protected $classname;
	
	protected static $instance = null;
		
	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new ApiWrapperFactory();
		}
		
		return self::$instance;
	}
	
	/**
	 * Get provider name from id
	 * @param int $id
	 * @return mixed provider name or null
	 */
	public function getProviderNameFromId($id) {
		$providerMap = F::app()->wg->videoMigrationProviderMap;
		if (!empty($providerMap[$id])) {
			return strtolower($providerMap[$id]);
		}
		
		return null;
	}
	
	public function getApiWrapper($url) {
		$url = trim($url);
		$fixed_url = strtoupper( $url );
		$test = strpos( $fixed_url, "HTTP://" );
		if( !false === $test ) {
			return false;
		}
		
		$fixed_url = str_replace( "HTTP://", "", $fixed_url );
		$fixed_parts = explode( "/", $fixed_url );
		$hostname = $fixed_parts[0];

		if ( endsWith($hostname, "METACAFE.COM") ) {
			$this->parseMetacafeUrl($url);
		}
		elseif ( endsWith($hostname, "YOUTUBE.COM")
		|| endsWith($hostname, "YOUTU.BE" ) ) {
			$this->parseYoutubeUrl($url);
		}
		elseif ( endsWith($hostname, "SEVENLOAD.COM") ) {
			$this->parseSevenloadUrl($url);
		}
		elseif ( endsWith($hostname, "MYVIDEO.DE") ) {
			$this->parseMyvideoUrl($url);
		}
		elseif ( endsWith($hostname, "GAMEVIDEOS.1UP.COM") ) {
			$this->parseGamevideosUrl($url);
		}
		elseif ( endsWith($hostname, "VIMEO.COM") ) {
			$this->parseVimeoUrl($url);
		}
		elseif ( endsWith($hostname, "5MIN.COM") ) {
			$this->parseFiveminUrl($url);
		}
		elseif ( endsWith($hostname, "SOUTHPARKSTUDIOS.COM" ) ) {
			$this->parseSouthparkstudiosUrl($url);
		}
		elseif ( endsWith($hostname, "BLIP.TV") ) {
			$this->parseBliptvUrl($url);
		}
		// dailymotion goes like
		// http://www.dailymotion.pl/video/xavqj5_NAME
		// (example for Polish location)
		elseif ( strpos($hostname, "WWW.DAILYMOTION") !== false ) {
			$this->parseDailymotionUrl($url);
		}
		elseif ( endsWith($hostname, "VIDDLER.COM") ) {
			$this->parseViddlerUrl($url);
		}
		elseif ( strpos($hostname, "GAMETRAILERS") !== false ) {
			$this->parseGametrailersUrl($url);
		}
		elseif ( endsWith($hostname, "HULU.COM") ) {
			$this->parseHuluUrl($url);
		}
		elseif ( endsWith($hostname, "MOVIECLIPS.COM" ) ) {
		}

		// Screenplay is not supported by this method
		
		// Realgravity is not supported by this method
		
		//@todo Wikia premium video
		
		//@todo local video		
		
		
		if ($this->classname && $this->videoId) {
			return new $classname($this->videoId);
		}
		
		return null;
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if parsed successfully
	 */
	private function parseMetacafeUrl($url) {
		// reuse some NY stuff for now
		$standard_url = strpos( strtoupper( $url ), "HTTP://WWW.METACAFE.COM/WATCH/" );
		if( false !== $standard_url ) {
			$id = substr( $url , $standard_url+ strlen("HTTP://WWW.METACAFE.COM/WATCH/") , strlen($url) );
			$last_char = substr( $id,-1 ,1 );

			if($last_char == "/"){
				$id = substr( $id , 0 , strlen($id)-1 );
			}

			if ( !( false !== strpos( $id, ".SWF" ) ) ) {
				$id .= ".swf";
			}

			$data = explode( "/", $id );
			if (is_array( $data ) ) {
				$this->classname = 'MetacafeApiWrapper';
				$this->videoId = $data[0];
				return true;
			}
		}		
		
		return false;
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if parsed successfully
	 */
	private function parseYoutubeUrl($url) {

		$aData = array();

		$id = '';
		$parsedUrl = parse_url( $url );
		if ( !empty( $parsedUrl['query'] ) ){
			parse_str( $parsedUrl['query'], $aData );
		};
		if ( isset( $aData['v'] ) ){
			$id = $aData['v'];
		}

		if( empty( $id ) ){
			$parsedUrl = parse_url( $url );

			$aExploded = explode( '/', $parsedUrl['path'] );
			$id = array_pop( $aExploded );
		}

		if( false !== strpos( $id, "&" ) ){
			$parsedId = explode("&",$id);
			$id = $parsedId[0];
		}
		
		if ($id) {
			$this->classname = 'YoutubeApiWrapper';
			$this->videoId = $id;
			return true;			
		}

		return false;
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if parssed successfully 
	 */
	private function parseSevenloadUrl($url) {
		$parsed = explode( "/", $url );
		$id = array_pop( $parsed );
		$parsed_id = explode( "-", $id );
		if( is_array( $parsed_id ) ) {
			//@todo create SevenloadApiWrapper
			/* $this->classname = 'SevenloadApiWrapper'; */
			$this->videoId = $parsed_id[0];
			return true;
		}
		
		return false;		
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if parsed successfully
	 */
	private function parseMyvideoUrl($url) {
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$this->classname = 'MyvideoApiWrapper';
			$this->videoId = array_pop( $parsed );
			return true;
		}
		
		return false;
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if parsed successfully
	 */
	private function parseGamevideosUrl($url) {
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			//@todo create GamevideosApiWrapper
			/*$this->classname = 'GamevideosApiWrapper'; */
			$this->videoId = array_pop( $parsed );
			return true;
		}

		return false;
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if parsed successfully 
	 */
	private function parseVimeoUrl($url) {
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$this->classname = 'VimeoApiWrapper';
			$this->videoId = array_pop( $parsed );
			return true;
		}

		return false;
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if parsed successfully
	 */
	private function parseFiveminUrl($url) {
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$this->classname = 'FiveminApiWrapper';
			$ids = array_pop( $parsed );
			$parsed_twice = explode( "-", $ids );
			$this->videoId = array_pop( $parsed_twice );
			return true;
		}
		
		return false;
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if parsed successfully 
	 */
	private function parseSouthparkstudiosUrl($url) {
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			//@todo create SouthparkstudiosApiWrapper
			/* $this->classname = 'SouthparkstudiosApiWrapper'; */
			$mdata = array_pop( $parsed );
			if ( ('' != $mdata ) && ( false === strpos( $mdata, "?" ) ) ) {
				$this->videoId = $mdata;
			} else {
				$this->videoId = array_pop( $parsed );
			}
			return true;
		}
		
		return false;
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if parsed successfully
	 */
	private function parseBliptvUrl($url) {
		$blip = '';
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$this->classname = 'BliptvApiWrapper';
			$mdata = array_pop( $parsed );
			if ( '' != $mdata ) {
				$blip = $mdata;
			} else {
				$blip = array_pop( $parsed );
			}
			$last = explode( "?", $blip);
			$this->videoId = $last[0];
			return true;
		}
		
		return false;
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if parsed successfully 
	 */
	private function parseDailymotionUrl($url) {
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$this->classname = 'DailymotionApiWrapper';
			$mdata = array_pop( $parsed );
			if ( ('' != $mdata ) && ( false === strpos( $mdata, "?" ) ) ) {
				$this->videoId = $mdata;
			} else {
				$this->videoId = array_pop( $parsed );
			}
			return true;
		}		
		
		return false;
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if parsed successfully 
	 */
	private function parseViddlerUrl($url) {
		$parsed = explode( "/explore/", strtolower($url));
		if( is_array( $parsed ) ) {
			$this->classname = 'ViddlerApiWrapper';
			$mdata = array_pop( $parsed );
			if ( ('' != $mdata ) && ( false === strpos( $mdata, "?" ) ) ) {
				$this->videoId = $mdata;
			} else {
				$this->videoId = array_pop( $parsed );
			}
			if ( substr( $this->mId, -1, 1) != "/" )
			{
				$this->videoId .= "/";
			}
			return true;
		}
		
		return false;
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if successful
	 */
	private function parseGametrailersUrl($url) {
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			//@todo create GametrailersApiWrapper
			/* $this->classname = 'GametrailersApiWrapper'; */
			$id = explode("?",array_pop( $parsed ));
			$this->videoId = $id;
			return true;
		}
		return false;
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if successful
	 */
	private function parseHuluUrl($url) {
		// Hulu goes like
		// http://www.hulu.com/watch/252775/[seo terms]
		$url = trim($url, "/");
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			// mId is a number, and it is either last or second to last element of $parsed
			$last = explode('?', array_pop( $parsed ) );
			$last = $last[0];
			if (is_numeric($last)) {
				$this->videoId = $last;
			}
			else {
				$this->videoId = array_pop($parsed);
			}
			$this->classname = 'HuluApiWrapper';
			return true;
		}
		
		return false;		
	}
	
	/**
	 *
	 * @param string $url
	 * @return boolean true if successful
	 */
	private function parseMovieclipsUrl($url) {
		$url = trim($url, '/');
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$this->classname = 'MovieclipsApiWrapper';
			$this->videoId = array_pop( $parsed );
			return true;
		}
		
		return false;		
	}
}