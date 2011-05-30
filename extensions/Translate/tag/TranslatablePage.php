<?php
/**
 * Translatable page model.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2009-2010 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Class to parse translatable wiki pages.
 * @ingroup PageTranslation
 */
class TranslatablePage {
	/**
	 * Title of the page.
	 */
	protected $title = null;

	/**
	 * Text contents of the page.
	 */
	protected $text = null;

	/**
	 * Revision of the page, if applicaple.
	 */
	protected $revision = null;

	/**
	 * From which source this object was constructed.
	 * Can be: text, revision, title
	 */
	protected $source = null;

	/**
	 * Whether the page contents is already loaded.
	 */
	protected $init = false;

	protected $displayTitle = 'Page display title';

	/**
	 * @param title Title object for the page
	 */
	protected function __construct( Title $title ) {
		$this->title = $title;
	}

	// Public constructors //

	/**
	 * Constructs a translatable page from given text.
	 * Some functions will fail unless you set revision
	 * parameter manually.
	 */
	public static function newFromText( Title $title, $text ) {
		$obj = new self( $title );
		$obj->text = $text;
		$obj->source = 'text';

		return $obj;
	}

	/**
	 * Constructs a translatable page from given revision.
	 * The revision must belong to the title given or unspecified
	 * behaviour will happen.
	 */

	public static function newFromRevision( Title $title, $revision ) {
		$rev = Revision::newFromTitle( $title, $revision );
		if ( $rev === null ) {
			throw new MWException( 'Revision is null' );
		}

		$obj = new self( $title );
		$obj->source = 'revision';
		$obj->revision = $revision;

		return $obj;
	}

	/**
	 * Constructs a translatable page from title.
	 * The text of last marked revision is loaded when neded.
	 */
	public static function newFromTitle( Title $title ) {
		$obj = new self( $title );
		$obj->source = 'title';

		return $obj;
	}

	// Getters //

	/**
	 * Returns the title for this translatable page.
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Returns the text for this translatable page.
	 */
	public function getText() {
		if ( $this->init === false ) {
			switch ( $this->source ) {
			case 'text':
				break;
			case 'title':
				$this->revision = $this->getMarkedTag();
			case 'revision':
				$rev = Revision::newFromTitle( $this->getTitle(), $this->revision );
				$this->text = $rev->getText();
				break;
			}
		}

		if ( !is_string( $this->text ) ) {
			throw new MWException( 'We have no text' );
		}

		$this->init = true;
		return $this->text;
	}

	/**
	 * Revision is null if object was constructed using newFromText.
	 * @return null or integer
	 */
	public function getRevision() {
		return $this->revision;
	}

	/**
	 * Manually set a revision number to use loading page text.
	 * @param $revision integer
	 */
	public function setRevision( $revision ) {
		$this->revision = $revision;
		$this->source = 'revision';
		$this->init = false;
	}

	// Public functions //

	/**
	 * Returns MessageGroup id (to be) used for translating this page.
	 * @return \string
	 */
	public function getMessageGroupId() {
		return self::getMessageGroupIdFromTitle( $this->getTitle() );
	}

	/**
	 * Constructs MessageGroup id for any title.
	 * @param $title Title
	 * @return \string
	 */
	public static function getMessageGroupIdFromTitle( Title $title ) {
		return 'page|' . $title->getPrefixedText();
	}

	/**
	 * Returns MessageGroup used for translating this page. It may still be empty
	 * if the page has not been ever marked.
	 * @return \type{WikiPageMessageGroup}
	 */
	public function getMessageGroup() {
		return MessageGroups::getGroup( $this->getMessageGroupId() );
	}

	/**
	 * Get translated page title.
	 * @param $code \string Language code.
	 * @return \string or null
	 */
	public function getPageDisplayTitle( $code ) {
		$section = str_replace( ' ', '_', $this->displayTitle );
		$page = $this->getTitle()->getPrefixedDBKey();
		return $this->getMessageGroup()->getMessage( "$page/$section", $code );
	}

