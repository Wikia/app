<?php
if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgExtensionFunctions[] = 'WikiaVideo_init';

function WikiaVideo_init() {
	global $wgExtraNamespaces, $wgAutoloadClasses, $wgParser;
	$wgExtraNamespaces[NS_VIDEO] = 'Video';
	$wgAutoloadClasses['VideoPage'] = dirname(__FILE__). '/VideoPage.php';
	$wgParser->setHook('videogallery', 'WikiaVideo_renderVideoGallery');
	return true;
}

function WikiaVideo_renderVideoGallery($input, $args, $parser) {
	$out = '';
	$videos = array();

	$lines = explode("\n", $input);
	foreach($lines as $line) {
		$matches = array();
		preg_match( "/^([^|]+)(\\|(.*))?$/", $line, $matches );

		if(count($matches) == 0) {
			continue;
		}

		if(strpos($matches[0], '%') !== false) {
			$matches[1] = urldecode($matches[1]);
		}

		$tp = Title::newFromText($matches[1]);
		$nt =& $tp;

		if(is_null($nt)) {
			continue;
		}

		if(isset($matches[3])) {
			$html = $parser->recursiveTagParse(trim($matches[3]));
		} else {
			$html = '';
		}

		$videos[] = array($tp, $html);
	}

	if(count($videos) > 0) {
		$out .= '<table class="gallery" cellspacing="0" cellpadding="0"><tr>';

		for($i = 0; $i < count($videos); $i++) {
			$video = new VideoPage($videos[$i][0]);
			$video->load();
			$out .= '<td><div class="gallerybox" style="width: 335px;"><div class="thumb" style="padding: 13px 0; width: 330px;"><div style="margin-left: auto; margin-right: auto; width: 300px;">'.$video->getEmbedCode().'</div></div><div class="gallerytext">'.(!empty($videos[$i][1]) ? $videos[$i][1] : '').'</div></div></td>';

			if($i%2 == 1) {
				$out .= '</tr></tr>';
			}
		}

		$out .= '</tr></table>';
	}

	return $out;
}

function WikiaVideo_makeVideo($title, $options, $sk) {
	wfProfileIn('WikiaVideo_makeVideo');
	if(!$title->exists()) {
		$out = $sk->makeColouredLinkObj(Title::newFromText('WikiaVideoAdd', NS_SPECIAL), 'new', $title->getPrefixedText(), 'name=' . $title->getDBKey());
	} else {
		// defaults
		$width = 400;
		$thumb = '';
		$caption = '';

		$params = explode('|', $options);
		foreach($params as $param) {
			$width_check = strpos($param, 'px');
			if($width_check > -1) {
				$width = str_replace('px', '', $param);
			} else if('thumb' == $param) {
				$thumb = 'thumb';
			} else if(('left' == $param) || ('right' == $param)) {
				$align = $param;
			} else {
				$caption = $param;
			}
		}

		if(empty($align)) {
			if($thumb == 'thumb') {
				$align = 'right';
			} else {
				$align = 'left';
			}
		}

		$video = new VideoPage($title);
		$video->load();
		$out = $video->generateWindow($align, $width, $caption, $thumb);
	}
	wfProfileOut('WikiaVideo_makeVideo');
	return $out;
}

$wgHooks['MWNamespace:isMovable'][] = 'WikiaVideo_isMovable';
function WikiaVideo_isMovable($result, $index) {
	if($index == NS_VIDEO) {
		$result = false;
	}
	return true;
}

$wgHooks['ArticleFromTitle'][] = 'WikiaVideoArticleFromTitle';
function WikiaVideoArticleFromTitle($title, $article) {
	if(NS_VIDEO == $title->getNamespace()) {
		$article = new VideoPage($title);
	}
	return true;
}
