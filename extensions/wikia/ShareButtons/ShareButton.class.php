<?php

/**
 * Abstract class for various social networks providing share buttons
 */

abstract class ShareButton extends WikiaObject {
	/**
	 * The title object whose URL we will be using to share. Defaults to wgTitle.
	 * @var Title
	 */
	protected $title;

	/**
	 * Return instance of share button for given social network
	 *
	 * @param string $name social networks name
	 * @param Title|null $title the title whose URL we will share 
	 * @return ShareButton object instance
	 */
	static public function factory( $name, $title = null ) {
		$className = 'ShareButton' . $name;
		if ( class_exists( $className ) ) {
			return new $className( $title instanceof Title ? $title : F::app()->wg->Title );
		}
	}

	/**
	 * Use ShareButton::factory instead
	 */
	public function __construct( Title $title ) {
		$this->title = $title;
	}

	/**
	 * Return color scheme name to be used based on SASS color calculation
	 *
	 * @return string color scheme to be used ("light" or "dark")
	 */
	protected function getColorScheme() {
		return SassUtil::isThemeDark() ? 'dark': 'light';
	}

	/**
	 * Return absolute URL to a page to be shared (uses wgTitle)
	 * The path component of the URL is urlencoded to prevent confusion between sharing services
	 * @return string URL to be shared
	 */
	protected function getURL() {
		$path = $this->title->getLocalUrl();
		$paths = explode( '/', $path );
		foreach ( $paths as $index => $section ) {
			$paths[$index] = urlencode( $section );
		}
		return str_replace( $path, implode( '/', $paths ), $this->title->getFullUrl() );
	}

	/**
	 * Return HTML rendering share box (with votes count)
	 */
	abstract public function getShareBox();

	/**
	 * Return HTML rendering share button
	 */
	abstract public function getShareButton();

	/**
	 * Return HTML rendering share link
	 */
	abstract public function getShareLink();
}
