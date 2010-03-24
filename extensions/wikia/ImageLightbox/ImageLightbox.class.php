<?php

class ImageLightbox {

	/**
	 * Handle AJAX request and return bigger version of requested image
	 */
	static public function ajax() {
		global $wgTitle;

		wfProfileIn(__METHOD__);

		// limit dimensions of returned image
		global $wgRequest;
		$maxWidth = $wgRequest->getInt('maxwidth', 500) - 20;
		$maxHeight = $wgRequest->getInt('maxheight', 300) - 75;

		$image = wfFindFile($wgTitle);

		if (empty($image)) {
			wfProfileOut(__METHOD__);
			return array();
		}

		// get original dimensions of an image
		$width = $image->getWidth();
		$height = $image->getHeight();

		// don't try to make image larger
		if ($width > $maxWidth or $height > $maxHeight) {
			$width = $maxWidth;
			$height = $maxHeight;
		}

		// generate thumbnail
		$thumb = $image->getThumbnail($width, $height);
		$height = max($thumb->getHeight(), 200);
		$width = max($thumb->getWidth(), 200);

		// render it
		$html = Xml::element('img', array(
			'alt' => '',
			'height' => $height,
			'width' => $width,
			'src' => 'http://images1.wikia.nocookie.net/common/skins/common/blank.gif/cb1',
			'style' => "background-image: url('{$thumb->url}')",
		));

		wfLoadExtensionMessages('ImageLightbox');

		$res = array(
			'width' => $width,
			'height' => $height,
			'name' => $wgTitle->getText(),
			'html' => $html,
			'href' => $wgTitle->getLocalUrl(),
			'msg' => array(
				'tooltip' => wfMsg('lightbox_details_tooltip'),
			),
		);

		wfProfileOut(__METHOD__);

		return $res;
	}

	/**
	 * Load extension's JS and CSS files
	 *
	 * TODO: consider loading them via StaticChute
	 */
	static public function beforePageDisplay(&$out, &$sk) {
		global $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;
		$out->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/ImageLightbox/ImageLightbox.js?{$wgStyleVersion}\"></script>\n");
		$out->addExtensionStyle("{$wgExtensionsPath}/wikia/ImageLightbox/ImageLightbox.css?{$wgStyleVersion}");
		return true;
	}
}
