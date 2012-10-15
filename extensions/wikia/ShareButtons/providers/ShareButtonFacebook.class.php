<?php

class ShareButtonFacebook extends ShareButton {

	public function __construct(WikiaApp $app) {
		parent::__construct($app);
	}

	/**
	 * Return HTML rendering share box (with votes count)
	 *
	 * @see https://developers.facebook.com/docs/reference/plugins/like/
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

		$html .= F::build('JSSnippets')->addToStack(
			array(),
			array(
				'$.loadFacebookAPI'
			)
		);

		return $html;
	}

	/**
	 * Return HTML rendering share button
	 */
	public function getShareButton() {

	}

	/**
	 * Return HTML rendering share link
	 */
	public function getShareLink() {

	}
}
