<?php

declare( strict_types=1 );

namespace Wikia\Search\UnifiedSearch;

final class UnifiedSearchPageResultItem implements UnifiedSearchResultItem {

	private $pageid;
	private $title;
	private $text;
	private $url;
	private $ns;
	private $hub_s;
	private $thumbnail;
	private $wikiId;
	private $wikiUrl;
	private $sitename;

	public function __construct(array $value) {
		$this->pageid = $value['pageId'];
		$this->title = $value['title'];
		$this->text = $value['content'];
		$this->url = $value['url'];
		$this->ns = $value['namespace'];
		$this->hub_s = $value['hub'] ?? null;
		$this->thumbnail = $value['thumbnail'] ?? null;
		$this->wikiId = $value['wikiId'];
		$this->wikiUrl = $value['wikiUrl'];
		$this->sitename = $value['sitename'];
	}

	public function getText( $field = 'text', $wordLimit = null ) {
		$text = $this[$field] ?? '';
		$textAsString = is_array( $text ) ? implode( " ", $text ) : $text;

		$textAsString = static::limitTextLength( $textAsString, $wordLimit );

		// if title and description both start with the same File: prefix, remove the prefix from description
		$textAsString = $this->removePrefix( $this->findFilePrefix( $this->title, $this->ns ),
			$textAsString );

		return $textAsString;
	}

	public function findFilePrefix( $title, $namespace ) {
		if ( $namespace == \NS_FILE && strpos( $title, ":" ) !== false ) {
			/**
			 * find 'File:' prefix (in content language) in title
			 * we could try to use Title class or wgContLang->getNsText here, but none of those actually
			 * will allow us to get potentially i18n'ed namespace prefix in a simple and working way, while
			 *a simple explode with limit will work
			 */
			list ( $prefix, $rest ) = explode( ":", $title, 2 );

			return $prefix . ':';
		}

		return '';
	}

	public function removePrefix( $prefix, $value ) {
		if ( $prefix && ( strpos( $value, $prefix ) === 0 ) ) {
			return substr( $value, strlen( $prefix ) );
		} else {
			return $value;
		}
	}

	public function getEscapedUrl() {
		return htmlentities( $this['url'], ENT_QUOTES | ENT_IGNORE, 'UTF-8', false );
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

	public function getTextUrl() {
		return urldecode( $this->getUrl() );
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
