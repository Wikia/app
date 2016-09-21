<?php

/**
 * Class to get html title (the contents of <title>)
 */
class WikiaHtmlTitle {

	/**
	 * @var string - The separator used to separate parts of the HTML title
	 *
	 * Note there is a logic that guesses the separator from a MediaWiki message <pagetitle>
	 * This logic might be removed later for consistency and simplicity (see the file below)
	 */
	private $separator = ' - ';

	/** @var array - Configurable parts of the title */
	private $parts = [];

	/** @var Message|null - The site name to include in the title */
	private $siteName;

	/** @var Message - The brand name to include in the title */
	private $brandName;

	public function __construct() {
		$this->brandName = wfMessage( 'wikia-pagetitle-brand' );
		$this->siteName = wfMessage( 'wikia-pagetitle-sitename' );

		if ( WikiaPageType::isWikiaHomePage() ) {
			$this->siteName = null;
		}
	}

	/**
	 * Set the HTML title parts
	 *
	 * You can pass an empty array: the generated title will be wiki name + brand name
	 * You can pass one-item array: the generated title will be the passed item + wiki name + brand name
	 * You can pass more items: the generated title will be the passed items + wiki name + brand name
	 *
	 * It's useful to pass many items at once to construct titles like that:
	 *
	 * "A few words about the admin - George User Blog - My Wiki - Wikia"
	 *
	 * Just do:
	 *
	 * $titleBuilder->setParts( $blogTitle, wfMessage( 'user-blog-title' )->params( $userName ) );
	 *
	 * The wiki name and brand name are added to all titles, so you don't worry about them.
	 *
	 * @param array $parts - title parts as Message and/or strings, empty parts will be ignored
	 * @return $this
	 */
	public function setParts( array $parts ) {
		$this->parts = $parts;
		return $this;
	}

	/**
	 * Get all parts including the automatically generated ones
	 *
	 * @return array
	 */
	public function getAllParts() {
		$parts = array_merge(
			$this->parts,
			[$this->siteName, $this->brandName]
		);

		$stringParts = array_map( function( $part ) {
			if ( $part instanceof Message ) {
				return $part->inContentLanguage()->text();
			}
			if ( is_string( $part ) ) {
				return $part;
			}
			return null;
		}, $parts );

		return array_filter( $stringParts, function ( $part ) {
			return !empty( $part );
		} );
	}

	/**
	 * Get the separator used for building HTML titles
	 *
	 * @return string
	 */
	public function getSeparator() {
		return $this->separator;
	}

	/**
	 * Get fully built HTML title
	 *
	 * @return string
	 */
	public function getTitle() {
		return join( $this->getSeparator(), $this->getAllParts() );
	}

	/**
	 * Set HTML title based on the information passed from OutputPage
	 *
	 * This adds the HTML title structure for special pages.
	 * Later we should add structure for images, videos, categories, blogs, etc.
	 * Then this method should be promoted to a separate class with a set of tests.
	 *
	 * @param Title $title
	 * @param string $name
	 * @return WikiaHtmlTitle
	 */
	public function generateTitle( $title, $name ) {
		if ( !$title ) {
			return $this->setParts( [ $name ] );
		}

		// Extra title for admin dashboard (and maybe other pages handled by extensions)
		$parts = [];
		wfRunHooks( 'WikiaHtmlTitleExtraParts', [ $title, &$parts ] );
		array_unshift( $parts, $name );

		return $this->setParts( $parts );
	}
}
