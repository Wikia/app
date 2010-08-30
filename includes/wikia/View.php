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
		wfProfileIn(__METHOD__);

		if(!empty($this->data)) {
			extract ($this->data);
		}

		ob_start();
		require $this->templatePath;
		$out = ob_get_clean();

		wfProfileOut(__METHOD__);
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
	 * @param img String - [optional] the name of a message to be used as link tooltip
	 */

	static function specialPageLink($pageName, $message = '', $class = null, $img = null, $alt = null) {
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
			$src = $img == 'blank.gif' ? $wgBlankImgUrl : "{$wgStylePath}/oasis/images/{$img}";
			$message = Xml::element('img', array('src' => $src)) . $message;
		}

		$linker = self::getLinker();
		return $linker->link(
				SpecialPage::getTitleFor( $pageName ),
				$message,  // link text
				$classes,
				null,  // query
				array ("known", "noclasses")
			);
	}

	/**
	 * Call Linker::link method to generate HTML links from Title object
	 */
	static function link($target, $text = null, $customAttribs = array(), $query = array(), $options = array()) {
		$linker = self::getLinker();
		return $linker->link($target, $text, $customAttribs, $query, $options);
	}
}