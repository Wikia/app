<?php

class JWPlayer {
	const VIDEO_GOOGLE_ANALYTICS_ACCOUNT_ID = 'UA-24709745-1';

	private static $JWPLAYER_DIR = '/extensions/wikia/JWPlayer/';
	private static $JWPLAYER_JS = 'jwplayer.min.js';
	private static $JWPLAYER_SWF = 'player.swf';
	private static $JWPLAYER_JS_PLUGINS_DIR = 'plugins/js/';
	
	private static $CACHEBUSTER = 3;	// increment this anytime an asset file is modified
	
	// ad.tag must be initialized somewhere in this class!
	private static $JWPLAYER_GOOGIMA_DATA = 
		array('ad.tag'=>'', 'ad.position'=>'pre', 'ad.bandwidth'=>'high',
			'admessagedynamic'=>'Your video will play in XX seconds', 'admessagedynamickey'=>'XX',
			//'allowadskip'=>'true', 'allowadskippastseconds'=>5,	// wlee 11/1/11: do not skip ads yet
			'scaled_ads'=>'false'
		    );
	
	public static function getJavascriptPlayerUrl() {
		return self::getAssetUrl(self::$JWPLAYER_DIR . self::$JWPLAYER_JS);
	}
	
	public static function getEmbedCode($articleId, $videoid, $url, $title, $width, $height, $showAd, $duration, $isHd, $hdfile='', $thumbUrl='', $cityShort='life', $autoplay=true, $isAjax=true, $playerOptions=array()) {
		$jwplayerData = array();
		$jwplayerData['jwplayerjs'] = self::getJavascriptPlayerUrl();
		$jwplayerData['player'] = self::getAssetUrl( self::$JWPLAYER_DIR . self::$JWPLAYER_SWF );
		$jwplayerData['playerId'] = 'player-'.$videoid.'-'.mt_rand();
		$jwplayerData['plugins'] = array('gapro-1'=>array('accountid'=>self::VIDEO_GOOGLE_ANALYTICS_ACCOUNT_ID),
						'timeslidertooltipplugin-2'=>array(), 
						self::getAssetUrl(self::$JWPLAYER_DIR.self::$JWPLAYER_JS_PLUGINS_DIR .'infobox.js')=>array('title'=>htmlspecialchars($title))
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
		$jwplayerData['skin'] = self::getAssetUrl( self::$JWPLAYER_DIR . '/skins/wikia/'.$wikiaSkinZip );
	
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
				
			}
			else {
				$jwplayerData['plugins']['hd-2'] = array();
			}
		}
		
		// ad
		if ($showAd) {
			self::$JWPLAYER_GOOGIMA_DATA['ad.tag'] = self::initGoogleIMAAdTag($cityShort);
			if (self::$JWPLAYER_GOOGIMA_DATA['ad.tag']) {
				$jwplayerData['plugins']['googima'] = self::$JWPLAYER_GOOGIMA_DATA;
			}
		}
		
		// addl params
		$jwplayerData = array_merge($jwplayerData, $playerOptions);

		// jwplayer embed code
		$sJSON = '{'
			. '"flashplayer": "'.$jwplayerData['player'].'",'
			. '"id": "'.$jwplayerData['playerId'].'",'
			. '"width": "'.$width.'",'
			. '"height": "'.$height.'",'
			. '"file": ' . self::initJWPlayerURL($jwplayerData['file'], true) . ','
			. (!empty($jwplayerData['image']) ? '"image": ' . self::initJWPlayerURL($jwplayerData['image'], true) . ',' : '')
			. (!empty($jwplayerData['provider']) ? '"provider": "' . $jwplayerData['provider'] . '",' : '')
			. (!empty($jwplayerData['duration']) ? '"duration": "' . $jwplayerData['duration'] . '",' : '')
			. '"autostart": "' . ($autoplay ? 'true' : 'false') . '",'
			. '"stretching": "uniform",'
			. '"controlbar.position": "over",'
			. '"dock": false,'
			. '"skin": "' . $jwplayerData['skin'] . '",';
		$sJSON .= '"plugins": {';
		$pluginTexts = array();
		foreach ($jwplayerData['plugins'] as $plugin=>$options) {
			$pluginText = '"'.$plugin.'": {';
			$pluginOptionTexts = array();
			foreach ($options as $key=>$val) {
				$text = '"'.$key.'": ';
				if (startsWith($val, 'http://')
				|| startsWith($val, 'https://')) {
					$text .= self::initJWPlayerURL($val, $asJSON);
				}
				else {
					$text .= '"'.$val.'"';
				}
				$pluginOptionTexts[] = $text;
			}
			$pluginText .= implode(',', $pluginOptionTexts);
			$pluginText .= '}';
			$pluginTexts[] = $pluginText;
		}
		$sJSON .= implode(',', $pluginTexts)
			. '}'	// end plugins
			. '}';

		
		//@todo return html if $isAjax == false
		
		$code = '';
		if ($isAjax) {
			$code = json_decode($sJSON);
		}
		else {
			$code = <<<EOT
<div id="{$jwplayerData['playerId']}"></div>
<script type="text/javascript">
	wgAfterContentAndJS.push( function() {
		$.getScript("{$jwplayerData['jwplayerjs']}", function() { jwplayer("{$jwplayerData['playerId']}").setup($sJSON); });
	});
</script>
EOT;
		}
		
		return $code;
	}
	
	protected static function getAssetUrl($url) {
		return $url . '?cb=' . self::$CACHEBUSTER;		
	}
	
	/**
	 * MediaWiki parser tries to linkify any URL it encounters.
	 * This method escapes URLs for use in JW Player to avoid this linkification.
	 * @param string $url
	 * @param boolean $useJSON
	 * @return string 
	 */
	protected static function initJWPlayerURL($url, $useJSON) {
		if (!empty($useJSON)) {
			return '"' . $url . '"';
		}
		else {
			return 'decodeURIComponent("' . urlencode($url) . '")';  // when player embedded in action=render page, the file URL is automatically linkified. prevent this behavior
		}
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