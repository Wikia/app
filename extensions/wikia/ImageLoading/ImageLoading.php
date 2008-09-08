<?php
if(!defined('MEDIAWIKI')) {
	die(1);
}

$wgExtensionCredits['other'][] = array(
    'name' => 'ImageLoading',
    'author' => 'Inez Korczyński',
);

$wgHooks['OutputPageBeforeHTML'][] = 'ImageLoadingInit';

$ImageLoadingImages = array();
//$ImageLoadingCounter = 0;

function ImageLoadingReplace($matches) {
	global $ImageLoadingImages, $ImageLoadingCounter;
	//$ImageLoadingCounter++;
	//if($ImageLoadingCounter > 3) {
		$ImageLoadingImages[] = array('h' => $matches[3], 'w' => $matches[2], 'src' => $matches[1]);
		return str_replace('src="'.$matches[1].'"', 'id="img'.(count($ImageLoadingImages)-1).'"', $matches[0]);
	//} else {
	//	return $matches[0];
	//}
}

function ImageLoadingInit(&$out, &$text) {
	global $ImageLoadingImages;
	$text = preg_replace_callback("/<img.*? src=\"([^\"]*)\" width=\"(\d*)\" height=\"(\d*)\"/", "ImageLoadingReplace", $text);
	$script = '<script type="text/javascript" src="http://yui.yahooapis.com/combo?2.5.2/build/yahoo-dom-event/yahoo-dom-event.js&2.5.2/build/imageloader/imageloader-min.js"></script><script>var foldGroup = new YAHOO.util.ImageLoader.group(window, "scroll");';
	foreach($ImageLoadingImages as $key => $val) {
		$script .= "foldGroup.registerSrcImage('img{$key}', '{$val['src']}', {$val['w']}, {$val['h']});";
	}
	$script .= 'foldGroup.foldConditional = true;';
	$script .= 'foldGroup.addTrigger(window, "resize");</script>';
	$out->addScript($script);
	return true;
}