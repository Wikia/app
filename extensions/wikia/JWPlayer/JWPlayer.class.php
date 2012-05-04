<?php

class JWPlayer {
	const VIDEO_GOOGLE_ANALYTICS_ACCOUNT_ID = 'UA-24709745-1';
	const JWPLAYER_VERSION = '5.9.5';
	const INFOBOX_VERSION = '1';
	const SKIN_VERSION = '3';

	private static $JWPLAYER_DIR = '/wikia/JWPlayer/';
	private static $JWPLAYER_JS = 'jwplayer.min.js';
	private static $JWPLAYER_SWF = 'player.swf';
	private static $JWPLAYER_JS_PLUGINS_DIR = 'plugins/js/';
	private static $JWPLAYER_PLUGIN_AGEGATE_JS = 'agegate3.js';	
	private static $JWPLAYER_PLUGIN_HD_JS = 'hd-2.1.min.js';
	private static $JWPLAYER_PLUGIN_HD_SWF = 'hd-2.1.swf';	
	private static $JWPLAYER_GOOGIMA_DATA;
	
	protected $articleId;
	protected $videoId;		// unique id of clip
	protected $url;			// url of clip
	protected $title;		// title of clip
	protected $width;		// width of the player
	protected $height;		// height of player
	protected $showAd;		// show ad in player?
	protected $duration;		// duration of clip (in seconds)
	protected $hd;			// is clip in hd?
	protected $hdFile;		// location of hd stream
	protected $thumbUrl;		// location of thumbnail
	protected $autoplay = true;	// does video start playing when page loads?
	protected $ageGate = false;	// is video age-gated?
	protected $ajax = true;		// is player loaded by ajax?
	protected $postOnload = false;	// is player loaded after the page onload event?
	protected $playerOptions;	// misc options
	
	public function __construct() {
		// note: self::$JWPLAYER_GOOGIMA_DATA['ad.tag'] must be initialized elsewhere,
		// before the JWPlayer is rendered
		self::$JWPLAYER_GOOGIMA_DATA = 
			array('ad.position'=>'pre', 'ad.bandwidth'=>'high',
				'admessagedynamic'=>F::app()->wf->Msg('jwplayer-ad-message'), 'admessagedynamickey'=>'XX',
				//'allowadskip'=>'true', 'allowadskippastseconds'=>5,	// wlee 11/1/11: do not skip ads yet
				'scaled_ads'=>'false'
			    );
	}
	
	/**
	 * Get the URL for the JWPlayer javascript asset
	 * @return string
	 */
	public function getJavascriptPlayerUrl() {
		return self::getAssetUrl(F::app()->wg->ExtensionsPath . self::$JWPLAYER_DIR . self::$JWPLAYER_JS, self::JWPLAYER_VERSION);
	}
	
