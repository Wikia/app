<?php

class ShareButtonFacebook extends ShareButton {

    /**
	 * AssetsManager compliant path to assets
	 * @var array
	 */
	protected static $assets =  array( '//extensions/wikia/ShareButtons/js/ShareButtonFacebook.js' );

	/**
	 * Return HTML rendering share box (with votes count)
	 *
	 * @see https://developers.facebook.com/docs/reference/plugins/like/
	 * @return string
	 */
	public function getShareBox() {
		global $wgNoExternals;
		if (!empty($wgNoExternals)) {
			return '';
		}

		$html = Xml::element('div', array(
			'class' => 'fb-like',
			'data-send' => 'false',
			'data-layout' => 'box_count',
			'data-width' => 50,
			'data-href' => $this->getUrl(),
			'data-colorscheme' => $this->getColorScheme(),
		), ' ');

		return $html;
	}
}
