<?php

declare( strict_types=1 );

final class UserStatistics implements JsonSerializable {
	/** @var WikiActivityList */
	private $pageViews;
	/** @var UserSummary */
	private $summary;
	/** @var ArticlePageViewsList */
	private $articlePageViews;

	public function __construct(
		UserSummary $summary,
		WikiActivityList $pageViews,
		ArticlePageViewsList $articlePageViews
	) {
		$this->pageViews = $pageViews;
		$this->summary = $summary;
		$this->articlePageViews = $articlePageViews;
	}

	public function jsonSerialize() {
		return [
			'summary' => $this->summary,
			'top5Wikis' => $this->pageViews->top5Wikis(),
			'top5Articles' => $this->articlePageViews->top5Articles(),
		];
	}
}
