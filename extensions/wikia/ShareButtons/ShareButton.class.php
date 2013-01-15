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
	 * Stores assets for a given button type
	 * @var array
	 */
	protected static $assets = array();

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
	 * Returns an array containing assets for a provided network
	 * Will return an empty array if the class name is incorrect
	 * @param string $name The name of the network
	 * @return array
	 */
	static public function getAssetsForNetwork( $name ) {
	    $className = 'ShareButton' . $name;
		if ( class_exists( $className ) ) {
			return $className::getAssets();
		}
		return array();
	}

	/**
	 * Use ShareButton::factory instead
	 * @param Title $title
	 */
	public function __construct( Title $title ) {
		$this->title = $title;
	}

	/**
	 * Return color scheme name to be used based on SASS color calculation
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
	 * Return protected static assets from inherited class. By default this is an empty array.
	 * Child classes can specify their own value for this property.
	 * @return array
	 */
	public static function getAssets() {
		return static::$assets;
	}

	/**
	 * Return HTML rendering share box (with votes count)
	 * @return string
	 */
	public function getShareBox() {
		return '';
	}

	/**
	 * Return HTML rendering share button
	 * @return string
	 */
	public function getShareButton() {
		return '';
	}

	/**
	 * Return HTML rendering share link
	 * @return string
	 */
	public function getShareLink() {
		return '';
	}
}
