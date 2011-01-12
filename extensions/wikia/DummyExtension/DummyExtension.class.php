<?php

class DummyExtension extends WikiaHookHandler {

	/**
	 * current page title
	 * @var Title
	 */
	private $title = null;
	/**
	 * wikia app instance
	 * @var WikiaApp
	 */
	private $wikia = null;

	public function __construct(Title $currentTitle = null) {
		$this->title = $currentTitle;
		$this->wikia = WF::build('App');
	}

	/**
	 * @return Title
	 */
	public function getTitle() {
		if($this->title == null) {
			$this->title = $this->wikia->getGlobal('wgTitle');
		}
		return $this->title;
	}

	public function onOutputPageBeforeHTML( &$out, &$text ) {
		echo __METHOD__ . " - hook handler fired!<br />";
		echo "Title: " . $this->getTitle()->getText() . "<br />";

		$registry = $this->wikia->getRegistry();

		//var_dump($registry['wgUser']);
		var_dump($this->getHookOptions());

		return true;
	}

}