	/**
	 * Get the embed code.
	 * NOTE: before calling this method, remake sure to set desired options 
	 * with the setXXX() methods
	 * @return string
	 */
	public function getEmbedCode() {
		$jwplayerData = array();
		$jwplayerData['jwplayerjs'] = self::getJavascriptPlayerUrl();
		$jwplayerData['player'] = self::getAssetUrl( F::app()->wg->ExtensionsPath . self::$JWPLAYER_DIR . self::$JWPLAYER_SWF, self::JWPLAYER_VERSION );
		$jwplayerData['playerId'] = 'player-'.$this->videoId.'-'.mt_rand();
		$jwplayerData['plugins'] = array('gapro-1'=>array('accountid'=>self::VIDEO_GOOGLE_ANALYTICS_ACCOUNT_ID),
						'timeslidertooltipplugin-2'=>array(), 
                        // wlee 2012/04/14: turning off infobox.js due to a conflict with pre-roll ads (https://wikia.fogbugz.com/default.asp?20871)
						//self::getAssetUrl(F::app()->wg->ExtensionsPath.self::$JWPLAYER_DIR.self::$JWPLAYER_JS_PLUGINS_DIR .'infobox.js', self::INFOBOX_VERSION)=>array('title'=>htmlspecialchars($this->title))
						);
		
		$jwplayerData['file'] = $this->url;

		// skin
		if ($this->width < 330) {
			$wikiaSkinZip = 'wikia-small.zip';
		}
		elseif ($this->width >= 660) {
			$wikiaSkinZip = 'wikia.zip';			
		}
		else {
			$wikiaSkinZip = 'wikia-medium.zip';			
		}
		$jwplayerData['skin'] = self::getAssetUrl( F::app()->wg->ExtensionsPath . self::$JWPLAYER_DIR . 'skins/wikia/'.$wikiaSkinZip, self::SKIN_VERSION );

		// duration
		if ($this->duration) {
			$jwplayerData['duration'] = $this->duration;
		}
		
		// PLUGINS
		
		// HD
		if ($this->hd) {
			if ($this->hdFile) {
				$jwplayerData['plugins'][self::getAssetUrl(F::app()->wg->ExtensionsPath . self::$JWPLAYER_DIR . self::$JWPLAYER_PLUGIN_HD_SWF, self::JWPLAYER_VERSION)] = array('file'=>$this->hdFile, 'state'=>'false');  // when player embedded in action=render page, the file URL is automatically linkified. prevent this behavior			
			}
			else {
				$jwplayerData['plugins'][self::getAssetUrl(F::app()->wg->ExtensionsPath . self::$JWPLAYER_DIR . self::$JWPLAYER_PLUGIN_HD_SWF, self::JWPLAYER_VERSION)] = array();
			}
		}

		// ad
		if ($this->showAd) {
			// note: self::$JWPLAYER_GOOGIMA_DATA['ad.tag'] must be initialized elsewhere,
			// before the JWPlayer is rendered
			$jwplayerData['plugins']['googima'] = self::$JWPLAYER_GOOGIMA_DATA;
		}
		
		// age gate
		// NOTE: this code must be before the thumb section
		if ($this->ageGate) {
			$agegateOptions = array(
			    'cookielife'=>60*24*365,	// cookielife in minutes
			    'message'=>F::app()->wf->Msg('jwplayer-agegate-message'),
			    'minage'=>17
			    );
			$jwplayerData['plugins'][self::getAssetUrl(F::app()->wg->ExtensionsPath . self::$JWPLAYER_DIR . self::$JWPLAYER_PLUGIN_AGEGATE_JS, self::JWPLAYER_VERSION)] = $agegateOptions;
			// autoplay is not compatible with age gate. force thumb to appear
			$this->autoplay = false;	// plugin autoplays automatically if this option set to false
		}
		
		// thumb
		if (!empty($this->thumbUrl) && empty($this->autoplay)) {
			$jwplayerData['image'] = $this->thumbUrl;
		}

		// addl params
		$jwplayerData = array_merge($jwplayerData, $this->playerOptions);

		// jwplayer config
		// NOTE: if the JW Player is embedded in an article (not loaded
		// by AJAX), all URLs within the config need to be escaped
		// to prevent the parser from linkifying them. One way to do
		// this is decodeURIComponent($url)
		$jwplayerConfig = array(
		    'id'	=> $jwplayerData['playerId'],
		    'width'	=> $this->width,
		    'height'	=> $this->height,
		    'file'	=> $jwplayerData['file'],
		    'modes'	=> array(
			array('type'=>'flash','src'=>$jwplayerData['player']),
			array('type'=>'html5', 'config'=>array( 'file'=>$jwplayerData['file'], 'provider'=>'video') ),
			array('type'=>'download', 'config'=>array( 'file'=>$jwplayerData['file'], 'provider'=>'video') )
			),
		    'autostart'	=> $this->autoplay ? 'true' : 'false',
		    'stretching'=> 'uniform',
		    'controlbar.position' => 'over',
		    'dock'	=> 'false',
		    'skin'	=> $jwplayerData['skin']		    
		);
		if (!empty($jwplayerData['image'])) {
			$jwplayerConfig['image'] = $jwplayerData['image'];
		}
		if (!empty($jwplayerData['provider'])) {
			$jwplayerConfig['provider'] = $jwplayerData['provider'];
		}
		if (!empty($jwplayerData['duration'])) {
			$jwplayerConfig['duration'] = $jwplayerData['duration'];
		}
		if (!empty($jwplayerData['plugins'])) {
			$jwplayerConfig['plugins'] = $jwplayerData['plugins'];
		}
				
		$code = '';
		if ($this->ajax) {
			$code = $jwplayerConfig;
		}
		else {
			$jwplayerConfigJSON = json_encode($jwplayerConfig);
			$code = <<<EOT
<div id="{$jwplayerData['playerId']}"></div>
<script type="text/javascript">
EOT;
			if (!$this->postOnload) {
				$code .= <<<EOT
	wgAfterContentAndJS.push( function() {
EOT;
			}
			
			$code .= <<<EOT
		$.getScript("{$jwplayerData['jwplayerjs']}", function() { jwplayer("{$jwplayerData['playerId']}").setup($jwplayerConfigJSON); });
EOT;
		
			if (!$this->postOnload) {
				$code .= <<<EOT
	});       
EOT;
			}
			
			$code .= <<<EOT
</script>
EOT;
		}
		
		return $code;
	}
	
