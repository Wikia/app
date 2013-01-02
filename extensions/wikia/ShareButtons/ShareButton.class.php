<?php

/**
 * Abstract class for various social networks providing share buttons
 */

abstract class ShareButton {

	protected $app;
	protected $title;

	/**
	 * Return instance of share button for given social network
	 *
	 * @param WikiaApp $app application instance
	 * @param string $name social networks name
	 * @return ShareButton object instance
	 */
	static public function factory(WikiaApp $app, $name) {
		$className = 'ShareButton' . $name;
		$instance = null;

		if (class_exists($className)) {
			$instance = F::build($className, array('app' => $app));
		}

		return $instance;
	}

	/**
	 * Use ShareButton::factory instead
	 */
	public function __construct(WikiaApp $app) {
		$this->app = $app;

		// use the current title
		$this->title = $this->app->wg->Title;
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
