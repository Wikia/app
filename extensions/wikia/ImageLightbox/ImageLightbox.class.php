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

		$res = array(
			'width' => $thumb->getWidth(),
			'height' => $thumb->getHeight(),
			'html' => $thumb->toHtml(),
			'href' => $wgTitle->getLocalUrl(),
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
