<?php

declare( strict_types=1 );

namespace Wikia\Search\UnifiedSearch;

final class UnifiedCommunitySearchResultItem implements UnifiedSearchResultItem {
	private $description;
	private $name;
	private $descriptionWordLimit;
	private $pageCount;
	private $videoCount;
	private $imageCount;
	/** @var string|null image URL */
	private $thumbnail;
	private $url;
	private $hub;
	private $pos;
	private $thumbTracking;
	private $viewMoreWikisLink;

	public function __construct(array $value) {
		$this->url = $value['url'];
		$this->hub = $value['hub'];
		$this->name = $value['name'];
		$this->description = $value['description'];
		$this->pageCount = $value['pageCount'];
		$this->imageCount = $value['imageCount'];
		$this->videoCount = $value['videoCount'];
		$this->thumbnail = $value['thumbnail'] ?? null;

		// Added during extension
		$this->pos = $value['pos'] ?? null;
		$this->descriptionWordLimit = $value['descriptionWordLimit'] ?? null;
		$this->thumbTracking = $value['thumbTracking'] ?? null;
		$this->viewMoreWikisLink = $value['viewMoreWikisLink'] ?? null;
	}

	public function getUrl() {
		$url = $this->url ?? '';
		if ( \WebRequest::detectProtocol() === 'https' && \wfHttpsAllowedForURL( $url ) ) {
			$url = \wfHttpToHttps( $url );
		}
		return $url;
	}

	public static function limitTextLength( $textAsString, $wordLimit ) {
		if ( $wordLimit !== null ) {
			$wordsExploded = explode( ' ', $textAsString );
			$textAsString = implode( ' ', array_slice( $wordsExploded, 0, $wordLimit ) );
			if ( count( $wordsExploded ) > $wordLimit ) {
				$textAsString = static::fixSnippeting( $textAsString, true );

				return $textAsString;
			}

			return $textAsString;
		}

		return $textAsString;
	}

	public function extended(array $data): self
	{
		return new self(array_merge($this->toArray(), $data));
	}

	public function toArray(): array
	{
		return get_object_vars($this);
	}

	public function getDescription() {
		return self::limitTextLength( htmlspecialchars( $this->description ), $this->descriptionWordLimit );
	}

	public function offsetExists( $offset ) {
		return property_exists($this, $offset);
	}

	public function offsetGet( $offset ) {
		return $this->{$offset};
	}

	public function offsetSet( $offset, $value ) {
		$this->{$offset} = $value;
	}

	public function offsetUnset( $offset ) {
		unset($this->{$offset});
	}
}
