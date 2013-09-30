<?php

namespace Wikia\JsonFormat\Simple;

class ArticleNode {
	/** @var String */
	private $title;
	/** @var \Wikia\JsonFormat\SectionNode[] */
	private $sections;

	function __construct( $title, $sections = []) {
		$this->title = $title;
		$this->sections = $sections;
	}

	/**
	 * @param \Wikia\JsonFormat\SectionNode[] $sections
	 */
	public function setSections($sections) {
		$this->sections = $sections;
	}

	/**
	 * @return \Wikia\JsonFormat\SectionNode[]
	 */
	public function getSections() {
		return $this->sections;
	}

	public function addSection( SectionNode $node ) {
		$this->sections[] = $node;
	}

	/**
	 * @param String $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return String
	 */
	public function getTitle() {
		return $this->title;
	}

}
