<?php

declare( strict_types=1 );


final class UserSummary {
	/** @var int */
	public $pageViews;
	/** @var int */
	public $daysSpent;
	/** @var int */
	public $distinctWikis;
	/** @var int */
	public $edits;
	/** @var int */
	public $creates;
	/** @var int */
	public $posts;

	public function __construct(
		int $pageViews,
		int $daysSpent,
		int $distinctWikis,
		int $edits,
		int $creates,
		int $posts
	) {
		$this->pageViews = $pageViews;
		$this->daysSpent = $daysSpent;
		$this->distinctWikis = $distinctWikis;
		$this->edits = $edits;
		$this->creates = $creates;
		$this->posts = $posts;
	}

	public static function missing(): self {
		return new self(0, 0, 0, 0, 0, 0);
	}
}
