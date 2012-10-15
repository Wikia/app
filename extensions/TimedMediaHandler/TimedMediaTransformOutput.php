<?php 

class TimedMediaTransformOutput extends MediaTransformOutput {
	static $serial = 0;
	
	// Video file sources object lazy init in getSources()
	var $sources = null;
	var $textTracks = null;
	var $hashTime = null;
	var $textHandler = null; // lazy init in getTextHandler
	
	// The prefix for player ids
	const PLAYER_ID_PREFIX = 'mwe_player_';
	
	function __construct( $conf ){
		$options = array( 'file', 'dstPath', 'sources', 'thumbUrl', 'start', 'end', 'width', 'height', 'length', 'offset', 'isVideo', 'path' );
		foreach ( $options as $key ) {
			if( isset( $conf[ $key ]) ){
				$this->$key = $conf[$key];
			} else {
				$this->$key = false;
			}
		}
	}
	
	function getTextHandler(){
		if( !$this->textHandler ){
			// Init an associated textHandler
			$this->textHandler = new TextHandler( $this->file );
		}
		return $this->textHandler; 
	}
	/**
	 * Get the media transform thumbnail
	 */
	function getUrl(){
		global $wgStylePath;
		if ( $this->isVideo && $this->thumbUrl ) {
			return $this->thumbUrl;
		}
		// else return the fileicon for the poster url: 
		return "$wgStylePath/common/images/icons/fileicon-ogg.png";		
	}
	
	// TODO get the local path
	function getPath(){
		return $this->dstPath;
	}
	
	function getPlayerHeight(){
		// Check if "video" tag output:
		if ( $this->isVideo ) {
			return intval( $this->height );
		} else {
			// Give sound files a height of 23px
			return 23;
		}
	}
	
	function getTagName(){		
		return ( $this->isVideo ) ? 'video' : 'audio';
	}
	
	function toHtml( $options = array() ) {
		global $wgVideoTagOut, $wgMinimumVideoPlayerSize, $wgOut;

		
		if ( count( func_get_args() ) == 2 ) {
			throw new MWException( __METHOD__ .' called in the old style' );
		}
			
		// Check if the video is too small to play inline ( instead do a pop-up dialog ) 
		if( $this->width <= $wgMinimumVideoPlayerSize && $this->isVideo ){
			return $this->getImagePopUp();
		} else {
			return $this->getHtmlMediaTagOutput();
		}		
	}
	// XXX migrate this to the mediawiki Html class as 'tagSet' helper function
	static function htmlTagSet( $tagName, $tagSet ){
		$s = '';
		if( empty( $tagSet ) ){
			return '';
		}
		foreach( $tagSet as $attr ){
			$s .= Html::element( $tagName, $attr);
		}
		return $s;
	}
	
	function getImagePopUp(){
		return Xml::tags( 'div' , array(
				'id' => self::PLAYER_ID_PREFIX . TimedMediaTransformOutput::$serial++,
				'class' => 'PopUpMediaTransform',
				'style' => "width:" . intval( $this->width ) . "px;height:" . 
							intval( $this->height ) . "px",
				'data-videopayload' => $this->getHtmlMediaTagOutput( $this->getPopupPlayerSize() ),
				),
			Xml::tags( 'img', array(
				'style' => "width:" . intval( $this->width ) . "px;height:" . 
							intval( $this->height ) . "px",
				'src' =>  $this->getUrl(),
			),'')
			.
			// For javascript disabled browsers provide a link to the asset:
			Xml::tags( 'a', array(
					'href'=> $this->file->getUrl(),
					'title' => wfMsg( 'timedmedia-play-media' ),
					'target' => 'new'
				), '<b></b>'. // why is the a child tag escaped unless there is an html string prefix? 
				Xml::tags( 'div', array(
						'class' => 'play-btn-large'
					), '' )
			)
		);
	}
	
	/**
	 * Get target popup player size 
	 */
	function getPopupPlayerSize(){
		// Get the max width from the enabled transcode settings: 
		$maxImageSize = WebVideoTranscode::getMaxSizeWebStream();
		return WebVideoTranscode::getMaxSizeTransform( $this->file, $maxImageSize);
	}
	
	/**
	 * Call mediaWiki xml helper class to build media tag output from 
	 * supplied arrays
	 */
	function getHtmlMediaTagOutput( $sizeOverride = array() ){
		// Try to get the first source src attribute ( usually this should be the source file )
		$mediaSources = $this->getMediaSources();
		$firstSource = current( $mediaSources );
		if( !$firstSource['src'] ){
			// XXX media handlers don't seem to work with exceptions..
			return 'Error missing media source';
		};
		// Build the video tag output:		
		$s = Html::rawElement( $this->getTagName(), $this->getMediaAttr( $sizeOverride ),
	
			// The set of media sources: 
			self::htmlTagSet( 'source', $mediaSources ) .
			
			// Timed text: 
			self::htmlTagSet( 'track', $this->getTextHandler()->getTracks() ) .		
			
			// Fallback text displayed for browsers without js and without video tag support: 
			/// XXX note we may want to replace this with an image and download link play button
			wfMsg( 'timedmedia-no-player-js', $firstSource['src'] )
		);
		return $s;
	}
	