	/**
	 * Returns a TPParse object which represents the parsed page.
	 * Throws TPExcetion if the page is malformed as a translatable
	 * page.
	 */
	public function getParse() {
		if ( isset( $this->cachedParse ) ) {
			return $this->cachedParse;
		}

		$text = $this->getText();

		$nowiki = array();
		$text = self::armourNowiki( $nowiki, $text );

		$sections = array();

		// Add section to allow translating the page name
		$displaytitle = new TPSection;
		$displaytitle->id = $this->displayTitle;
		$displaytitle->text = $this->getTitle()->getPrefixedText();
		$sections[self::getUniq()] = $displaytitle;

		$tagPlaceHolders = array();

		while ( true ) {
			$re = '~(<translate>)\s*(.*?)(</translate>)~s';
			$matches = array();
			$ok = preg_match_all( $re, $text, $matches, PREG_OFFSET_CAPTURE );

			if ( $ok === 0 ) {
				break; // No matches
			}

			// Do-placehold for the whole stuff
			$ph    = self::getUniq();
			$start = $matches[0][0][1];
			$len   = strlen( $matches[0][0][0] );
			$end   = $start + $len;
			$text = self::index_replace( $text, $ph, $start, $end );

			// Sectionise the contents
			// Strip the surrounding tags
			$contents = $matches[0][0][0]; // full match
			$start = $matches[2][0][1] - $matches[0][0][1]; // bytes before actual content
			$len   = strlen( $matches[2][0][0] ); // len of the content
			$end   = $start + $len;

			$sectiontext = substr( $contents, $start, $len );

			if ( strpos( $sectiontext, '<translate>' ) !== false ) {
				throw new TPException( array( 'pt-parse-nested', $sectiontext ) );
			}

			$sectiontext = self::unArmourNowiki( $nowiki, $sectiontext );

			$ret = $this->sectionise( $sections, $sectiontext );

			$tagPlaceHolders[$ph] =
				self::index_replace( $contents, $ret, $start, $end );
		}

		$prettyTemplate = $text;
		foreach ( $tagPlaceHolders as $ph => $value ) {
			$prettyTemplate = str_replace( $ph, '[...]', $prettyTemplate );
		}

		if ( strpos( $text, '<translate>' ) !== false ) {
			throw new TPException( array( 'pt-parse-open', $prettyTemplate ) );
		} elseif ( strpos( $text, '</translate>' ) !== false ) {
			throw new TPException( array( 'pt-parse-close', $prettyTemplate ) );
		}

		foreach ( $tagPlaceHolders as $ph => $value ) {
			$text = str_replace( $ph, $value, $text );
		}

		if ( count( $sections ) === 1 ) {
			// Don't return display title for pages which have no sections
			$sections = array();
		}

		$text = self::unArmourNowiki( $nowiki, $text );

		$parse = new TPParse( $this->getTitle() );
		$parse->template = $text;
		$parse->sections = $sections;

		// Cache it
		$this->cachedParse = $parse;

		return $parse;
	}

	// Inner functionality //

	public static function armourNowiki( &$holders, $text ) {
		$re = '~(<nowiki>)(.*?)(</nowiki>)~s';

		while ( preg_match( $re, $text, $matches ) ) {
			$ph = self::getUniq();
			$text = str_replace( $matches[0], $ph, $text );
			$holders[$ph] = $matches[0];
		}

		return $text;
	}

	public static function unArmourNowiki( $holders, $text ) {
		foreach ( $holders as $ph => $value ) {
			$text = str_replace( $ph, $value, $text );
		}

		return $text;
	}

	/**
	 * Returns a random string that can be used as placeholder.
	 */
	protected static function getUniq() {
		static $i = 0;
		return "\x7fUNIQ" . dechex( mt_rand( 0, 0x7fffffff ) ) . dechex( mt_rand( 0, 0x7fffffff ) ) . '|' . $i++;
	}

	protected static function index_replace( $string, $rep, $start, $end ) {
		return substr( $string, 0, $start ) . $rep . substr( $string, $end );
	}

	/**
	 * Splits the content marked with \<translate> tags into sections, which
	 * are separated with with two or more newlines. Extra whitespace is captured
	 * in the template and not included in the sections.
	 * @param $sections Array of placeholder => TPSection.
	 * @param $text Contents of one pair of \<translate> tags.
	 * @return string Templace with placeholders for sections, which itself are added to $sections.
	 */
	protected function sectionise( &$sections, $text ) {
		$flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE;
		$parts = preg_split( '~(\s*\n\n\s*|\s*$)~', $text, -1, $flags );

		$template = '';
		foreach ( $parts as $_ ) {
			if ( trim( $_ ) === '' ) {
				$template .= $_;
			} else {
				$ph = self::getUniq();
				$sections[$ph] = $this->shakeSection( $_ );
				$template .= $ph;
			}
		}

		return $template;
	}

