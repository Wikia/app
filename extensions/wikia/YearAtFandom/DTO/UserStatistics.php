<?php

declare( strict_types=1 );

final class UserStatistics implements JsonSerializable {
	/** @var WikiPageViewsList */
	private $pageViews;
	/** @var UserSummary */
	private $summary;

	public function __construct( UserSummary $summary, WikiPageViewsList $pageViews ) {
		$this->pageViews = $pageViews;
		$this->summary = $summary;
	}

	public function jsonSerialize() {
		return [
			'summary' => $this->summary,
			'top5' => $this->pageViews->top5Wikis()
		];
	}
}
