<?php
class View {

	private $templatePath;
	private $data;
	private static $cachedLinker;

	public function __construct($templatePath, $data) {
		$this->templatePath = $templatePath;
		$this->data = $data;
	}

	public function render() {
		wfProfileIn(__METHOD__ . " (" . substr(strrchr($this->templatePath, "/"), 1, -4) .")");

		if(!empty($this->data)) {
			extract ($this->data);
		}

		ob_start();
		require $this->templatePath;
		$out = ob_get_clean();

		wfProfileOut(__METHOD__ . " (" . substr(strrchr($this->templatePath, "/"), 1, -4) .")");
		return $out;
	}

	public static function partial($name, $action = 'Index', $data = null) {
		global $wgAutoloadClasses;

		$moduleClassName = $name.'Module';
		return new View(dirname($wgAutoloadClasses[$moduleClassName]).'/templates/'.$name.'_'.$action.'.php', $data);
	}

	/**
	 * Create / get cached instance of Linker class
	 */
	private static function getLinker() {
		if (!is_object(self::$cachedLinker)) {
			self::$cachedLinker = new Linker();
		}

		return self::$cachedLinker;
	}

	/*  Create a link to any page with Oasis style buttons
	 *
	 * Sample Usages:
	 * View::normalPageLink('Somewhere', 'button-createpage', 'wikia-button');
	 * View::normalPageLink('Somewhere', 'oasis-button-random-page', 'wikia-button secondary', 'icon_button_random.png') ?>
	 *
 	 * @param title Title - the Title of the page to link to
	 * @param message String - the name of a message to use as the link text
	 * @param class String - [optional] the name of a css class for button styling or array of HTML attributes for button
	 * @param img String - [optional] the name of an image to pre-pend to the text (for secondary buttons)
	 * @param alt String - [optional] the name of a message to be used as link tooltip
	 * @param imgclass String - [optional] the name of a css class for the image (for secondary buttons)
	 * @param query array [optional] query parameters
	 */

	static function normalPageLink($title, $message = '', $class = null, $img = null, $alt = null, $imgclass = null, $query = null) {
		global $wgStylePath, $wgBlankImgUrl;

		$classes = array();
		if (is_string($class)) {
			$classes['class'] = $class;
		}
		else if (is_array($class)) {
			$classes = $class;
		}

		if ($alt != '') {
			$classes['title'] = wfMsg($alt);
		}

		if ($message != '') {
			$message = wfMsg($message);
		}
		// Image precedes message text
		if ($img != null) {
			$src = $img == 'blank.gif' ? $wgBlankImgUrl : "{$wgStylePath}/common/{$img}";
			$attr = array('src' => $src);
			if ($img == 'blank.gif') {
				$attr['height'] = '0';
				$attr['width'] = '0';
			}
			if ($imgclass != '') {
				$attr['class'] = $imgclass;
			}
			$message = Xml::element('img', $attr) . $message;
		}

		$linker = self::getLinker();
		return $linker->link(
				$title,
				$message,  // link text
				$classes,
				$query,  // query
				array ("known", "noclasses")
			);
	}

	/* create a link to a SpecialPage.
	 *
	 * Depending on params, this will create a text link, a css button, or a "secondary" button with an embedded image
	 * avoiding this hardcoded stuff
	 * <a href=" Title::makeTitle(NS_SPECIAL, 'CreatePage')->getLocalURL()" class="wikia-button"> <?= wfMsg('button-createpage') </a>
	 *
	 * You can also use the link function directly if you want to, but it's a bit messy and doesn't handle the image case
	 * View::link(SpecialPage::getTitleFor('Following'), wfMsg('wikiafollowedpages-special-seeall'), array("class" => "more"))
	 *
	 * Params:
	 * View::specialPageLink('PageName', 'messagename', 'css-class', 'image-name');
	 *
	 * Sample Usages:
	 * View::specialPageLink('CreatePage', 'button-createpage', 'wikia-button');
	 * View::specialPageLink('Random', 'oasis-button-random-page', 'wikia-button secondary', 'icon_button_random.png') ?>
	 *
	 * @param pageName String - the name of the special page to link to
	 * @param msg String - the name of a message to use as the link text
	 * @param class String - [optional] the name of a css class for button styling or array of HTML attributes for button
	 * @param img String - [optional] the name of an image to pre-pend to the text (for secondary buttons)
	 * @param alt String - [optional] the name of a message to be used as link tooltip
	 * @param imgclass String - [optional] the name of a css class for the image (for secondary buttons)
	 */

	static function specialPageLink($pageName, $message = '', $class = null, $img = null, $alt = null, $imgclass = null, $query = null)
	{
		$title = SpecialPage::getTitleFor( $pageName );
		return self::normalPageLink($title, $message, $class, $img, $alt, $imgclass, $query);
	}

	/**
	 * Call Linker::link method to generate HTML links from Title object
	 */
	static function link($target, $text = null, $customAttribs = array(), $query = array(), $options = array()) {
		$linker = self::getLinker();
		return $linker->link($target, $text, $customAttribs, $query, $options);
	}
}