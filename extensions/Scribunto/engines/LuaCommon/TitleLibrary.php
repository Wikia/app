<?php

class Scribunto_LuaTitleLibrary extends Scribunto_LuaLibraryBase {
	// Note these caches are naturally limited to
	// $wgExpensiveParserFunctionLimit + 1 actual Title objects because any
	// addition besides the one for the current page calls
	// incrementExpensiveFunctionCount()
	private $titleCache = array();
	private $idCache = array( 0 => null );

	function register() {
		$lib = array(
			'newTitle' => array( $this, 'newTitle' ),
			'makeTitle' => array( $this, 'makeTitle' ),
			'getUrl' => array( $this, 'getUrl' ),
			'getContent' => array( $this, 'getContent' ),
			'fileExists' => array( $this, 'fileExists' ),
			'protectionLevels' => array( $this, 'protectionLevels' ),
		);
		$this->getEngine()->registerInterface( 'mw.title.lua', $lib, array(
			'thisTitle' => $this->returnTitleToLua( $this->getTitle() ),
			'NS_MEDIA' => NS_MEDIA,
		) );
	}

	private function checkNamespace( $name, $argIdx, &$arg, $default = null ) {
		global $wgContLang;

		if ( $arg === null && $default !== null ) {
			$arg = $default;
		} elseif ( is_numeric( $arg ) ) {
			$arg = (int)$arg;
			if ( !MWNamespace::exists( $arg ) ) {
				throw new Scribunto_LuaError(
					"bad argument #$argIdx to '$name' (unrecognized namespace number '$arg')"
				);
			}
		} elseif ( is_string( $arg ) ) {
			$ns = $wgContLang->getNsIndex( $arg );
			if ( $ns === false ) {
				throw new Scribunto_LuaError(
					"bad argument #$argIdx to '$name' (unrecognized namespace name '$arg')"
				);
			}
			$arg = $ns;
		} else {
			$this->checkType( $name, $argIdx, $arg, 'namespace number or name' );
		}
	}

	/**
	 * Extract information from a Title object for return to Lua
	 *
	 * This also records a link to this title in the current ParserOutput
	 * and caches the title for repeated lookups. The caller should call
	 * incrementExpensiveFunctionCount() if necessary.
	 *
	 * @param $title Title Title to return
	 * @return array Lua data
	 */
	private function returnTitleToLua( Title $title ) {
		// Cache it
		$this->titleCache[$title->getPrefixedDBkey()] = $title;
		if ( $title->getArticleID() > 0 ) {
			$this->idCache[$title->getArticleID()] = $title;
		}

		// Record a link
		if ( $this->getParser() && !$title->equals( $this->getTitle() ) ) {
			$this->getParser()->getOutput()->addLink( $title );
		}

		$ns = $title->getNamespace();
		$ret = array(
			'isLocal' => (bool)$title->isLocal(),
			'isRedirect' => (bool)$title->isRedirect(),
			'interwiki' => $title->getInterwiki(),
			'namespace' => $ns,
			'nsText' => $title->getNsText(),
			'text' => $title->getText(),
			'id' => $title->getArticleID(),
			'fragment' => $title->getFragment(),
			'thePartialUrl' => $title->getPartialURL(),
		);
		if ( $ns === NS_SPECIAL ) {
			$ret['exists'] = (bool)SpecialPageFactory::exists( $title->getDBkey() );
		} else {
			$ret['exists'] = $ret['id'] > 0;
		}
		if ( $ns !== NS_FILE && $ns !== NS_MEDIA ) {
			$ret['fileExists'] = false;
		}
		return $ret;
	}

	/**
	 * Handler for title.new
	 *
	 * Calls Title::newFromID or Title::newFromTitle as appropriate for the
	 * arguments, and may call incrementExpensiveFunctionCount() if the title
	 * is not already cached.
	 *
	 * @param $text_or_id string|int Title or page_id to fetch
	 * @param $defaultNamespace string|int Namespace name or number to use if $text_or_id doesn't override
	 * @return array Lua data
	 */
	function newTitle( $text_or_id, $defaultNamespace = null ) {
		$type = $this->getLuaType( $text_or_id );
		if ( $type === 'number' ) {
			if ( array_key_exists( $text_or_id, $this->idCache ) ) {
				$title = $this->idCache[$text_or_id];
			} else {
				$this->incrementExpensiveFunctionCount();
				$title = Title::newFromID( $text_or_id );
				$this->idCache[$text_or_id] = $title;
			}
			if ( !$title ) {
				return array( null );
			}
		} elseif ( $type === 'string' ) {
			$this->checkNamespace( 'title.new', 2, $defaultNamespace, NS_MAIN );

			// Note this just fills in the given fields, it doesn't fetch from
			// the page table.
			$title = Title::newFromText( $text_or_id, $defaultNamespace );
			if ( !$title ) {
				return array( null );
			}
			if ( isset( $this->titleCache[$title->getPrefixedDBkey()] ) ) {
				// Use the cached version, because that has already been loaded from the database
				$title = $this->titleCache[$title->getPrefixedDBkey()];
			} else {
				$this->incrementExpensiveFunctionCount();
			}
		} else {
			// This will always fail
			$this->checkType( 'title.new', 1, $text_or_id, 'number or string' );
		}

		return array( $this->returnTitleToLua( $title ) );
	}

