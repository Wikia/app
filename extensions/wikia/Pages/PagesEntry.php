<?php

class PagesEntry implements JsonSerializable {
	use JsonDeserializerTrait;

	/** @var int $articleId */
	private $articleId;

	/** @var int $namespace */
	private $namespace;

	/** @var string $title */
	private $title;

	/** @var bool $redirect */
	private $redirect;

	/** @var bool $contentPage */
	private $contentPage;

	/** @var int $latestRevisionId */
	private $latestRevisionId;

	/** @var string $latestRevisionTimestamp */
	private $latestRevisionTimestamp;

	public static function newFromPageAndRevision( WikiPage $wikiPage, Revision $revision ): PagesEntry {
		$pagesEntry = new PagesEntry();

		$pagesEntry->articleId = $revision->getPage();

		$title = $wikiPage->getTitle();

		$pagesEntry->namespace = $title->getNamespace();
		$pagesEntry->title = $title->getDBkey();
		$pagesEntry->contentPage = $title->isContentPage();

		$pagesEntry->redirect = $wikiPage->isRedirect();

		$pagesEntry->latestRevisionId = $revision->getId();
		$pagesEntry->latestRevisionTimestamp = $revision->getTimestamp();

		return $pagesEntry;
	}

	/**
	 * @return int
	 */
	public function getArticleId(): int {
		return $this->articleId;
	}

	/**
	 * @return int
	 */
	public function getNamespace(): int {
		return $this->namespace;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * @return bool
	 */
	public function isRedirect(): bool {
		return $this->redirect;
	}

	/**
	 * @return bool
	 */
	public function isContentPage(): bool {
		return $this->contentPage;
	}

	/**
	 * @return int
	 */
	public function getLatestRevisionId(): int {
		return $this->latestRevisionId;
	}

	/**
	 * @return string
	 */
	public function getLatestRevisionTimestamp(): string {
		return $this->latestRevisionTimestamp;
	}

	public function jsonSerialize() {
		return get_object_vars( $this );
	}
}
