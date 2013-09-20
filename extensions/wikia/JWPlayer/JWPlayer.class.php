<?php

class JWPlayer {
	const VIDEO_GOOGLE_ANALYTICS_ACCOUNT_ID = 'UA-24709745-1';
	const JWPLAYER_VERSION = '5.9.8';
	const INFOBOX_VERSION = '1';
	const SKIN_VERSION = '3';
	const GOOGIMA_DATA_VARIABLE = 'googimaData';
	const GOOGIMA_DATA_TOKEN = '%GOOGIMADATA%';

	private static $JWPLAYER_DIR = '/wikia/JWPlayer/';
	private static $JWPLAYER_JS = 'jwplayer.min.js';
	private static $JWPLAYER_SWF = 'player.swf';
	private static $JWPLAYER_PLUGIN_HD_SWF = 'hd-2.1.swf';
	private static $BLANK_MP4 = 'blank.mp4';

	protected $playerId;
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

	public function __construct($videoId) {
		$this->videoId = $videoId;
		$this->playerId = 'player-' . $this->videoId . '-' . mt_rand() . '-';
	}

	/**
	 * Get the URL for the JWPlayer javascript asset
	 * @return string
	 */
	public static function getJavascriptPlayerUrl() {
		return self::getAssetUrl(F::app()->wg->ExtensionsPath . self::$JWPLAYER_DIR . self::$JWPLAYER_JS, self::JWPLAYER_VERSION);
	}

	/**
	 * Get the embed code.
	 * NOTE: before calling this method, remake sure to set desired options
	 * with the setXXX() methods
	 * @return string
	 */
	public function getEmbedCode() {
		$jwplayerjs = self::getJavascriptPlayerUrl();

		$html = <<<EOT
<div id="{$this->playerId}"></div>
EOT;

		$jwScript = <<<EOT
var playerId = "{$this->playerId}",
	time = new Date().getTime(),
	container = document.getElementById(playerId),
	newId = playerId + time;
	container.id = newId;

EOT;

		$jwScript .= $this->getCombinedScript();

		$code = array(
			'html' => $html,
			'jsParams' => array(
				'jwScript' => $jwScript,
			),
			'init' => 'wikia.videohandler.jwplayer',
			'scripts' => array(
				$jwplayerjs,
				"extensions/wikia/JWPlayer/js/JWPlayer.js"
			),
		);

		return $code;
	}

	public function getCombinedScript() {
		$script = '';
		//@todo init preroll ad on video detail page
		if ($this->showAd) {
			$script .= $this->getScript('ad');
		}
		if ($this->showAd && $this->ageGate) {
			$script .= $this->getScript('agegate');
			$script .= $this->getScript('preroll');
		}
		else {
			$script .= $this->getScript('normal');
		}
		$script = str_replace('"' . self::GOOGIMA_DATA_TOKEN . '"', self::GOOGIMA_DATA_VARIABLE, $script);
		$script = str_replace('"' . $this->playerId . '"', 'newId', $script);

		return $script;
	}

	protected function getScript($mode='normal') {
		$script = '';

		switch ($mode) {
			case 'normal':
				$jwplayerConfigJSON = json_encode_jsfunc( $this->getPlayerConfig($this->url, $mode) );
				$script = "jwplayer(\"{$this->playerId}\").setup($jwplayerConfigJSON);\n";
				break;
			case 'preroll':
				$file = self::getAssetUrl(F::app()->wg->ExtensionsPath . self::$JWPLAYER_DIR . self::$BLANK_MP4, self::JWPLAYER_VERSION);
				$prerollPlayerConfigJSON = json_encode_jsfunc( $this->getPlayerConfig($file, $mode) );
				$script = "jwplayer(\"{$this->playerId}\").setup($prerollPlayerConfigJSON);\n";
				break;
			case 'agegate':
				$agegatePlayerConfigJSON = json_encode_jsfunc( $this->getPlayerConfig($this->url, $mode) );
				$script = "jwplayer(\"{$this->playerId}\").setup($agegatePlayerConfigJSON);\n";
				break;
			case 'ad':
				$googimaDataVariable = self::GOOGIMA_DATA_VARIABLE;
				$jwplayerAdMessage = wfMsg('jwplayer-ad-message');
				$script = <<<EOT
if (window.wikiaDartHelper && (!window.wgUserName || window.wgUserShowAds)) {
	var jwplayer_ad_tag = wikiaDartHelper.getUrl({
		slotname: 'JWPLAYER',
		slotsize: '320x240',
		adType: 'pfadx',
		src: 'jwplayer'
	});
	$googimaDataVariable = {
        'ad.position': 'pre',
        'ad.bandwidth': 'high',
        'admessagedynamic': '$jwplayerAdMessage',
        'admessagedynamickey': 'XX',
        'scaled_ads': 'false',
        'ad.tag': jwplayer_ad_tag
    };
}
else {
    $googimaDataVariable = null;
}

EOT;
				break;
			default:
		}

		return $script;
	}

