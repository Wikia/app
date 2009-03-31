<?php

/**
 * Code for handling pages marked with <translate> tag. This class does parsing.
 *
 * Section: piece of text, separated usually with two new lines, that is used as
 * an single translation unit for change tracking and so on.
 * Occurance: contents of <translate>..</translate>, which there can be many on
 * one page.
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class TranslateTag {
	/** Counter for nth <translate>..</translate> invocation to know to which
 	 *  occurance each section belongs to, when doing save-time parsing. */
	var $invocation = 0;

	// Deprecated, TODO: write a suitable factory functions for replacement
	public static function getInstance() {
		$obj = new self;
		// $obj->reset();
		return $obj;
	}

	/** Factory for creating a new instance from Title object */
	public static function newFromTitle( Title $title ) {
		$obj = new self();
		$obj->invocation = 0;
		$obj->title = $title;

		$text = TranslateTagUtils::getTagPageSource( $title );

		$cb = array( $obj, 'parseMetadata' );
		preg_replace_callback( self::METADATA, $cb, $text );
		return $obj;
	}

	/** Factory for creating a new instance from occurance */
	public static function newFromTagContents( &$text, $code ) {
		$obj = new self();
		$obj->invocation = - 1;
		$obj->title = null;
		$obj->renderCode = $code;

		$cb = array( $obj, 'parseMetadata' );
		preg_replace_callback( self::METADATA, $cb, $text );
		return $obj;
	}

	// TODO: Move to hook or utils?
	// Remember to to use TranslateUtils::injectCSS()
	public function getHeader( Title $title, $code = false ) {
		global $wgLang;
		$par = array(
			'group' => 'page|' . $title->getPrefixedText(),
			'language' => $code ? $code : $wgLang->getCode(),
			'task' => 'view'
		);
		$translate = SpecialPage::getTitleFor( 'Translate' );
		$link = $translate->getFullUrl( wfArrayToCgi( $par ) );

		wfLoadExtensionMessages( 'Translate' );
		$linkDesc    = wfMsgNoTrans( 'translate-tag-translate-link-desc' );
		$legendText  = wfMsgNoTrans( 'translate-tag-legend' );
		$legendOther = wfMsgNoTrans( 'translate-tag-legend-fallback' );
		$legendFuzzy = wfMsgNoTrans( 'translate-tag-legend-fuzzy' );


		$legend  = "<div style=\"font-size: x-small\">";
		$legend .= "<span class='plainlinks'>[$link $linkDesc]</span> ";
		if ( $code ) {
			$legend .= " | $legendText <span class=\"mw-translate-other\">$legendOther</span>";
			$legend .= " <span class=\"mw-translate-fuzzy\">$legendFuzzy</span>";
		}
		// TODO: the following text will of course be removed :)
		$legend .= ' | This page is translatable using the experimental wiki page translation feature.</div>';
		$legend .= "\n----\n";
		return $legend;
	}

	// Some regexps
	const METADATA = '~\n?<!--TS(.*?)-->\n?~us';
	const PATTERN_COMMENT = '~\n?<!--T[=:;](.*?)-->\n?~u';
	const PATTERN_TAG = '~(<translate>)\n?(.+?)(</translate>)~us';

	// Renders a translation page to given language
	public function renderPage( $text, Title $title, $code = false ) {
		$this->renderTitle = $title;
		$this->renderCode = $code;
		$cb = array( $this, 'parseMetadata' );
		preg_replace_callback( self::METADATA, $cb, $text );

		$cb = array( $this, 'replaceTagCb' );
		$text = StringUtils::delimiterReplaceCallback( '<translate>', '</translate>', $cb, $text );

		return preg_replace_callback( self::PATTERN_TAG, $cb, $text );
	}

	public function replaceTagCb( $matches ) {
		return $this->replaceTag( $matches[1] );
	}

	/**
	 * Replaces sections with translations if available, and substitutes variables
	 */
	public function replaceTag( $input ) {
		$regex = $this->getSectionRegex();
		$matches = array();
		preg_match_all( $regex, $input, $matches, PREG_SET_ORDER );
		foreach ( $matches as $match ) {
			$key = $match['id'];
			$section = $match['section'];

			$translation = null;
			if ( $this->renderCode ) {
				$translation = $this->getContents( $this->renderTitle, $key, $this->renderCode );
			}

			if ( $translation !== null ) {
				$vars = $this->extractVariablesFromSection( $section );
				foreach ( $vars as $v ) {
					list( $search, $replace ) = $v;
					$translation = str_replace( $search, $replace, $translation );
				}

				// Inject the translation in the source by replacing the definition with it
				$input = str_replace( $section, $translation, $input );
			} else {
				// Do in-place replace of variables, copy to keep $section intact for
				// the replace later
				$replace = $section;
				// Replace with newline to avoid eating the newline after header
				// and it doesn't hurt because surrounding is trimmed for inlines
				$replace = preg_replace( self::PATTERN_COMMENT, "\n", $replace );
				$this->extractVariablesFromSection( $replace, 'replace' );

				if ( $this->renderCode ) {
					$replace = $this->wrapAndClean( 'mw-translate-other', $replace );
				}
				$input = str_replace( $section, $replace, $input );
				$input = str_replace( $match['holder'], '', $input );
			}
		}

		// Clean any comments there may be left
		$input = preg_replace( self::PATTERN_PLACEHOLDER, '', $input );
		$input = preg_replace( self::METADATA, '', $input );

		return trim( $input );

	}
	
	public function extractVariablesFromSection( &$text, $subst = false ) {
		$regex = '~<tvar(?:\|(?P<id>[^>]+))>(?P<value>.*?)</>~u';
		$matches = array();
		// Quick return
		if ( !preg_match_all( $regex, $text, $matches, PREG_SET_ORDER ) ) return array();

		// Extracting
		$vars = array();
		foreach ( $matches as $match ) {
			$id = $match['id']; // Default to provided id
			// But if it isn't provided, autonumber them from one onwards
			if ( $id === '' ) $id = count( $vars ) ? max( array_keys( $vars ) ) + 1 : 1;
			// Index by id, for above to work.
			// Store array or replace, replacement for easy replace afterwards
			$vars[$id] = array( '$' . $id, $match['value'] );
			// If requested, subst them immediately
			if ( $subst === 'replace' )
				$text = str_replace( $match[0], $match['value'], $text );
			elseif ( $subst === 'holder' )
				$text = str_replace( $match[0], '$' . $id, $text );
		}

		return $vars;
	}

	/**
	 * Fetches translation for a section.
	 */
	public function getContents( Title $title, $key, $code ) {
		global $wgContLang;

		$namespace = $this->getNamespace( $title );
		$sectionPageName = $this->getTranslationPage( $title, $key, $code );
		$sectionTitle = Title::makeTitle( $namespace, $sectionPageName );
		if ( !$sectionTitle ) throw new MWException( 'bad title' );

		$revision = Revision::loadFromTitle( wfGetDB( DB_SLAVE ), $sectionTitle );
		if ( $revision ) {
			$translation = $revision->getText();
			if ( strpos( $translation, TRANSLATE_FUZZY ) !== false ) {
				$translation = str_replace( TRANSLATE_FUZZY, '', $translation );
				$translation = $this->wrapAndClean( 'mw-translate-fuzzy', $translation );
			}

			return $translation;
		}

		return null;
	}

	public function wrapAndClean( $class, $text ) {
		$text = trim( $text );

		$tag = 'div';
		$sep = "\n";
		if ( strpos( $text, "\n" ) === false && strpos( $text, '==' ) === false ) {
			$tag = 'span';
			$sep = '';
		}

		$class = htmlspecialchars( $class );

		return "<$tag class=\"$class\">$sep$text$sep</$tag>";
	}

	const PATTERN_SECTION = '~(<!--T:[^-]+-->)(.*?)<!--T;-->~us';
	const PATTERN_PLACEHOLDER = '~<!--T:[^-/]+/?-->~us';

	public function getSectionRegex( $taggedOnly = true ) {
		$id  = '(:? *(?P<holder><!--T:(?P<id>[^-/]+)-->)\n?)';
		$end = '(?P<trail>\n{2,}|\s*\z)';
		$text = '(?Us:[^\n].*)';
		$header = '(?m:(?P<header>(?>={1,6}).+={1,6})[ |\n]?)';

		if ( $taggedOnly ) {
			$regex = "(?P<section>$header?$id$text?)$end";
		} else {
			$regex = "(?P<section>$header?$id?$text?)$end";
			// $regex = $text;
		}

		return "~$regex~u";
	}

	// Deprecated
	public function reset() {
		$this->sections = array();
		$this->placeholders = array();
		$this->invocation = 0;
	}

	public static function parseSectionDefinitions( Title $title, array &$namespaces ) {
		$obj = self::getInstance();

		$defs = array();

		$revision = Revision::newFromTitle( $title );
		$pagecontents = $revision->getText();

		$cb = array( $obj, 'parseMetadata' );
		preg_replace_callback( self::METADATA, $cb, $pagecontents );

		$matches = array();
		preg_match_all( $obj->getSectionRegex(), $pagecontents, $matches, PREG_SET_ORDER );
		foreach ( $matches as $match ) {
			$key = $match['id'];

			$contents = preg_replace( self::PATTERN_COMMENT, "\n", $match['section'] );
			$contents = trim( $contents );
			$key = $obj->getTranslationPage( $title, $key );
			$obj->extractVariablesFromSection( $contents, 'holder' );
			$defs[$key] = $contents;
		}

		$ns = $obj->getNamespace( $title );
		$namespaces = array( $ns, $ns + 1 );

		return $defs;
		
	}

	/** Use this to get the location of translations */
	public function getTranslationPage( Title $title, $key, $code = false ) {
		global $wgTranslateTagTranslationLocation;
		list( , $format ) = $wgTranslateTagTranslationLocation;

		// Some data
		$ns = $title->getNsText();
		$page = $title->getDBkey();
		$fullname = $title->getPrefixedDBkey();
		$snippet = $this->sections[$key]['page'];

		$search = array( '$NS', '$PAGE', '$FULLNAME', '$KEY', '$SNIPPET' );
		$replace = array( $ns, $page, $fullname, $key, $snippet );
		$pagename = str_replace( $search, $replace, $format );
		if ( $code !== false ) $pagename .= "/$code";

		return $pagename;
	}

	/** Use this to get the namespace for page names provided with
	 * getTranslationPage
	 */
	public function getNamespace( Title $title ) {
		global $wgTranslateTagTranslationLocation;
		list( $nsId, ) = $wgTranslateTagTranslationLocation;
		if ( $nsId === null ) $nsId = $title->getNamespace();
		return $nsId;
	}

	// Initiate fuzzyjobs on changed sections
	public function onArticleSaveComplete(
		$article, $user, $text, $summary, $isminor, $_, $_, $flags, $revision
	) {
		if ( $revision === null || $isminor ) return true;

		$namespace = $this->getNamespace( $article->getTitle() );

		foreach ( $this->changed as $key ) {
			$page = $this->getTranslationPage( $article->getTitle(), $key );
			$title = Title::makeTitle( $namespace, $page );
			if ( !$title ) continue;

			$summary = str_replace( '-->', '-- >', $summary );

			$url = $article->getTitle()->getFullUrl( 'diff=' . $revision->getId() );
			$reason = wfMsgForContent( 'translate-tag-fuzzy-reason', $user->getName(), $url, $summary );
			$reason = "<!-- $reason -->";
			$comment = wfMsgForContent( 'translate-tag-fuzzy-comment', $user->getName(), $revision->getId() );

			FuzzyJob::fuzzyPages( $reason, $comment, $title );
		}
		return true;
	}

	public static function save( $article, $user, &$text, $summary, $isminor, $iswatch, $section ) {
		// Quick escape on normal pages
		if ( strpos( $text, '</translate>' ) === false ) return true;

		$obj = self::getInstance();
		$obj->reset();
		
		// Parse existing section mappings
		$obj->invocation = 0;
		$cb = array( $obj, 'parseMetadata' );
		$text = preg_replace_callback( self::METADATA, $cb, $text );

		$obj->changed = array();
		$obj->invocation = 0;
		$cb = array( $obj, 'saveCb' );
		$text = preg_replace_callback( self::PATTERN_TAG, $cb, $text );

		// Trim trailing whitespace. It is not allowed in wikitext and shows up in
		// diffs
		$text = rtrim( $text );

		if ( count( $obj->changed ) ) {
			// Register fuzzier
			// We need to do it later, so that we know the revision number
			global $wgHooks;
			$wgHooks['ArticleSaveComplete'][] = $obj;
		}

		return true;
	}

	public function saveCb( $matches ) {

		$data = $matches[2];

		// Add sections to unsectioned data
		$cb = array( $this, 'saveCbSectionCb' );
		$regex = $this->getSectionRegex( false );
		$data = preg_replace_callback( $regex, $cb, $data );

		// Add two newlines before metadata so that it wont be parsed as a part of
		// the section it is after
		$output  = $matches[1] . "\n" . $data . "\n\n";
		$output .= $this->outputMetadata();
		$output .= $matches[3];

		$this->invocation++;
		return $output;
	}

	public function parseMetadata( $data ) {
		$matches = array();
		preg_match_all( '~^(.*?)\|(.*?)\|(.*?)$~umD', $data[1], $matches, PREG_SET_ORDER );
		foreach ( $matches as $match ) {
			$this->sections[$match[1]] = array(
				'hash' => $match[2],
				'page' => $match[3],
				'invo' => $this->invocation,
			);
		}

		$this->invocation++;
		return '';
	}

	/**
	 * Returns list of translation sections in an array.
	 * @param $code language code for the pages.
	 */
	public function getSectionPages() {
		$pages = array();
		foreach ( array_keys( $this->sections ) as $key ) {
			$pages[] = $this->getTranslationPage( $this->title, $key );
		}
		return $pages;
	}

	public function outputMetadata() {
		$s  = "<!--TS\n";
		foreach ( $this->sections as $key => $section ) {
			if ( $section['invo'] !== $this->invocation ) continue;
			$s .= "$key|{$section['hash']}|{$section['page']}\n";
		}
		$s .= "-->\n";
		return $s;
	}

	public function saveCbSectionCb( array $matches ) {
		// Have to do rematch, because this is stupid
		preg_match( $this->getSectionRegex( false ), $matches[0], $match );
		$section = $match['section'];

		if ( trim( $match[0] ) === '' ) return $match[0];

		if ( $match['holder'] !== '' ) {
			$key = $match['id'];
			$newhash = self::hash( $match['section'] );
			$oldhash = $this->sections[$key]['hash'];


			if ( $newhash !== $oldhash ) {
				$this->changed[] = $key;
			}

			$page = @$this->sections[$key]['page'];
			// Create page, unless it is already choosen
			if ( $page === null ) $page = TranslateUtils::snippet( $section, 30 );

			$array = array(
				'hash' => $newhash,
				'invo' => $this->invocation,
				'page' => $page,
			);

			// Update data
			$this->sections[$key] = $array;

			return $match[0];
		}

		if ( empty( $this->sections ) ) $key = 0;
		else $key = max( array_keys( $this->sections ) );

		$this->sections[++$key] = array(
			'hash' => self::hash( $section ),
			'page' => TranslateUtils::snippet( $section, 30 ),
			'invo' => $this->invocation,
		);

		$holder = "<!--T:$key-->";

		if ( $match['header'] !== '' ) {
			$section = str_replace( $match['header'], $match['header'] . ' ' . $holder, $section );
		} else {
			$section = $holder . "\n" . $section;
		}

		return $section . $match['trail'];
	}

	public static function hash( $contents ) {
		return sha1( trim( $contents ) );
	}

}