	/**
	 * Handler for title.makeTitle
	 *
	 * Calls Title::makeTitleSafe, and may call
	 * incrementExpensiveFunctionCount() if the title is not already cached.
	 *
	 * @param $ns string|int Namespace
	 * @param $text string Title text
	 * @param $fragment string URI fragment
	 * @param $interwiki string Interwiki code
	 * @return array Lua data
	 */
	function makeTitle( $ns, $text, $fragment = null, $interwiki = null ) {
		$this->checkNamespace( 'makeTitle', 1, $ns );
		$this->checkType( 'makeTitle', 2, $text, 'string' );
		$this->checkTypeOptional( 'makeTitle', 3, $fragment, 'string', '' );
		$this->checkTypeOptional( 'makeTitle', 4, $interwiki, 'string', '' );

		// Note this just fills in the given fields, it doesn't fetch from the
		// page table.
		$title = Title::makeTitleSafe( $ns, $text, $fragment, $interwiki );
		if ( !$title ) {
			return array( null );
		}
		if ( isset( $this->titleCache[$title->getPrefixedDBkey()] ) ) {
			// Use the cached version, because that has already been loaded from the database
			$title = $this->titleCache[$title->getPrefixedDBkey()];
		} else {
			$this->incrementExpensiveFunctionCount();
		}

		return array( $this->returnTitleToLua( $title ) );
	}

	// May call the following Title methods:
	// getFullUrl, getLocalUrl, getCanonicalUrl
	function getUrl( $text, $which, $query = null, $proto = null ) {
		static $protoMap = array(
			'http' => PROTO_HTTP,
			'https' => PROTO_HTTPS,
			'relative' => PROTO_RELATIVE,
			'canonical' => PROTO_CANONICAL,
		);

		$this->checkType( 'getUrl', 1, $text, 'string' );
		$this->checkType( 'getUrl', 2, $which, 'string' );
		if ( !in_array( $which, array( 'fullUrl', 'localUrl', 'canonicalUrl' ), true ) ) {
			$this->checkType( 'getUrl', 2, $which, "'fullUrl', 'localUrl', or 'canonicalUrl'" );
		}
		$func = "get" . ucfirst( $which );

		$args = array( $query, false );
		if ( !is_string( $query ) && !is_array( $query ) ) {
			$this->checkTypeOptional( $which, 1, $query, 'table or string', '' );
		}
		if ( $which === 'fullUrl' ) {
			$this->checkTypeOptional( $which, 2, $proto, 'string', 'relative' );
			if ( !isset( $protoMap[$proto] ) ) {
				$this->checkType( $which, 2, $proto, "'http', 'https', 'relative', or 'canonical'" );
			}
			$args[] = $protoMap[$proto];
		}

		$title = Title::newFromText( $text );
		if ( !$title ) {
			return array( null );
		}
		return array( call_user_func_array( array( $title, $func ), $args ) );
	}

	function getContent( $text ) {
		$this->checkType( 'getContent', 1, $text, 'string' );
		$title = Title::newFromText( $text );
		if ( !$title ) {
			return array( null );
		}

		// Record in templatelinks, so edits cause the page to be refreshed
		$this->getParser()->getOutput()->addTemplate(
			$title, $title->getArticleID(), $title->getLatestRevID()
		);

		$rev = Revision::newFromTitle( $title );
		if ( !$rev ) {
			return array( null );
		}
		$content = $rev->getText();
		if ( !$content ) {
			return array( null );
		}
		return array( $content );
	}

	function fileExists( $text ) {
		$this->checkType( 'fileExists', 1, $text, 'string' );
		$title = Title::newFromText( $text );
		if ( !$title ) {
			return array( false );
		}
		$ns = $title->getNamespace();
		if ( $ns !== NS_FILE && $ns !== NS_MEDIA ) {
			return array( false );
		}

		$this->incrementExpensiveFunctionCount();
		$file = wfFindFile( $title );
		if ( !$file ) {
			return array( false );
		}
		$this->getParser()->getOutput()->addImage(
			$file->getName(), $file->getTimestamp(), $file->getSha1()
		);
		return array( (bool)$file->exists() );
	}

	private function makeRestrictionsArraysOneBased( $restrictions ) {
		$ret = array();
		foreach ( $restrictions as $action => $requirements ) {
			if ( empty( $requirements ) ) {
				$ret[$action] = $requirements;
			} else {
				$ret[$action] = array_combine( range( 1, count( $requirements ) ), array_values( $requirements ) );
			}
		}
		return $ret;
	}

	public function protectionLevels( $text ) {
		$this->checkType( 'protectionLevels', 1, $text, 'string' );
		$title = Title::newFromText( $text );
		if ( !$title ) {
			return array( null );
		}

		// @todo Once support for MediaWiki prior to 1.23 is dropped, remove this if block
		// (and maybe inline makeRestrictionsArraysOneBased)
		if ( !is_callable( array( $title, 'areRestrictionsLoaded' ) ) ) {
			if ( !$title->mRestrictionsLoaded ) {
				$this->incrementExpensiveFunctionCount();
				$title->loadRestrictions();
			}
			return array( $this->makeRestrictionsArraysOneBased( $title->mRestrictions ) );
		}

		if ( !$title->areRestrictionsLoaded() ) {
			$this->incrementExpensiveFunctionCount();
		}
		return array( $this->makeRestrictionsArraysOneBased( $title->getAllRestrictions() ) );
	}
}
