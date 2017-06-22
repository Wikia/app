<?php

namespace ContributionPrototype;

class CPArticle {

	private $content;
	private $title;

	function __construct($content, $title) {
		$this->content = $content;
		$this->title = $title;
	}

	public function getContent() {
		return $this->content;
	}

	public function getTitle() {
		return $this->title;
	}
}