	protected function getPlayerConfig($file, $mode='normal') {
		switch ($mode) {
			case 'normal':
				$autostart = $this->autoplay;
				$image = (!empty($this->thumbUrl) && empty($this->autoplay)) ? $this->thumbUrl : '';
				break;
			case 'preroll':
				$autostart = $this->autoplay;
				$image = (!empty($this->thumbUrl) && empty($this->autoplay)) ? $this->thumbUrl : '';
				$events = array('onPlay'=>'function(){ loadAgegatePlayer(); }');
				break;
			case 'agegate':
				$autostart = true;
				$image = '';
				break;
			default:
				$autostart = $this->autoplay;
				$image = '';
		}


		// NOTE: if the JW Player is embedded in an article (not loaded
		// by AJAX), all URLs within the config need to be escaped
		// to prevent the parser from linkifying them. One way to do
		// this is decodeURIComponent($url)
		$jwplayerConfig = array(
		    'id'	=> $this->playerId,
		    'width'	=> $this->width,
		    'height'	=> $this->height,
		    'file'	=> $file,
		    'modes'	=> array(
			array('type'=>'flash','src'=>self::getAssetUrl( F::app()->wg->ExtensionsPath . self::$JWPLAYER_DIR . self::$JWPLAYER_SWF, self::JWPLAYER_VERSION )),
			array('type'=>'html5', 'config'=>array( 'file'=>$file, 'provider'=>'video') ),
			array('type'=>'download', 'config'=>array( 'file'=>$file, 'provider'=>'video') )
			),
		    'autostart'	=> $autostart,
		    'stretching'=> 'uniform',
		    'controlbar.position' => 'over',
		    'dock'	=> 'false',
		    'skin'	=> $this->getSkinUrl(),
		    'provider'	=> 'video'
		);
		if (!empty($image)) {
			$jwplayerConfig['image'] = $image;
		}
		if ($this->duration && $mode != 'preroll') {
			$jwplayerConfig['duration'] = $this->duration;
		}
		if (!empty($events)) {
			$jwplayerConfig['events'] = $events;
		}
		$jwplayerConfig['plugins'] = $this->getPlugins($mode);

		return $jwplayerConfig;
	}

	protected function getSkinUrl() {
		if ($this->width < 330) {
			$wikiaSkinZip = 'wikia-small.zip';
		}
		elseif ($this->width >= 660) {
			$wikiaSkinZip = 'wikia.zip';
		}
		else {
			$wikiaSkinZip = 'wikia-medium.zip';
		}

		return self::getAssetUrl( F::app()->wg->ExtensionsPath . self::$JWPLAYER_DIR . 'skins/wikia/'.$wikiaSkinZip, self::SKIN_VERSION );
	}

	protected function getPlugins($mode='normal') {
		switch ($mode) {
			case 'normal':
				$canDisplayAgegate = true;
				$googima = true;
				break;
			case 'preroll':
				$canDisplayAgegate = false;
				$googima = true;
				break;
			case 'agegate':
				$canDisplayAgegate = true;
				$googima = false;
				break;
			default:
				$canDisplayAgegate = false;
				$googima = true;
		}

		$plugins = array('gapro-1'=>array('accountid'=>self::VIDEO_GOOGLE_ANALYTICS_ACCOUNT_ID),
						'timeslidertooltipplugin-3'=>array(),
                        // wlee 2012/04/14: turning off infobox.js due to a conflict with pre-roll ads (https://wikia.fogbugz.com/default.asp?20871)
						//self::getAssetUrl(F::app()->wg->ExtensionsPath.self::$JWPLAYER_DIR.self::$JWPLAYER_JS_PLUGINS_DIR .'infobox.js', self::INFOBOX_VERSION)=>array('title'=>htmlspecialchars($this->title))
						);

		if ($this->hd) {
			if ($this->hdFile) {
				$plugins[self::getAssetUrl(F::app()->wg->ExtensionsPath . self::$JWPLAYER_DIR . self::$JWPLAYER_PLUGIN_HD_SWF, self::JWPLAYER_VERSION)] = array('file'=>$this->hdFile, 'state'=>'false');  // when player embedded in action=render page, the file URL is automatically linkified. prevent this behavior
			}
			else {
				$plugins[self::getAssetUrl(F::app()->wg->ExtensionsPath . self::$JWPLAYER_DIR . self::$JWPLAYER_PLUGIN_HD_SWF, self::JWPLAYER_VERSION)] = array();
			}
		}

		// ad
		// show ads to logged-out users or users with the pref set
		if ($googima
		&& (F::app()->wg->User->isAnon() || F::app()->wg->User->getOption('showAds'))) {
			// NOTE: ad config is initialized in self::getScript() because
			// ad.tag's cannot be quoted. If ad.tag is set on server side, it
			// will be quoted by json_encode()
			// NOTE: when enabling the googima plugin, all settings must be
			// non-null, especially ad.tag. If you do not want to serve an ad
			// at all, it is not enough to set ad.tag to null. You must unset
			// the entire googima object!
			$plugins['googima'] = self::GOOGIMA_DATA_TOKEN;
		}

		// age gate
		// NOTE: this code must be before the thumb section
		if ($this->ageGate && $canDisplayAgegate) {
			$agegateOptions = array(
			    'cookielife' => 60*24*365,	// cookielife in minutes
			    'message' => wfMsg('jwplayer-agegate-message'),
			    'minage' => 17
			    );
			$plugins['agegate-3'] = $agegateOptions;
		}

		return $plugins;
	}

	/**
	 * Set the article id
	 * @param int $id
	 */
	public function setArticleId($id) {
		$this->articleId = $id;
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
