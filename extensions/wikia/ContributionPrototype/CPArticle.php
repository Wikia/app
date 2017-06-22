<?php

namespace ContributionPrototype;

class CPArticle {

	private $content;
	private $entityName;

	function __construct($content, $entityName) {
		$this->content = $content;
		$this->entityName = $entityName;
	}

	public function getContent() {
		return $this->content;
	}

	public function getEntityName() {
		return $this->entityName;
	}
}