	/**
	 * Checks if this section already contains a section marker. If there
	 * is not, a new one will be created. Marker will have the value of
	 * -1, which will later be replaced with a real value.
	 *
	 * May throw a TPException if there is error with existing section
	 * markers.
	 *
	 * @param $content string Content of one section
	 * @return TPSection
	 */
	protected function shakeSection( $content ) {
		$re = '~<!--T:(.*?)-->~';
		$matches = array();
		$count = preg_match_all( $re, $content, $matches, PREG_SET_ORDER );

		if ( $count > 1 ) {
			throw new TPException( array( 'pt-shake-multiple', $content ) );
		}

		$section = new TPSection;
		if ( $count === 1 ) {
			foreach ( $matches as $match ) {
				list( /*full*/, $id ) = $match;
				$section->id = $id;

				// Currently handle only these two standard places.
				// Is this too strict?
				$rer1 = '~^<!--T:(.*?)-->\n~'; // Normal sections
				$rer2 = '~\s*<!--T:(.*?)-->$~m'; // Sections with title
				$content = preg_replace( $rer1, '', $content );
				$content = preg_replace( $rer2, '', $content );

				if ( preg_match( $re, $content ) === 1 ) {
					throw new TPException( array( 'pt-shake-position', $content ) );
				} elseif ( trim( $content ) === '' ) {
					throw new TPException( array( 'pt-shake-empty', $id ) );
				}
			}
		} else {
			// New section
			$section->id = -1;
		}

		$section->text = $content;

		return $section;
	}

	public function addMarkedTag( $revision, $value = null ) {
		$this->addTag( 'tp:mark', $revision, $value );
		MessageGroups::clearCache();
	}

	public function addReadyTag( $revision ) {
		$this->addTag( 'tp:tag', $revision );
	}

	protected function addTag( $tag, $revision, $value = null ) {
		$dbw = wfGetDB( DB_MASTER );

		$id = $this->getTagId( $tag );

		if ( is_object( $revision ) ) {
			throw new MWException( 'Got object, excepted id' );
		}

		$conds = array(
			'rt_page' => $this->getTitle()->getArticleId(),
			'rt_type' => $id,
			'rt_revision' => $revision
		);
		$dbw->delete( 'revtag', $conds, __METHOD__ );

		if ( $value !== null ) {
			$conds['rt_value'] = serialize( implode( '|', $value ) );
		}

		$dbw->insert( 'revtag', $conds, __METHOD__ );
	}

	public function getMarkedTag( $db = DB_SLAVE ) {
		return $this->getTag( 'tp:mark' );
	}

	public function getReadyTag( $db = DB_SLAVE ) {
		return $this->getTag( 'tp:tag' );
	}

	/**
	 * Removes all page translation feature data from the database.
	 * Does not remove translated sections or translation pages.
	 * @todo Change name to something better.
	 */
	public function removeTags() {
		$dbw = wfGetDB( DB_MASTER );
		$conds = array(
			'rt_page' => $this->getTitle()->getArticleId(),
			'rt_type' => array(
				$this->getTagId( 'tp:mark' ),
				$this->getTagId( 'tp:tag' ),
			),
		);

		$dbw->delete( 'revtag', $conds, __METHOD__ );
		$dbw->delete( 'translate_sections', array( 'trs_page' => $this->getTitle()->getArticleId() ), __METHOD__ );
	}

	// Returns false if not found
	protected function getTag( $tag, $dbt = DB_SLAVE ) {

		if ( !$this->getTitle()->exists() ) {
			return false;
		}

		static $cache = array();
		$aid = $this->getTitle()->getArticleId();

		if ( isset( $cache[$aid][$tag] ) ) {
			return $cache[$aid][$tag];
		}

		$db = wfGetDB( $dbt );
		$id = $this->getTagId( $tag );

		$fields = 'rt_revision';
		$conds = array(
			'rt_page' => $aid,
			'rt_type' => $id,
		);

		$options = array( 'ORDER BY' => 'rt_revision DESC' );

		$tagRevision = $db->selectField( 'revtag', $fields, $conds, __METHOD__, $options );
		if ( $tagRevision !== false ) {
			return $cache[$aid][$tag] = intval( $tagRevision );
		} else {
			return $cache[$aid][$tag] = false;
		}
	}

