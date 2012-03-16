<?php

class JWPlayer {
	const VIDEO_GOOGLE_ANALYTICS_ACCOUNT_ID = 'UA-24709745-1';
	const JWPLAYER_VERSION = '5.9';
	const INFOBOX_VERSION = '1';
	const SKIN_VERSION = '1';

	private static $JWPLAYER_DIR = '/wikia/JWPlayer/';
	private static $JWPLAYER_JS = 'jwplayer.min.js';
	private static $JWPLAYER_SWF = 'player.swf';
	private static $JWPLAYER_JS_PLUGINS_DIR = 'plugins/js/';
	private static $JWPLAYER_PLUGIN_HD_JS = 'hd-2.1.min.js';
	private static $JWPLAYER_PLUGIN_HD_SWF = 'hd-2.1.swf';
	
	// ad.tag must be initialized somewhere in this class!
	private static $JWPLAYER_GOOGIMA_DATA = 
		array('ad.tag'=>'', 'ad.position'=>'pre', 'ad.bandwidth'=>'high',
			'admessagedynamic'=>'Your video will play in XX seconds', 'admessagedynamickey'=>'XX',
			//'allowadskip'=>'true', 'allowadskippastseconds'=>5,	// wlee 11/1/11: do not skip ads yet
			'scaled_ads'=>'false'
		    );
	
	public static function getJavascriptPlayerUrl() {
		global $wgExtensionsPath;
		
		return self::getAssetUrl($wgExtensionsPath . self::$JWPLAYER_DIR . self::$JWPLAYER_JS, self::JWPLAYER_VERSION);
	}
	
	public static function getEmbedCode($articleId, $videoid, $url, $title, $width, $height, $showAd, $duration, $isHd, $hdfile='', $thumbUrl='', $cityShort='life', $autoplay=true, $isAjax=true, $postOnload=false, $playerOptions=array()) {
		global $wgExtensionsPath;
		
		$jwplayerData = array();
		$jwplayerData['jwplayerjs'] = self::getJavascriptPlayerUrl();
		$jwplayerData['player'] = self::getAssetUrl( $wgExtensionsPath . self::$JWPLAYER_DIR . self::$JWPLAYER_SWF, self::JWPLAYER_VERSION );
		$jwplayerData['playerId'] = 'player-'.$videoid.'-'.mt_rand();
		$jwplayerData['plugins'] = array('gapro-1'=>array('accountid'=>self::VIDEO_GOOGLE_ANALYTICS_ACCOUNT_ID),
						'timeslidertooltipplugin-2'=>array(), 
						self::getAssetUrl($wgExtensionsPath.self::$JWPLAYER_DIR.self::$JWPLAYER_JS_PLUGINS_DIR .'infobox.js', self::INFOBOX_VERSION)=>array('title'=>htmlspecialchars($title))
						);
		
		$jwplayerData['file'] = $url;

		// skin
		if ($width < 330) {
			$wikiaSkinZip = 'wikia-small.zip';
		}
		elseif ($width >= 660) {
			$wikiaSkinZip = 'wikia.zip';			
		}
		else {
			$wikiaSkinZip = 'wikia-medium.zip';			
		}
		$jwplayerData['skin'] = self::getAssetUrl( $wgExtensionsPath . self::$JWPLAYER_DIR . 'skins/wikia/'.$wikiaSkinZip, self::SKIN_VERSION );
	
		// thumb
		if (!empty($thumbUrl) && empty($autoplay)) {
			$jwplayerData['image'] = $thumbUrl;
		}

		// duration
		if ($duration) {
			$jwplayerData['duration'] = $duration;
		}
		
		// HD
		if ($isHd) {
			if ($hdfile) {
				$jwplayerData['plugins'][self::getAssetUrl($wgExtensionsPath . self::$JWPLAYER_DIR . self::$JWPLAYER_PLUGIN_HD_SWF, self::JWPLAYER_VERSION)] = array('file'=>$hdfile, 'state'=>'false');  // when player embedded in action=render page, the file URL is automatically linkified. prevent this behavior			
			}
			else {
				$jwplayerData['plugins'][self::getAssetUrl($wgExtensionsPath . self::$JWPLAYER_DIR . self::$JWPLAYER_PLUGIN_HD_SWF, self::JWPLAYER_VERSION)] = array();
			}
		}
		
		// preroll
//		$jwplayerData['plugins']['http://lp.longtailvideo.com/5/adtvideo/adtvideo.swf'] = array('config'=>'/extensions/wikia/WikiaVideo/wikia_exclusive.xml');
//		
		// ad
		if ($showAd) {
			self::$JWPLAYER_GOOGIMA_DATA['ad.tag'] = self::initGoogleIMAAdTag($articleId, $cityShort);
			if (self::$JWPLAYER_GOOGIMA_DATA['ad.tag']) {
				$jwplayerData['plugins']['googima'] = self::$JWPLAYER_GOOGIMA_DATA;
			}
		}
		
		// addl params
		$jwplayerData = array_merge($jwplayerData, $playerOptions);

		// jwplayer config
		// NOTE: if the JW Player is embedded in an article (not loaded
		// by AJAX), all URLs within the config need to be escaped
		// to prevent the parser from linkifying them. One way to do
		// this is decodeURIComponent($url)
		$jwplayerConfig = array(
		    'id'	=> $jwplayerData['playerId'],
		    'width'	=> $width,
		    'height'	=> $height,
		    'file'	=> $jwplayerData['file'],
		    'modes'	=> array(
			array('type'=>'flash','src'=>$jwplayerData['player']),
			array('type'=>'html5'),
			array('type'=>'download')
			),
		    'autostart'	=> $autoplay ? 'true' : 'false',
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
		if ($isAjax) {
			$code = $jwplayerConfig;
		}
		else {
			$jwplayerConfigJSON = json_encode($jwplayerConfig);
			$code = <<<EOT
<div id="{$jwplayerData['playerId']}"></div>
<script type="text/javascript">
EOT;
			if (!$postOnload) {
				$code .= <<<EOT
	wgAfterContentAndJS.push( function() {
EOT;
			}
			
			$code .= <<<EOT
		$.getScript("{$jwplayerData['jwplayerjs']}", function() { jwplayer("{$jwplayerData['playerId']}").setup($jwplayerConfigJSON); });
EOT;
		
			if (!$postOnload) {
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
	
	protected static function getAssetUrl($url, $version) {
		//@todo use cachebusting value or cachebuster framework
		return $url . '?v=' . $version;
	}
	
	protected static function initGoogleIMAAdTag($articleId, $cityShort='life') {
		global $wgDBname;
		//@todo use logic in AdConfig.js to construct tag

		if ($cityShort) {
			$url = "http://ad.doubleclick.net/pfadx/wka.{$cityShort}/_{$wgDBname};sz=320x240;artid=$articleId";
			return $url;
		}
		
		return '';
	}
}