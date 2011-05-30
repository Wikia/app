<?php
/**
 * Helper code TranslatablePage.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2009-2010 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * This class represents the results of parsed source page, that is, the
 * extracted sections and a template.
 * @ingroup PageTranslation
 */
class TPParse {
	/// \type{Title} Title of the page.
	protected $title = null;

	/** \arrayof{String,TPSection} Parsed sections indexed with placeholder.
	 * @todo Encapsulate
	 */
	public $sections   = array();
	/** \string Page source with content replaced with placeholders.
	 * @todo Encapsulate
	 */
	public $template   = null;
	/// \arrayof{String,TPSection} Sections saved in the database.
	protected $dbSections = null;

	/// Constructor
	public function __construct( Title $title ) {
		$this->title = $title;
	}

	/**
	 * Returns the number of sections in this page.
	 * @return \int
	 */
	public function countSections() {
		return count( $this->sections );
	}

	/**
	 * Returns the page template where translatable content is replaced with
	 * placeholders.
	 * @return \string
	 */
	public function getTemplate() {
		return $this->template;
	}

	/**
	 * Returns the page template where the ugly placeholders are replaced with
	 * section markers. Sections which previously had no number will get one
	 * assigned now.
	 * @return \string
	 */
	public function getTemplatePretty() {
		$text = $this->template;
		$sections = $this->getSectionsForSave();
		foreach ( $sections as $ph => $s ) {
			$text = str_replace( $ph, "<!--T:{$s->id}-->", $text );
		}

		return $text;
	}

	/**
	 * Gets the sections and assigns section id for new sections
	 * @return \arrayof{String,TPSection}
	 */
	public function getSectionsForSave() {
		$this->loadFromDatabase();

		$sections = $this->sections;
		$highest = 0;
		foreach ( array_keys( $this->dbSections ) as $key ) {
			if ( !is_int( $key ) ) continue;
			$highest = max( $highest, $key );
		}

		foreach ( $sections as $_ ) {
			if ( !is_int( $_->id ) ) continue;
			$highest = max( $_->id, $highest );
		}

		foreach ( $sections as $s ) {
			$s->type = 'old';

			if ( $s->id === - 1 ) {
				$s->type = 'new';
				$s->id = ++$highest;
			} else {
				if ( isset( $this->dbSections[$s->id] ) ) {
					$storedText = $this->dbSections[$s->id]->text;
					if ( $s->text !== $storedText ) {
						$s->type = 'changed';
						$s->oldtext = $storedText;
					}
				}
			}

		}

		return $sections;
	}

	/**
	 * Returns list of deleted sections.
	 * @return \arrayof{String,TPsection} List of sections indexed by id.
	 */
	public function getDeletedSections() {
		$sections = $this->getSectionsForSave();
		$deleted = $this->dbSections;

		foreach ( $sections as $s ) {
			if ( isset( $deleted[$s->id] ) ) {
				unset( $deleted[$s->id] );
			}
		}

		return $deleted;
	}

	/**
	 * Load section saved in the database. Populates dbSections.
	 */
	protected function loadFromDatabase() {
		if ( $this->dbSections !== null ) {
			return;
		}

		$this->dbSections = array();

		$db = wfGetDB( DB_SLAVE );
		$tables = 'translate_sections';
		$vars = array( 'trs_key', 'trs_text' );
		$conds = array( 'trs_page' => $this->title->getArticleID() );

		$res = $db->select( $tables, $vars, $conds, __METHOD__ );
		foreach ( $res as $r ) {
			$section = new TPSection;
			$section->id = $r->trs_key;
			$section->text = $r->trs_text;
			$section->type = 'db';
			$this->dbSections[$r->trs_key] = $section;
		}
	}

	/**
	 * Returns the source page stripped of most translation mark-up.
	 * @return \string Wikitext.
	 */
	public function getSourcePageText() {
		$text = $this->template;

		/// @todo Use str_replace outside of the loop.
		foreach ( $this->sections as $ph => $s ) {
			$text = str_replace( $ph, $s->getMarkedText(), $text );
		}

		return $text;
	}

	/**
	 * Returns translation page with all possible translations replaced in, ugly
	 * translation tags removed and outdated translation marked with a class
	 * mw-translate-fuzzy.
	 * @todo The class marking has to be more intelligent with span&div use.
	 * @param $collection \type{MessageCollection} Collection that holds translated messages.
	 * @return \string Whole page as wikitext.
	 */
	public function getTranslationPageText( /*MessageCollection*/ $collection ) {
		$text = $this->template; // The source

		// For finding the messages
		$prefix = $this->title->getPrefixedDBKey() . '/';

		if ( $collection instanceOf MessageCollection ) {
			$collection->filter( 'hastranslation', false );
			$collection->loadTranslations();
		}

		foreach ( $this->sections as $ph => $s ) {
			$sectiontext = null;

			if ( isset( $collection[$prefix . $s->id] ) ) {
				$msg = $collection[$prefix . $s->id];
				$translation = $msg->translation();

				if ( $translation !== null ) {
					// Ideally we should not have fuzzy here, but old texts do
					$sectiontext = str_replace( TRANSLATE_FUZZY, '', $translation );

					if ( $msg->hasTag( 'fuzzy' ) ) {
						$sectiontext = "<span class=\"mw-translate-fuzzy\">\n$sectiontext\n</span>";
					}
				}
			}

			// Use the original text if no translation is available
			if ( $sectiontext === null ) {
				$sectiontext = $s->getTextForTrans();
			}

			// Substitute variables into section text and substitute text into document
			$sectiontext = self::replaceVariables( $s->getVariables(), $sectiontext );
			$text = str_replace( $ph, $sectiontext, $text );
		}

		$nph = array();
		$text = TranslatablePage::armourNowiki( $nph, $text );

		// Remove translation markup
		$cb = array( __CLASS__, 'replaceTagCb' );
		$text = preg_replace_callback( '~(<translate>)(.*)(</translate>)~sU', $cb, $text );
		$text = TranslatablePage::unArmourNowiki( $nph, $text );

		return $text;
	}

	/**
	 * Replaces variables from given text.
	 * @todo Is plain str_replace not enough (even the loop is not needed)?
	 */
	protected static function replaceVariables( $variables, $text ) {
		foreach ( $variables as $key => $value ) {
			$text = str_replace( $key, $value, $text );
		}

		return $text;
	}

	/**
	 * Chops of trailing or preceeding whitespace intelligently to avoid
	 * build up of unintented whitespace.
	 * @param $matches \array
	 * @return \string
	 */
	protected static function replaceTagCb( $matches ) {
		return preg_replace( '~^\n|\n\z~', '', $matches[2] );
	}
}