	public function getTranslationUrl( $code = false ) {
		$translate = SpecialPage::getTitleFor( 'Translate' );
		$params = array(
			'group' => $this->getMessageGroupId(),
			'task' => 'view',
			'language' => $code,
		);

		return $translate->getFullURL( $params );
	}

	public function getMarkedRevs( $tag ) {
		$db = wfGetDB( DB_SLAVE );

		// Can this be done in one query?
		$id = $db->selectField( 'revtag_type', 'rtt_id',
			array( 'rtt_name' => $tag ), __METHOD__ );

		$fields = array( 'rt_revision', 'rt_value' );
		$conds = array(
			'rt_page' => $this->getTitle()->getArticleId(),
			'rt_type' => $id,
		);
		$options = array( 'ORDER BY' => 'rt_revision DESC' );

		return $db->select( 'revtag', $fields, $conds, __METHOD__, $options );
	}

	public function getTranslationPages() {
		// Fetch the available translation pages from database
		$dbr = wfGetDB( DB_SLAVE );
		$prefix = $this->getTitle()->getDBkey() . '/';
		$likePattern = $dbr->buildLike( $prefix, $dbr->anyString() );
		$res = $dbr->select(
			'page',
			array( 'page_namespace', 'page_title' ),
			array(
				'page_namespace' => $this->getTitle()->getNamespace(),
				"page_title $likePattern"
			),
			__METHOD__
		);

		$titles = TitleArray::newFromResult( $res );
		$filtered = array();

		// Make sure we only get translation subpages while ignoring others
		$codes = Language::getLanguageNames( false );
		$prefix = $this->getTitle()->getText();
		foreach ( $titles as $title ) {
			list( $name, $code ) = TranslateUtils::figureMessage( $title->getText() );
			if ( !isset( $codes[$code] ) || $name !== $prefix ) {
				continue;
			}
			$filtered[] = $title;
		}

		return $filtered;
	}

	public function getTranslationPercentages( $force = false ) {
		// Check the memory cache, as this is very slow to calculate
		global $wgMemc, $wgRequest;

		$memcKey = wfMemcKey( 'pt', 'status', $this->getTitle()->getPrefixedText() );
		$cache = $wgMemc->get( $memcKey );

		$force = $force || $wgRequest->getText( 'action' ) === 'purge';
		if ( !$force && is_array( $cache ) ) {
			return $cache;
		}

		$titles = $this->getTranslationPages();

		// Calculate percentages for the available translations
		$group = $this->getMessageGroup();
		if ( !$group instanceof WikiPageMessageGroup ) {
			return null;
		}

		$markedRevs = $this->getMarkedRevs( 'tp:mark' );

		$temp = array();
		foreach ( $titles as $t ) {
			list( , $code ) = TranslateUtils::figureMessage( $t->getText() );
			$collection = $group->initCollection( $code );

			$percent = $this->getPercentageInternal( $collection, $markedRevs );
			// To avoid storing 40 decimals of inaccuracy, truncate to two decimals
			$temp[$collection->code] = sprintf( '%.2f', $percent );
		}

		// Content language is always up-to-date
		global $wgContLang;

		$temp[$wgContLang->getCode()] = 1.00;

		$wgMemc->set( $memcKey, $temp, 60 * 60 * 12 );

		return $temp;
	}

	protected function getPercentageInternal( $collection, $markedRevs ) {
		$count = count( $collection );
		if ( $count === 0 ) {
			return 0;
		}

		// We want to get fuzzy though
		$collection->filter( 'hastranslation', false );
		$collection->initMessages();

		$total = 0;

		foreach ( $collection as $key => $message ) {
			$score = 1;

			// Fuzzy halves score
			if ( $message->hasTag( 'fuzzy' ) ) {
				$score *= 0.5;

				/* Reduce 20% for every newer revision than what is translated against.
				 * This is inside fuzzy clause, because there might be silent changes
				 * which we don't want to decrease the translation percentage.
				 */
				$rev = $this->getTransrev( $key . '/' . $collection->code );
				foreach ( $markedRevs as $r ) {
					if ( $rev === $r->rt_revision ) break;
					$changed = explode( '|', unserialize( $r->rt_value ) );

					// Get a suitable section key
					$parts = explode( '/', $key );
					$ikey = $parts[count( $parts ) - 1];

					// If the section was changed, reduce the score
					if ( in_array( $ikey, $changed, true ) ) {
						$score *= 0.8;
					}
				}
			}
			$total += $score;
		}

		// Divide score by count to get completion percentage
		return $total / $count;
	}

