<?php

namespace Wikia\RobotsTxt;

/**
 * Class Wikia\RobotsTxt\PathBuilder
 *
 * Path builder allows you to build paths you pass to RobotsTxt.
 *
 * It takes care of finding all of the aliases of the special pages and namespaces.
 */
class PathBuilder {

	/**
	 * @var \Language[]: the languages to use to build namespaces and special pages names
	 */
	private $languages;

	/**
	 * @var string[]: the English and the local name for the NS_SPECIAL namespace
	 */
	private $specialNamespaces;

	/**
	 * @var string: the article path
	 */
	private $articlePath;

	public function __construct() {
		global $wgArticlePath, $wgContLang;

		$languages = [ $wgContLang ];
		if ( $wgContLang->getCode() !== 'en' ) {
			$languages[] = \Language::factory( 'en' );
		}

		$this->languages = $languages;
		$this->specialNamespaces = $this->getNamespaces( NS_SPECIAL );
		$this->articlePath = $wgArticlePath;
	}

	/**
	 * Get paths a given page is accessible at:
	 *
	 *  * /wiki/PAGENAME (the canonical way)
	 *  * /index.php?title=PAGENAME
	 *  * /index.php/PAGENAME
	 *
	 * The returned path is partially URL-encoded
	 *
	 * @param string $pageName the name of the page, ex. "Spezial:Alle_Seiten"
	 * @param bool $canonicalOnly only return the canonical way of accessing the page/namespace
	 * @return array an array of paths
	 */
	public function buildPaths( $pageName, $canonicalOnly = false ) {
		$pageName = $this->encodeUrl( $pageName );
		$paths = [
			str_replace( '$1', $pageName, $this->articlePath )
		];

		if ( $canonicalOnly ) {
			return $paths;
		}

		$paths[] = '/*?*title=' . $pageName;
		$paths[] = '/index.php/' . $pageName;

		return $paths;
	}

	/**
	 * Get paths a given special page is accessible at
	 *
	 * @param string $pageName name of the special page as exposed in alias file for the special page
	 * @param bool $canonicalOnly only return the canonical way of accessing the page
	 * @return array of paths
	 */
	public function buildPathsForSpecialPage( $pageName, $canonicalOnly = false ) {
		$paths = [];
		foreach ( $this->specialNamespaces as $specialNamespaceAlias ) {
			foreach ( $this->getSpecialPageNames( $pageName ) as $localPageName ) {
				$paths = array_merge(
					$paths,
					$this->buildPaths( $specialNamespaceAlias . ':' . $localPageName, $canonicalOnly )
				);
			}
		}
		return $paths;
	}

	/**
	 * Get paths a given namespace is accessible at
	 *
	 * @param int $namespaceId namespace ID
	 * @param bool $canonicalOnly only return the canonical way of accessing the namespace
	 * @return array of paths
	 */
	public function buildPathsForNamespace( $namespaceId, $canonicalOnly = false ) {
		$paths = [];

		foreach ( $this->getNamespaces( $namespaceId ) as $namespace ) {
			$paths = array_merge(
				$paths,
				$this->buildPaths( $namespace . ':', $canonicalOnly )
			);
		}

		return $paths;
	}

	/**
	 * Build path matching URLs with a specific param present
	 *
	 * This will only work for robots that understand wildcards.
	 *
	 * @param string $param URL param to block
	 * @return array
	 */
	public function buildPathsForParam( $param ) {
		return [
			'/*?' . $param . '=',
			'/*?*&' . $param . '=',
		];
	}

	/**
	 * Encode URL in a way you can safely put that to robots.txt
	 *
	 * There's no need to encode characters like /, :, *, ?, &, =, $, so they are decoded
	 * Non-English characters WILL be encoded.
	 *
	 * @param string $in the URL to encode
	 * @return string
	 */
	private function encodeUrl( $in ) {
		return str_replace(
			[ '%2F', '%3A', '%2A', '%3F', '%26', '%3D', '%24' ],
			[ '/', ':', '*', '?', '&', '=', '$' ],
			rawurlencode( $in )
		);
	}

	/**
	 * Get the special page's aliases
	 *
	 * @param string $pageName special page name as specified in the SpecialPage object
	 * @return array
	 */
	private function getSpecialPageNames( $pageName ) {
		$aliases = [];
		foreach ( $this->languages as $lang ) {
			$specialAliases = $lang->getSpecialPageAliases();
			if ( isset( $specialAliases[$pageName] ) && is_array( $specialAliases[$pageName] ) ) {
				$aliases = array_merge( $aliases, $specialAliases[$pageName] );
			}
		}

		return array_unique( $aliases );
	}

	/**
	 * Get the namespace's names translated to $this->languages
	 *
	 * @param int $namespaceId
	 * @return array
	 */
	private function getNamespaces( $namespaceId ) {
		$namespaces = [];
		foreach ( $this->languages as $lang ) {
			$namespaces[] = $lang->getNamespaces()[$namespaceId];
		}
		return array_unique( $namespaces );
	}
}
