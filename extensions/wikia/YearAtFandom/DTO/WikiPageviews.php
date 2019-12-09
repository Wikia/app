<?php

declare( strict_types=1 );

final class WikiPageviews {
	/** @var int */
	public $wikiId;
	/** @var string */
	public $name;
	/** @var int */
	public $views;
	/** @var int */
	public $position;

	public function __construct( int $wikiId, int $position, string $name, int $views ) {
		$this->wikiId = $wikiId;
		$this->name = $name;
		$this->views = $views;
		$this->position = $position;
	}
}
