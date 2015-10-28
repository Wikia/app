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

	/** @var array - Environment like dev-rychu, sandbox-s4, etc */
	private $environment;

	/** @var string - The site name to include in the title */
	private $siteName;

	/** @var string - The brand name to include in the title */
	private $brandName;

	public function __construct() {
		global $wgWikiaEnvironment;

		if ( $wgWikiaEnvironment !== WIKIA_ENV_PROD ) {
			$this->environment = wfHostname();
		}

		$this->brandName = wfMessage( 'wikia-pagetitle-brand' );
		$this->siteName = wfMessage( 'wikia-pagetitle-sitename' );

		if ( WikiaPageType::isWikiaHomePage() ) {
			$this->siteName = null;
		}

		// Compatibility mode: extract the wiki title from <pagetitle> MW message
		// Remove later
		$pageTitleTemplate = wfMessage( 'pagetitle' )->inContentLanguage()->text();

		if (preg_match( '/^\\$1( \\W )(.*)$/u', $pageTitleTemplate, $m ) ) {
			$this->separator = $m[1];
			$this->siteName = $m[2];
		}
		// End of compatibility mode
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
		$newParts = [];

		foreach ( $parts as $part ) {
			if ( $part instanceof Message ) {
				$newParts[] = $part->inContentLanguage()->text();
			}
			if ( is_string( $part ) ) {
				$newParts[] = $part;
			}
		}

		$this->parts = $newParts;
		return $this;
	}

	/**
	 * Get all parts including the automatically generated ones
	 *
	 * @return array
	 */
	public function getAllParts() {
		$parts = array_merge(
			[$this->environment],
			$this->parts,
			[$this->siteName, $this->brandName]
		);
		return array_filter( $parts, function ( $part ) {
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
}
