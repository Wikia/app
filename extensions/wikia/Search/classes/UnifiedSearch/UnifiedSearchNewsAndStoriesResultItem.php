<?php

declare( strict_types=1 );

namespace Wikia\Search\UnifiedSearch;

final class UnifiedSearchNewsAndStoriesResultItem implements UnifiedSearchResultItem {
	/** @var string title */
	private $title;
	/** @var string title */
	private $url;
	/** @var string|null image URL */
	private $image;
	/** @var string vertical */
	private $vertical;


	public function __construct(array $value) {
		$this->title = $value['title'];
		$this->url = $value['url'];
		$this->image = $value['thumbnail'] ?? null;
		$this->vertical = $value['vertical'];
	}

	public function getUrl() {
		$url = $this->url ?? '';
		if ( \WebRequest::detectProtocol() === 'https' && \wfHttpsAllowedForURL( $url ) ) {
			$url = \wfHttpToHttps( $url );
		}
		return $url;
	}

	public function extended(array $data): self
	{
		return new self(array_merge($this->toArray(), $data));
	}

	public function toArray(): array
	{
		return get_object_vars($this);
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