	/**
	 * Get a poster image from the api
	 * @param Number, the width of the requested image 
	 */
	function getPosterFromApi ( $width ){		
		// The media system is ~kind of~ strange. ( how do we get an alternate sized thumb url? )
		// without going into some crazy object cloning or handler lookups path of least resistance, 
		// seems to just do an inline FauxRequest: 
		$params = new FauxRequest( array(
	        'action' => 'query',
	        'prop' => 'imageinfo',
	        'iiprop' => 'url',
	        'iiurlwidth' => intval( $width ),
	        'titles' => $this->file->getTitle()->getPrefixedDBkey()
		) );
		$api = new ApiMain( $params );
		$api->execute();
		$data = $api->getResultData();
		if( isset( $data['query'] ) && isset( $data['query']['pages'] ) ){
			$page = current( $data['query']['pages'] );
			if( isset( $page['imageinfo'] ) && isset( $page['imageinfo'][0]['thumburl'] ) ){
				return $page['imageinfo'][0]['thumburl'];
			}
		}
		return false;
		// no posterUrl found ( but its oky we still have the poster form $this->getUrl() )
	}
	
	/**
	 * Get the media attributes
	 * @param $sizeOverride {Array} of width and height
	 */ 
	function getMediaAttr( $sizeOverride = false ){
		global $wgVideoPlayerSkin ;
		// Normalize values
		$length = floatval( $this->length  );
		$offset = floatval( $this->offset );
		
		$width = $sizeOverride ? $sizeOverride[0] : $this->width;
		$height = $sizeOverride ? $sizeOverride[1]: $this->height;
	
		// The poster url:
		$posterUrl = $this->getUrl();
		
		// Update the $posterUrl to $sizeOverride ( if not an old file ) 
		if( !$this->file->isOld() && $sizeOverride && $sizeOverride[0] && intval( $sizeOverride[0] ) != intval( $this->width ) ){			
			$apiUrl = $this->getPosterFromApi( $sizeOverride[0] );
			if( $apiUrl ){
				$posterUrl = $apiUrl;
			}
		}
		$mediaAttr = array(
			'id' => self::PLAYER_ID_PREFIX . TimedMediaTransformOutput::$serial++,
			'style' => "width:{$width}px;height:{$height}px",
			// also set direct width height attributes for IE html elements to retain properties:
			'width' => $width,
			'height' => $height,
			// Get the correct size: 
			'poster' => $posterUrl,

			// Note we set controls to true ( for no-js players ) when mwEmbed rewrites the interface
			// it updates the controls attribute of the embed video
			'controls'=> 'true',
		);
		
		// Set player skin:
		if( $wgVideoPlayerSkin ){
			$mediaAttr['class'] = htmlspecialchars ( $wgVideoPlayerSkin );
		}
		
		// Custom data-attributes
		$mediaAttr += array(			
			'data-durationhint' => $length,
			'data-startoffset' => $offset,
			'data-mwtitle' => $this->file->getTitle()->getDBKey()
		);
		
		// Add api provider:		
		if( !$this->file->isLocal() ){			
			// Set the api provider name to "commons" for shared ( instant commons convention ) 
			// ( provider names should have identified the provider
			// instead of the provider type "shared" )
			$apiProviderName = $this->file->getRepoName();
			if( $apiProviderName == 'shared' || $apiProviderName == 'wikimediacommons' ) {
				$apiProviderName = 'commons';
			}
		} else {
			$apiProviderName = 'local';
		}
		// XXX Note: will probably migrate mwprovider to an escaped api url.
		$mediaAttr[ 'data-mwprovider' ] = $apiProviderName;
		
		return $mediaAttr;
	}
	
	function getMediaSources(){
		if( !$this->sources ){
			// Generate transcode jobs ( and get sources that area already transcoded)
			// At a minimum this should return the source video file. 
			$this->sources = WebVideoTranscode::getSources( $this->file );	
			// Check if we have "start or end" times and append the temporal url fragment hash
			foreach( $this->sources as &$source ){
				$source['src'].= $this->getTemporalUrlHash();
			}			
		}
		return $this->sources;
	}
	
	function getTemporalUrlHash(){
		if( $this->hashTime ){
			return $this->hashTime;
		}
		$hash ='';
		if( $this->start ){
			$startSec = TimedMediaHandler::parseTimeString( $this->start );
			if( $startSec !== false ){
				$hash.= '#t=' . TimedMediaHandler::seconds2npt( $startSec );
			}
		}
		if( $this->end ){
			if( $hash == '' ){
				$hash .= '#t=0';
			}
			$endSec = TimedMediaHandler::parseTimeString( $this->end );
			if( $endSec !== false ){
				$hash.= ',' . TimedMediaHandler::seconds2npt( $endSec );
			}
		}
		$this->hashTime = $hash;
		return $this->hashTime;
	}	
}