	public function getTransRev( $suffix ) {
		$id = $this->getTagId( 'tp:transver' );
		$title = Title::makeTitle( NS_TRANSLATIONS, $suffix );

		$db = wfGetDB( DB_SLAVE );
		$fields = 'rt_value';
		$conds = array(
			'rt_page' => $title->getArticleId(),
			'rt_type' => $id,
		);
		$options = array( 'ORDER BY' => 'rt_revision DESC' );

		return $db->selectField( 'revtag', $fields, $conds, __METHOD__, $options );
	}

	protected static function getTagId( $tag ) {
		$validTags = array( 'tp:mark', 'tp:tag', 'tp:transver' );
		if ( !in_array( $tag, $validTags ) ) {
			throw new MWException( "Invalid tag $tag requested" );
		}

		global $wgTranslateStaticTags;

		if ( is_array( $wgTranslateStaticTags ) ) {
			return $wgTranslateStaticTags[$tag];
		}

		// Simple static cache
		static $tagcache = array();

		if ( !count( $tagcache ) ) {
			$db = wfGetDB( DB_SLAVE );
			$res = $db->select(
				'revtag_type', // Table
				array( 'rtt_name', 'rtt_id' ),
				array( 'rtt_name' => $validTags ),
				__METHOD__
			);

			foreach ( $res as $r ) {
				$tagcache[$r->rtt_name] = $r->rtt_id;
			}
		}

		return $tagcache[$tag];
	}

	public static function isTranslationPage( Title $title ) {
		list( $key, $code ) = TranslateUtils::figureMessage( $title->getText() );

		if ( $key === '' || $code === '' ) {
			return false;
		}

		$codes = Language::getLanguageNames( false );
		global $wgTranslateDocumentationLanguageCode;
		unset( $codes[$wgTranslateDocumentationLanguageCode] );

		if ( !isset( $codes[$code] ) ) {
			return false;
		}

		$newtitle = self::changeTitleText( $title, $key );

		if ( !$newtitle ) {
			return false;
		}

		$page = TranslatablePage::newFromTitle( $newtitle );

		if ( $page->getMarkedTag() === false ) {
			return false;
		}

		return $page;
	}

	protected static function changeTitleText( Title $title, $text ) {
		return Title::makeTitleSafe( $title->getNamespace(), $text );
	}

	public static function isSourcePage( Title $title ) {
		static $cache = null;

		$cacheObj = wfGetCache( CACHE_ANYTHING );
		$cacheKey = wfMemcKey( 'pagetranslation', 'sourcepages' );

		if ( $cache === null ) {
			$cache = $cacheObj->get( $cacheKey );
		}
		if ( !is_array( $cache ) ) {
			$cache = self::getTranslatablePages();
			$cacheObj->set( $cacheKey, $cache, 60 * 5 );
		}

		return in_array( $title->getArticleId(), $cache );
	}

	/// List of page ids where the latest revision is either tagged or marked
	public static function getTranslatablePages() {
		$dbr = wfGetDB( DB_SLAVE );

		$tables = array( 'revtag', 'page' );
		$fields = 'rt_page';
		$conds = array(
			'rt_page = page_id',
			'rt_revision = page_latest',
			'rt_type' => array( self::getTagId( 'tp:mark' ), self::getTagId( 'tp:tag' ) ),
		);
		$options = array( 'GROUP BY' => 'rt_page' );

		$res = $dbr->select( $tables, $fields, $conds, __METHOD__, $options );
		$results = array();
		foreach ( $res as $row ) {
			$results[] = $row->rt_page;
		}

		return $results;
	}
}

/**
 * Class to signal syntax errors in translatable pages.
 * @ingroup PageTranslation
 */
class TPException extends MWException {
	protected $msg = null;

	/**
	 * @param $msg \string Message key.
	 */
	public function __construct( $msg ) {
		$this->msg = $msg;
		parent::__construct( call_user_func_array( 'wfMsg', $msg ) );
	}

	/**
	 * @return \string A localised error message.
	 */
	public function getMsg() {
		return $this->msg;
	}
}