	/**
	 * Set the article id
	 * @param int $id 
	 */
	public function setArticleId($id) {
		$this->articleId = $id;
	}
	
	/**
	 * Set the video's id (assigned by video provider)
	 * @param string $id 
	 */
	public function setVideoId($id) {
		$this->videoId = $id;
	}
	
	/**
	 * Set the url to the video
	 * @param string $url 
	 */
	public function setUrl($url) {
		$this->url = $url;
	}
	
	/**
	 * Set the video's title
	 * @param string $title 
	 */
	public function setTitle($title) {
		$this->title = $title;
	}
	
	/**
	 * Set the player's width
	 * @param int $width 
	 */
	public function setWidth($width) {
		$this->width = $width;
	}
	
	/**
	 * Set the player's height
	 * @param int $height 
	 */
	public function setHeight($height) {
		$this->height = $height;
	}
	
	/**
	 * Should the player show an ad?
	 * @param boolean $showAd 
	 */
	public function setShowAd($showAd) {
		$this->showAd = $showAd;
	}
	
	/**
	 * Set the video's duration
	 * @param int $duration number of seconds
	 */
	public function setDuration($duration) {
		$this->duration = $duration;
	}
	
	/**
	 * Does the video have an HD stream?
	 * @param boolean $isHd 
	 */
	public function setHd($isHd) {
		$this->hd = $isHd;
	}
	
	/**
	 * Set the video's HD stream location
	 * @param string $hdFile 
	 */
	public function setHdFile($hdFile) {
		$this->hdFile = $hdFile;
	}
	
	/**
	 * Set the video's thumbnail location
	 * @param string $thumbUrl
	 */
	public function setThumbUrl($thumbUrl) {
		$this->thumbUrl = $thumbUrl;
	}
	
	/**
	 * Should the player start playing video as soon as the player loads?
	 * @param boolean $isAutoplay 
	 */
	public function setAutoplay($isAutoplay) {
		$this->autoplay = $isAutoplay;
	}
	
	/**
	 * Should the player show an age gate for restricted content?
	 * @param boolean $isAgeGate 
	 */
	public function setAgeGate($isAgeGate) {
		$this->ageGate = $isAgeGate;
	}
	
	/**
	 * Is the player being loaded via AJAX request?
	 * @param boolean $isAjax 
	 */
	public function setAjax($isAjax) {
		$this->ajax = $isAjax;
	}
	
	/**
	 * Is the player being loaded after the page's onload event?
	 * @param boolean $postOnload 
	 */
	public function setPostOnload($postOnload) {
		$this->postOnload = $postOnload;
	}
	
	/**
	 * Set miscelleneous JW Player options
	 * @param array $options
	 */
	public function setPlayerOptions($options) {
		$this->playerOptions = $options;
	}
	
	/**
	 * Get an asset URL, with the version (or cache buster) appended
	 * @param string $url
	 * @param string $version
	 * @return string
	 */
	protected function getAssetUrl($url, $version) {
		//@todo use cachebusting value or cachebuster framework
		return $url . '?v=' . $version;
	}
}
